<?php

namespace App\Http\Controllers\Admin;

//use App\Models\Station;
//use App\Observers\AdministratorObservers;
use App\Models\Admin;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Requests\AdministratorRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdministratorsController extends Controller
{
    public function index(Admin $administrator)
    {
        $administrators = $administrator->all();
        return view('admin.administrators.index', compact('administrators'));
    }

    public function create(Admin $administrator, Company $company, Role $role)
    {
        $roles = $role->all();
        $companies = $company->all();
        //dd($stations);
        return view('admin.administrators.create_and_edit', compact('administrator', 'companies', 'roles'));
    }

    public function store(Request $request, Admin $administrator)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'station_id' => $request->company_id
        ];
        $administrator = $administrator->create($data);

        $administrator->syncRoles($request->administrator_roles);
        return redirect()->route('admin.administrators.index');
    }


    public function show(Admin $administrator)
    {
        //dd($administrator->getRoleNames());
        //return view('admin.administrators.show', compact('administrator'));
    }


    public function edit(Admin $administrator, Role $role, Company $company)
    {
        $roles = $role->all();
        $companies = $company->all();
        $administrator_roles = $administrator->getRoleNames()->toArray();
        //dd($administrator_roles);
        return view('admin.administrators.create_and_edit', compact('administrator', 'roles', 'companies', 'administrator_roles'));
    }


    public function update(Request $request, Admin $administrator)
    {
        if (Hash::check($request->password,$administrator->password)) {
            $administrator->update($request->only(['name', 'email', 'company_id']));
        } else {
            $administrator->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company_id' => $request->company_id
            ]);
        }
        $administrator->syncRoles($request->administrator_roles);
        return redirect()->route('admin.administrators.index');
    }

    public function destroy(Admin $administrator)
    {
        $administrator->delete();
        return response()->json(['status' => 1, 'msg' => '删除成功']);
    }
}
