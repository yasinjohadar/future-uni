<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained('course_sections')->cascadeOnDelete();
            $table->date('session_date');
            $table->string('title')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['course_section_id', 'session_date']);
        });

        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->string('status')->default('present');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['attendance_session_id', 'enrollment_id']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->foreignId('course_section_id')
                ->nullable()
                ->after('program_id')
                ->constrained('course_sections')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('course_section_id');
        });

        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('attendance_sessions');
    }
};
