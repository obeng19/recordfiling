<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>PRFillingSys | Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default.css')}}"/>
    <!-- EOF CSS INCLUDE -->
</head>
<body>

<div class="login-container">

    <div class="login-box animated fadeInDown">
        <div class="login-logo"></div>
        <div class="login-body">
            <div class="login-title"><strong>Welcome</strong>, Please login</div>
            <form class="form-horizontal" method="post">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{csrf_field()}}
                <div class="form-group">
                    <div class="col-md-12">
                        <input name="login" value="{{old('login')}}" type="text" class="form-control" placeholder="Email or Username"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input name="password" type="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        {{--<a href="#" class="btn btn-link btn-block">Forgot your password?</a>--}}
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-default btn-block" style="color: black; font-weight: bold">Log In</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left" style="color: black !important; font-weight: bold !important;">
                &copy; 2019 RecordFilling | Powered by: Koachie Health Systems
            </div>
            <div class="pull-right">
                {{--<a href="#">About</a> |--}}
                {{--<a href="#">Privacy</a> |--}}
                {{--<a href="#">Contact Us</a>--}}
            </div>
        </div>
    </div>
</div>

</body>
</html>






