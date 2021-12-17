<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function list() {
        $transports = Transport::with('stations')->orderBy('name', 'ASC')->get()->toArray();
        $transportNew = [];
        if ($transports) {
            foreach ($transports as $transport) {
                $countStations = count($transport['stations']);
                if ($countStations > 0) {
                    $transportNew[] = $transport;
                }
            }
            return $this->response(200, "Get list success", $transports, true);
        }
        return $this->response(422, "Get list fail", $transports, false);
    }
}
