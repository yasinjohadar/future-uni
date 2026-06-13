<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AdmissionController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CollegesController;
use App\Http\Controllers\Frontend\DepartmentsController;
use App\Http\Controllers\Frontend\FacultyController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\LibraryController;
use App\Http\Controllers\Frontend\ProgramsController;
use App\Http\Controllers\Frontend\ResearchController;
use App\Http\Controllers\Frontend\StaffController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::redirect('/news', '/blog')->name('news');

Route::get('/contact', [PageController::class, 'show'])
    ->defaults('page', 'contact')
    ->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/colleges', [CollegesController::class, 'index'])->name('colleges');
Route::get('/colleges/{collegeSlug}', [CollegesController::class, 'show'])->name('colleges.show');
Route::get('/colleges/{collegeSlug}/departments/{departmentSlug}', [DepartmentsController::class, 'show'])->name('departments.show');

Route::get('/programs', [ProgramsController::class, 'index'])->name('programs');
Route::get('/programs/{slug}', [ProgramsController::class, 'show'])->name('programs.show');

Route::get('/staff', [StaffController::class, 'index'])->name('staff');
Route::get('/staff/{slug}', [StaffController::class, 'show'])->name('staff.show');
Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty');

Route::get('/admission', [AdmissionController::class, 'index'])->name('admission');
Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');

Route::get('/research', [ResearchController::class, 'index'])->name('research');
Route::get('/research/{slug}', [ResearchController::class, 'show'])->name('research.show');
Route::get('/research-detail', [ResearchController::class, 'legacyDetail'])->name('research-detail');

Route::get('/library', [LibraryController::class, 'index'])->name('library');
Route::get('/library/search', [LibraryController::class, 'search'])->name('library.search');
Route::get('/library/book/{slug}', [LibraryController::class, 'show'])->name('library.book.show');
Route::get('/book-detail', [LibraryController::class, 'legacyDetail'])->name('book-detail');

$skipSlugs = [
    'contact', 'admission', 'college-detail', 'program-detail',
    'staff', 'staff-detail', 'faculty', 'programs', 'departments', 'login',
    'research', 'research-detail', 'library', 'book-detail',
];

foreach (config('frontend-pages.pages', []) as $slug => $page) {
    if (in_array($slug, $skipSlugs, true)) {
        continue;
    }

    Route::get($page['path'], [PageController::class, 'show'])
        ->defaults('page', $slug)
        ->name($page['route']);
}

Route::get('/consultation', function () {
    return view('frontend.pages.consultation');
})->name('consultation');

Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');
