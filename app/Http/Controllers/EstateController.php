<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MongoController as Controller;
use App\Block\Grid as Grid;
use App\Models\EstateInformation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Facades\Voyager;

class EstateController extends Controller
{
    public function index(Request $request)
    {
        return parent::index($request);
    }

    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = $model->findOrFail($id);
        }

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        $this->validate($request, [
            'estate_image.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $estateAdded = [];
        $estateAppend = [];
        $estateDatabase = [];
        // estate append
        if ($request->hasfile('estate_image')) {
            $images = $request->file('estate_image');
            $i = 0;
            foreach ($images as $image) {
                $name = date('Ymd_His') . $i;
                $link = '/estates/' . $id . '/images/' . $name;
                $ext = $image->getClientOriginalExtension();
                $image->move(public_path() . '/estates/' . $id . '/images/', $name . '.' . $ext);
                $estateAppend[] =
                    [
                        'url_path' => $link,
                        'media_type' => $ext,
                        'description' => $request->get('description_added')[$i],
                        'sort_order' => $request->get('image_sort')[$i],
                        'id_image' => '1'.date('HIS').$i
                    ];
                $i++;
            }
        }

        // estate load from database
        $description = ($request->get('description_current') == null) ? $request->get('description_added') : $request->get('description_current');
        if ($description != null) {

            $count = count($description);
            // missing new sort after add new image
            $numberNewSort = 0;
            $numberNewSort = count($request->get('image_sort')) - $count;

            if (!empty($request->get('url_image')) && !empty($request->get('ext_image')) && !empty($request->get('description_current_hidden'))) {
                for ($i = 0; $i < $count; $i++) {
                    $estateDatabase[] = [
                        'url_path' => $request->get('url_image')[$i],
                        'media_type' => $request->get('ext_image')[$i],
                        'description' => $description[$i],
                        'sort_order' => $request->get('image_sort')[$i + $numberNewSort],
                        'id_image' => $request->get('id_image')[$i],
                    ];
                }
            }
        }
        $allImageId = $request->get('all_image_id');
        if ($allImageId != null) {
            $imageId = explode("-", $allImageId);
            array_pop($imageId);
            $count = count($imageId); 

            for($i = 0; $i < $count; $i++) {
                $estateAppend[$i]['image_id_flag'] = $imageId[$i];
            }
            $countEstateAppend = count($estateAppend);
            $countEstateDatabase = count($estateDatabase);
            for ($j=0; $j < $countEstateDatabase; $j++) { 
                for ($k=0; $k < $countEstateAppend; $k++) { 
                    if (in_array($estateAppend[$k]['image_id_flag'], $estateDatabase[$j])) {
                        $estateDatabase[$j]['url_path'] = $estateAppend[$k]['url_path'];
                        $estateDatabase[$j]['media_type'] = $estateAppend[$k]['media_type'];
                    }
                }
            }
        }

        if (!empty($estateAppend) && $estateDatabase) {
            $estateAdded = array_merge($estateDatabase, $estateAppend);
            if ($allImageId != null) {
                $estateAdded = $estateDatabase;
            }
        } else {
            $estateAdded = empty($estateAppend) ? $estateDatabase : $estateAppend;
        }

        try {
            EstateInformation::where('estate_id', $id)->delete();

            $estateInformation = new EstateInformation();
            $estateInformation->estate_id = $id;
            $estateInformation->renovation_media = $estateAdded;
            $estateInformation->save();
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        $view = 'voyager::estate.edit-add';

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);

        // Get image estate infomation
        $estateInformation = EstateInformation::where('estate_id', $id)->get()->toArray();
        if ($estateInformation) {
            $renovationMedia = $estateInformation[0]['renovation_media'];
            if (isset($renovationMedia[0]['sort_order'])) {
                foreach ($renovationMedia as $key => $row) {
                    $flag[$key]  = $row['sort_order'];
                }
                array_multisort($flag, SORT_ASC, $renovationMedia);
            }
            $estateInformation[0]['renovation_media'] = $renovationMedia;
            $dataTypeContent->estate_infomation = $estateInformation;
        }
        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }
}
