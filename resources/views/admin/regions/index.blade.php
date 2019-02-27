@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@endpush

@section('title', 'Category')

@section('header')
    <li><a href="#">Home</a></li>
    <li class="active">Users</li>
@endsection
@section('action')
    <div class="col-sm-6">
        <div class="m-t-sm text-right text-left-xs">
            <a href="{{route('settings.regions.create')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> ADD NEW</a>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">--}}
                    {{--<h3 class="panel-title">Roles</h3>--}}
                    <span style="float: right; margin-right: 25px">
                        {{--<a href="#" class="btn btn-primary"><span class="fa fa-plus"></span> New User</a></li>--}}
                    </span>
                </div>
                {{--<div class="panel-body">--}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {!! session()->get('success') !!}
                        </div>
                    @endif
                    {!! $dataTable->table() !!}
                </div>
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@stop
@push('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}
@endpush