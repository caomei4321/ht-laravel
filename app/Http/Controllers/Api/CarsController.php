<?php

namespace App\Http\Controllers\Api;

use App\Models\CarNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    public function carRecord()
    {
        $records = CarNumber::get(['colorType', 'type', 'carColor', 'license']);
        foreach ($records as $record) {
            switch ($record['colorType']) {
                case 1:
                    $record['colorType'] = '蓝色';
                    break;
                case 2:
                    $record['colorType'] = '黄色';
                    break;
                case 3:
                    $record['colorType'] = '白色';
                    break;
                case 4:
                    $record['colorType'] = '黑色';
                    break;
                case 5:
                    $record['colorType'] = '绿色';
                    break;
                default :
                    $record['colorType'] = '未知';
                    break;
            };  //
            switch ($record['type']) {
                case 1:
                    $record['type'] = '蓝牌小汽车';
                    break;
                case 2:
                    $record['type'] = '黑牌小汽车';
                    break;
                case 3:
                    $record['type'] = '单排小汽车';
                    break;
                case 4:
                    $record['type'] = '双排小汽车';
                    break;
                case 5:
                    $record['type'] = '警车车牌';
                    break;
                case 6:
                    $record['type'] = '武警车牌';
                    break;
                case 7:
                    $record['type'] = '个性化车牌';
                    break;
                case 8:
                    $record['type'] = '单排军车牌';
                    break;
                case 9:
                    $record['type'] = '双排军车牌';
                    break;
                case 10:
                    $record['type'] = '使馆车牌';
                    break;
                case 11:
                    $record['type'] = '中国香港进出中国大陆车牌';
                    break;
                case 12:
                    $record['type'] = '农用车牌';
                    break;
                case 13:
                    $record['type'] = '教练车牌';
                    break;
                case 14:
                    $record['type'] = '中国澳门进出中国大陆车牌';
                    break;
                case 15:
                    $record['type'] = '双层武警车牌';
                    break;
                case 16:
                    $record['type'] = '武警总队车牌';
                    break;
                case 17:
                    $record['type'] = '双层武警总队车牌';
                    break;
                case 18:
                    $record['type'] = '民航车牌';
                    break;
                case 19:
                    $record['type'] = '新能源车牌';
                    break;
                default :
                    $record['type'] = '未知车牌';
                    break ;
            };
            switch ($record['carColor']) {
                default :
                    $record['carColor'] = '未知颜色';
            };
        }
        return $records;
    }
}
