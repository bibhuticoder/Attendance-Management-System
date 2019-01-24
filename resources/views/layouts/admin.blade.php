@extends('adminlte::page')


@section('css')
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}" />
@stop

@section('js')
    <script src="{{asset('js/datepicker.js')}}"></script>
    <script>
    window.onload = function(){
        $('input[data-toggle="datepicker"]').datepicker({
            format: 'yyyy-mm-dd'
        });
    }
    </script>
@stop