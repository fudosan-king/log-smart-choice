<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MongoController as Controller;
use App\Models\EstateInformation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Events\BreadDataAdded;
use App\Actions\ResizeImage;


class EstateController extends Controller
{
    // Add custom field for estates
    private $mapLabel = array(
        'title_text' => 'Title',
        'content_textarea' => 'Content',
        'comment_textarea' => 'Comment'
    );

    private function _loadImagesEstateInformation($estate_id, $default='renovation'){
        $estate = EstateInformation::select('renovation_media', 'estate_befor_photo',
            'estate_after_photo', 'estate_main_photo', 'estate_equipment', 'estate_flooring')
            ->where('estate_id', $estate_id)->get()->first();
        return $estate ? $estate : '{}';
    }
    /*
    $resizeOption = ['exact', 'maxwidth', 'maxheight']
    */
    private function _uploadPhoto($estate_id, $image, $name, $local, $width=null, $height=null, $resizeOption='default'){
        $resize = new ResizeImage($image);
        if (!$width && !$height){
            $width = $resize->origWidth;
            $height = $resize->origHeight;
        }
        $resize->resizeTo($width, $height, $resizeOption);
        $file_name = date('Ymd_His') . $name;
        $path = '/estates/' . $estate_id . '/' . $local;
        $public_path = public_path() . $path;
        if (!is_dir($public_path)) {
            mkdir($public_path, 0777, true);
        }
        $ext = $resize->getTypeFile();
        $url_path = $path . '/' . $file_name . '.' . $ext;
        $resize->saveImage($public_path . '/' . $file_name . '.' . $ext);
        return $url_path;
    }

