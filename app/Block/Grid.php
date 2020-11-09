<?php

namespace App\Block;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Block\Column;
use phpDocumentor\Reflection\Types\Boolean;

class Grid
{
    const LIMIT = 25;

    private $_columns = array();

    private $_searchFields = array('estate_name' => 'Estate Name', 'price' => 'price');

    private $_searchNames = array();

    private $_columnsKey = array('_id', 'estate_name', 'price', 'sort_order', 'trade_status');

    private $_collection;

    private $_request;

    private $_showCheckbox = true;

    private $_model;

    private $_template = 'admin.grid';

    private $_isSerializeGrid = false;

    public function __construct(Request $request, $model = 'App\Models\Estate')
    {
        $this->_initSearch()->_initCollumns();
        $this->_request = $request;
        $this->_model = $model;
        $this->_isSerializeGrid = true;
    }

    public function isSerializeGrid()
    {
        return $this->_isSerializeGrid;
    }

    /**
     * Init Search Fields
     *
     * @return this
     */
    protected function _initSearch()
    {
        foreach ($this->_searchFields as $key => $value) {
            $this->_searchNames[$key] = $value;
        }
        return $this;
    }

    /**
     * Init Columns
     *
     * @return this
     */
    protected function _initCollumns()
    {
        $this->addCollumns(array(
            'key' => 'hidden',
            'index' => '_id',
            'display_name' => 'id',
            'type' => 'checkbox_row',
            'isShow' => false
        ));

        $this->addCollumns(array(
            'key' => '_id',
            'index' => '_id',
            'display_name' => 'Id',
            'type' => 'text',
        ));
        $this->addCollumns(array(
            'key' => 'estate_name',
            'index' => 'estate_name',
            'display_name' => 'Estate Name',
            'type' => 'text',
        ));
        $this->addCollumns(array(
            'key' => 'price',
            'display_name' => 'Price',
            'index' => 'price',
            'type' => 'text'
        ));
        $this->addCollumns(array(
            'key' => 'sort_order',
            'index' => 'sort_order',
            'display_name' => 'Sort Order',
            'type' => 'input',
            'is_serialzie' => true,
            'class' => 'form-control'
        ));
        return $this;
    }

    protected function _prepareCollection()
    {
        $model = app($this->_model);
        $query = $model::select($this->_columnsKey)->paginate(self::LIMIT);

        $search = (object) ['value' => $this->_request->get('s'), 'key' => $this->_request->get('key'), 'filter' => $this->_request->get('filter')];
        $orderBy = $this->_request->get('order_by');

        if ($search->value != '' && $search->key && $search->filter) {
            $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
            $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
            $query->where($search->key, $search_filter, $search_value);
        }

        if ($orderBy) {
            $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
            $query->orderBy($orderBy, $querySortOrder);
        }

        $this->_collection = $query;
    }

    /**
     * Get Collection
     *
     * @return collection
     */
    public function getCollection()
    {
        if (!$this->_collection) {
            $this->_prepareCollection();
        }
        return $this->_collection;
    }

    /**
     * Set Template Html
     *
     * @param [type] $template
     * @return void
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
        return $this;
    }

    /**
     * Add Collumns to Grid
     *
     * @param array $columns
     * @return $this
     */
    public function addCollumns(array $columns)
    {
        $item = new Column();
        $item->setData($columns)->setName($columns['key']);
        $this->_columns[$columns['key']] = $item;
        return $this;
    }

    /**
     * Allow show checkbox
     *
     * @return boolean
     */
    public function isShowCheckbox()
    {
        return $this->_showCheckbox;
    }

    public function getColumn($key)
    {
        return $this->_columns[$key] ?? null;
    }

    /**
     * Render Html
     *
     * @return void
     */
    public function toHtml()
    {
        $search = (object) ['value' => $this->_request->get('s'), 'key' => $this->_request->get('key'), 'filter' => $this->_request->get('filter')];
        $defaultSearchKey = null;
        return view($this->_template, array(
            'grid' => $this,
            'searchNames' => $this->_searchNames,
            'search' => $search,
            'defaultSearchKey' => $defaultSearchKey,
            'columns' => $this->_columns,
            'collections'  => $this->getCollection()
        ));
    }
}
