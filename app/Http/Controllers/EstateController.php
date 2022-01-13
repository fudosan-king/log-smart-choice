<?php

namespace App\Http\Controllers;

use TCG\Voyager\Http\Controllers\VoyagerBaseController as Controller;
use App\Models\EstateInformation;
use App\Models\TabSearch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Events\BreadDataAdded;
use App\Actions\ResizeImage;
use App\Models\District;
use App\Models\Estates;

class EstateController extends Controller
{
    // Add custom field for estates
    private $mapLabel = array(
        'title_text' => 'Title',
        'content_textarea' => 'Content',
        'comment_textarea' => 'Comment'
    );

    private function _loadEstateInformation($estate_id, $default = 'renovation')
    {
        $estate = EstateInformation::select('renovation_media', 'estate_befor_photo',
            'estate_after_photo', 'estate_main_photo', 'estate_equipment', 'estate_flooring', 'category_tab_search',
            'tab_search', 'id_estate_3d', 'time_to_join', 'direction', 'company_design', 'article_title', 'url_map',
            'url_view_street', 'estate_fee')
            ->where('estate_id', $estate_id)->get()->first();
        return $estate ? $estate : '{}';
    }
    /*
    $resizeOption = ['exact', 'maxwidth', 'maxheight']
    */
    private function _uploadPhoto($estate_id, $image, $name, $local, $width=null, $height=null, $resizeOption='default'){
        // $resize = new ResizeImage($image);
        // if (!$width && !$height){
        //     $width = $resize->origWidth;
        //     $height = $resize->origHeight;
        // }
        // $resize->resizeTo($width, $height, $resizeOption);
        $file_name = date('Ymd_His') . $name;
        $path = '/estates/' . $estate_id . '/' . $local;
        $public_path = public_path() . $path;
        if (!is_dir($public_path)) {
            mkdir($public_path, 0777, true);
        }
        $ext = $image->getClientOriginalExtension();
        // $ext = $resize->getTypeFile();
        $url_path = $path . '/' . $file_name . '.' . $ext;
        $image->move($public_path, $file_name . '.' . $ext);
        // $resize->saveImage($public_path . '/' . $file_name . '.' . $ext);
        return $url_path;
    }

