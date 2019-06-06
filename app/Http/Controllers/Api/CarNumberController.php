<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarNumber;
use Illuminate\Support\Facades\DB;

class CarNumberController extends Controller
{
    protected $car;

    public function __construct()
    {
        $this->car = new CarNumber();
    }

    public function base64 ($imgBase64, $pre)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/' , $imgBase64 , $res)) {
            //获取图片类型
            $type = $res[2];
            //设置生成图片名字
//            $imageName = 'b'.time().'.'.$type;
            $imageName = $pre.time().'.'.$type;
            if (strstr($imgBase64,",")){
                $image = explode(',',$imgBase64);
                $image = $image[1];
            }
            // 设置图片本地保存路劲
            $path = "cars/".date("Ymd",time());
            if (!is_dir($path)){
                //判断目录是否存在 不存在就创建
                mkdir($path,0777,true);
            }
            $imageSrc= $path."/". $imageName; //图片名字
            $r = file_put_contents($imageSrc, base64_decode($image));//返回的是字节数
            if (!$r) {
                $tmparr1=array('data'=>null,"code"=>1,"msg"=>"图片生成失败");
                return json_encode($tmparr1);
            }else{
                $tmparr2=array('data'=>1,"code"=>0,"msg"=>"图片生成成功");
//                echo json_encode($tmparr2);
                return $imageSrc;
            }
        }
    }


    public function getTest(Request $request)
    {
        $doc = file_get_contents("php://input");
        $data = json_decode($doc);
        foreach ($data as $alarm) {
            foreach ($alarm->result as $value) {
                $value;
            }
        }
        $bigImg = $data->AlarmInfoPlate->result->PlateResult->imageFile;
        $imgBase64 ="data:image/jpeg;base64,".$bigImg;
        $imageFile = $this->base64($imgBase64, 'b'); // 大图片
        $miniImg =  $data->AlarmInfoPlate->result->PlateResult->imageFragmentFile;
        $miniImgBase64 = "data:image/jpeg;base64,".$miniImg;
        $imageFragmentFile=$this->base64($miniImgBase64, 's'); // 小图片
        if ($data->AlarmInfoPlate->result->PlateResult->gioouts) {
            $test = $data->AlarmInfoPlate->result->PlateResult->gioouts;
            $string = '';
            foreach ($test as $v ){
                $str = "ionum:".$v->ionum .'' ."ctrltype". $v->ctrltype.',';
                $string .= $str;
            }
        }else{
            $string = '';
        }
        $info = [
            'channel' => $alarm->channel,
            'deviceName' => $alarm->deviceName,
            'ipaddr' => $alarm->ipaddr,
            'serialno' => $alarm->serialno,
            'bright' =>$value->bright,
            'carBright' =>$value->carBright,
            'carColor' =>$value->carColor,
            'colorType' =>$value->colorType,
            'colorValue' =>$value->colorValue,
            'confidence' =>$value->confidence,
            'direction' =>$value->direction,
            'isoffline' =>$value->isoffline,
            'imageFile' => $imageFile,
            'imageFragmentFile' => $imageFragmentFile,
            'gioouts' => $string,
            'license' =>$value->license,
            'plateid' =>$value->plateid,
            'timeUsed' =>$value->timeUsed,
            'triggerType' =>$value->triggerType,
            'type' =>$value->type,
            'bottom' =>$value->location->RECT->bottom,
            'left' =>$value->location->RECT->left,
            'right' =>$value->location->RECT->right,
            'top' =>$value->location->RECT->top,
            'sec' =>$value->timeStamp->Timeval->sec,
            'usec' =>$value->timeStamp->Timeval->usec,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $this->car->insertData($info);
        if ($info['triggerType'] == 8) {
            DB::table('push_message')->whereBetween('created_at', [$info['created_at'],date('Y-m-d H:i:s',time())])
                                    ->where('license', $info['license'])
                                    ->where('isoffline','1')
                                    ->delete();
        }
        $fp = fopen("device_info.txt", "w");
        if(!$fp){
            return;
        }
        $flag=fwrite($fp, $doc);
        if(!$flag)
        {
            fclose($fp);
            return;
        }
        fclose($fp);

        // sleep 200ms
        usleep(200*1000);
        $ret = DB::table('cares')->where('license',$value->license)->first();
        if (!$ret) {
            // 发送开闸命令
            $cars = [
                'plateid' =>$value->plateid,
                'license' =>$value->license,
                'colorType' =>$value->colorType,
                'type' =>$value->type,
                'colorValue' =>$value->colorValue,
                'carColor' =>$value->carColor,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
            DB::table('cares')->insert($cars);
            // 发送抓拍命令
            echo '{"Response_AlarmInfoPlate":{"info":"no","manualTrigger":"ok"}}';
            // 发送开闸命令
            //echo '{"Response_AlarmInfoPlate":{"info":"ok","plateid":'.$info['plateid'].',"content":"123","is_pay":"true","serialData":[{"serialChannel":0,"data" : "123456","dataLen" : 12},{"serialChannel":1,"data" : "123456","dataLen" : 11}]}';
        }else if ($ret->enable == 1 && $ret->need_alarm == 0 ){
            echo '{"Response_AlarmInfoPlate":{"info":"ok","plateid":'.$info['plateid'].',"content":"123","is_pay":"true","serialData":[{"serialChannel":0,"data" : "123456","dataLen" : 12},{"serialChannel":1,"data" : "123456","dataLen" : 12}], "white_list_operate":{"operate_type" : 0,"white_list_data":[{"plate": "'.$ret->license.'","enable": 1,"need_alarm": 0,"enable_time": "'.$ret->enable_time.'","overdue_time": "'.$ret->need_alarm.'"}]}}';
        }else {
            echo '{"Response_AlarmInfoPlate":{"info":"ok","plateid":'.$info['plateid'].',"content":"123","is_pay":"true","serialData":[{"serialChannel":0,"data" : "123456","dataLen" : 12},{"serialChannel":1,"data" : "123456","dataLen" : 13}]}';
        }

        // http发送串口数据123456相机串口能否读到到串口数据123456
    }

    public function serial(Request $request)
    {
        $doc = file_get_contents("php://input");
        $data = json_decode($doc);
        $sr = fopen('receivedeviceinfo.txt', "w");
        $flag=fwrite($sr, $doc);
        if(!$flag)
        {
            fclose($sr);
            return;
        }
        $flag=fwrite($sr, "\r\n");
        fclose($sr);
        foreach ($data as $serialno) {
            $info = [
                'channel' => $serialno->channel,
                'serialno' => $serialno->serialno,
                'ipaddr' => $serialno->ipaddr,
                'deviceName' => $serialno->deviceName,
                'serialChannel' => $serialno->serialChannel,
                'data' => $serialno->data,
                'dataLen' => $serialno->dataLen,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
        }
        $ret = DB::table('serialno')->insert($info);
        echo '{"Response_AlarmInfoPlate":{"info":"ok","content":"111","is_pay":"true", "serialData" :[{"serialChannel":0,"data" : "123456","dataLen" : 12},{"serialChannel":"1","data" : "654321","dataLen" : "12"}]}';
    }


    public function receive(Request $request)
    {
        $doc = $request['serialno'];
        $data = json_decode($doc);
        $sr = fopen('receive.txt', "w");
        $flag=fwrite($sr, $doc);
        if(!$flag)
        {
            fclose($sr);
            return;
        }
        $flag=fwrite($sr, "\r\n");
        fclose($sr);
        echo "{$data}";
        //echo '{"Response_AlarmInfoPlate":{"info":"ok","content":"'.$doc.'","is_pay":"true"}}';
    }
}
