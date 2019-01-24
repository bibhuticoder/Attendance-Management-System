@extends('layouts.app') 
@section('content')

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Attendance System</a>
    </div>
</nav>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-7 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5">Try the full featured QR code based Attendance System Application</h1>
                    <a href="/attendance" class="btn btn-outline btn-xl js-scroll-trigger">Take Attendance</a>
                </div>
            </div>
            <div class="col-lg-5 my-auto">
                <img src="img/qr-scan.png" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</header>
@stop