@extends('layouts.base')
@section('content')
    <form class="form-horizontal" method="post">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    {{csrf_field()}}
            <div class="form-group">
                <label class="col-md-3 control-label">NEW PASSWORD *</label>
                <div class="col-md-4">
                    <input name="password1" value="{{ old('password1') }}" type="password" class="form-control" placeholder="Enter New Password">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">REPEAT PASSWORD *</label>
                <div class="col-md-4">
                    <input name="password2" value="{{ old('password1') }}" type="password" class="form-control" placeholder="Repeat Password">
                </div>
            </div>

            <hr class="mt10 mb15">
            <div class="col-md-offset-3">
                <button class="btn btn-success"><i class="fa fa-plus-circle"></i> SUBMIT DATA</button>
            </div>
    </form>
@endsection