    private function _insertDatabase($estate_id, $key, $value){
        try {
            $estateInformation = EstateInformation::where('estate_id', $estate_id)->first();
            if ($estateInformation) {
                $estateInformation[$key] = $value;
                $estateInformation->save();
            } else {
                $estateInfomationNew = new EstateInformation();
                $estateInfomationNew->$key = $value;
                $estateInfomationNew->estate_id = $estate_id;
                $estateInfomationNew->save();
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
        $list_images_full = $request->get('estate_image');
        $i = 0;
        if($list_images){
            foreach ($list_images as $list_image) {
                try {
                    $estate_image = $request->file('estate_image')[$i];
                } catch (Exception $e) {
                    $estate_image = null;
                }
                if($estate_image){
                    // $url_path = $this->_uploadPhoto($estate_id, $estate_image, $i, 'images', 1920, 600, 'maxheight');
                    $url_path = $this->_uploadPhoto($estate_id, $estate_image, $i, 'images');
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

    private function _insertMainImage($request, $estate_id) {
        
        $main = [];
        if ($request->has('estate_main_photo_hidden')) {
            $imageMainCount = count($request->get('estate_main_photo_hidden'));
            for ($i = 0; $i < $imageMainCount; $i++) {
                $urlImageMain = $request->get('estate_main_photo_hidden')[$i];
                if (isset($request->file('estate_main_photo')[$i])) {
                    $imageFlooring = $request->file('estate_main_photo')[$i];
                    // $urlImageMain = $this->_uploadPhoto($estate_id, $imageFlooring, '_main_photo', 'main_photo', 1920, 600, 'maxheight');
                    $urlImageMain = $this->_uploadPhoto($estate_id, $imageFlooring, '_main_photo'.$i, 'main_photo');
                }

                $main[] = [
                    'url_path' => $urlImageMain,
                ];
            }

        } 

        $this->_insertDatabase($estate_id, 'estate_main_photo', $main);
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

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->orderBy('order', 'asc')->where('browse', 1)->get();
            $i = 0;
            foreach ($dataRow as $key => $row) {
                $searchNames[$row->field] = $row->display_name;
                $i++;
            }
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;
        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $model->{$dataType->scope}();
            } else {
                $query = $model::select('*');
            }
            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $searchFilter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $searchValue = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
                switch ($search->key) {
                    case 'tab_search_id':
                        $tabsSearch = TabSearch::where('name', $searchFilter, $searchValue)->get();
                        $tabIds = [];
                        foreach ($tabsSearch as $tabSearch) {
                            $tabIds[] = $tabSearch->id;
                        }
                        $estateIds = [];
                        $estatesInformation = EstateInformation::whereIn('tab_search', $tabIds)->get();
                        foreach ($estatesInformation as $estateInformation) {
                            $estateIds[] = $estateInformation->estate_id;
                        }
                        $query->whereIn('_id', $estateIds);
                        break;
                    default:
                        $query->where($search->key, $searchFilter, $searchValue);
                        break;
                }
            }

            if ($orderBy) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }
            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        // Define list of columns that can be sorted server side
        $sortableColumns = $this->getSortableColumns($dataType->browseRows);


        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortableColumns',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showCheckboxColumn'
        ));
    }

    public function update(Request $request, $id)
    {
        
        $userId = Auth::user()->id;
        $timestamp = strtotime(date('Y-m-d H:i:s')) * 1000;
        $lastedModified = new \MongoDB\BSON\UTCDateTime($timestamp);
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

        // $customerField = $this->_setCustomField($request);
        // $descriptionUrlImageLeft = '';
        // $descriptionUrlImageRight = '';

        // Check decor is_numberic
        if ($request->has('decor')) {
            if (!is_numeric($request->get('decor', 0))) {
                return redirect()->back()->with([
                    'message' => 'Wrong format decor',
                    'alert-type' => 'error',
                ]);
            }
        }

        $estate = Estates ::find($id);

        $data->is_send_announcement = Estates::NOT_SEND_ANNOUNCEMENT;

        if ($request->status == Estates::STATUS_SALE) {
            $model->increaseDecreaseEstateInStation($estate->transports, true, $id);
            $model->increaseDecreaseEstateInDistrict($estate->address, true, $id);

            $data->is_send_announcement = Estates::SEND_ANNOUNCEMENT;
        } else {
            $model->increaseDecreaseEstateInDistrict($estate->address, false, $id);
            $model->increaseDecreaseEstateInStation($estate->transports, false, $id);
        }

        $roundSquare = explode('.', $estate['tatemono_menseki']);
        $data->renovation_cost = 0;
        if ($estate['renovation_type'] != Estates::DECOR) {
            if ($estate['tatemono_menseki'] >= Estates::RENOVATION_SQUARE_MAX) {
                $data->renovation_cost = Estates::RENOVATION_COST[Estates::RENOVATION_SQUARE_MAX];
            } elseif (array_key_exists($roundSquare[0], Estates::RENOVATION_COST)) {
                $data->renovation_cost = Estates::RENOVATION_COST[$roundSquare[0]];
            }
        }

        // Check estate description photo or hidden photo exist
        // if ($request->hasFile('estate_description_left_photo')) {
        //     $estateDescriptionLeftPhoto = $request->file('estate_description_left_photo');
        //     $imageName = explode('.', $estateDescriptionLeftPhoto->getClientOriginalName());
        //     $descriptionUrlImageLeft = $this->_uploadPhoto($id, $estateDescriptionLeftPhoto, $imageName[0], 'images');
        // } elseif ($request->has('estate_description_left_photo_hidden')) {
        //     $descriptionUrlImageLeft = $request->get('estate_description_left_photo_hidden');
        // }

        // if ($request->hasFile('estate_description_right_photo')) {
        //     $estateDescriptionRightPhoto = $request->file('estate_description_right_photo');
        //     $imageName = explode('.', $estateDescriptionRightPhoto->getClientOriginalName());
        //     $descriptionUrlImageRight = $this->_uploadPhoto($id, $estateDescriptionRightPhoto, $imageName[0], 'images');
        // } elseif ($request->has('estate_description_right_photo_hidden')) {
        //     $descriptionUrlImageRight = $request->get('estate_description_right_photo_hidden');
        // }

        // $descriptionEstate = [
        //     'description_title' => htmlspecialchars($request->get('description_title'), ENT_QUOTES),
        //     'description_content' => htmlspecialchars($request->get('description_content'), ENT_QUOTES),
        //     'description_url_image_left' => $descriptionUrlImageLeft,
        //     'description_url_image_right' => $descriptionUrlImageRight,
        // ];

        // set custom field description estate
        // foreach( $descriptionEstate as $key => $value) {
        //     $customerField[$key] = $value;
        // }
        // $customerField = array_merge($customerField, $descriptionEstate);
        // $request['custom_field'] = $customerField;

        // slide Equiment
        // $slidesEquipment = [];
        // if ($request->has('estate_image_equipment_hidden')) {
        //     $slideEquipmentHiddenCount = count($request->get('estate_image_equipment_hidden'));

        //     for ($i = 0; $i < $slideEquipmentHiddenCount; $i++) {
        //         $slideEquipment = null;
        //         $urlSlideEquipment = $request->get('estate_image_equipment_hidden')[$i];
        //         if (isset($request->file('estate_image_equipment')[$i])) {
        //             $slideEquipment = $request->file('estate_image_equipment')[$i];
        //             $urlSlideEquipment = $this->_uploadPhoto($id, $slideEquipment, $i, 'slides_equipment');
        //         }

        //         $slidesEquipment[] = [
        //             'slide_equipment' => $urlSlideEquipment,
        //             'caption_equipment' => $request->get('estate_image_equipment_caption')[$i],
        //         ];
        //     }
        // }

        // flooring
        // $flooring = [];
        // if ($request->has('estate_image_flooring_hidden')) {
        //     $imageFlooringCount = count($request->get('estate_image_flooring_hidden'));
        //     for ($i = 0; $i < $imageFlooringCount; $i++) {
        //         $slideEquipment = null;
        //         $urlImageFlooring = $request->get('estate_image_flooring_hidden')[$i];
        //         if (isset($request->file('estate_image_flooring')[$i])) {
        //             $imageFlooring = $request->file('estate_image_flooring')[$i];
        //             $urlImageFlooring = $this->_uploadPhoto($id, $imageFlooring, $i, 'flooring');
        //         }

        //         $flooring[] = [
        //             'flooring_image_url' => $urlImageFlooring,
        //             'flooring_title' => $request->get('estate_flooring_title')[$i],
        //             'flooring_content' => $request->get('estate_flooring_content')[$i],
        //         ];
        //     }
        // }

        // category tab
        // $categoriesTab = [];
        // if (!empty($request->get('category'))) {
        //     $categoriesTab = array_keys($request->get('category'));
        // }

        // tab search
        $tabsSearch = [];
        if (!empty($request->get('tab_search'))) {
            $tabs = array_keys($request->get('tab_search'));
            foreach ($tabs as $key => $value) {
                $tabsSearch[] = ['tab_search' => $value];
            }
        }

        $data->tab_search = $tabsSearch;


        // estate fee
        $data->estate_fee = $request->get('estate_fee') == 'on' ? Estates::BROKERAGE_FEE_ENABLE : Estates::BROKERAGE_FEE_DISABLE;

        // Validate fields with ajax
        $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        // $this->_insertDatabase($id, 'estate_equipment', $slidesEquipment);
        // $this->_insertDatabase($id, 'estate_flooring', $flooring);
        // $this->_insertDatabase($id, 'category_tab_search', $categoriesTab);
        $this->_insertDatabase($id, 'tab_search', $tabsSearch);
        $this->_insertDatabase($id, 'time_to_join', $request->get('time_to_join'));
        $this->_insertDatabase($id, 'direction', $request->get('direction'));
        $this->_insertDatabase($id, 'company_design', $request->get('company_design'));
        $this->_insertDatabase($id, 'article_title', $request->get('article_title'));
        $this->_insertDatabase($id, 'url_map', $request->get('url_map'));
        $this->_insertDatabase($id, 'url_view_street', $request->get('url_view_street'));
        $this->_insertDatabase($id, 'date_lasted_modified_in_lsc', $lastedModified);
        $this->_insertDatabase($id, 'user_lasted_modified_in_lsc', $userId);
        $this->_insertDatabase($id, 'status', $request->get('status'));
        $this->_insertDatabase($id, 'estate_fee', $data->estate_fee);

        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);


        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        $this->validate($request, [
            'estate_image.*' => 'image|mimes:jpg,png,jpeg|max:2048',
            'estate_main_photo.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $this->_insertMainImage($request, $id);
        $this->_insertImages($request, $id);
        // $this->_insertBeforAfterImage($request, $id);

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
        $estateInfo = $this->_loadEstateInformation($id);

        // get tab search
        $tabsSearch = TabSearch::where('status', TabSearch::ACTIVE)->get();

        $mapLabel = $this->mapLabel;
        $tabSelected = [];
        if ($estateInfo->tab_search) {
            foreach ($estateInfo->tab_search as $tab) {
                $tabSelected[] = $tab['tab_search'];
            }
        }

        return Voyager::view($view, compact('dataType',
            'dataTypeContent', 'isModelTranslatable', 'mapLabel', 'estateInfo', 'tabsSearch', 'tabSelected'
        ));
    }

    public function show(Request $request, $id)
    {
        return redirect('/detail/'.$id);
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

        $estateInfo = $this->_loadEstateInformation($id);
        $mapLabel = $this->mapLabel;

        return Voyager::view($view, compact('dataType',
            'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted',
            'mapLabel', 'estateInfo'
        ));
    }

    

    protected function getSortableColumns($rows)
    {
        return $rows->filter(function ($item) {
            if ($item->type != 'relationship') {
                return true;
            }
            if ($item->details->type != 'belongsTo') {
                return false;
            }

            return !$this->relationIsUsingAccessorAsLabel($item->details);
        })
        ->pluck('field')
        ->toArray();
    }

    protected function relationIsUsingAccessorAsLabel($details)
    {
        return in_array($details->label, app($details->model)->additional_attributes ?? []);
    }
}
