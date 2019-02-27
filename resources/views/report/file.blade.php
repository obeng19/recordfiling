@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@endpush

@section('title', 'File Report')

@section('header')
    <li><a href="#">Home</a></li>
    <li class="active">Users</li>
@endsection
@section('content')
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
        <form action="" method="Post">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Report Type</label>
                    <select name="report_type" id="report" class="form-control select">
                        <option value="">--select--</option>
                        <option value="1">Date</option>
                        <option value="2">Date/Category & Subcategory</option>
                        @if($_role==='ADM_MAIN')
                            @else
                            <option value="3">Region</option>
                            @endif

                    </select>

                </div>

            </div>
            <br>
            <div class="row ">
                @if($_role==='ADM_MAIN')
                @else
                    <div class="col-md-3 region" >
                    <label>Region</label>
                    <select name="region_id" class="form-control select" id="region_id">
                        <option value="">-- select Region --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {!! old('region_id') == $region->id ? 'selected="selected"' : '' !!}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                    @endif


                    <div class="col-md-3 reg_div" >
                        <label>Category</label>
                        <select name="cat_id" class="form-control select" id="cat_id">
                            <option value="">-- select Category --</option>
                            @foreach($category as $categorys)
                                <option value="{{ $categorys->id }}" {!! old('cat_id') == $categorys->id ? 'selected="selected"' : '' !!}>{{ $categorys->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-3 reg_div" >
                        <label>Subcategory</label>
                        <select name="subcat_id" id="subcat_id" class="form-control select">
                            <option value="">-select subcategory-</option>
                            @foreach($subcategory as $subcategorys)

                            @endforeach
                        </select>
                    </div>


                <div class="col-md-2 date_divs" style="display: none">
                    <label for="">From</label>
                    <input type="text" name="from" class="form-control datepicker" id="from">
                </div>
                <div class="col-md-2 date_divs" style="display: none">
                    <label>To</label>
                    <input type="text" name="to" class="form-control datepicker" id="to">
                </div>
                <div class="col-md-2" style="margin-top: 30px">
                    <button id="searchBt" name="searchBt" value="1" class="btn btn-primary"><i class="fa fa-search">  Search</i> </button>
                </div>

            </div>
            <hr>
            <div style="overflow-x: scroll; font-size: 12px;">
                {!! $dataTable->table() !!}
            </div>

        </form>

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
    <script>

        // $( document ).ready(function() {
            $('#dataTableBuilder')
                .on('preXhr.dt', function ( e, settings, data ) {
                    data.cat_id= $('#cat_id').val();
                    data.subcat_id= $('#subcat_id').val();
                    data.region_id= $('#region_id').val();
                    data.from= $('#from').val();
                    data.to= $('#to').val();
                    data.report_type= $('#report').val();
                });


            $('#searchBt').on('click', function () {
                var types = $('#report').val();
                var subcat_id = $('#subcat_id').val();
                var cat_id = $('#cat_id').val();
                var region_id = $('#region_id').val();
                var from = $('#from').val();
                var to = $('#to').val();
                switch (types) {
                    case "1":
                        if (!from || !to){
                            alert("Please select a criteria")
                        }else{
                            $('#dataTableBuilder').DataTable().ajax.reload();
                        }

                        break;
                    case "2":
                        if (!from || !to || !subcat_id || !cat_id){
                            alert("Please select a criteria")
                        }else{
                            $('#dataTableBuilder').DataTable().ajax.reload();
                        }
                        break;
                        case "3":
                        if (!region_id ){
                            alert("Please select a criteria")
                        }else{
                            $('#dataTableBuilder').DataTable().ajax.reload();
                        }
                        break;

                    default:
                        alert("Please select Report Type");
                        break;

                }
                return false;
            // });
        });

        $('#cat_id').on('change', function () {
            var cat = $(this).val();
            var url = '{{ route("file.docs.get", ":id") }}';
            url = url.replace(':id', cat);
            $.get(url, function (data) {
                $('#subcat_id').html('');
                $.each(data.sub, function () {
                        $('#subcat_id').append('<option value="' + this['id'] + '">' + this['name'] + '</option>');
                })
            }, "json")
        });

        $('#report').on('change', function () {
            var types = $(this).val();
            switch (types) {
                case "1":
                    $('.date_divs').show();
                    $('.region').hide();
                    $('.reg_div').hide();
                    break;

                case "2":
                    $('.reg_div').show();
                    $('.date_divs').show();
                    $('.region').hide();

                    break;

                    case "3":
                    $('.reg_div').hide();
                    $('.date_divs').hide();
                    $('.region').show();
                    break;

            }

        });
    </script>
@endpush