    private function _insertDatabase($estate_id, $key, $value){
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
                $estateInformation[$key] = $value;
                $estateInformation->save();
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    // Set data for custom field
    private function _setCustomField($request){
        $mapLabel = $this->mapLabel;
        $custom_field = array();

        foreach ($mapLabel as $key => $value) {
            $field = explode('_', $key);
            $query = strval($field[0]);
            $custom_field[$field[0]] = htmlspecialchars($request->$query, ENT_QUOTES);
        }
        return $custom_field;
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
                    $url_path = $this->_uploadPhoto($estate_id, $estate_image, $i, 'images', 1920, 600, 'maxheight');
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
        $this->_insertDatabase($estate_id, 'renovation_media', $estateImages);
    }

    private function _insertMainImage($request, $estate_id){
        try {
            $estate_main_photo = $request->file('estate_main_photo');
        } catch (Exception $e) {
            $estate_main_photo = null;
        }
        if($estate_main_photo){
            $url_path = $this->_uploadPhoto($estate_id, $estate_main_photo, '_main_photo', 'main_photo', 1920, 600, 'maxheight');
            $this->_insertDatabase($estate_id, 'estate_main_photo', $url_path);
        }
    }

    private function _insertBeforAfterImage($request, $estate_id){
        try {
            $estate_befor_photo = $request->file('estate_befor_photo');
        } catch (Exception $e) {
            $estate_befor_photo = null;
        }

        try {
            $estate_after_photo = $request->file('estate_after_photo');
        } catch (Exception $e) {
            $estate_after_photo = null;
        }

        if($estate_befor_photo){
            $url_path_befor = $this->_uploadPhoto($estate_id, $estate_befor_photo, '_befor_photo', 'befor_after_photo', 1664, 520, 'maxheight');
            $this->_insertDatabase($estate_id, 'estate_befor_photo', $url_path_befor);
        }
        if($estate_after_photo){
            $url_path_after = $this->_uploadPhoto($estate_id, $estate_after_photo, '_after_photo', 'befor_after_photo', 1664, 520, 'maxheight');
            $this->_insertDatabase($estate_id, 'estate_after_photo', $url_path_after);
        }
    }

    public function index(Request $request){
        return parent::index($request);
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
        $request['custom_field'] = $this->_setCustomField($request);
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        $this->_insertImages($request, $data->_id);
        $this->_insertMainImage($request, $data->_id);
        $this->_insertBeforAfterImage($request, $data->_id);

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

        $customerField = $this->_setCustomField($request);
        $descriptionUrlImageLeft = '';
        $descriptionUrlImageRight = '';

        // Check estate description photo or hidden photo exist
        if ($request->hasFile('estate_description_left_photo')) {
            $estateDescriptionLeftPhoto = $request->file('estate_description_left_photo');
            $imageName = explode('.', $estateDescriptionLeftPhoto->getClientOriginalName());
            $descriptionUrlImageLeft = $this->_uploadPhoto($id, $estateDescriptionLeftPhoto, $imageName[0], 'images');
        } elseif ($request->has('estate_description_left_photo_hidden')) {
            $descriptionUrlImageLeft = $request->get('estate_description_left_photo_hidden');
        }

        if ($request->hasFile('estate_description_right_photo')) {
            $estateDescriptionRightPhoto = $request->file('estate_description_right_photo');
            $imageName = explode('.', $estateDescriptionRightPhoto->getClientOriginalName());
            $descriptionUrlImageRight = $this->_uploadPhoto($id, $estateDescriptionRightPhoto, $imageName[0], 'images');
        } elseif ($request->has('estate_description_right_photo_hidden')) {
            $descriptionUrlImageRight = $request->get('estate_description_right_photo_hidden');
        }

        $descriptionEstate = [
            'description_title' => htmlspecialchars($request->get('description_title'), ENT_QUOTES),
            'description_content' => htmlspecialchars($request->get('description_content'), ENT_QUOTES),
            'description_url_image_left' => $descriptionUrlImageLeft,
            'description_url_image_right' => $descriptionUrlImageRight,
        ];

        // set custom field description estate
        foreach( $descriptionEstate as $key => $value) {
            $customerField[$key] = $value;
        }
        $customerField = array_merge($customerField, $descriptionEstate);
        $request['custom_field'] = $customerField;

        // slide Equiment
        $slidesEquipment = [];
        if ($request->has('estate_image_equipment_hidden')) {
            $slideEquipmentHiddenCount = count($request->get('estate_image_equipment_hidden'));

            for ($i = 0; $i < $slideEquipmentHiddenCount; $i++) {
                $slideEquipment = null;
                $urlSlideEquipment = $request->get('estate_image_equipment_hidden')[$i];
                if (isset($request->file('estate_image_equipment')[$i])) {
                    $slideEquipment = $request->file('estate_image_equipment')[$i];
                    $urlSlideEquipment = $this->_uploadPhoto($id, $slideEquipment, $i, 'slides_equipment');
                }

                $slidesEquipment[] = [
                    'slide_equipment' => $urlSlideEquipment,
                    'caption_equipment' => $request->get('estate_image_equipment_caption')[$i],
                ];
            }
        }

        // flooring
        $flooring = [];
        if ($request->has('estate_image_flooring_hidden')) {
            $imageFlooringCount = count($request->get('estate_image_flooring_hidden'));
            for ($i = 0; $i < $imageFlooringCount; $i++) {
                $slideEquipment = null;
                $urlImageFlooring = $request->get('estate_image_flooring_hidden')[$i];
                if (isset($request->file('estate_image_flooring')[$i])) {
                    $imageFlooring = $request->file('estate_image_flooring')[$i];
                    $urlImageFlooring = $this->_uploadPhoto($id, $imageFlooring, $i, 'flooring');
                }

                $flooring[] = [
                    'flooring_image_url' => $urlImageFlooring,
                    'flooring_title' => $request->get('estate_flooring_title')[$i],
                    'flooring_content' => $request->get('estate_flooring_content')[$i],
                ];
            }
        }

        // Validate fields with ajax
        $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        // estate equipment
        $this->_insertDatabase($id, 'estate_equipment', $slidesEquipment);
        // estate flooring
        $this->_insertDatabase($id, 'estate_flooring', $flooring);
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
        $this->_insertMainImage($request, $id);
        $this->_insertBeforAfterImage($request, $id);

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
         // Check permission
        $this->authorize('edit', $dataTypeContent);

        $view = 'voyager::estates.edit-add';

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);
        $estateInfo = $this->_loadImagesEstateInformation($id);
//        $imagesData = $this->_loadImages($id, 'renovation');
//        $mainPhoto = $this->_loadImages($id, 'main');
//        $beforAfterPhoto = $this->_loadImages($id, 'befor_after');
//        $equipmentSlide = $this->_loadImages($id, 'estate_equipment');
//        $flooring = $this->_loadImages($id, 'estate_flooring');

        $mapLabel = $this->mapLabel;

        return Voyager::view($view, compact('dataType',
            'dataTypeContent', 'isModelTranslatable', 'mapLabel', 'estateInfo'
        ));
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

//        $imagesData = $this->_loadImages($id, 'renovation');
//        $mainPhoto = $this->_loadImages($id, 'main');
//        $beforAfterPhoto = $this->_loadImages($id, 'befor_after');
//        $equipmentSlide = $this->_loadImages($id, 'estate_equipment');
//        $flooring = $this->_loadImages($id, 'estate_flooring');
        $estateInfo = $this->_loadImagesEstateInformation($id);
        $mapLabel = $this->mapLabel;

        return Voyager::view($view, compact('dataType',
            'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted',
            'mapLabel', 'estateInfo'
        ));
    }
}
