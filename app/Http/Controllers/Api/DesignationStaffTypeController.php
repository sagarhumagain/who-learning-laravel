<?php

namespace App\Http\Controllers\Api;

use App\Models\DesignationStaffType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DesignationStaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designationStaffType = DesignationStaffType::get();
        return response()->json($designationStaffType);
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
        DesignationStaffType::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DesignationStaffType  $designationStaffType
     * @return \Illuminate\Http\Response
     */
    public function show(DesignationStaffType $designationStaffType)
    {
        return response()->json($designationStaffType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DesignationStaffType  $designationStaffType
     * @return \Illuminate\Http\Response
     */
    public function edit(DesignationStaffType $designationStaffType)
    {
        return response()->json($designationStaffType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DesignationStaffType  $designationStaffType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DesignationStaffType $designationStaffType)
    {
        $designationStaffType->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DesignationStaffType  $designationStaffType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DesignationStaffType $designationStaffType)
    {
        $designationStaffType->delete();
        return response()->json(true);
    }
}
