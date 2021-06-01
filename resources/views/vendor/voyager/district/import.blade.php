@extends('voyager::master')

{{--@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))--}}


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> Import {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="panel panel-bordered">
            <!-- form start -->
            <form action="{{route('admin.district.import')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group col-md-12 ">
                        <label class="control-label" for="name">Upload file</label>
                        <input type="file" name="import_file"
                               accept="text/csv"
                               class="input-upload col-md-12"
                               id="file-import">
                    </div>
                </div>
                <div class="panel-footer border-0 ">
                    <button type="submit" class="btn btn-primary save ">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

