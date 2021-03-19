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

                        <h2 class="padding_tab_search"> Category</h2>
                        <hr class="hr_tab_search">
                        <div class="category_tab_search">
                            @if($categoriesTabSearch)
                                @foreach($categoriesTabSearch as $key => $categoryTabSearch)
                                    <div class="form-check category_checkbox">
                                        <input type="checkbox" class="form-check-input"
                                               id="category_{{ $categoryTabSearch->name.$key }}"
                                               name="category[{{ $categoryTabSearch->id }}]"
                                                @php
                                                    if ($estateInfo->tab_search && in_array($categoryTabSearch->id, $estateInfo->category_tab_search)) {
                                                         echo "checked";
                                                     }
                                                @endphp
                                        >
                                        <label class="form-check-label"
                                               for="category_{{ $categoryTabSearch->name.$key }}">{{ $categoryTabSearch->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <h2 class="padding_tab_search"> Tab Search</h2>
                        <hr class="hr_tab_search">
                        <div class="category_tab_search">
                            @if($tabsSearch)
                                @foreach($tabsSearch as $key => $tabSearch)
                                    <div class="form-check category_checkbox">
                                        <input type="checkbox" class="form-check-input" id="tab_search_{{ $tabSearch->name.$key }}" name="tab_search[{{ $tabSearch->id }}]"
                                                @php

                                                    if ($estateInfo->tab_search && in_array($tabSearch->id, $estateInfo->tab_search)) {
                                                         echo "checked";
                                                     }
                                                @endphp
                                        >
                                        <label class="form-check-label" for="tab_search_{{ $tabSearch->name.$key }}">{{ $tabSearch->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
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

                        <h1 class="padding_tab_search">Description</h1>
                        <hr class="hr_tab_search">
                        <div class="col-md-12 ">
                            <estate-description-component :data="'{{ $dataTypeContent }}'" :data_read="false"></estate-description-component>
                        </div>
                        

                        <h1 class="padding_tab_search">Main Photo</h1>
                        <hr class="hr_tab_search">
                        <estatemainphoto-component :data="'{{ $estateInfo }}'"></estatemainphoto-component>

                        <h1>Befor/After</h1>
                        <hr>
                        <estatebeforafter-component :befor="'{{ $estateInfo }}'" :after="'{{ $estateInfo }}'"></estatebeforafter-component>


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
