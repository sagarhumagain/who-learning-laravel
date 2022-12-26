<?php

namespace App\Http\Controllers\Api;

use App\Models\ContractTypeStaffType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTypeStaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractTypeStaffType = ContractTypeStaffType::get();
        return response()->json($contractTypeStaffType);
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
        ContractTypeStaffType::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractTypeStaffType  $contractTypeStaffType
     * @return \Illuminate\Http\Response
     */
    public function show(ContractTypeStaffType $contractTypeStaffType)
    {
        return response()->json($contractTypeStaffType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractTypeStaffType  $contractTypeStaffType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractTypeStaffType $contractTypeStaffType)
    {
        return response()->json($contractTypeStaffType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractTypeStaffType  $contractTypeStaffType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractTypeStaffType $contractTypeStaffType)
    {
        $contractTypeStaffType->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractTypeStaffType  $contractTypeStaffType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractTypeStaffType $contractTypeStaffType)
    {
        $contractTypeStaffType->delete();
        return response()->json(true);
    }
}
