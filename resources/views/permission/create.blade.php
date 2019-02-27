@extends('layouts.base')

@push('styles')

@endpush

@section('title', 'Create Regions')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">--}}
            {{--                    <h3 class="panel-title">{{empty(1) ? 'New': 'Edit'}} User</h3>--}}

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
        @if (session()->has('danger'))
            <div class="alert alert-danger">
                {!! session()->get('danger') !!}
            </div>
        @endif
        <form class="form-horizontalx" method="POST" action="{{route('settings.permission.create')}}" >
            {{csrf_field()}}
                <div class="row">
                    <div class=" col-sm-4 ">
                        <label class=""> Permission name</label>
                        {{--<div class="col-sm-12">--}}
                            <input type="text" class="form-control" value="{{old('name')}}" name="name"
                                   placeholder="Name">
                        {{--</div>--}}
                    </div>
                    <div class=" col-sm-4 ">
                        <label class="">Display Name</label>
                        {{--<div class="col-sm-12">--}}
                            <input type="text" class="form-control" value="{{old('display_name')}}" name="display_name"
                                   placeholder="Display Name">
                        {{--</div>--}}
                    </div>
                    <div class="col-sm-4 ">
                        <label class="">Description</label>
                        {{--<div class="col-sm-12">--}}
                            <input type="text" class="form-control" value="{{old('description')}}" name="description"
                                   placeholder="Description">
                        {{--</div>--}}
                    </div>

                </div>

            <hr>
            <div class="row" style="margin-left: 400px">
                <div class="col-md-1">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
                <div class="col-md-4" style="margin-left: 60px">
                    <a href="{{route('settings.permission.create')}}" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>Back</a>
                </div>
            </div>
        </form>
@endsection

@push('scripts')


@endpush