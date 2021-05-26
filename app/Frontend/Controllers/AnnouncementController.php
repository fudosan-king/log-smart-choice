<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    /**
     * delete
     *
     * @param  mixed $request
     * @return void
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        try {
            Announcement::findOrFail($id)->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Delete announcement fail', []);
        }

        return $this->response(200, 'Delete announcement success', [], true);
    }
}
