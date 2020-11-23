<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\EstateInfomation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class EstateController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->get('keyword') : '';
        $priceFrom = $request->has('price_from') ? $request->get('price_from') : '';
        $priceTo = $request->has('price_to') ? $request->get('price_to') : '';
        $metreSquare = $request->has('metre_square') ? $request->get('metre_square') : '';
        $limit = 10;
        $validator = Validator::make($request->all(), [
            'keyword'      => 'max:100',
            'metre_square' => 'numeric',
            'price_from'   => 'numeric',
            'price_to'     => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $estates = Estate::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke',
            'land_space', 'homepage');
        if ($keyword) {
            $estates->where('estate_name', "like", "%" . $keyword . "%");
        }

        if ($priceFrom) {
            $estates->where('price', '>=', $priceFrom);
        }

        if ($priceTo) {
            $estates->where('price', '<=', $priceTo);
        }

        if ($metreSquare) {
            $getMetreSquare = $this->_getConditionMetreSquard($metreSquare);
            $estates->where('tatemono_menseki', '>=', (int)$getMetreSquare[0]);
            $estates->where('tatemono_menseki', '<=', (int)$getMetreSquare[1]);
        }

        $data = $estates->paginate($limit)->toArray();

        if ($data) {
            $estatesArr = [];
            foreach ($data['data'] as $key => $value) {
                $estateInformation = EstateInfomation::where('estate_id', $estatesArr[$key]['_id'])->get()->toArray();
                $estatesArr[$key]['estate_infomation'] = $estateInformation;
            }
            $data['data'] = $estatesArr;
        }

        return view('frontend.search.estate', ['data' => $data]);
    }


    /**
     * @param $metreSquare
     * @return array
     */
    private function _getConditionMetreSquard($metreSquare)
    {
        $lengthOfString = strlen($metreSquare);
        $numberFrom = '';
        $numberTo = '';
        for ($i = 1; $i < $lengthOfString; $i++) {
            $numberFrom .= '0';
            $numberTo .= '9';
        }

        $firstPartNumber = substr($metreSquare, 0, 1);

        $fromMetreSquare = $firstPartNumber . $numberFrom;
        $toMetreSquare = $firstPartNumber . $numberTo;
        return [$fromMetreSquare, $toMetreSquare];
    }
}