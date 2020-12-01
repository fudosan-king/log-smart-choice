@extends('voyager::master')



@section('page_header')
    <div class="clearfix">

        <h1 class="page-title">
            {{ $title }}
            <i class="voyager-book"></i>
        </h1>

    </div>
@endsection

@section('content')
    <div class="page-content settings container-fluid">
        <form action="{{ route('admin.about.save') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel">
                @foreach($items as $item)
                    <h3 class="panel-title">
                        {{ $item->display_name }}
                    </h3>

                    <div class="panel-body no-padding-left-right">
                        <div class="col-md-12 padding-left-right">
                            @if ($item->type == 'text')
                                <input type="text" class="form-control" name="{{ $item->key }}" value="{{ $item->value }}">
                            @endif
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach

            </div>
            <button type="submit" class="btn btn-primary pull-left">{{ __('voyager::settings.save') }}</button>
        </form>
    </div>

@endsection