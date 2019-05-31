<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Department;
use App\Models\Device;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Admin\UserRequest;

class UsersController extends Controller
{

    public function index(User $user, UserRequest $request)
    {
        //$this->authorize('own', $user);

        if ($request->user()->hasRole('administrator')) {
            $users = $user->paginate(15);
        } else {
            $users = $user->where('company_id',$request->user()->company_id)->paginate(15);
        }

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function create(User $user, Department $department, Device $device, UserRequest $request)
    {
        //$this->authorize('own', $user);
        //if ($request->user()->hasRole('administrator')) {
        //    $departments = $department->where('company_id',$request->user()->company_id)->get();
        //}
        $departments = $department->where('company_id',$request->user()->company_id)->get();
        $devices = $device->where('company_id',$request->user()->company_id)->get();

        return view('admin.users.create_and_edit', [
            'user' => $user,
            'departments' => $departments,
            'devices' => $devices
        ]);
    }

    public function store(User $user, UserRequest $request, ImageUploadHandler $uploader)
    {
        //dd($request->image->getClientOriginalName());
        $data = $request->all();
        if ($request->image) {
            //$fillname = 'person'.$request->job_number;
            $result = $uploader->save($request->image, 'users', $data['name'].$data['job_number']);
            if ($result) {
                $data['image'] = $result['path'];
                $data['image_name'] = $result['filename'];
            } else {
                $data['image'] = '';
            }
        }
        $data['password'] = bcrypt($data['password']);
        if (!$request->user()->hasRole('administrator')) {
            $data['company_id'] = $request->user()->company_id;
        }

        $user->fill([
            'name'  => $data['name'],
            'job_number' => $data['job_number'],
            'phone'     => $data['phone'],
            'password' => $data['password'],
            'department_id' => $data['department_id'],
            'image'     => $data['image'],
            'image_name'=> $data['image_name'],
            'company_id'=> $data['company_id']
        ]);
        $user->save();

        if (isset($data['device'])) {
            $user->device()->attach($data['device']);
        }
        return redirect()->route('user.index');
    }

    public function show(User $user)
    {
        $user_records = $user->user_records()->orderBy('id', 'desc')->get();
        //dd($user_records);
        return view('admin.users.show', [
            'user' => $user,
            'userRecords' => $user_records
        ]);
    }

    public function edit(User $user, Department $department, Company $company, UserRequest $request, Device $device)
    {
        $departments = $department->where('company_id',$request->user()->company_id)->get();
        $userDevice = $user->device()->get()->toArray();
        $devices = $device->where('company_id', $request->user()->company_id)->get();
        
        return view('admin.users.create_and_edit', [
            'user' => $user,
            'departments' => $departments,
            'devices'     => $devices,
            'user_device' => $userDevice,

        ]);
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();
        if ($request->image) {
            //$fillname = 'person'.$request->job_number;
            $result = $uploader->save($request->image, 'users', $data['name'].$data['job_number']);
            if ($result) {
                $data['image'] = $result['path'];
                $data['image_name'] = $result['filename'];
            }
        }
        if (strlen($request->password) < 57) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        if (isset($data['device'])) {
            $user->device()->sync($request->device);
        }
        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 1, 'message' => '删除成功']);
    }
}
