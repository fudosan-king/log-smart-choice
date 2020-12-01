<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class AboutController extends VoyagerBaseController
{
    /**
     * Show About Company
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $title = 'Setting About Company';
        $aboutSetting = About::where('group', About::ABOUT)->get();
        $this->authorize('browse', app('App\Models\About'));

        return view('admin.about.company', array('items' => $aboutSetting, 'title' => $title));
    }

    /**
     * Save About Company
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Request $request)
    {
        $this->authorize('edit', app('App\Models\About'));
        $data = $this->_convertKeyAboutCompany($request->all());
        try {
            foreach ($data as $key => $value) {
                About::where('group', About::ABOUT)->where('key', $key)->update(['value' => $data[$key]]);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return back()->with([
            'message'    => __('voyager::settings.successfully_created'),
            'alert-type' => 'success',
        ]);
    }

    /**
     * Convert Key
     * @param $items
     * @return array
     */
    private function _convertKeyAboutCompany($items)
    {
        $data = [];
        foreach ($items as $key => $item) {
            if ($key != '_token') {
                $newKey = substr_replace($key, '.', 5, 1);
                $data[$newKey] = $item;
            }
        }
        return $data;
    }
}
