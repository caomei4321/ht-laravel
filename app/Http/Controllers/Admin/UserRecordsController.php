<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRecord;
use Carbon\Carbon;

class UserRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRecord $userRecord)
    {
        //dd(Carbon::today());
        $userRecords = $userRecord->whereDate('created_at', Carbon::today())->get();
        return view('admin.userRecord.index', compact('userRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSearch(Request $request, UserRecord $userRecord)
    {
        //dd($request->all());
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $job_number = $request->job_number;
        $userRecords = $userRecord->whereDate('created_at', '>=', $request->start_time)
                                    ->whereDate('created_at', '<=', $request->end_time)
                                    ->where('job_number', 'like', '%' . $job_number . '%')
                                    ->get();
        //dd($userRecords);
        return view('admin.userRecord.index', compact('userRecords'));
    }
}
