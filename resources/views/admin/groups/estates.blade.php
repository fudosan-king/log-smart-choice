@extends('voyager::master')


@section('page_header')
<div class="clearfix">

    <h1 class="page-title">
        {{  $item->group_name }}
    </h1> 
    <button type="submit" class="btn btn-primary pull-right save" form="gridForm">
        {{ __('voyager::generic.save') }}
    </button>      
</div>
@stop

@section('content')
    {{ $grid->toHtml() }}
@endsection