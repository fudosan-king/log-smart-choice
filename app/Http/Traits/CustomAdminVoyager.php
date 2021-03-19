<?php

namespace App\Http\Traits;

use App\Models\PagesSeo;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\DataRow;

trait CustomAdminVoyager
{

    /**
     * @return array
     */
    protected function getPagesSeo()
    {
        $page = PagesSeo::where('status', PagesSeo::STATUS_ACTIVATE)->get()->toArray();
        $count = count($page);
        $pageList = [];
        $allPage = [];
        for ($i = 0; $i < $count; $i++) {
            $pageList = array_merge($pageList, [$page[$i]['id'] => $page[$i]['name']]);
            $allPage[$page[$i]['id']] = $pageList[$i];
        }
        return $allPage;
    }

    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($string)
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
}