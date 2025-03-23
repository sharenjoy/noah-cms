<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();

            $table->morphs('model');

            $table->json('description')->nullable();
            $table->json('title')->nullable();
            $table->string('image')->nullable();
            $table->json('author')->nullable();
            $table->string('robots')->nullable();
            $table->string('canonical_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo');
    }
};
