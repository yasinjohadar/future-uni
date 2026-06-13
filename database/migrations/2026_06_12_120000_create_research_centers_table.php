<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_centers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->longText('long_description')->nullable();
            $table->foreignId('college_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('director_id')->nullable()->constrained('staff_members')->nullOnDelete();
            $table->string('director_title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('established')->nullable();
            $table->unsignedSmallInteger('projects_count')->default(0);
            $table->unsignedSmallInteger('publications_count')->default(0);
            $table->json('stats')->nullable();
            $table->json('focus_areas')->nullable();
            $table->json('active_projects')->nullable();
            $table->json('partners')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_centers');
    }
};
