@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@endpush

@section('title', 'File')

@section('header')
    <li><a href="#">Home</a></li>
    <li class="active">Users</li>
@endsection
@section('action')
    <div class="col-sm-6">
        <div class="m-t-sm text-right text-left-xs">
            <a href="{{route('file.docs.create')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> ADD NEW</a>
        </div>
    </div>
@stop
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
                    {!! $dataTable->table() !!}

@stop
@push('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}
@endpush