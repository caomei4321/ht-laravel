<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarNumber extends Model
{
    protected $table = 'push_message';

    protected $fillable = [
        'channel','deviceName', 'ipaddr','serialno','bright','carBright','colorType','colorValue','confidence','direction','isoffline','gioouts','license','plateid','timeUsed','triggerType','type', 'bottom','left','right', 'top','sec', 'usec'
    ];

    public function getPlateId($parm)
    {
        $res = DB::table('cares')->where('plateid', $parm)->first();
        return $res;
    }

    public function insertData($inputs)
    {
        $ret = DB::table($this->table)->insert($inputs);
        return $ret;
    }
}
