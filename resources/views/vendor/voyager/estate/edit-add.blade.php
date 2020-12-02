@extends('voyager::master')

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
                        <div class="form-group">
                            <label for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>

                            {!! Voyager::formField($row, $dataType, $dataTypeContent) !!}

                        </div>
                        @endforeach

                        <div class="form-group hp_photo_wrap">
                            <ul id="sortable">
                                @isset ($dataTypeContent->estate_infomation)
                                    @php
                                        $estateInformation = $dataTypeContent->estate_infomation;
                                        $estateImages = $estateInformation[0]['renovation_media'];
                                        $count = count($estateImages);
                                    @endphp
                                    @for ($i = 0; $i < $count; $i++) @php $id=$i + 1; @endphp 
                                        <li id="imageInfo{{ $id }}">
                                            <h3>image {{ $id }}</h3>
                                            <input class="input_file" data-id="img-{{ $id }}" type="file" id="imgInp{{ $id }}" data-name="avatar" name="estate_image[]">
                                            <div class="img-wrap">
                                                <span class="close" id="{{ $id }}">&times;</span>
                                            </div>
                                            @php
                                                $url = $estateImages[$i]['url_path'];
                                                $ext = $estateImages[$i]['media_type'];
                                                $fullImage = $url.'.'.$ext;
                                            @endphp
                                            <img id="image-estate{{ $id }}" src="{{ URL::asset($fullImage) }}" class="image_estate" onerror="this.onerror=null;this.src='/storage/estate/no_image.png';"/>
                                            <div class="photo_info">
                                                <input type="number" placeholder="Image sort {{ $id }}" data-sort-id="{{$id}}" name="image_sort[]" value="{{ $estateImages[$i]['sort_order'] }}">
                                                <textarea class="form-control" data-id="description_current-{{ $id }}" id="description_estate{{ $id }}" name="description_current[]">{{ $estateImages[$i]['description'] }}</textarea>
                                            </div>
                                            <input type="hidden" name='url_image[]' value="{{ $url }}">
                                            <input type="hidden" name='ext_image[]' value="{{ $ext }}">
                                            <input type="hidden" class="description_current_hidden{{$id}}" name='description_current_hidden[]' value="{{ $estateImages[$i]['description'] }}">
                                            <input type="hidden" class="id_image{{$id}}" name='id_image[]' value="{{ $estateImages[$i]['id_image'] }}">
                                            
                                            <input type="hidden" name="change-image">
                                        </li>
                                        <input type="hidden" name='all_image_id' value="">
                                    @endfor
                                @endisset
                            </ul>
                        </div>

                    </div><!-- panel-body -->

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">{{ __('voyager::generic.submit') }}</button>
                        <button type="button" name="append_image" class="btn btn-primary append-image">Append Images</button>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')

<script>
    $('document').ready(function() {

        //upload images
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + id).attr('src', e.target.result);
                };

                // convert to base64 string
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('button[name=append_image]').click(function() {
            var idImage = $('#sortable li').length + 1;
            var html = '';
            html += '<li id="imageInfo' + idImage + '">';
            html += '<h3>image ' + idImage + '</h3>';
            html += '<input class="input_file" type="file" id="imgInp' + idImage + '" data-name="avatar" name="estate_image[]">';
            html += '<div class="img-wrap">';
            html += '<span class="close" id="' + idImage + '" >&times;</span>';
            html += '</div>';
            html += '<img id="image-estate' + idImage + '" src="" class="image_estate" onerror="this.onerror=null;this.src=\'/storage/estate/no_image.png\';"/>';
            html += '<div class="photo_info">';
            html += '<input type="number" placeholder="Image Sort ' + idImage + '" name="image_sort[]">';
            html += '<textarea class="form-control" id="" name="description_added[]"></textarea>';
            html += '</div>';
            html += '</li>';
            $("#sortable").append(html);
            $("#imgInp" + idImage).change(function() {
                readURL(this, 'image-estate' + idImage);
            });

            $('.img-wrap .close').click(function(e) {
                var id = e.target.id;
                $('ul #imageInfo' + id).remove();
            });
        });

        var idImageCurrent = $('#sortable li').length;

        var i;
        for (i = 0; i < idImageCurrent; i++) {
            var id = i + 1;
            $('.img-wrap .close').click(function(e) {
                var id = e.target.id;
                $("ul #imageInfo" + id).remove();
            });
        }
        var imageChanged = "";
        $('input[data-id^=img-]').change( function(e) {
            var id = (e.target.id).slice(-1);
            readURL(this, 'image-estate' + id);
            var idImageChanged = $('.id_image'+id).val();
            imageChanged += idImageChanged+'-';
            $('input[name=all_image_id]').val(imageChanged);
        });
        $('textarea[data-id^=description_current-]').keyup(function(e) {
            var value = e.target.value;
            var id = (e.target.id).slice(-1);
            $('.description_current_hidden' + id).val(value);
        });

    });
</script>
@endsection