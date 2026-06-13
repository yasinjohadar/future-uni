<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Concerns\RespondsWithAjaxTable;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use RespondsWithAjaxTable;

    public function index(Request $request)
    {
        $data = $this->buildStudentsIndexData($request);

        if ($response = $this->ajaxTableResponse(
            $request,
            $data,
            'admin.people.students.partials.list',
            'admin.people.students.partials.modals'
        )) {
            return $response;
        }

        return view('admin.people.students.index', $data);
    }

    /**
     * @return array{students: \Illuminate\Contracts\Pagination\LengthAwarePaginator, programs: \Illuminate\Support\Collection, stats: array<string, int>}
     */
    private function buildStudentsIndexData(Request $request): array
    {
        $query = Student::with(['user', 'program.college']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $programs = Program::active()->ordered()->get();

        $stats = [
            'total' => Student::count(),
            'active' => Student::where('status', 'active')->count(),
            'graduated' => Student::where('status', 'graduated')->count(),
            'suspended' => Student::where('status', 'suspended')->count(),
            'filtered' => $students->total(),
        ];

        return compact('students', 'programs', 'stats');
    }

    public function create()
    {
        $programs = Program::active()->ordered()->get();

        return view('admin.people.students.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'student_number' => 'required|string|max:50|unique:students,student_number',
            'program_id' => 'nullable|exists:programs,id',
            'status' => 'required|in:active,inactive,graduated,suspended',
            'enrollment_date' => 'nullable|date',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_number' => $validated['student_number'],
            'program_id' => $validated['program_id'] ?? null,
            'status' => $validated['status'],
            'enrollment_date' => $validated['enrollment_date'] ?? now(),
        ]);

        return redirect()->route('admin.people.students.index')->with('success', 'تم إضافة الطالب بنجاح.');
    }

    public function edit(Student $student)
    {
        $student->load(['user', 'program.college']);
        $programs = Program::active()->ordered()->get();

        return view('admin.people.students.edit', compact('student', 'programs'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'student_number' => 'required|string|max:50|unique:students,student_number,' . $student->id,
            'program_id' => 'nullable|exists:programs,id',
            'status' => 'required|in:active,inactive,graduated,suspended',
            'enrollment_date' => 'nullable|date',
        ]);

        $student->user?->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $student->update([
            'student_number' => $validated['student_number'],
            'program_id' => $validated['program_id'] ?? null,
            'status' => $validated['status'],
            'enrollment_date' => $validated['enrollment_date'] ?? $student->enrollment_date,
        ]);

        return redirect()->route('admin.people.students.index')->with('success', 'تم تحديث بيانات الطالب.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.people.students.index')->with('success', 'تم حذف الطالب.');
    }
}
