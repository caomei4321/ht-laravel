<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\Admin\DepartmentRequest;

class DepartmentsController extends Controller
{
    public function index(Department $department)
    {
        return view('admin.department.index', [
            'departments' => $department->all()
        ]);
    }

    public function create(Department $department)
    {
        return view('admin.department.create_and_edit', [
            'department' => $department
        ]);
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $department->create($request->only('department_name'));

        return redirect()->route('department.index');
    }

    public function edit(Department $department)
    {
        return view('admin.department.create_and_edit', [
            'department' => $department
        ]);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->only('department_name'));

        return redirect()->route('department.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'status' => 1,
            'msg' => '删除成功'
        ]);
    }
}
