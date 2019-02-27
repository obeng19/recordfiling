@extends('layouts.base')

@push('styles')

@endpush

@section('title', 'Create Role')

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
                        <form class="form-horizontalx" method="POST" action="{{route('settings.management.role.create')}}">
                            {{csrf_field()}}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Name</label>
                                    <input name="name" type="text" value="{{  old('name') }}" class="form-control" placeholder="Name">
                                </div>
                                <div class="col-sm-4">
                                    <label>Code</label>
                                    <input name="code" type="text" value="{{  old('code') }}" class="form-control" placeholder="Code" >
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-sm-12 ">
                                    <div class="col-sm-12">
                                        @foreach($permissions->chunk(20) as $specimens)
                                            <div class="col-sm-4">
                                                @foreach($specimens as $permissions)
                                                    {{--<label class="checkbox-inline">--}}
                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <input style="" class="" type="checkbox" id="permission_id" name="permission_id[]" value="{{$permissions->id}}" >
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <span style="text-transform: uppercase">{{$permissions->name}}</span>
                                                        </div>
                                                    </div>

                                                    {{--</label>--}}
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            <hr />
                            <div class="row" style="margin-left: 400px">
                                <div class="col-md-1">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
                                <div class="col-md-4" style="margin-left: 60px">
                                    <a href="{{route('settings.management.role.index')}}" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>Back</a>
                                </div>
                            </div>
                    </form>
                </div>
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@stop

@push('scripts')

@endpush
