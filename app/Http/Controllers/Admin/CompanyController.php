<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index(Company $company)
    {
        $companies = $company->all();
        return view('admin.company.index', compact('companies'));
    }

    public function create(Company $company)
    {
        return view('admin.company.create_and_edit', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        $company->create($request->only(['company_name', 'working_at', 'end_at']));
        return redirect()->route('admin.company.index');
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

    public function edit(Company $company)
    {
        return view('admin.company.create_and_edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $company->update($request->only(['company_name','working_at','end_at']));
        return redirect()->route('admin.company.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(['status' => 1, 'msg' => '删除成功']);
    }
}
