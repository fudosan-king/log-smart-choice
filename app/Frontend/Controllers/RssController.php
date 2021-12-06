<?php
namespace App\Frontend\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Estates;
use \stdClass;
use \DateTime;


class RssController extends Controller {
    protected $selectField;

    public function __construct()
    {
        $this->selectField = [
            'estate_name', 'price', 'address',
            'tatemono_menseki', 'transports',
            'renovation_type', 'date_created', 'room_count',
            'room_kind', 'tab_search'
        ];
    }
    public function index()
    {
        $estates = Estates::select($this->selectField)
            ->where('status', Estates::STATUS_SALE)
            ->orderBy('date_created', 'desc')
            ->get()->toArray();
        $posts = array();
        $idx = 0;
        foreach($estates as $estate){
            if($idx > 10) {
                break;
            }
            $demo = new stdClass();
            $address = $estate['address']['pref'] . $estate['address']['city'] . $estate['address']['ooaza'] . $estate['address']['tyoume'];
            $title = $estate['estate_name'] . '｜' . $address;
            $demo->title = $title;
            $url_web = setting('admin.url_web', config('fdk.url_web'));
            $demo->slug = 'https://' . $url_web . '/detail/' . $estate['_id'];

            $body = '<p>物件価格: ' . number_format($estate['price'], 0) . '万円</p>';
            $body = $body . '<p>専有面積: ' . $estate['tatemono_menseki'] . 'm²</p>';
            $body = $body . '<p>間取り: ' . $estate['room_count'] . $estate['room_kind'] . '</p>';
            $demo->body = $body;

            $demo->category = 'Estates';
            $demo->id = $estate['_id'];
            $demo->user = 'Order Renove';
            $now = now();
            $date_created = explode(' ', $estate['date_created'])[0];
            $now->year = explode('-', $date_created)[0];
            $now->month = explode('-', $date_created)[1];
            $now->day = explode('-', $date_created)[2];
            $demo->created_at = $now;
            array_push($posts, $demo);
            $idx += 1;
        }

        return response()->view('rss.feed', compact('posts'))->header('Content-Type', 'application/xml');
    }
}
