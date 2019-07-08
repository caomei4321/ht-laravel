<?php

namespace App\Http\Controllers\Api;

use App\Models\Version;
use Illuminate\Http\Request;

class VersionsController extends Controller
{
    public function version(Version $version)
    {
        $data = $version->limit(1)->orderBy('created_at','desc')->get();
        return $data;
    }
}
