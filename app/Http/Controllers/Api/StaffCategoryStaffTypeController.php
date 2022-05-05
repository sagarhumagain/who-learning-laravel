<?php

namespace App\Http\Controllers\Api;

use App\Models\StaffCategoryStaffType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffCategoryStaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffCategoryStaffType = StaffCategoryStaffType::get();
        return response()->json($staffCategoryStaffType);
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
        StaffCategoryStaffType::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffCategoryStaffType  $staffCategoryStaffType
     * @return \Illuminate\Http\Response
     */
    public function show(StaffCategoryStaffType $staffCategoryStaffType)
    {
        return response()->json($staffCategoryStaffType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffCategoryStaffType  $staffCategoryStaffType
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffCategoryStaffType $staffCategoryStaffType)
    {
        return response()->json($staffCategoryStaffType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffCategoryStaffType  $staffCategoryStaffType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffCategoryStaffType $staffCategoryStaffType)
    {
        $staffCategoryStaffType->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffCategoryStaffType  $staffCategoryStaffType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffCategoryStaffType $staffCategoryStaffType)
    {
        $staffCategoryStaffType->delete();
        return response()->json(true);
    }
}
