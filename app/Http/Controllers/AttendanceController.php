<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Faculty;
use App\Model\Attendance;
use App\Model\Student;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function takeAttendance(Request $request)
    {
        $request->validate([
            'roll_no' => 'required',
        ]);

        $student = Student::where('roll_no', $request->input('roll_no'))->firstOrFail();
        $now = Carbon::now();
        $check_in_deadline = Carbon::createFromTime(9, 0, 0, 'UTC');
        
        // check if already checked_in 
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('checked_in_at', Carbon::now()->toDateString())
            ->first();
        
        // check out if already checked_in
        if($attendance){
            $attendance->checked_out_at = $now;
            $attendance->status = 1;
            $updated = $attendance->save();
            return ($updated)
                ? response()->json('Checked out successfully.', 200)
                : response()->json('Error', 400);
        }

        // if not, check in
        $created = Attendance::create([
            'student_id' => $student->id,
            'checked_in_at' => $now,
            'status' => ($now->gt($check_in_deadline)) ? 2 : 1

        ]);
        return ($created)
            ? response()->json('Checked in successfully.', 200)
            : response()->json('Error', 400);
    }
}
