@extends('adminlte::page') 
@section('content_header')
<h1>
    <- </h1>






        
@stop 
@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Student Details</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>{{$student->full_name}}</td>
                            </tr>
                            <tr>
                                <td>Roll No.</td>
                                <td id="roll_no">{{$student->roll_no}}</td>
                            </tr>
                            <tr>
                                <td>Faculty</td>
                                <td>{{$student->faculty}}</td>
                            </tr>
                            <tr>
                                <td>Date Joined</td>
                                <td>{{Carbon\Carbon::parse($student->joined_at)->toFormattedDateString()}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Identity Card</h3>
                    </div>
                    <div class="box-body">
                        <div id="id-card" style="width: 400px; height: 150px; border-style: solid; border-width: 1px; padding: 10px;">
                            <div id="qrcode" style="float:left; margin-right: 50px;"></div>
                            <p>Name: {{$student->full_name}}</p>
                            <p>Roll no: {{$student->roll_no}}</p>
                            <p>Faculty: {{$student->faculty}}</p>
                            <p>Date Joined: {{Carbon\Carbon::parse($student->joined_at)->toFormattedDateString()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Attendance Statistics till Today</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="doughnutChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('js/qrcode.min.js')}}"></script>
        <script>
            window.onload = function(){
                
                // Generate QR code
                var qrcode = new QRCode("qrcode", {
                    text: $("#roll_no").text().trim(),
                    width: 128,
                    height: 128,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });

                // chart JS
                getAttendanceDataOfStudent();
            }


            function initDoughnutChart(stats){
                var options = {
                    maintainAspectRatio: false
                };
                var data = {
                    datasets: [{
                        data: stats,
                            backgroundColor:[
                            '#4CAF50', //green
                            '#f44336', //red
                            '#FFC107' //orange
                        ],
                        borderColor: [
                            '#2E7D32',
                            '#c62828',
                            '#FF8F00'
                        ],
                        borderWidth: 1
                    }],
                    labels: [
                        'Present',
                        'Absent',
                        'Late'
                    ]
                };
                var ctx = document.getElementById("doughnutChart");
                ctx.height = 300;
                var myDoughnutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: options
                });
            }

            function getAttendanceDataOfStudent(){
                $.ajax({
                    method: 'GET',
                    url: '/admin/students/{{$student->id}}/attendance-statistics'
                })
                .done((stat) => {
                    // console.log(stat.join);
                    initDoughnutChart(stat);
                })
                // 
            }

        </script>

        
@stop