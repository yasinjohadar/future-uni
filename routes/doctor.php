<?php

use App\Http\Controllers\Doctor\AnnouncementController;
use App\Http\Controllers\Doctor\AttendanceController;
use App\Http\Controllers\Doctor\DashboardController;
use App\Http\Controllers\Doctor\GradeController;
use App\Http\Controllers\Doctor\ProfileController;
use App\Http\Controllers\Doctor\ScheduleController;
use App\Http\Controllers\Doctor\SectionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'check.user.active', 'role:doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
        Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
        Route::post('/sections/{section}/grades/publish-all', [SectionController::class, 'publishAllGrades'])->name('sections.publish-all-grades');
        Route::get('/sections/{section}/export', [SectionController::class, 'export'])->name('sections.export');

        Route::patch('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
        Route::post('/grades/{grade}/publish', [GradeController::class, 'publish'])->name('grades.publish');

        Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/sections/{section}/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/sections/{section}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/sections/{section}/attendance/{session}', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/sections/{section}/attendance/{session}', [AttendanceController::class, 'update'])->name('attendance.update');

        Route::post('/sections/{section}/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('/sections/{section}/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
