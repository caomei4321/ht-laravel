<?php

namespace App\Http\Controllers\Admin;

use App\Models\Version;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VersionController extends Controller
{
    public function index(Version $version)
    {
        $versions = $version->paginate(15);
        return view('admin.version.index', compact('versions'));
    }

    public function create(Version $version)
    {
        return view('admin.version.create', compact('version'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function fileUpload()
    {

    }
}
