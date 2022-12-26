<?php

namespace App\Http\Controllers\Api;

use App\Models\ContractTypeStaffCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTypeStaffCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractTypeStaffCategory = ContractTypeStaffCategory::get();
        return response()->json($contractTypeStaffCategory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'create' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ContractTypeStaffCategory::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractTypeStaffCategory  $contractTypeStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ContractTypeStaffCategory $contractTypeStaffCategory)
    {
        return response()->json($contractTypeStaffCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractTypeStaffCategory  $contractTypeStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractTypeStaffCategory $contractTypeStaffCategory)
    {
        return response()->json($contractTypeStaffCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractTypeStaffCategory  $contractTypeStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractTypeStaffCategory $contractTypeStaffCategory)
    {
        $contractTypeStaffCategory->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractTypeStaffCategory  $contractTypeStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractTypeStaffCategory $contractTypeStaffCategory)
    {
        $contractTypeStaffCategory->delete();
        return response()->json(true);
    }
}
