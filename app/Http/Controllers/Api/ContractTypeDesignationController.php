<?php

namespace App\Http\Controllers\Api;

use App\Models\ContractTypeDesignation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTypeDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractTypeDesignation = ContractTypeDesignation::get();
        return response()->json($contractTypeDesignation);
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
        ContractTypeDesignation::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractTypeDesignation  $contractTypeDesignation
     * @return \Illuminate\Http\Response
     */
    public function show(ContractTypeDesignation $contractTypeDesignation)
    {
        return response()->json($contractTypeDesignation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractTypeDesignation  $contractTypeDesignation
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractTypeDesignation $contractTypeDesignation)
    {
        return response()->json($contractTypeDesignation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractTypeDesignation  $contractTypeDesignation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractTypeDesignation $contractTypeDesignation)
    {
        $contractTypeDesignation->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractTypeDesignation  $contractTypeDesignation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractTypeDesignation $contractTypeDesignation)
    {
        $contractTypeDesignation->delete();
        return response()->json(true);
    }
}
