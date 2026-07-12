<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Enums\EnrollmentStatus;
use App\Enums\FeeInvoiceStatus;
use App\Enums\LibraryLoanStatus;
use App\Models\AcademicTerm;
use App\Models\Announcement;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\FeeInvoice;
use App\Models\FeePayment;
use App\Models\Grade;
use App\Models\LibraryBook;
use App\Models\LibraryLoan;
use App\Models\Program;
use App\Models\ProgramCourse;
use App\Models\StaffMember;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentPortalSeeder extends Seeder
{
    public function run(): void
    {
        $studentUser = User::where('email', config('demo-credentials.student.email'))->first();
        $doctorUser = User::where('email', config('demo-credentials.doctor.email'))->first();
        $student = $studentUser?->student;

        if (! $student) {
            $this->command?->warn('لم يُعثر على الطالب التجريبي — تأكد من تشغيل DoctorsSeeder أولاً.');

            return;
        }

        $program = $student->program ?? Program::active()->ordered()->first();
        if (! $program) {
            $this->command?->warn('لا يوجد برنامج أكاديمي للـ seed.');

            return;
        }

        $courses = collect([
            ['code' => 'BUS101', 'name' => 'مبادئ الإدارة', 'credits' => 3, 'semester' => 1, 'type' => 'core'],
            ['code' => 'BUS102', 'name' => 'محاسبة مالية', 'credits' => 3, 'semester' => 1, 'type' => 'core'],
            ['code' => 'BUS201', 'name' => 'سلوك تنظيمي', 'credits' => 3, 'semester' => 2, 'type' => 'core'],
            ['code' => 'BUS202', 'name' => 'تسويق أساسي', 'credits' => 3, 'semester' => 2, 'type' => 'core'],
            ['code' => 'ENG101', 'name' => 'لغة إنجليزية 1', 'credits' => 2, 'semester' => 1, 'type' => 'general'],
            ['code' => 'IT101', 'name' => 'مهارات حاسوب', 'credits' => 2, 'semester' => 1, 'type' => 'general'],
        ])->map(function (array $data, int $index) use ($program) {
            return ProgramCourse::updateOrCreate(
                ['program_id' => $program->id, 'code' => $data['code']],
                [
                    'name' => $data['name'],
                    'credits' => $data['credits'],
                    'semester' => $data['semester'],
                    'type' => $data['type'],
                    'sort_order' => $index + 1,
                ]
            );
        });

        $term = AcademicTerm::updateOrCreate(
            ['code' => '2025-FALL'],
            [
                'name' => 'الفصل الأول 2025/2026',
                'starts_at' => now()->startOfMonth()->subMonths(1),
                'ends_at' => now()->startOfMonth()->addMonths(3),
                'registration_opens_at' => now()->subDays(14),
                'registration_closes_at' => now()->addDays(30),
                'is_current' => true,
                'is_active' => true,
            ]
        );
        $term->markAsCurrent();

        $staff = StaffMember::query()->active()->ordered()->first();

        $schedule = [
            ['days' => [0, 2], 'starts_at' => '08:00:00', 'ends_at' => '09:30:00', 'room' => 'قاعة 101'],
            ['days' => [1, 3], 'starts_at' => '10:00:00', 'ends_at' => '11:30:00', 'room' => 'قاعة 205'],
            ['days' => [0, 2], 'starts_at' => '12:00:00', 'ends_at' => '13:30:00', 'room' => 'مختبر أ'],
            ['days' => [1, 4], 'starts_at' => '08:00:00', 'ends_at' => '09:30:00', 'room' => 'قاعة 110'],
        ];

        $sections = $courses->take(4)->values()->map(function (ProgramCourse $course, int $index) use ($term, $staff, $doctorUser, $schedule) {
            $slot = $schedule[$index % count($schedule)];

            return CourseSection::updateOrCreate(
                [
                    'program_course_id' => $course->id,
                    'academic_term_id' => $term->id,
                    'section_code' => 'A',
                ],
                [
                    'staff_member_id' => $staff?->id,
                    'instructor_user_id' => $doctorUser?->id,
                    'capacity' => 40,
                    'days' => $slot['days'],
                    'starts_at' => $slot['starts_at'],
                    'ends_at' => $slot['ends_at'],
                    'room' => $slot['room'],
                    'is_active' => true,
                ]
            );
        });

        // Extra open section for self-registration demo (not auto-enrolled)
        $openCourse = $courses->get(4);
        if ($openCourse) {
            CourseSection::updateOrCreate(
                [
                    'program_course_id' => $openCourse->id,
                    'academic_term_id' => $term->id,
                    'section_code' => 'A',
                ],
                [
                    'staff_member_id' => $staff?->id,
                    'instructor_user_id' => $doctorUser?->id,
                    'capacity' => 40,
                    'days' => [2, 4],
                    'starts_at' => '14:00:00',
                    'ends_at' => '15:30:00',
                    'room' => 'قاعة 301',
                    'is_active' => true,
                ]
            );
        }

        $gradeSamples = [
            ['midterm' => 85, 'final' => 90],
            ['midterm' => 78, 'final' => 82],
            ['midterm' => 88, 'final' => 85],
            ['midterm' => null, 'final' => null],
        ];

        foreach ($sections as $index => $section) {
            $enrollment = Enrollment::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'course_section_id' => $section->id,
                ],
                [
                    'status' => EnrollmentStatus::Enrolled,
                    'enrolled_at' => now()->subDays(20),
                ]
            );

            $sample = $gradeSamples[$index] ?? ['midterm' => null, 'final' => null];
            $grade = Grade::updateOrCreate(
                ['enrollment_id' => $enrollment->id],
                [
                    'midterm' => $sample['midterm'],
                    'final' => $sample['final'],
                ]
            );
            $grade->recalculate();
            $grade->published_at = ($sample['midterm'] !== null) ? now()->subDay() : null;
            $grade->save();
        }

        Announcement::updateOrCreate(
            ['title' => 'بدء الفصل الدراسي الحالي'],
            [
                'body' => 'مرحباً بكم في الفصل الدراسي الحالي. يرجى متابعة الجدول والمقررات من بوابة الطالب.',
                'audience' => 'all',
                'published_at' => now()->subDays(3),
                'is_active' => true,
                'created_by' => User::where('email', config('demo-credentials.admin.email'))->value('id'),
            ]
        );

        Announcement::updateOrCreate(
            ['title' => 'تنبيه خاص ببرنامجك'],
            [
                'body' => 'يرجى مراجعة الخطة الدراسية والتأكد من استكمال متطلبات هذا الفصل.',
                'audience' => 'program',
                'program_id' => $program->id,
                'college_id' => $program->college_id,
                'published_at' => now()->subDay(),
                'is_active' => true,
            ]
        );

        $invoice = FeeInvoice::updateOrCreate(
            [
                'student_id' => $student->id,
                'title' => 'رسوم الفصل الأول 2025/2026',
            ],
            [
                'amount' => 2500,
                'paid_amount' => 1000,
                'due_date' => now()->addDays(20),
                'status' => FeeInvoiceStatus::Partial,
                'notes' => 'دفعة أولى مسجّلة',
            ]
        );

        if ($invoice->payments()->count() === 0) {
            FeePayment::create([
                'fee_invoice_id' => $invoice->id,
                'amount' => 1000,
                'paid_at' => now()->subDays(10),
                'method' => 'نقداً',
                'note' => 'دفعة أولى',
                'recorded_by' => User::where('email', config('demo-credentials.admin.email'))->value('id'),
            ]);
        }

        $book = LibraryBook::query()->active()->first();
        if ($book) {
            LibraryLoan::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'library_book_id' => $book->id,
                    'status' => LibraryLoanStatus::Borrowed,
                ],
                [
                    'borrowed_at' => now()->subDays(7),
                    'due_at' => now()->addDays(7),
                    'returned_at' => null,
                    'notes' => 'استعارة تجريبية',
                ]
            );
        }

        $firstSection = $sections->first();
        if ($firstSection && $doctorUser) {
            $attendanceSession = AttendanceSession::updateOrCreate(
                [
                    'course_section_id' => $firstSection->id,
                    'session_date' => now()->subDays(2)->toDateString(),
                ],
                [
                    'title' => 'محاضرة تجريبية',
                    'note' => 'جلسة حضور للتجربة',
                ]
            );

            foreach ($firstSection->enrollments()->where('status', 'enrolled')->get() as $enrollment) {
                AttendanceRecord::updateOrCreate(
                    [
                        'attendance_session_id' => $attendanceSession->id,
                        'enrollment_id' => $enrollment->id,
                    ],
                    ['status' => AttendanceStatus::Present]
                );
            }

            Announcement::updateOrCreate(
                [
                    'title' => 'تنبيه من الدكتور — شعبة ' . $firstSection->section_code,
                    'course_section_id' => $firstSection->id,
                ],
                [
                    'body' => 'يرجى مراجعة متطلبات المقرر والتجهيز للامتحان النصفي.',
                    'audience' => 'section',
                    'published_at' => now()->subHours(5),
                    'is_active' => true,
                    'created_by' => $doctorUser->id,
                ]
            );
        }

        $this->command?->info('تم تجهيز بيانات بوابة الطالب التجريبية.');
    }
}
