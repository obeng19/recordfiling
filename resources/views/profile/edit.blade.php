@extends('layouts.base')

@push('styles')

@endpush

@section('title', 'Profile')
{{--@section('action')--}}
    {{--<div class="col-sm-6">--}}
        {{--<div class="m-t-sm text-right text-left-xs">--}}
            {{--<a href="#" class="btn btn-primary"><i class="fa fa-plus-circle"></i> ADD NEW</a>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@stop--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">--}}
{{--                    <h3 class="panel-title">{{empty($user) ? 'New': 'Edit'}} User</h3>--}}

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
                        <form class="form-horizontalx" method="post" action="{{route('profile.update', ['id'=>$data->id])}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group pull-in clearfix">
                            <div class="col-sm-4">
                                <label>First Name</label>
                                @php $_first_name = !empty(old('first_name')) ? old('first_name') : $data->first_name @endphp
                                <input name="first_name" type="text" value="{{$_first_name }}" class="form-control" placeholder="First Name">
                            </div>
                            <div class="col-sm-4">
                                <label>Last Name</label>
                                @php $_last_name = !empty(old('last_name')) ? old('last_name') : $data->last_name @endphp
                                <input name="last_name" type="text" value="{{ $_last_name }}" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="col-sm-4">
                                <label>Email</label>
                                @php $_email = !empty(old('email')) ? old('email') : $data->email @endphp
                                <input name="email" type="email" value="{{ $_email }}" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group pull-in clearfix">
                            <div class="col-sm-4">
                                <label>Gender</label>
                                @php $_gender = !empty(old('gender')) ? old('gender') : $data->gender @endphp
                                <select name="gender" class="form-control select">
                                    <option value="">-- Select User gender --</option>
                                    <option value="male" {{ $_gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $_gender === 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label>Region</label>
                                <select name="region_id" class="form-control select" id="region" disabled>
                                    @php $_region_id = !empty(old('region_id')) ? old('region_id') : $data->region_id @endphp
                                    <option value="">-- select region --</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {!! $_region_id == $region->id ? 'selected="selected"' : '' !!}>{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Role</label>
                                <select name="role_id" class="form-control select" disabled="">
                                    @php $_role_id = !empty(old('role_id')) ? old('role_id') : $data->role_id @endphp
                                    <option value="">-- Select User Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {!! $_role_id == $role->id ? 'selected="selected"' : '' !!}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="form-group pull-in clearfix">
                                <div class="col-sm-4">
                                    <label>Phone Number</label>
                                    @php $_official_phone = !empty(old('official_phone')) ? old('official_phone') : $data->official_phone @endphp
                                    <input name="official_phone" type="number" value="{{$_official_phone}}" class="form-control" placeholder="official_phone">
                                </div>
                            <div class="col-sm-4">
                                <label>Username</label>
                                @php $_username = !empty(old('username')) ? old('username') : $data->username @endphp
                                <input name="username" type="text" value="{{ $_username }}" class="form-control" placeholder="Username" readonly>
                            </div>
                                <div class="col-sm-4">
                                    <label>Password</label>
                                    <input name="password" value="{{ old('password') }}" type="password" class="form-control">
                                </div>

                            </div>
                                <div class="form-group pull-in clearfix">
                                    <div class="col-sm-4">
                                        <label>Confirm Password</label>
                                        <input name="confirm_password" value="{{ old('confirm_password') }}" type="password" class="form-control">
                                    </div>
                                </div>
                        <hr />
                        <div class="row" style="margin-left: 400px">
                            <div class="col-md-1">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@stop

@push('scripts')
    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile-img").change(function(){
            readURL(this);
        });

    </script>

@endpush
