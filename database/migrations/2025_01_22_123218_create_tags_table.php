<?php

use Sharenjoy\NoahCms\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (in_array(HasTranslations::class, class_uses(Tag::class))) {
            $fieldDataType = 'json';
        } else {
            $fieldDataType = 'string';
        }

        Schema::create('tags', function (Blueprint $table) use ($fieldDataType) {
            $table->id();
            $table->$fieldDataType('name');
            $table->string('slug', 50);
            $table->string('type', 50)->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
};
