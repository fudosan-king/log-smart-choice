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
        $ids = $request->get('id');
        try {
            $announcement = Announcement::select('id');
            foreach ($ids as $value) {
                $announcement->orWhere('id', $value);
            }
            $announcement->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Delete announcement fail', []);
        }

        return $this->response(200, 'Delete announcement success', [], true);
    }

    public function markRead(Request $request)
    {
        $id = $request->get('id');
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->is_read = true;
            $announcement->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Update read announcement fail', []);
        }

        return $this->response(200, 'Update read announcement success', ['estateId' => $announcement->estate_id], true);
    }
}
