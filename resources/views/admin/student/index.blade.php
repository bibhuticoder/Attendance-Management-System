@extends('adminlte::page')

@section('content_header')
    <h1>Manage Faculties</h1>
@stop

@section('content')
    
<div class="box box-solid">
    <div class="box-body">
        <button
            type="button" 
            class="btn btn-primary" 
            data-toggle="modal" 
            data-target="#modal-add">
                <i class="fa fa-user-plus"></i>
                &nbsp;Add New Student
        </button>
        @if ($errors->any())
                {!! implode('', $errors->all('<span class="help-block">:message</span>')) !!}
        @endif
        <br>
        <br>
        {{-- Table --}}
        <table class="table table-hover table-responsive" id="students-table">
            <thead>
                <tr>
                    <th>Sn.</th>
                    <th>Full Name</th>
                    <th>Roll No</th>
                    <th>Faculty</th>
                    <th>Date Joined</th>
                    <th>Controls</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


{{-- Delete Modal --}}
<div class="modal fade in" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Delete Student</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Student ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>

                {{-- delete button --}}
                <form action="" method="POST" id="form-delete">
                    {{method_field('DELETE')}}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-sm btn-danger" value="Yes"/>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade in" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="students" method="post" id="form-edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Student</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="full_name" id="edit-student-full_name" class="form-control" placeholder="Student's Fullname" required>
                    <br>
                    <select name="faculty_id" id="edit-student-faculty_id" class="form-control" required>
                        @foreach ($faculties as $faculty)
                        <option value="{{$faculty->id}}">{{$faculty->name}}</option>   
                        @endforeach
                    </select>
                    <br>
                    <label>Roll no. and other necessary fields will be generated automatically.</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    {{method_field('PUT')}}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-sm btn-primary" value="Save Changes"/>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade in" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="students" method="post" id="form-add">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Student</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="full_name" class="form-control" placeholder="Student's Fullname" required>
                    <br>
                    <select name="faculty_id" class="form-control" required>
                        <option value="">----------</option>
                        @foreach ($faculties as $faculty)
                        <option value="{{$faculty->id}}">{{$faculty->name}}</option>   
                        @endforeach
                    </select>
                    <br>
                    <label>Roll no. and other necessary fields will be generated automatically.</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-sm btn-primary" value="Save Changes"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function deleteStudent(id){
		$("#form-delete").attr("action", `students/${id}`);
	}

    function editStudent(id, full_name, faculty_id){
		$("#form-edit").attr("action", `students/${id}`);
        $("#edit-student-full_name").val(full_name);
        $("#edit-student-faculty_id").val(faculty_id);
	}


    window.onload = function(){
        $("#students-table").DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/get-students',
            responsive: true,
            order: [[1, 'asc']],
            columns:[
                {data: 'id', name: 'id', orderable: false, render: (data, type, student, meta) => {
                    return meta.row+1;
                }},
                {data: 'full_name', name: 'full_name', render: (data, type, student) => {
                    return `<a href="students/${student.id}">${student.full_name}</a>`;
                }},
                {data: 'roll_no', name: 'roll_no'},
                {data: 'faculty', name: 'faculty'},
                {data: 'joined_at', name: 'joined_at'},
                {data: 'id', name: 'id', orderable: false, render: (data, type, student) => {
                    return(`
                    <button
                            type="button" 
                            class="btn btn-sm btn-danger" 
                            data-toggle="modal" 
                            onclick="deleteStudent(${student.id})"
                            data-target="#modal-delete">
                                <i class="fa fa-trash"></i>
                        </button>
                        <button
                            type="button" 
                            class="btn btn-sm btn-primary" 
                            data-toggle="modal" 
                            onclick="editStudent(${student.id}, '${student.full_name}', '${student.faculty_id}')"
                            data-target="#modal-edit">
                                <i class="fa fa-pencil"></i>
                        </button>
                    `);
                }},
            ]
        });
    }

</script>

@stop