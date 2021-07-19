<?php

namespace App\Block;

use App\Block\Grid;
use App\Models\Estates;

class EstateGroups extends Grid
{
    const LIMIT = 25;

    protected $_searchFields = array('estate_name' => 'Estate Name', 'price' => 'price');

    protected $_columnsKey = array('_id', 'estate_name', 'price', 'sort_order', 'trade_status');

    protected $_condition = [['field' => 'status', 'operation' => '=', 'value' => Estates::STATUS_SALE]];

    protected $_orderBy = 'sort_order_recommend';

    protected $_sortOrder = 'asc';

    protected function initColumns()
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
            'type' => 'select',
            'is_serialzie' => true,
            'class' => 'form-control'
        ));

        $this->addCondition($this->_condition);

        $this->addOrderBy($this->_orderBy);

        $this->addSortBy($this->_sortOrder);

        return $this;
    }

    protected function prepareCollection()
    {
        parent::prepareCollection();
        $this->addSelectedItem($this->getCollection());
        return $this;
    }

    public function addSelectedItem($collection)
    {
        $request = $this->getRequest();
        $item = $this->getRequest()->get('item');
        $ids = array();
        if (!empty($item->estate_list)) {
            $ids = array_column($item->estate_list, 'estate_id');
        }
        switch ($request->get('selected')){
            case 'no':
                $collection->whereIn('_id', $ids, 'and', true);
                break;
            case 'yes';
                $collection->whereIn('_id', $ids);
                break;
            default:
                break;
        }
        return $collection;
    }

    public function serializeString()
    {
        $group = $this->getRequest()->get('item');
        $serializeString = array();
        if (!empty($group->estate_list)) {
            foreach ($group->estate_list as $estate) {
                $string = array();
                array_push($string, '"_id":"' . $estate['estate_id'] . '"');
                foreach ($this->_columns as $column) {
                    if ($column->getData('is_serialzie')) {
                        array_push($string, '"' . $column->getData('key') . '":"' . $estate[$column->getData('key')] . '"');
                    }
                }
                array_push($serializeString, '{' . implode(',', $string) . '}');
            }
        }
        return base64_encode(implode('&', $serializeString));
    }

    public function getSaveUrl()
    {
        return route('admin.groups.save', ['id' => $this->getRequest()->get('item')->id]);
    }
}
