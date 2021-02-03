<?php


namespace App\Http\Controllers;

use App\Models\PagesSeo;
use App\Models\Tags;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;

class TagsController extends VoyagerCustomController
{

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Check page seo exist
        $pageId = $request->has('page_id') ? $request->get('page_id') : '';
        $page = PagesSeo::where('id', $pageId)->get();

        if ($page->isEmpty()) {
            return redirect()->back()->with([
                'message'    => 'Page Seo not found',
                'alert-type' => 'error',
            ]);
        }

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();

        // Validate name content
        $tagType = $request->get('type');
        $tagName = $request->get('name');
        $nameContent = $request->get('name_content');
        if (!$this->_validTag($tagType, $tagName, $nameContent)) {
            if ($tagName == 'name') {
                return redirect()->back()->with([
                    'message'    => 'Meta name only support keywords, description, twitter:card, twitter:site, robots',
                    'alert-type' => 'error',
                ]);
            } else {
                return redirect()->back()->with([
                    'message'    => 'Meta property only support og:locale, og:type, og:title, og:description, og:url, og:site_name',
                    'alert-type' => 'error',
                ]);
            }
        }

        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message'    => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
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

        // Check page seo exist
        $pageId = $request->has('page_id') ? $request->get('page_id') : '';
        $page = PagesSeo::where('id', $pageId)->get();

        if ($page->isEmpty()) {
            return redirect()->back()->with([
                'message'    => 'Page Seo not found',
                'alert-type' => 'error',
            ]);
        }

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();

        // Validate name content
        $tagType = $request->get('type');
        $tagName = $request->get('name');
        $nameContent = $request->get('name_content');
        if (!$this->_validTag($tagType, $tagName, $nameContent)) {
            if ($tagName == 'name') {
                return redirect()->back()->with([
                    'message'    => 'Meta name only support keywords, description, twitter:card, twitter:site, robots',
                    'alert-type' => 'error',
                ]);
            } else {
                return redirect()->back()->with([
                    'message'    => 'Meta property only support og:locale, og:type, og:title, og:description, og:url, og:site_name',
                    'alert-type' => 'error',
                ]);
            }
        }

        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    /**
     * @param $tagType
     * @param $tagName
     * @param $tagContent
     * @return bool
     */
    private function _validTag($tagType, $tagName, $tagContent)
    {
        if ($tagType == 'meta') {
            if ($tagName == 'name') {
                if (!in_array($tagContent, Tags::TAG_NAME_CONTENT)) {
                    return false;
                }
            } else {
                if (!in_array($tagContent, Tags::TAG_PROPERTY_CONTENT)) {
                    return false;
                }
            }
        }
        return true;
    }
}