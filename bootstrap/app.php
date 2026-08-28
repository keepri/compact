<?php

declare(strict_types=1);

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // When a Livewire XHR request arrives with a stale CSRF token, regenerate
        // the token and return it in the X-CSRF-TOKEN response header.
        // The client-side respond hook reads this header, updates the
        // <meta name="csrf-token"> tag, and transparently retries the request.
        //
        // NOTE: Laravel's prepareException() converts TokenMismatchException into
        // HttpException(419) before renderViaCallbacks runs, so we must type-hint
        // HttpException and guard on status 419 — not TokenMismatchException directly.
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() !== 419) {
                return null;
            }

            if ($request->hasHeader('X-Livewire')) {
                session()->regenerateToken();
                // Explicitly persist the session — the StartSession middleware only
                // saves after $next($request) returns, which never happens when an
                // exception is thrown. Without this save() the new token exists only
                // in memory: every subsequent request sees a stale token and 419s again.
                session()->save();
                $newToken = session()->token();

                Log::info('[csrf-refresh] 419 on Livewire request — regenerated token', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]);

                return new JsonResponse(['message' => 'CSRF token mismatch.'], 419)
                    ->header('X-CSRF-TOKEN', $newToken);
            }

            Log::warning('[csrf-refresh] 419 on non-Livewire request — falling through to default handler', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);

            return null;
        });

        $exceptions->respond(function ($response, $exception, $request) {
            // Only handle HTTP exceptions (404, 500, etc.)
            if (! $exception instanceof HttpException) {
                return $response;
            }

            // Only handle web requests (HTML), not API requests (JSON)
            if ($request->expectsJson()) {
                return $response;
            }

            $statusCode = $exception->getStatusCode();

            $view = match (true) {
                $statusCode === 404 => 'errors.404',           // 404 Not Found
                $statusCode >= 500 => 'errors.500',            // all 5xx server errors
                default => null,
            };

            if ($view === null) {
                return $response;
            }

            // Rendering happens inside the exception handler, so a failure here
            // (template deleted, database unreachable while fetching the page
            // content) would replace the original error with a confusing one.
            // Fall back to the framework's own response instead.
            try {
                return response()->view($view, [], $statusCode);
            } catch (Throwable $throwable) {
                Log::error("[error-pages] failed to render {$view}, falling back to the default response", [
                    'status' => $statusCode,
                    'exception' => $throwable->getMessage(),
                ]);

                return $response;
            }
        });
    })->create();
