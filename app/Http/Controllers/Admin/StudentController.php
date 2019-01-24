<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Student;
use App\Model\Faculty;
use App\Model\Attendance;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $faculties = Faculty::all();
        return view('admin.student.index', compact('students', 'faculties'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.student.show', compact('student'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'faculty_id' => 'required',
        ]);
        
        // generate Roll No
        $now = Carbon::now();
        $year = substr($now->year . '', 1, 3);
        $faculty = 'BSCIT';
        $roll = '0'.Student::count();

        $request->merge(['roll_no' => $year.$faculty.$roll]);
        $request->merge(['joined_at' => $now]);
        $request->merge(['faculty' => Faculty::findOrFail($request->faculty_id)->name]);

        $created = Student::create($request->all());
        if($created) return redirect()->back()->with('success', 'Student Created Successfully.');
        else return redirect()->back()->with('error', 'Error');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'full_name' => 'required',
            'faculty_id' => 'required',
        ]);
        
        // generate Roll No
        $now = Carbon::now();
        $year = substr($now->year . '', 1, 3);
        $faculty = 'BSCIT';
        $roll = '0'.Student::count();

        $request->merge(['roll_no' => $year.$faculty.$roll]);
        $request->merge(['faculty' => Faculty::findOrFail($request->faculty_id)->name]);

        $updated = $student->update($request->all());
        if($updated) return redirect()->back()->with('success', 'Student Created Successfully.');
        else return redirect()->back()->with('error', 'Error');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $deleted = $student->delete();
        if($deleted) return redirect()->back()->with('success', 'Student deleted Successfully.');
        else return redirect()->back()->with('error', 'Error');
    }

    public function attendanceStatistics($id){
        $absent = Attendance::where('student_id', $id)->where('status', 0)->count();
        $present = Attendance::where('student_id', $id)->where('status', 1)->count(); 
        $late = Attendance::where('student_id', $id)->where('status', 2)->count(); 
        $stat = [$present, $absent, $late];
        return response()->json($stat, 200);
    }

}
