// Livewire CSRF auto-refresh: patch window.fetch so that when a Livewire XHR
// gets a 419 with an X-CSRF-TOKEN header, we update the token and retry
// transparently — Livewire never sees the 419.
//
// WHY fetch-patch instead of Livewire's respond hook:
// Livewire's respond() hook calls callbacks synchronously (forEach), so async
// callbacks are never awaited — Livewire reads mutableObject.response immediately
// after calling respond(), before our retry resolves, and proceeds to show the
// "page expired" confirm() dialog. Patching fetch intercepts at a lower level
// where we can genuinely await the retry before returning.
//
// WHY up to 2 retries:
// When the session row is GC'd but a "remember me" cookie exists, the first
// retry re-hydrates auth via the recaller cookie. Laravel's SessionGuard calls
// updateSession() which calls session()->regenerate() — rotating the CSRF token
// a second time. The server never returns this second token to the client, so
// the next request 419s again. A second retry catches that rotation and recovers
// transparently. If a third 419 occurs we give up.
(function () {
    const originalFetch = window.fetch;

    function updateDomTokens(token) {
        document.querySelector('meta[name="csrf-token"]')?.setAttribute('content', token);
        document.querySelector('[data-csrf]')?.setAttribute('data-csrf', token);
    }

    window.fetch = async function (input, init) {
        const isLivewire = init?.headers?.['X-Livewire'] !== undefined;

        let response = await originalFetch(input, init);

        if (!isLivewire || response.status !== 419) return response;

        // Up to 2 retry attempts to handle:
        // attempt 1 — plain session expiry / stale token
        // attempt 2 — token rotated again by remember-me re-hydration (updateSession)
        let reload = false;

        for (let attempt = 1; attempt <= 2; attempt++) {
            const newToken = response.headers.get('X-CSRF-TOKEN');

            if (!newToken) {
                console.warn('[csrf-refresh] No X-CSRF-TOKEN in response — cannot refresh. Headers:', [...response.headers.entries()]);
                break;
            }

            updateDomTokens(newToken);

            let body;
            try {
                body = JSON.parse(init.body);
            } catch {
                console.warn('[csrf-refresh] Request body is not JSON — cannot patch _token. Passing 419 through.', init?.body);
                break;
            }
            body._token = newToken;

            init = { ...init, body: JSON.stringify(body) };
            response = await originalFetch(input, init);

            if (response.status === 401) {
                // Session is gone and auth could not be re-hydrated (no remember me,
                // or remember me token invalid). Do a full page reload so Laravel's
                // auth middleware issues a proper redirect()->guest() with the current
                // URL as the intended destination.
                console.warn('[csrf-refresh] retry returned 401 — session lost, reloading page');
                reload = true;
                break;
            }

            if (response.status !== 419) {
                break;
            }
        }

        if (reload) {
            window.location.reload();
            // Return a never-resolving promise so Livewire never processes this.
            return new Promise(() => {});
        }

        if (response.status === 419) {
            console.error('[csrf-refresh] all retries returned 419 — passing through to Livewire');
        }

        return response;
    };
})();
