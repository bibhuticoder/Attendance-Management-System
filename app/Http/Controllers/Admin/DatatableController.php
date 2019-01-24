<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Model\Faculty;
use App\Model\Attendance;
use App\Model\Student;

class DatatableController extends Controller
{
    public function students(Request $request)
    {
        return DataTables::of(Student::query())->make(true);
    }

    public function attendances(Request $request)
    {
        $date    = $request->query('date');
        $faculty = $request->query('faculty');
        $batch   = $request->query('batch');

        if(!$request->query('faculty')){
            return DataTables::of(Attendance::query()->with('student')->orderBy('updated_at', 'DESC'))->make(true);
        }
        else{
            return DataTables::of(
                Attendance::query()
                    ->with('student')
                    ->whereHas('student', function($q) use ($faculty, $batch){
                        $q->where('faculty', $faculty)->whereYear('joined_at', $batch);
                    })
                    ->whereDate('checked_in_at', $date)
                    ->orderBy('created_at', 'Desc')
            )->make(true);
        }
    }
}
