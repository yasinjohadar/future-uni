<?php

use App\Http\Controllers\Student\AnnouncementController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\FinanceController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\Student\LibraryController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\RegistrationController;
use App\Http\Controllers\Student\ScheduleController;
use App\Http\Controllers\Student\StudyPlanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'check.user.active', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
        Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/study-plan', [StudyPlanController::class, 'index'])->name('study-plan.index');
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
        Route::get('/registration', [RegistrationController::class, 'index'])->name('registration.index');
        Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
        Route::delete('/registration/{enrollment}', [RegistrationController::class, 'destroy'])->name('registration.destroy');
        Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    });
