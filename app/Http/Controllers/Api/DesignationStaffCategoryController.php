<?php

namespace App\Http\Controllers\Api;

use App\Models\DesignationStaffCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DesignationStaffCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designationStaffCategory = DesignationStaffCategory::get();
        return response()->json($designationStaffCategory);
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
        DesignationStaffCategory::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DesignationStaffCategory  $designationStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DesignationStaffCategory $designationStaffCategory)
    {
        return response()->json($designationStaffCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DesignationStaffCategory  $designationStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(DesignationStaffCategory $designationStaffCategory)
    {
        return response()->json($designationStaffCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DesignationStaffCategory  $designationStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DesignationStaffCategory $designationStaffCategory)
    {
        $designationStaffCategory->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DesignationStaffCategory  $designationStaffCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DesignationStaffCategory $designationStaffCategory)
    {
        $designationStaffCategory->delete();
        return response()->json(true);
    }
}
