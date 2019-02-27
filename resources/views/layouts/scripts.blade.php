<!-- START PRELOADS -->
<audio id="audio-alert" src="{{asset("audio/alert.mp3")}}" preload="auto"></audio>
<audio id="audio-fail" src="{{asset("audio/fail.mp3")}}" preload="auto"></audio>
<!-- END PRELOADS -->

<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{asset("js/plugins/jquery/jquery-3.2.1.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/jquery/jquery-ui.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/bootstrap/bootstrap.min.js")}}"></script>
<!-- END PLUGINS -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            {{--'Authorization': "{{ auth()->user()->token() }}"--}}
        }
    });
    var API_URL = "{{ env('API_URL') }}";
</script>
<!-- START THIS PAGE PLUGINS-->
<script type="text/javascript" src="{{asset("js/plugins/icheck/icheck.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/scrolltotop/scrolltopcontrol.js")}}"></script>

<script type="text/javascript" src="{{asset("js/plugins/morris/raphael-min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/morris/morris.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/rickshaw/d3.v3.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/rickshaw/rickshaw.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/bootstrap/bootstrap-datepicker.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/bootstrap/bootstrap-timepicker.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/owl/owl.carousel.min.js")}}"></script>

<script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/plugins/bala/bala.DualSelectList.jquery.js') }}"></script>

<script type="text/javascript" src="{{asset("js/plugins/moment.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/plugins/daterangepicker/daterangepicker.js")}}"></script>
<script type="text/javascript" src="{{asset("js/multiple-select/multiple-select.js")}}"></script>
<script type="text/javascript" src="{{asset("js/date-time/bootstrap-datetimepicker.min.js")}}"></script>
<!-- END THIS PAGE PLUGINS-->

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{asset("js/settings.js")}}"></script>

<script type="text/javascript" src="{{asset("js/plugins.js")}}"></script>
<script type="text/javascript" src="{{asset("js/actions.js")}}"></script>

<script type="text/javascript" src="{{asset("js/demo_dashboard.js")}}"></script>
<!-- END TEMPLATE -->
<script>
    var route = "{{route("app.home")}}";
    $('.select').select2();
    $('.date').datepicker({

    });
    $('.date-crm').datepicker({
        //startDate: new Date(),
        //endDate: new Date()
    });
    $('.time').timepicker({
        minuteStep: 5,
        showSeconds: true,
        showMeridian: false
    });
    $('.date-time').datetimepicker();
    $('.m-select').multipleSelect({
        width: '100%'
    })
</script>
<!-- END SCRIPTS -->
@stack('scripts')