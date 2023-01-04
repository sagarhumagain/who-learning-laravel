<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\ContractRequest;
use App\Models\Contract;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {
        try {
            $this->assignPillars($request->pillar_id, $request->user_id);
            Contract::create($request->all());
            $data['error']= false;
            $data['message']='Contract Info! Has Been Created';
        } catch (Exception $e) {
            $data['error']= true;
            $data['message'] =  $e->getMessage();
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, $id)
    {
        try {
            $this->assignPillars($request->pillar_id, $request->user_id);
            Contract::updateOrCreate(['id' => $id], $request->all());
            $data['error']= false;
            $data['message']='Contract Info! Has Been Updated';
        } catch (Exception $e) {
            $data['error']= true;
            $data['message'] =  $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Contract::find($id)->delete();
            $data['error']= false;
            $data['message']='Contract Info! Has Been Deleted';
        } catch (Exception $e) {
            $data['error']= true;
            $data['message'] =  $e->getMessage();
        }
    }

    public function assignPillars($pillar_ids, $user_id)
    {
        $user = User::find($user_id);
        $pillars = [];
        foreach ($pillar_ids as $pillar) {
            array_push($pillars, $pillar['id']);
        }
        $user->pillars()->sync($pillars);
    }
}
