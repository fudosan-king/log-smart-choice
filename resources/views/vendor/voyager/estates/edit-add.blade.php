@extends('voyager::master')

@section('head')
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('page_header')
<h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i>
    {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
</h1>
@stop

@section('css')
<link href="{{ mix('css/estate.css') }}" rel="stylesheet">
@endsection


@section('content')
<div class="page-content container-fluid">
    @include('voyager::alerts')
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-bordered">
                <!-- form start -->
                <form class="form-edit-add" role="form" action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif" method="POST" enctype="multipart/form-data">

                    <!-- PUT Method if we are editing -->
                    @if(isset($dataTypeContent->id))
                    {{ method_field("PUT") }}
                    @endif

                    <!-- CSRF TOKEN -->
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

                        @foreach($dataType->addRows as $row)
                        @php if ($row->field == 'custom_field') { continue; } @endphp
                        <div class="form-group">
                            <label for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>

                            {!! Voyager::formField($row, $dataType, $dataTypeContent) !!}

                        </div>
                        @endforeach

                        @php
                        $custom_field = $dataTypeContent->custom_field;
                        foreach ($custom_field as $key => $value) {
                        @endphp
                            <div class="form-group">
                                <label for="name">@php echo $mapLabel[$key] @endphp</label>
                                <input type="text" name="@php echo $key @endphp" value="@php echo $value @endphp" class="form-control">
                            </div>
                        @php
                        }
                        @endphp

                        <estateimage-component :data=@json($imagesData)></estateimage-component>

                    </div><!-- panel-body -->

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary button-submit-estate">{{ __('voyager::generic.submit') }}</button>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>
@endsection
