<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Faculty;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::all();
        return view('admin.faculty.index', compact('faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:faculties',
        ]);
        $created = Faculty::create($request->all());
        if($created) return redirect()->back()->with('success', 'Faculty Created Successfully.');
        else return redirect()->back()->with('error', 'Error');
    }

    public function update(Request $request, $id)
    {
        $faculty = Faculty::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:faculties,name' . $faculty->id,
        ]);
        $updated = $faculty->update($request->all());
        if($updated) return redirect()->back()->with('success', 'Faculty Updated Successfully.');
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
