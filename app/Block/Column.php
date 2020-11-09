<?php

namespace App\Block;

use Illuminate\Support\Facades\DB;

class Column
{
    private $_name = 'column';

    private $_view = 'admin.fields.';

    private $_type = 'text';

    private $_data = array();


    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }

    public function isShow()
    {
        return $this->_data['isShow'] ?? True;
    }



    public function getData($key = null)
    {
        return is_null($key) ? $this->_data : $this->_data[$key] ?? '';
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function renderView($rowData)
    {
        $view = $this->getData('type') ? $this->_view . $this->getData('type') : $this->_view . $this->_type;
        return view($view, array('row' => $rowData, 'item' => $this));
    }
}
