@extends('layouts.base')

@section('title', 'Dashboard')

@section('header')
    <li><a href="#">Home</a></li>
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <!-- START WIDGETS -->
    <div class="row">
        <div class="col-md-12">

            <!-- START WIDGET CLOCK -->
            <div class="widget widget-padding-sm" style="background-color: #59ABE3 !important;">
                <div class="widget-big-int plugin-clock">00:00</div>
                <div class="widget-subtitle plugin-date">Loading...</div>
                <div class="widget-controls">
                    {{--<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>--}}
                </div>
                <div class="widget-buttons widget-c3">
                    <div class="col-md-offset-4 col">
                        <a href="{{route('report.file.index')}}"><span class="fa fa-clock-o"></span></a>
                    </div>
                    {{--<div class="col">--}}
                        {{--<a href="#"><span class="fa fa-bell"></span></a>--}}
                    {{--</div>--}}
                    {{--<div class="col">--}}
                        {{--<a href="#"><span class="fa fa-calendar"></span></a>--}}
                    {{--</div>--}}
                </div>
            </div>
            <!-- END WIDGET CLOCK -->

        </div>
    </div>

    <!-- END DASHBOARD CHART -->
@endsection