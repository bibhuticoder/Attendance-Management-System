@extends('layouts.admin') 
@section('content_header')
<h1>Attendance Statistics</h1>



@stop 
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Present percentage by faculty</h3>
            </div>
            <div class="box-body">
                    <canvas id="presentPercentChart" width="300" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Top 10 students</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sn</th>
                                <th>Student Name</th>
                                <th>Present Days</th>
                            </tr>
                        </thead>
                        <tbody id="top-students">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>


<script>

    function random(min, max){
        return parseInt(Math.random() * (max - min) + min);
    }

    function getRandomColors(num){
        var colors = ['f44336', 'E91E63', '9C27B0', '673AB7', '3F51B5', '2196F3', '03A9F4', '00BCD4', '009688', '4CAF50', '8BC34A', 'FFEB3B', 'FF5722', '795548', '607D8B']
        var final = [];
        while(num > 0){
            var randColor = colors[random(0, colors.length)];
            if(final.indexOf(randColor) === -1){
                final.push(randColor);
                num--;
            }
        }
        return final.map((f) => '#' + f);
    }

    function getPresentPercentageByFaculty(){
        $.ajax({
            method: 'GET',
            url: '/admin/statistics/faculty-present-percentages'
        }).done((data) => {
            console.log(data);
            initPresentPercentChart(data);
        })
    }

    function getTopStudents(){
        $.ajax({
            method: 'GET',
            url: '/admin/statistics/top-students'
        }).done((data) => {
            var html = "";
            var count = 0;
            for(var name in data){
                html += `
                    <tr>
                        <td>${count+1}</td>
                        <td>${name}</td>
                        <td>
                            <span class="badge bg-green">${data[name]}</span>
                        </td>
                    </tr>
                `;
                count++;
            }
            $("#top-students").html(html);
        })
    }

    function initPresentPercentChart(stats){

        var data = Object.values(stats);
        var labels = Object.keys(stats);
        var colors = getRandomColors(data.length);
        var options = {
            maintainAspectRatio: false
        };
        var data = {
            datasets: [{
                data: data,
                backgroundColor: colors
            }],
            labels: labels
        };
        var ctx = document.getElementById("presentPercentChart");
        ctx.height = 230;
        var myDoughnutChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });
            
    }

    window.addEventListener("load", function(){
        console.log('asda');
        getPresentPercentageByFaculty();
        getTopStudents();
    });

</script>



@stop