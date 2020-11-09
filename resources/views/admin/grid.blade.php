@extends('voyager::master')

@section('content')
<div class="page-content browse container-fluid">
    @include('voyager::alerts')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                        <form method="get" class="form-search">
                            <div id="search-input">
                                <div class="col-2">
                                    <select id="search_key" name="key">
                                        @foreach($searchNames as $key => $name)
                                            <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select id="filter" name="filter">
                                        <option value="contains" @if($search->filter == "contains") selected @endif>contains</option>
                                        <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                                    </select>
                                </div>
                                <div class="input-group col-md-12">
                                    <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info btn-lg" type="submit">
                                            <i class="voyager-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        @if($grid->isShowCheckbox())
                                            <th class="dt-not-orderable">
                                                <input type="checkbox" class="select_all" id="select_all">
                                            </th>
                                        @endif
                                        @foreach($columns as $column)
                                        @if ($column->isShow())
                                            <th>
                                                {{ $column->getData('display_name') }}
                                            </th>
                                        @endif
                                        @endforeach
                                    </thead>
                                    <tbody>
                                        @foreach($collections as $row)
                                            <tr>
                                                @foreach($columns as $column)
                                                    <td> {{ $column->renderView($row) }} </td>
                                                @endforeach
                                            </tr>                    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pull-right">
                                {{ $collections->links('vendor.pagination.bootstrap-4') }}
                            </div>
                            @if (Request::has('sort_order') && Request::has('order_by'))
                                <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                            @endif

                            @if($grid->isSerializeGrid())
                                <input type="hidden" value="test" name="serialize_data"/>
                            @endif
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection