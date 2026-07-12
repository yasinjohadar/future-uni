<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DoctorsSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        $doctorCreds = config('demo-credentials.doctor');
        $doctor = User::updateOrCreate(
            ['email' => $doctorCreds['email']],
            [
                'name' => $doctorCreds['name'],
                'password' => Hash::make($doctorCreds['password']),
                'status' => 'active',
                'is_active' => true,
            ]
        );
        $doctor->syncRoles(['doctor']);

        $studentCreds = config('demo-credentials.student');
        $programId = Program::active()->ordered()->value('id') ?? Program::query()->value('id');

        $studentUser = User::updateOrCreate(
            ['email' => $studentCreds['email']],
            [
                'name' => $studentCreds['name'],
                'password' => Hash::make($studentCreds['password']),
                'status' => 'active',
                'is_active' => true,
            ]
        );
        $studentUser->syncRoles(['student']);

        if ($programId) {
            $existingNumber = Student::where('user_id', $studentUser->id)->value('student_number');
            $studentNumber = $existingNumber;

            if (! $studentNumber) {
                $year = now()->year;
                $max = Student::query()
                    ->where('student_number', 'like', $year . '%')
                    ->pluck('student_number')
                    ->map(fn (string $number) => (int) substr($number, 4))
                    ->max();
                $studentNumber = sprintf('%d%04d', $year, ($max ?? 0) + 1);
            }

            Student::updateOrCreate(
                ['user_id' => $studentUser->id],
                [
                    'student_number' => $studentNumber,
                    'program_id' => $programId,
                    'status' => 'active',
                    'enrollment_date' => now()->subYear(),
                ]
            );
        }

        $this->command?->info('تم تجهيز حسابات الدكتور والطالب التجريبية.');
    }
}
