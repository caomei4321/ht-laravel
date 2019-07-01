<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function departmentList()
    {
        $companyId = $this->user()->company_id;

        $departments = Department::where('company_id',$companyId)->get(['id','department_name','license']);

        return $departments;
    }
}
