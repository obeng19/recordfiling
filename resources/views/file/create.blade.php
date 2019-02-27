@extends('layouts.base')

@push('styles')
    <style>
        .file{
            padding:5px 10px;
            background:#33414e;
            border:1px solid #33414e;
            position:relative;
            color:#fff;
            border-radius:2px;
            text-align:center;
            float:left;
            cursor:pointer
        }
        .hide_file {
            position: absolute;
            z-index: 1000;
            opacity: 0;
            cursor: pointer;
            right: 0;
            top: 0;
            height: 100%;
            font-size: 24px;
            width: 100%;

        }
    </style>
@endpush

@section('title', 'Create File')

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
                    @if (session()->has('danger'))
                        <div class="alert alert-danger">
                            {!! session()->get('danger') !!}
                        </div>
                    @endif
                        <form class="form-horizontalx" method="POST" action="{{route('file.docs.create')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            {{ method_field('POST') }}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <label>Category</label>
                                    <select name="cat_id" id="cat_id" class="form-control select">
                                        <option value="">-select category-</option>
                                        @foreach($category as $categorys)
                                            <option value="{{ $categorys->id }}" {!! old('cat_id') == $categorys->id ? 'selected="selected"' : '' !!}>{{ $categorys->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label>Subcategory</label>
                                    <select name="subcat_id" id="subcat_id" class="form-control select">
                                        <option value="">-select subcategory-</option>
                                    @foreach($subcategory as $subcategorys)

                                        @endforeach
                                    </select>
                                </div>

                                <div class=" col-md-4 file btn-btn" style="margin-top: 25px">
                                    Choose Files
                                    <input type="file" name="docs[]" class="form-control hide_file" id="files"  multiple />

                                </div>

                            </div>


                            <div class="row">
                                <br>
                                <div class="col-md-12"  >
                                <label for="">Selected Files</label>

                                    <pre id="filelist" style="display:none;"></pre>

                                </div>

                            </div>

                            <hr />
                            <div class="row" style="margin-left: 400px">
                                <div class="col-md-1">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
                                <div class="col-md-4" style="margin-left: 60px">
                                    <a href="{{route('file.docs.index')}}" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>Back</a>
                                </div>
                            </div>
                    </form>


@stop

@push('scripts')
    <script>
        document.getElementById('files').addEventListener('change', function(e) {
            var list = document.getElementById('filelist');
            list.innerHTML = '';
            for (var i = 0; i < this.files.length; i++) {
                list.innerHTML += (i + 1) + '. ' + this.files[i].name + '\n';
            }
            if (list.innerHTML == '') list.style.display = 'none';
            else list.style.display = 'block';
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
    </script>
@endpush
