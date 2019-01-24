<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Faculty;
use App\Model\Attendance;
use App\Model\Student;

class StatisticsController extends Controller
{

    public function index(){
        return view('admin.statistics.index');
    }

    public function facultyPresentPercentages(Request $request)
    {   
        $attendanceByFaculties = array();
        $faculties = Faculty::all();
        $attendances = Attendance::with('student')->where('status', 1)->get();

        // create array indexes
        foreach($faculties as $faculty){
            $attendanceByFaculties[$faculty->name] = 0;
        };

        // get no of PRESENT student in each faculty
        foreach($attendances as $attendance){
            $attendanceByFaculties[$attendance->student->faculty]++;
        };

        // calcuate present percentage
        foreach($attendanceByFaculties as $faculty_name => $present_students) {
            $total_students = Faculty::with('students')->where('name', $faculty_name)->firstorFail()->students->count();

            // avoid divede by zero error
            if($total_students > 0) $attendanceByFaculties[$faculty_name] = ($present_students/$total_students)*100;
            else $attendanceByFaculties[$faculty_name] = 0;
        }

        return $attendanceByFaculties;
    }

    public function topStudents(){
        $attendances = Attendance::with('student')->where('status', 1)->get();

        $students = array();
        foreach($attendances as $attendance){
            if(array_key_exists($attendance->student->full_name, $students)) 
                $students[$attendance->student->full_name]++;
            else
                $students[$attendance->student->full_name] = 0;
        }

        // sort according to present days DESC
        arsort($students);

        // only top 10
        return array_slice($students, 0, 10);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $updated = $attendance->update($request->all());
        if($updated) return redirect()->back()->with('success', 'Attendance Updated Successfully.');
        else return redirect()->back()->with('error', 'Error');
    }

    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        $deleted = $faculty->delete();
        if($deleted) return redirect()->back()->with('success', 'Faculty deleted Successfully.');
        else return redirect()->back()->with('error', 'Error');
    }

}
