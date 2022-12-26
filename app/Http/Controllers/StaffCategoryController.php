<?php

namespace App\Http\Controllers;

use App\Models\StaffCategory;
use Illuminate\Http\Request;

class StaffCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff_categories = StaffCategory::get();
        return response()->json($staff_categories);
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
        StaffCategory::create($request->all());
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StaffCategory $staffCategory)
    {
        return response()->json($staffCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffCategory $staffCategory)
    {
        return response()->json($staffCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffCategory $staffCategory)
    {
        $staffCategory->update($request->all());
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffCategory $staffCategory)
    {
        $staffCategory->delete();
        return response()->json(true);
    }
}
