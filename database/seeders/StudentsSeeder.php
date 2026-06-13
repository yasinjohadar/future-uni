<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentsSeeder extends Seeder
{
    private const COUNT = 50;

    private const STATUSES = ['active', 'active', 'active', 'active', 'active', 'inactive', 'graduated', 'suspended'];

    private array $firstNames = [
        'محمد', 'أحمد', 'عبدالله', 'خالد', 'سعود', 'فهد', 'تركي', 'سلمان', 'يوسف', 'عمر',
        'فاطمة', 'نورة', 'سارة', 'ريم', 'مها', 'لين', 'هند', 'أمل', 'دانة', 'جمان',
        'علي', 'حسن', 'إبراهيم', 'مصطفى', 'زيد', 'راشد', 'سعد', 'ماجد', 'بدر', 'نايف',
        'لمى', 'شهد', 'غادة', 'منى', 'هيفاء', 'العنود', 'جواهر', 'بسمة', 'رنا', 'أسماء',
    ];

    private array $lastNames = [
        'العتيبي', 'القحطاني', 'الدوسري', 'الشمري', 'الحربي', 'الزهراني', 'الغامدي', 'السبيعي',
        'المطيري', 'العنزي', 'الراشد', 'السالم', 'الفهد', 'الجبر', 'المالكي', 'الأحمد',
        'الخالد', 'الناصر', 'البلوشي', 'الشهري', 'العمري', 'الثبيتي', 'البقمي', 'القرني',
    ];

    public function run(): void
    {
        $programs = Program::active()->ordered()->get();

        if ($programs->isEmpty()) {
            $programs = Program::ordered()->get();
        }

        if ($programs->isEmpty()) {
            $this->command?->warn('لا توجد برامج في قاعدة البيانات. شغّل UniversitySeeder أولاً.');

            return;
        }

        $year = now()->year;
        $startIndex = $this->nextStudentIndex($year);
        $password = Hash::make('password');
        $created = 0;

        for ($i = 0; $i < self::COUNT; $i++) {
            $index = $startIndex + $i;
            $studentNumber = sprintf('%d%04d', $year, $index);
            $name = $this->randomArabicName();
            $email = sprintf('student.%d.%04d@futureuniversity.edu', $year, $index);

            if (Student::where('student_number', $studentNumber)->exists()) {
                continue;
            }

            if (User::where('email', $email)->exists()) {
                continue;
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'status' => 'active',
                'is_active' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_number' => $studentNumber,
                'program_id' => $programs->random()->id,
                'status' => self::STATUSES[array_rand(self::STATUSES)],
                'enrollment_date' => now()->subMonths(rand(1, 48))->subDays(rand(0, 28)),
            ]);

            $created++;
        }

        $this->command?->info("تم إنشاء {$created} طالب بنجاح.");
    }

    private function nextStudentIndex(int $year): int
    {
        $prefix = (string) $year;
        $max = Student::query()
            ->where('student_number', 'like', $prefix . '%')
            ->pluck('student_number')
            ->map(fn (string $number) => (int) substr($number, strlen($prefix)))
            ->max();

        return ($max ?? 0) + 1;
    }

    private function randomArabicName(): string
    {
        return $this->firstNames[array_rand($this->firstNames)] . ' ' . $this->lastNames[array_rand($this->lastNames)];
    }
}
