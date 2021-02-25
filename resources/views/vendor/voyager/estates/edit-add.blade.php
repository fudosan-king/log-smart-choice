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
                        @php if ($row->field == 'custom_field' ||
                                $row->field == 'estate_equipment' ||
                                $row->field == 'estate_flooring') {
                                continue;
                                }
                        @endphp
                        <div class="form-group">
                            <label for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>

                            {!! Voyager::formField($row, $dataType, $dataTypeContent, $row->details) !!}

                        </div>
                        @endforeach

                        @php
                        $custom_field = $dataTypeContent->custom_field;
                        foreach ($mapLabel as $key => $value) {
                            $field = explode('_', $key);
                        @endphp
                            <div class="form-group">
                                <label for="name">@php echo $value @endphp</label>
                                @php if ($field[1] == 'textarea'){
                                @endphp
                                    <textarea name="@php echo $field[0] @endphp" class="form-control">@php if (isset($custom_field[$field[0]])){ echo $custom_field[$field[0]]; } @endphp</textarea>
                                @php
                                } else {
                                @endphp
                                    <input name="@php echo $field[0] @endphp" type="@php echo $field[1] @endphp" value="@php if (isset($custom_field[$field[0]])){ echo $custom_field[$field[0]]; } @endphp" class="form-control">
                                @php
                                }
                                @endphp
                            </div>
                        @php
                        }
                        @endphp


                        @php
                        if (!isset($imagesData)){
                            $imagesData = null;
                        }
                        if (!isset($mainPhoto)){
                            $mainPhoto = null;
                        }
                        if (!isset($beforAfterPhoto)){
                            $beforAfterPhoto = array(null, null);
                        }
                        @endphp

                        <h1>Description</h1>
                        <hr>
                        <div class="col-md-12 ">
                            <estate-description-component :data="'{{ $dataTypeContent }}'" :data_read="false"></estate-description-component>
                        </div>
                        

                        <h1>Main Photo</h1>
                        <hr>
                        <estatemainphoto-component :data="{{ $estateInfo }}"></estatemainphoto-component>

                        <h1>Befor/After</h1>
                        <hr>
                        <estatebeforafter-component :befor="'{{ isset($estateInfo->estate_befor_photo) ? $estateInfo->estate_befor_photo : '' }}'" :after="'{{ isset($estateInfo->estate_after_photo) ? $estateInfo->estate_after_photo : '' }}'"></estatebeforafter-component>


                        <h1>Photos</h1>
                        <hr>
                        <estateimage-component :data="'{{ $estateInfo }}'"></estateimage-component>

                        <h1>Slide Equipment</h1>
                        <hr>
                        <estate-equipment-component :data="'{{ $estateInfo }}'" :data_read="false"></estate-equipment-component>

                        <h1>Flooring</h1>
                        <hr>
                        <estate-flooring-component :data="'{{ $estateInfo }}'" :data_read="false"></estate-flooring-component>

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
