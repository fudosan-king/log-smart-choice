<div class="page-content browse container-fluid">
    @include('voyager::alerts')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <form method="get" class="form-search">
                        {{ csrf_field() }}

                        <div id="search-input">
                            <div class="col-4">
                                <select id="search_key" name="key">
                                    @foreach($searchNames as $key => $name)
                                        <option value="{{ $key }}"
                                                @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                @if($grid->isShowCheckbox())
                                    <select id="search_selected" name="selected">
                                        @foreach ($grid->getSelectedFilter() as $label => $value)
                                            <option value="{{$value}}" {{ $grid->getRequest()->get('selected') == $value ? 'selected' :''}}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="input-group col-md-12">
                                <input type="text" class="form-control"
                                       placeholder="{{ __('voyager::generic.search') }}" name="s"
                                       value="{{ $search->value }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-lg" type="submit">
                                        <i class="voyager-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                    <form method="post" id="gridForm" method="POST" enctype="multipart/form-data" action="{{ $grid->getSaveUrl() }}">
                       {{ csrf_field() }}
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
                                    <tr id="row_{{ $row['_id'] }}">
                                        @foreach($columns as $column)
                                            <td> {{ $column->renderView($row) }} </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $collections->links('vendor.pagination.bootstrap-4') }}

                        @if (Request::has('sort_order') && Request::has('order_by'))
                            <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                            <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                        @endif

                        @if($grid->isSerializeGrid())
                            <input type="hidden" value="{{ $grid->serializeString() }}" name="serialize_data"/>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
<script>
    var Grid;
    $(document).ready(function(){
        Grid = new GridData('form-search', '.row_id', '.js_serialize_fields' , '#search_selected' , '#select_all', {{ $grid->ajaxUrl() }});
    });

    $('#search-input select').select2({
        minimumResultsForSearch: Infinity
    });
</script>
@endpush
