<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category')->default('all');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('established')->nullable();
            $table->string('students_count')->nullable();
            $table->string('building')->nullable();
            $table->string('accreditation')->nullable();
            $table->unsignedSmallInteger('departments_count')->default(0);
            $table->unsignedSmallInteger('programs_count')->default(0);
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('programs_count')->default(0);
            $table->unsignedSmallInteger('faculty_count')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['college_id', 'slug']);
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('level');
            $table->string('duration')->nullable();
            $table->unsignedSmallInteger('credits')->nullable();
            $table->unsignedInteger('students_count')->nullable();
            $table->unsignedSmallInteger('faculty_count')->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->json('objectives')->nullable();
            $table->json('careers')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('program_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->unsignedTinyInteger('credits')->default(3);
            $table->unsignedTinyInteger('semester')->nullable();
            $table->string('type')->default('core');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('type');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('specialty')->nullable();
            $table->string('academic_title')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('icon')->default('fa-user-tie');
            $table->foreignId('college_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('colleges', function (Blueprint $table) {
            $table->foreignId('dean_id')->nullable()->after('accreditation')->constrained('staff_members')->nullOnDelete();
        });

        Schema::create('admission_cycles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('academic_year');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_open')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('admission_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->foreignId('admission_cycle_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('high_school_gpa')->nullable();
            $table->string('city')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->json('documents')->nullable();
            $table->boolean('agreed_terms')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('homepage_hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('title_accent')->nullable();
            $table->text('description')->nullable();
            $table->string('primary_btn_label')->nullable();
            $table->string('primary_btn_url')->nullable();
            $table->string('secondary_btn_label')->nullable();
            $table->string('secondary_btn_url')->nullable();
            $table->string('background_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_stats', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('value');
            $table->string('label');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('student_number')->unique();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('active');
            $table->date('enrollment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropForeign(['dean_id']);
            $table->dropColumn('dean_id');
        });

        Schema::dropIfExists('students');
        Schema::dropIfExists('accreditations');
        Schema::dropIfExists('homepage_stats');
        Schema::dropIfExists('homepage_hero_slides');
        Schema::dropIfExists('admission_applications');
        Schema::dropIfExists('admission_cycles');
        Schema::dropIfExists('staff_members');
        Schema::dropIfExists('program_courses');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('colleges');
    }
};
