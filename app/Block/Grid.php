<?php

namespace App\Block;

use Illuminate\Http\Request;
use App\Block\Column;

abstract class Grid
{
    const LIMIT = 25;

    protected $_columns = array();

    protected $_searchFields;

    protected $_searchNames = array();

    protected $_columnsKey = array();

    protected $_collection;

    protected $_request;

    protected $_showCheckbox = true;

    protected $_model;

    protected $_template = 'admin.grid';

    protected $_isSerializeGrid = false;

    protected $_selectedFilter = array(
        'All'      => 'all',
        'Yes'      => 'yes',
        'No'       => 'no'
    );


    /**
     * Init Columns
     *
     * @return this
     */
    abstract protected function _initCollumns();

    abstract public function getSaveUrl();

    abstract function serializeString();

    public function __construct(Request $request, $model = 'App\Models\Estate')
    {
        $this->_initSearch()->_initCollumns();
        $this->_request = $request;
        $this->_model = $model;
        $this->_isSerializeGrid = true;
        $this->_prepareCollection()->addFilter()->addSort();
    }

    /**
     * Check Is Serialize Grid
     *
     * @return boolean
     */
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
     * Prepare Collection
     *
     * @return this
     */
    protected function _prepareCollection()
    {
        $model = app($this->_model);
        $query = $model::select($this->_columnsKey);
        $this->_collection = $query;
        return $this;
    }

    /**
     * Add Filter
     *
     * @return this
     */
    public function addFilter()
    {
        $request = $this->getRequest();
        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key')];
        if ($search->value != '' && $search->key) {
            $this->_collection->where($search->key, 'LIKE',  '%' . $search->value . '%');
        }
        return $this;
    }

    /**
     * Add Sort
     *
     * @return this
     */
    public function addSort()
    {
        $orderBy = $this->getRequest()->get('order_by');
        if ($orderBy) {
            $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
            $this->_collection->orderBy($orderBy, $querySortOrder);
        }
        return $this;
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

    public function ajaxUrl()
    {
        return '';
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

    public function getRequest()
    {
        return $this->_request;
    }

    public function getSelectedFilter()
    {
        return $this->_selectedFilter;
    }

    /**
     * Render Html
     *
     * @return void
     */
    public function toHtml()
    {
        $request = $this->getRequest();
        $paginationParams = $request->query();
        if (isset($paginationParams['item'])) {
            unset($paginationParams['item']);
        }
        $search = (object) ['value' => trim($request->get('s')), 'key' => $request->get('key')];
        $defaultSearchKey = null;
        return view($this->_template, array(
            'grid' => $this,
            'searchNames' => $this->_searchNames,
            'search' => $search,
            'defaultSearchKey' => $defaultSearchKey,
            'columns' => $this->_columns,
            'collections'  => $this->getCollection()->paginate(self::LIMIT)->appends($paginationParams)
        ));
    }

    public static function unserializeGridData($serializeString)
    {
        $decodeData = base64_decode($serializeString);
        $data = explode('&', $decodeData);
        foreach ($data as $key => $item) {
            $data[$key] = json_decode($item);
        }
        return $data;
    }
}
