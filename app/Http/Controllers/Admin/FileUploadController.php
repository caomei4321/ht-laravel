<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;

class FileUploadController extends Controller
{
    public function save(Request $request)
    {
        //return 1;
        return $request->all();

    }
}