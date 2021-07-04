<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Estates;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    protected $estateController;

    public function __construct()
    {
        $this->estateController = new EstateController();
    }
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

    /**
     * markRead
     *
     * @param  mixed $request
     * @return void
     */
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
    
    /**
     * listAnnouncement
     *
     * @param  mixed $request
     * @return void
     */
    public function listAnnouncement(Request $request)
    {
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $customerId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'limit' => 'numeric',
            'page' => 'numeric',
        ]);

        if ($validator->fails()) {
            return $this->response(422, $validator->errors(), []);
        }

        $announcements = Announcement::select('estate_id', 'id')
            ->where('customer_id', $customerId)
            ->paginate($limit, $page)->toArray();

        $announcementList = [];
        $announcementListIds = [];
        if ($announcements) {
            foreach ($announcements['data'] as $announcement) {
                $announcementList[] = $announcement['estate_id'];
                $announcementListIds[$announcement['estate_id']] = $announcement['id'];
            }
            $estates = Estates::select(
                'estate_name', 'price', 'address', 'tatemono_menseki',
                'total_price', 'transports', 'renovation_type', 'date_created'
            )->where('status', Estates::STATUS_SALE)
                ->whereIn('_id', $announcementList)
                ->orderBy('date_created', 'desc')
                ->get()->toArray();
            $announcements['data'] = $this->estateController->getEstateInformation($estates, [], $announcementListIds);
        }
        return $this->response(200, 'Get list success', $announcements, true);
    }
}
