<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->string('email')->nullable()->after('bio');
            $table->string('phone')->nullable()->after('email');
            $table->string('office')->nullable()->after('phone');
            $table->json('stats')->nullable()->after('office');
            $table->json('education')->nullable()->after('stats');
            $table->json('experience_history')->nullable()->after('education');
            $table->json('publications')->nullable()->after('experience_history');
            $table->json('awards')->nullable()->after('publications');
            $table->json('skills')->nullable()->after('awards');
        });
    }

    public function down(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->dropColumn([
                'email', 'phone', 'office', 'stats', 'education',
                'experience_history', 'publications', 'awards', 'skills',
            ]);
        });
    }
};
