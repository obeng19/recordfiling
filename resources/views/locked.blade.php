<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>Npontu ERP | Session Locked!</title>
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
            <div class="login-title"><strong>Session</strong>, Locked!</div>
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
                <b style="color: red">Your session has been locked</b><br />
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2017 {{ env('APP_NAME') }}
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






