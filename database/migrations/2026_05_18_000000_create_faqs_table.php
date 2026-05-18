<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sharenjoy\NoahCms\Models\Faq;
use Spatie\Translatable\HasTranslations;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (in_array(HasTranslations::class, class_uses(Faq::class))) {
            $fieldDataType = [
                'question' => 'json',
                'answer' => 'json',
            ];
        } else {
            $fieldDataType = [
                'question' => 'string',
                'answer' => 'text',
            ];
        }

        Schema::create('faqs', function (Blueprint $table) use ($fieldDataType) {
            $table->id();
            $table->{$fieldDataType['question']}('question');
            $table->{$fieldDataType['answer']}('answer');
            $table->unsignedInteger('order_column')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
