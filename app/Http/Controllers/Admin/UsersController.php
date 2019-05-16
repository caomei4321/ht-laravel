<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Department;
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

    public function create(User $user, Department $department, Company $company, UserRequest $request)
    {
        //$this->authorize('own', $user);
        //if ($request->user()->hasRole('administrator')) {
        //    $departments = $department->where('company_id',$request->user()->company_id)->get();
        //}

        return view('admin.users.create_and_edit', [
            'user' => $user,
            'departments' => $department->all(),
            'companies'  => $company->all()
        ]);
    }

    public function store(User $user, UserRequest $request, ImageUploadHandler $uploader)
    {
        //dd($request->image->getClientOriginalName());
        $data = $request->all();
        if ($request->image) {
            //$fillname = 'person'.$request->job_number;
            $result = $uploader->save($request->image, 'users', $data['name']);
            if ($result) {
                $data['image'] = $result['path'];
                $data['image_name'] = $result['filename'];
            } else {
                $data['image'] = '';
            }
        }
        $data['password'] = bcrypt($data['password']);
        $user->create($data);
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

    public function edit(User $user, Department $department, Company $company)
    {
        return view('admin.users.create_and_edit', [
            'user' => $user,
            'companies' => $company->all(),
            'departments' => $department->all()
        ]);
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();
        if ($request->image) {
            //$fillname = 'person'.$request->job_number;
            $result = $uploader->save($request->image, 'users', $data['name']);
            if ($result) {
                $data['image'] = $result['path'];
                $data['image_name'] = $result['filename'];
            }
        }
        if (strlen($request->password) < 57) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 1, 'message' => '删除成功']);
    }
}
