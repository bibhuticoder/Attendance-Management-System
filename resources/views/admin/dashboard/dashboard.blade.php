@extends('adminlte::page') 
@section('title', 'AdminLTE') 
@section('content_header')
<h1>Dashboard</h1>





@stop 
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$data['faculties']}}</h3>

                <p>Faculties</p>
            </div>
            <div class="icon">
                <i class="fa fa-fw fa-university "></i>
            </div>
            <a href="/admin/faculties" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$data['students']}}</h3>

                <p>Students</p>
            </div>
            <div class="icon">
                <i class="fa fa-fw fa-users "></i>
            </div>
            <a href="/admin/students" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$data['attendances']}}</h3>

                <p>Attendance</p>
            </div>
            <div class="icon">
                <i class="fa fa-book "></i>
            </div>
            <a href="/admin/attendances" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{count($attendancesToday)}}</h3>

                <p>Attendances today</p>
            </div>
            <div class="icon">
                <i class="fa fa-fw fa-area-chart "></i>
            </div>
            <a href="/admin/statistics" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Attendances</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover" id="attendances-table">
                    <thead>
                        <tr>
                            <th>Sn.</th>
                            <th>Student Name</th>
                            <th>Faculty</th>
                            <th>Status</th>
                            <th>Checked In At</th>
                            <th>Checked Out At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", function(){
        $("#attendances-table").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            searching: false,
            ajax: '/admin/get-attendances',
            responsive: true,
            pageLength: 5,
            columns:[
                {data: 'id', name: 'id', render: (data, type, attendance, meta) => {
                    return meta.row+1;
                }},
                {data: 'student.full_name', name: 'full_name', render: (data, type, attendance) => {
                    return `<a href="/admin/students/${attendance.student.id}">${data}</a>`;
                }},
                {data: 'student.faculty', name: 'faculty'},
                {data: 'status', name: 'status', render: (data, type, attendance) => {
                    return `<span class="label label-${['danger', 'success', 'warning'][data]}">${['Absent', 'Present', 'Late'][data]}</label>`;
                }},
                {data: 'checked_in_at', name: 'checked_in_at'},
                {data: 'checked_out_at', name: 'checked_out_at'},
            ]
        });
    });
</script>





@stop