<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sharenjoy\NoahCms\Models\Promo;
use Spatie\Translatable\HasTranslations;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (in_array(HasTranslations::class, class_uses(Promo::class))) {
            $fieldDataType = [
                'title' => 'json',
                'description' => 'json',
                'content' => 'json',
            ];
        } else {
            $fieldDataType = [
                'title' => 'string',
                'description' => 'text',
                'content' => 'text',
            ];
        }

        Schema::create('promos', function (Blueprint $table) use ($fieldDataType) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type', 50)->index();
            $table->string('slug', 100);
            $table->{$fieldDataType['title']}('title');
            $table->{$fieldDataType['description']}('description')->nullable();
            $table->{$fieldDataType['content']}('content')->nullable();
            $table->integer('img')->nullable();
            $table->text('album')->nullable();
            $table->string('coupon_code')->nullable();
            $table->boolean('always')->default(false);
            $table->string('time_type', 50)->index();
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('ended_at')->nullable()->index();
            $table->timestamp('display_ended_at')->nullable();
            $table->timestamp('published_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
