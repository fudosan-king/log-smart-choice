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
use TCG\Voyager\Events\BreadDataAdded;


class EstateController extends Controller
{
    private $mapLabel = array(
        'title' => 'Title',
        'content' => 'Content'
    );

    public function index(Request $request)
    {
        return parent::index($request);
    }

    private function _insertImages($request, $estate_id){
        // Process insert images
        $estateImages = [];
        $list_images = $request->get('estate_image_hidden');
        $i = 0;
        if($list_images){
            foreach ($list_images as $list_image) {
                try {
                    $estate_image = $request->file('estate_image')[$i];
                } catch (Exception $e) {
                    $estate_image = null;
                }
                if($estate_image){
                    $name = date('Ymd_His') . $i;
                    $link = '/estates/' . $estate_id . '/images/' . $name;
                    $ext = $estate_image->getClientOriginalExtension();
                    $url_path = $link . '.' . $ext;
                    $estate_image->move(public_path() . '/estates/' . $estate_id . '/images/', $name . '.' . $ext);
                }else{
                    $url_path = $request->get('estate_image_hidden')[$i];
                }
                $estateImages[] =
                    [
                        'url_path' => $url_path,
                        'description' => $request->get('description')[$i],
                    ];
                $i++;
            }
        }
        try {
            $estateInformation = null;
            if ($estate_id) {
                $estateInformation = EstateInformation::where('estate_id', $estate_id)->get()->first();

            }
            if (!isset($estateInformation) && $estate_id) {
                $estateInformation = new EstateInformation();
                $estateInformation->estate_id = $estate_id;
            }
            if ($estateInformation) {
                $estateInformation->renovation_media = $estateImages;
                $estateInformation->save();
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'add', $isModelTranslatable);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        $mapLabel = $this->mapLabel;

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'mapLabel'));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $mapLabel = $this->mapLabel;
        $custom_field = array();

        foreach ($mapLabel as $key => $value) {
            $custom_field[$key] = $request->$key;
        }
        $request['custom_field'] = $custom_field;
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        $this->_insertImages($request, $data->_id);

        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
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
        $mapLabel = $this->mapLabel;
        $custom_field = array();

        foreach ($mapLabel as $key => $value) {
            $custom_field[$key] = $request->$key;
        }
        $request['custom_field'] = $custom_field;

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

        $this->_insertImages($request, $id);

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

        $view = 'voyager::estates.edit-add';

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);

        // Get image estate infomation
        $estate = EstateInformation::where('estate_id', $id)->get();
        $estateInformation = $estate->toArray();
        if ($estateInformation) {
            $dataTypeContent->estate_infomation = $estateInformation;
            $imagesData = $estate->first()->getRenovationMedia();
        } else {
            $imagesData = null;
        }

        $mapLabel = $this->mapLabel;

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'imagesData', 'mapLabel'));
    }

    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $isSoftDeleted = false;

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
            if ($dataTypeContent->deleted_at) {
                $isSoftDeleted = true;
            }
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'read', $isModelTranslatable);

        $view = 'voyager::bread.read';

        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        // Get estate infomation
        $estate = EstateInformation::where('estate_id', $id)->get();
        $estateInformation = $estate->toArray();
        if ($estateInformation) {
            $dataTypeContent->estate_infomation = $estateInformation;
            $imagesData = $estate->first()->getRenovationMedia();
        } else {
            $imagesData = null;
        }

        $mapLabel = $this->mapLabel;

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted', 'imagesData', 'mapLabel'));
    }
}
