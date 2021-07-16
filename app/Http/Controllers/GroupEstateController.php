<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MongoController as Controller;
use App\Block\EstateGroups as EstateGrid;
use App\Models\Estates;
use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\ObjectId as ObjectId;

class GroupEstateController  extends Controller
{
    public function view($id, Request $request)
    {
        $group = Groups::where('_id', $id)->FirstOrFail();
        $this->authorize('edit_estate', app('App\Models\Groups'));
        $request->request->add(['item' => $group]);
        $grid = new EstateGrid($request);
        return view('admin.groups.estates', array('grid' => $grid, 'item' => $group));
    }

    public function save($id, Request $request)
    {
        $request = $request->request;
        $group = Groups::where('_id', $id)->FirstOrFail();
        $model = array();
        if ($serializeData = $request->get('serialize_data')) {
            $data = EstateGrid::unserializeGridData($serializeData);
            if (count($data)) {
                foreach ($data as $row) {
                    array_push($model, array(
                        'estate_id' =>  new ObjectId($row->_id),
                        'sort_order' => (int)  $row->sort_order
                    ));
                    $estate = Estates::find($row->_id);
                    if ($estate) {
                        $estate->sort_order_recommend = (int)$row->sort_order;
                        $estate->save();
                    }
                    
                }
            }
        }

        try {
            $group->setAttribute('estate_list', $model)->save();
        } catch (\Exception $ex) {
            Log::error($ex);
        }
        return redirect()->back();
        // return redirect()->route('admin.groups.estate', ['id' => $id]);
    }
}
