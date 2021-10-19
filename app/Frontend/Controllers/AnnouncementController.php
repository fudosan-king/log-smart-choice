<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailDailyEstate;
use App\Models\Announcement;
use App\Models\Estates;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use DateTime;
use Illuminate\Support\Facades\DB;
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
        $startDate = date('Y-m-d H:i:s', strtotime('-14 days'));
        $endDate = now()->format('Y-m-d H:i:s');
        $announcements = Announcement::select('estate_id', 'id', 'is_read', 'created_at')
            ->where('customer_id', $customerId)
            ->whereBetween('created_at', [$startDate, $endDate])
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
                'transports', 'renovation_type', 'date_created', 'status'
            )->where('status', '!=', Estates::STATUS_STOP)
                ->whereIn('_id', $announcementList)
                ->with('estateInformation')
                ->get()->toArray();

            $announcements['data'] = $estates;
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


    /**
     * store
     *
     * @param  bool $isSendMail
     * @return void
     */
    public function store()
    {
        $customers = Customer::select('id', 'announcement_condition', 'email')->where('role3d', Customer::ROLE_3D_CUSTOMER)
            ->where('status', Customer::ACTIVE)
            ->where('send_announcement', Customer::SEND_ANNOUNCEMENT)
            ->where('email', '!=', '')
            ->whereNotNull('email')
            ->where('announcement_condition', '!=', '')
            ->whereNotNull('announcement_condition')
            ->get();
        DB::beginTransaction();
        try {
            foreach ($customers as $customer) {
                $condition = json_decode($customer->announcement_condition, true);
                $estates = Estates::select('_id', 'room_count', 'room_kind', 'tatemono_menseki', 'address', 'date_created');
                if ($condition['city']) {
                    $estates->whereIn('address.city', $condition['city']);
                }

                if ($condition['price']) {
                    if ($condition['price']['min'] == Customer::CONDITION_MIN && $condition['price']['max'] == Customer::CONDITION_MAX) {
                        $condition['price']['min'] = 0;
                        $estates->where('price', '>', $condition['price']['min']);
                    } elseif ($condition['price']['min'] == Customer::CONDITION_MIN) {
                        $condition['price']['min'] = 0;
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    } elseif ($condition['price']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('price', '>=', $condition['price']['min']);
                    } else {
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    }
                }

                if ($condition['square']) {
                    if ($condition['square']['min'] == Customer::CONDITION_MIN && $condition['square']['max'] == Customer::CONDITION_MAX) {
                        $condition['square']['min'] = 0;
                        $estates->where('tatemono_menseki', '>', $condition['square']['min']);
                    } elseif ($condition['square']['min'] == Customer::CONDITION_MIN) {
                        $condition['square']['min'] = 0;
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    } elseif ($condition['square']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('tatemono_menseki', '>=', $condition['square']['min']);
                    } else {
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    }
                }

                $estates->where('is_send_announcement', Estates::SEND_ANNOUNCEMENT);
                $estates->where('status', '!=', Estates::STATUS_STOP);
                $estates->orderBy('date_imported', 'desc');
                $listEstate = $estates->limit(Estates::LIMIT_ESTATE_ANNOUNCEMENT)->get();

                if ($listEstate) {
                    foreach ($listEstate as $estate) {
                        $announcements = Announcement::where('estate_id', $estate->_id)
                            ->where('customer_id', $customer->id)->first();
                        if (!$announcements) {
                            $announcement = new Announcement();
                            $announcement->estate_id = $estate->_id;
                            $announcement->customer_id = $customer->id;
                            $announcement->is_read = false;
                            $announcement->save();
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

    /**
     * sendEmailAnnouncement function
     *
     * @return void
     */
    public function sendEmailAnnouncement()
    {
        $customers = Customer::select('id', 'announcement_condition', 'email', 'first_announcement')->where('role3d', Customer::ROLE_3D_CUSTOMER)
            ->where('status', Customer::ACTIVE)
            ->where('send_announcement', Customer::SEND_ANNOUNCEMENT)
            ->where('email', '!=', '')
            ->whereNotNull('email')
            ->where('announcement_condition', '!=', '')
            ->whereNotNull('announcement_condition')
            ->get();
        try {
            foreach ($customers as $customer) {
                $condition = json_decode($customer->announcement_condition, true);
                $estates = Estates::select('_id', 'room_count', 'room_kind', 'tatemono_menseki', 'address', 'date_created');
                if ($condition['city']) {
                    $estates->whereIn('address.city', $condition['city']);
                }

                if ($condition['price']) {
                    if ($condition['price']['min'] == Customer::CONDITION_MIN && $condition['price']['max'] == Customer::CONDITION_MAX) {
                        $condition['price']['min'] = 0;
                        $estates->where('price', '>', $condition['price']['min']);
                    } elseif ($condition['price']['min'] == Customer::CONDITION_MIN) {
                        $condition['price']['min'] = 0;
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    } elseif ($condition['price']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('price', '>=', $condition['price']['min']);
                    } else {
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    }
                }

                if ($condition['square']) {
                    if ($condition['square']['min'] == Customer::CONDITION_MIN && $condition['square']['max'] == Customer::CONDITION_MAX) {
                        $condition['square']['min'] = 0;
                        $estates->where('tatemono_menseki', '>', $condition['square']['min']);
                    } elseif ($condition['square']['min'] == Customer::CONDITION_MIN) {
                        $condition['square']['min'] = 0;
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    } elseif ($condition['square']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('tatemono_menseki', '>=', $condition['square']['min']);
                    } else {
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    }
                }

                $estates->where('is_send_announcement', Estates::SEND_ANNOUNCEMENT);
                $estates->where('status', '!=', Estates::STATUS_STOP);
                $estates->orderBy('date_imported', 'desc');
                $listEstate = $estates->limit(Estates::LIMIT_ESTATE_ANNOUNCEMENT)->get();

                if ($listEstate) {
                    $estateController = new EstateController();
                    $data = $estateController->getEstateInformation($listEstate);
                    $emailDailyEstate = new SendEmailDailyEstate($customer->email, $data, $condition);
                    dispatch($emailDailyEstate);
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }



    public function testSendNotice()
    {
        $customers = Customer::select('id', 'announcement_condition', 'email')->where('role3d', Customer::ROLE_3D_CUSTOMER)
            ->where('status', Customer::ACTIVE)
            ->where('email', '!=', '')
            ->whereNotNull('email')
            ->where('announcement_condition', '!=', '')
            ->whereNotNull('announcement_condition')
            ->get();
        DB::beginTransaction();
        try {
            foreach ($customers as $customer) {
                $condition = json_decode($customer->announcement_condition, true);
                $estates = Estates::select('_id', 'room_count', 'room_kind', 'tatemono_menseki', 'address', 'date_created');
                if ($condition['city']) {
                    $estates->whereIn('address.city', $condition['city']);
                }

                if ($condition['price']) {
                    if ($condition['price']['min'] == Customer::CONDITION_MIN && $condition['price']['max'] == Customer::CONDITION_MAX) {
                        $condition['price']['min'] = 0;
                        $estates->where('price', '>', $condition['price']['min']);
                    } elseif ($condition['price']['min'] == Customer::CONDITION_MIN) {
                        $condition['price']['min'] = 0;
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    } elseif ($condition['price']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('price', '>=', $condition['price']['min']);
                    } else {
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    }
                }

                if ($condition['square']) {
                    if ($condition['square']['min'] == Customer::CONDITION_MIN && $condition['square']['max'] == Customer::CONDITION_MAX) {
                        $condition['square']['min'] = 0;
                        $estates->where('tatemono_menseki', '>', $condition['square']['min']);
                    } elseif ($condition['square']['min'] == Customer::CONDITION_MIN) {
                        $condition['square']['min'] = 0;
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    } elseif ($condition['square']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('tatemono_menseki', '>=', $condition['square']['min']);
                    } else {
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    }
                }

                $estates->where('is_send_announcement', Estates::SEND_ANNOUNCEMENT);
                $estates->where('status', Estates::STATUS_SALE);
                $estates->orderBy('date_imported', 'desc');
                $listEstate = $estates->limit(Estates::LIMIT_ESTATE_ANNOUNCEMENT)->get();
                if ($listEstate) {
                    foreach ($listEstate as $estate) {
                        $announcements = Announcement::where('estate_id', $estate->_id)
                            ->where('customer_id', $customer->id)->first();
                        if (!$announcements) {
                            $announcement = new Announcement();
                            $announcement->estate_id = $estate->_id;
                            $announcement->customer_id = $customer->id;
                            $announcement->is_read = false;
                            $announcement->save();
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with([
                'message'    => "Send Notice Success",
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

    public function testSendEmail()
    {
        $listEstateSent = [];
        $customers = Customer::select('id', 'announcement_condition', 'email', 'first_announcement')->where('role3d', Customer::ROLE_3D_CUSTOMER)
            ->where('status', Customer::ACTIVE)
            ->where('send_announcement', Customer::SEND_ANNOUNCEMENT)
            ->where('email', '!=', '')
            ->whereNotNull('email')
            ->where('announcement_condition', '!=', '')
            ->whereNotNull('announcement_condition')
            ->get();
        try {
            foreach ($customers as $customer) {
                $customerCondition = $condition = json_decode($customer->announcement_condition, true);
                $estates = Estates::select('_id', 'room_count', 'room_kind', 'tatemono_menseki', 'address', 'date_created', 'price', 'estate_name', 'transports', 'renovation_cost');
                if ($condition['city']) {
                    $estates->whereIn('address.city', $condition['city']);
                }

                if ($condition['price']) {
                    if ($condition['price']['min'] == Customer::CONDITION_MIN && $condition['price']['max'] == Customer::CONDITION_MAX) {
                        $condition['price']['min'] = 0;
                        $estates->where('price', '>', $condition['price']['min']);
                    } elseif ($condition['price']['min'] == Customer::CONDITION_MIN) {
                        $condition['price']['min'] = 0;
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    } elseif ($condition['price']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('price', '>=', $condition['price']['min']);
                    } else {
                        $estates->whereBetween('price', [$condition['price']['min'], $condition['price']['max']]);
                    }
                }

                if ($condition['square']) {
                    if ($condition['square']['min'] == Customer::CONDITION_MIN && $condition['square']['max'] == Customer::CONDITION_MAX) {
                        $condition['square']['min'] = 0;
                        $estates->where('tatemono_menseki', '>', $condition['square']['min']);
                    } elseif ($condition['square']['min'] == Customer::CONDITION_MIN) {
                        $condition['square']['min'] = 0;
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    } elseif ($condition['square']['max'] == Customer::CONDITION_MAX) {
                        $estates->where('tatemono_menseki', '>=', $condition['square']['min']);
                    } else {
                        $estates->whereBetween('tatemono_menseki', [$condition['square']['min'], $condition['square']['max']]);
                    }
                }

                $estates->where('is_send_announcement', Estates::SEND_ANNOUNCEMENT);
                $estates->where('status', Estates::STATUS_SALE);
                $estates->orderBy('date_imported', 'desc');

                $listEstate = $estates->limit(Estates::LIMIT_ESTATE_ANNOUNCEMENT)->get();

                if ($listEstate->isNotEmpty()) {
                    $listEstateSent = $listEstate;
                    $estateController = new EstateController();
                    $data = $estateController->getEstateInformation($listEstate);
                    $customerCondition['city'] = '';
                    if (count($condition['city'])) {
                        $customerCondition['city'] = implode(', ', $condition['city']);
                    }
                    $emailDailyEstate = new SendEmailDailyEstate($customer, $data->toArray(), $customerCondition);
                    dispatch($emailDailyEstate);
                }
            }

            foreach ($listEstateSent as $estate) {
                $estate = Estates::find($estate->_id);
                $estate->is_send_announcement = Estates::NOT_SEND_ANNOUNCEMENT;
                $estate->save();
            }

            return redirect()->back()->with([
                'message'    => "Send Email Notice Success",
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
