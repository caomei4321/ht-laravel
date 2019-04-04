<?php

namespace App\Http\Controllers\Admin;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('admin/users/index', [
            'users' => $user->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('admin/users/create_and_edit', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request, ImageUploadHandler $uploader)
    {
        $data = $request->all();
        if ($request->image) {
            $fillname = 'person'.$request->job_number;
            $result = $uploader->save($request->image,'users',$fillname);
            if ($request) {
                $data['image'] = $result['path'];
            }
        }
        $user->create($data);
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.create_and_edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();
        if ($request->image) {
            $fillname = 'person'.$request->job_number;
            $result = $uploader->save($request->image,'users',$fillname);
            if ($request) {
                $data['image'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 1,'message' => '删除成功']);
    }
}
