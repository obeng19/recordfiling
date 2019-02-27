@extends('layouts.base')

@push('styles')

@endpush

@section('title', 'Edit Region')

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
                        <form class="form-horizontalx" method="POST" action="{{route('settings.subcategory.edit', ['id'=>$data->id])}}" >
                            {{csrf_field()}}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Category</label>
                                    <select name="cat_id" id="" class="form-control select">
                                        @php $_cat_id = !empty(old('cat_id')) ? old('cat_id') : $data->cat_id @endphp
                                        @foreach($category as $categorys)
                                            <option value="{{ $categorys->id }}" {!! $_cat_id == $categorys->id ? 'selected="selected"' : '' !!}>{{ $categorys->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label>Region</label>
                                    @php $_name = !empty(old('name')) ? old('name') : $data->name @endphp
                                    <input name="name" type="text" value="{{$_name}}" class="form-control" placeholder="Greater Accra">
                                </div>
                                <div class="col-sm-4">
                                    @php $_description = !empty(old('description')) ? old('description') : $data->description @endphp
                                    <label>Description</label>
                                    <textarea name="description" id="" class="form-control col-md-12" placeholder="Description">{{$_description}}</textarea>
                                </div>

                            </div>

                            <hr />
                            <div class="row" style="margin-left: 400px">
                                <div class="col-md-1">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                                </div>
                                <div class="col-md-4" style="margin-left: 60px">
                                    <a href="{{route('settings.subcategory.index')}}" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>Back</a>
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
