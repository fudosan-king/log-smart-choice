<?php

namespace App\Http\Traits;

use App\Models\City;
use App\Models\PagesSeo;
use TCG\Voyager\Models\DataRow;

trait CustomAdminVoyager
{
    private function _mergeList($count, $elements = []) {
        $list = [];
        for ($i = 0; $i < $count; $i++) {
            if (isset($elements[$i]['id'])) {
                $list[$elements[$i]['id']] = $elements[$i]['name'];
            }
        }
        return $list;
    }

    /**
     * @return array
     */
    public function getPagesSeo()
    {
        $page = PagesSeo::where('status', PagesSeo::STATUS_ACTIVATE)->get()->toArray();
        $count = count($page);
        return $this->_mergeList($count, $page);
    }

    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    public function fullTextWildcards($string)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $string = str_replace($reservedSymbols, '', $string);

        $words = explode(' ', $string);

        $flag = false;
        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 4) {
                $words[$key] = '+' . $word . '*';
                $flag = true;
            }
        }

        $searchTerm = implode(' ', $words);
        return compact('flag', 'searchTerm');
    }

    /**
     * @param $listItems
     * @param $fieldNeedUpdate
     */
    public function updateDetailsDataRow($listItems, $fieldNeedUpdate)
    {
        $detailItem = [];
        if ($listItems->isNotEmpty()) {
            $detailItem['options'] = [];
            foreach ($listItems as $listItem) {
                $detailItem['options'][$listItem->id] = $listItem->name;
            }
            $detailItem['default'] = $detailItem['options'][array_key_first($detailItem['options'])];
        }
        $detailDataRow = DataRow::where('field', $fieldNeedUpdate)->first();
        $detailDataRow->details = $detailItem;
        $detailDataRow->save();
    }

    public function syntaxFullTextSearch($query, $string, $searchFields)
    {

        $columns = implode(',', $searchFields);
        $wildCard = $this->fullTextWildcards($string);

        if ($wildCard['flag']) {
            $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $wildCard['searchTerm']);
        } else {
            $query->whereRaw("{$columns} LIKE '%{$wildCard['searchTerm']}%'");
        }

        return $query;
    }

    public function getCities() {
        $page = City::where('status', City::STATUS_ACTIVE)->get()->toArray();
        $count = count($page);
        return $this->_mergeList($count, $page);
    }
}