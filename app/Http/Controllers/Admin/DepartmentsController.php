<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\Admin\DepartmentRequest;

class DepartmentsController extends Controller
{
    public function index(Department $department, DepartmentRequest $request)
    {
        if ($request->user()->hasRole('administrator')) {
            $departmets = $department->all();
        } else {
            $departmets = $department->where('company_id', $request->user()->company_id)->get();
        }

        return view('admin.department.index', [
            'departments' => $departmets,
        ]);
    }

    public function create(Department $department, Company $company)
    {
        return view('admin.department.create_and_edit', [
            'department' => $department,
            'companies' => $company->all()
        ]);
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $this->authorize('own', $department);

        //dd($request->all());
        if ($request->user()->hasRole('administrator')) {
            $department->create($request->only('department_name', 'license', 'company_id', 'working_at', 'end_at'));
        } else {
            $department->create([
                'department_name' => $request->department_name,
                'license' => $request->license,
                'working_at' => $request->working_at,
                'end_at' => $request->end_at,
                'company_id' => $request->user()->company_id
            ]);
        }

        return redirect()->route('department.index');
    }

    public function edit(Department $department, Company $company)
    {
        $this->authorize('own', $department);
        return view('admin.department.create_and_edit', [
            'department' => $department,
            'companies' => $company->all()
        ]);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $this->authorize('own', $department);
        $department->update($request->only('department_name', 'license', 'company_id', 'working_at', 'end_at'));

        return redirect()->route('department.index');
    }

    public function destroy(Department $department)
    {
        $this->authorize('own', $department);

        $department->delete();
        return response()->json([
            'status' => 1,
            'msg' => '删除成功'
        ]);
    }
}
