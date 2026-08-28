<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('error_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('type')->default('generic');
            $table->json('heading')->nullable(false);
            $table->json('message')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_pages');
    }
};
