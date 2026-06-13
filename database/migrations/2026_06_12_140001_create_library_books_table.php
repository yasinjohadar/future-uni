<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('author');
            $table->foreignId('library_category_id')->constrained()->cascadeOnDelete();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('isbn')->nullable();
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();
            $table->string('publication_year', 4)->nullable();
            $table->unsignedSmallInteger('pages')->default(0);
            $table->string('language')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->boolean('is_available')->default(true);
            $table->unsignedSmallInteger('copies_total')->default(0);
            $table->unsignedSmallInteger('copies_available')->default(0);
            $table->string('shelf_location')->nullable();
            $table->longText('description')->nullable();
            $table->json('chapters')->nullable();
            $table->json('tags')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_books');
    }
};
