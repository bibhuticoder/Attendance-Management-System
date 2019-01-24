<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Faculty;
use App\Model\Student;
use App\Model\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = array();
        $data['faculties'] = Faculty::count();
        $data['students'] = Student::count();
        $data['attendances'] = Attendance::count();
        $attendancesToday = Attendance::whereDate('checked_in_at', Carbon::now()->toDateString())->get();
        return view('admin.dashboard.dashboard', compact('data', 'attendancesToday'));
    }

}
