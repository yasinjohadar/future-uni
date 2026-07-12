<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();

        $announcements = Announcement::query()
            ->visibleToStudent($student)
            ->latest('published_at')
            ->paginate(15);

        return view('student.pages.announcements.index', [
            'student' => $student,
            'announcements' => $announcements,
        ]);
    }
}
