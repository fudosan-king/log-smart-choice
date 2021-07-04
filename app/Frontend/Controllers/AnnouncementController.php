<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Estates;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $customerId = Auth::user()->id;
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->is_read = true;
            $announcement->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Update read announcement fail', []);
        }
        $announcementCount = Announcement::where('customer_id', $customerId)->where('is_read', 0)->whereNull('deleted_at')->count();
        return $this->response(200, 'Update read announcement success', [
            'estateId' => $announcement->estate_id,
            'announcement_count' => $announcementCount,
        ], true);
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

        $announcements = Announcement::select('estate_id', 'id', 'is_read', 'created_at')
            ->where('customer_id', $customerId)
            ->paginate($limit, $page)->toArray();
        $announcementList = [];
        $announcementListIds = [];
        if ($announcements) {
            Carbon::setLocale('ja-JP');
            foreach ($announcements['data'] as $announcement) {
                $announcementList[] = $announcement['estate_id'];
                $announcementListIds[$announcement['estate_id']] = 
                [
                    'announcement_id' => $announcement['id'],
                    'is_read' => $announcement['is_read'],
                    'announcement_created_at' => Carbon::createFromTimeStamp(strtotime($announcement['created_at']))->diffForHumans(),
                ];
            }
            $estates = Estates::select(
                'estate_name', 'price', 'address', 'tatemono_menseki',
                'total_price', 'transports', 'renovation_type', 'date_created'
            )->where('status', Estates::STATUS_SALE)
                ->whereIn('_id', $announcementList)
                ->orderBy('date_created', 'desc')
                ->get()->toArray();
            $announcements['data'] = $this->estateController->getEstateInformation($estates, []);
            // push announcement into estate
            foreach ($announcements['data'] as $key => $announcement) {
                if (array_key_exists($announcement['_id'], $announcementListIds)) {
                    $announcement['announcement_id'] = $announcementListIds[$announcement['_id']]['announcement_id'];
                    $announcement['is_read'] = $announcementListIds[$announcement['_id']]['is_read'];
                    $announcement['announcement_created_at'] = $announcementListIds[$announcement['_id']]['announcement_created_at'];
                }
                $announcements['data'][$key] = $announcement;
            }
        }
        return $this->response(200, 'Get list success', $announcements, true);
    }
}
