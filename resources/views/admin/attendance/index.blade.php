@extends('layouts.admin') 
@section('content_header')
<h1>Browse Attendance</h1>

@stop 
@section('content')

<div class="box box-solid">
    <div class="box-header">
        <div class="row">

            {{-- date --}}
            <div class="col-md-2">
                <input type="text" id="browse-date" class="form-control" data-toggle="datepicker" placeholder="Select Date" autocomplete="off"
                />
            </div>

            {{-- faculty --}}
            <div class="col-md-2">
                <select id="browse-faculty" class="form-control" required>
                        <option value="">Select Faculty</option>
                        @foreach ($faculties as $faculty)
                            <option value="{{$faculty->name}}">{{$faculty->name}}</option>
                        @endforeach
                    </select>
            </div>

            {{-- batch --}}
            <div class="col-md-2">
                <select id="browse-batch" class="form-control" required>
                        <option value="">Select Batch</option>
                        @for ($i = 2012; $i <= (int)Carbon\Carbon::now()->year; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" onclick="browse()">Browse</button>
            </div>

        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover" id="attendances-table">
            <thead>
                <tr>
                    <th>Sn.</th>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Checked In At</th>
                    <th>Checked Out At</th>
                    <th>Change Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- Change Attendance Status Modal --}}
<div class="modal fade in" id="modal-change-status">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="form-change-status">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Change Attendance Status</h4>
                    </div>
                    <div class="modal-body">
                        <p>Student Name: <label id="change-status-student-name"></label></p>
                        <p>Attendance Date: <label id="change-status-attendance-date"></label></p>

                        <select name="status" id="change-status-status" class="form-control">
                            <option value="0">Absent</option>
                            <option value="1">Present</option>
                            <option value="2">Late</option>
                        </select>
                        
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


<script>
    var ajaxUrl = '/admin/get-attendances';
    function changeAttendanceStatus(id, status, studentName, checkedInAt){
        $("#form-change-status").attr('action', `attendances/${id}`);
        $("#change-status-student-name").text(studentName);
        $("#change-status-attendance-date").text(checkedInAt);
        $("#change-status-status").val(status);
    }

    function browse(){
        var date    = $("#browse-date").val();
        var faculty = $("#browse-faculty").val();
        var batch   = $("#browse-batch").val();

        if(date.length === 0 | faculty.length === 0| batch.length === 0){
            alert('None of the fields can be empty');
            return;
        }
        
        ajaxUrl = `${ajaxUrl}?date=${date}&faculty=${faculty}&batch=${batch}`; 
        $('#attendances-table').DataTable().ajax.url(ajaxUrl).load();
    }

    window.addEventListener("load", function(){
        $("#attendances-table").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            searching: false,
            ajax: ajaxUrl,
            responsive: true,
            columns:[
                {data: 'id', name: 'id', render: (data, type, attendance, meta) => {
                    return meta.row+1;
                }},
                {data: 'student.full_name', name: 'full_name', render: (data, type, attendance) => {
                    return `<a href="students/${attendance.student.id}">${data}</a>`;
                }},
                {data: 'status', name: 'status', render: (data, type, attendance) => {
                    return `<span class="label label-${['danger', 'success', 'warning'][data]}">${['Absent', 'Present', 'Late'][data]}</label>`;
                }},
                {data: 'checked_in_at', name: 'checked_in_at'},
                {data: 'checked_out_at', name: 'checked_out_at'},
                {data: 'id', name: 'id', render: (data, type, attendance) => {
                    return(`
                    <button
                            type="button" 
                            class="btn btn-sm btn-default" 
                            data-toggle="modal" 
                            onclick="changeAttendanceStatus('${attendance.id}', '${attendance.status}', '${attendance.student.full_name}', '${attendance.checked_in_at}')"
                            data-target="#modal-change-status">
                                <i class="fa fa-refresh"></i> Change Status
                        </button>
                    `);
                }},
            ]
        });
    });

</script>


@stop