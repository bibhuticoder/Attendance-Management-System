<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Faculty;
use App\Model\Attendance;

class AttendanceController extends Controller
{

    public function index(Request $request)
    {
        $faculties = Faculty::all();
        return view('admin.attendance.index', compact('faculties'));
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
