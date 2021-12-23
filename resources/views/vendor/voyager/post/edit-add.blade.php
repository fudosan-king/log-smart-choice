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
                        <div class="form-group">
                            <label for="name">Title Package</label>
                            <input name="title_package" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Title Signal</label>
                            <input name="title_signal" value="" class="form-control">
                        </div>
                        @foreach($dataType->addRows as $row)

                        <div class="form-group">
                            <label for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>

                            {!! Voyager::formField($row, $dataType, $dataTypeContent, $row->details) !!}

                        </div>
                        @endforeach

                        <h1 class="padding_tab_search">Image Title</h1>
                        <hr class="hr_tab_search">

                        <estatemainphoto-component :data="{{ $estateInfo }}"></estatemainphoto-component>

                        <h2 class="padding_tab_search"> Tag Post</h2>
                        <hr class="hr_tab_search">
                        <div class="category_tab_search">
                            @if(isset($tagsPost))
                            @foreach($tagsPost as $key => $tagPost)
                            <div class="form-check category_checkbox">
                                <input type="checkbox" class="form-check-input" value="{{ $tagPost->id }}" id="tag_post_{{ $tagPost->name.$key }}" name="tag_post[{{ $tagPost->id }}]" @if (isset($tagSelected) && in_array($tagPost->id, $tagSelected)) checked @endif>
                                <label for="tag_post_{{ $tagPost->name.$key }}" class="form-check-label" forendif="tag_post_{{ $tagPost->name.$key }}">{{ $tagPost->name }}</label>
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
                        @endphp

                        <!-- <h1 class="padding_tab_search">Main Photo</h1>
                        <hr class="hr_tab_search"> -->

                        <!-- <h1>Photos</h1>
                        <hr> -->


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