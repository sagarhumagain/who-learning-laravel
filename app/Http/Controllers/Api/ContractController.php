<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\ContractRequest;
use App\Models\Contract;
use App\Models\User;
use App\Services\MailService;
use Exception;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
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
            if(isset($request->pillar_id)) {
                $this->assignPillars($request->pillar_id, $request->user_id);
            }
            Contract::create($request->all());
            $data = $this->getProfile($request->user_id);
            $this->mailService->sendContractApproveMail($data);

            $data['error'] = false;
            $data['message'] = 'Contract Info! Has Been Created';
        } catch (Exception $e) {
            $data['error'] = true;
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
            if(isset($request->pillar_id)) {
                $this->assignPillars($request->pillar_id, $request->user_id);
            }
            Contract::updateOrCreate(['id' => $id], $request->all());

            //send contract approval mail
            $data = $this->getProfile($request->user_id);
            $this->mailService->sendContractApproveMail($data);

            $data['error'] = false;
            $data['message'] = 'Contract Info! Has Been Updated';
        } catch (Exception $e) {
            $data['error'] = true;
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
            $data['error'] = false;
            $data['message'] = 'Contract Info! Has Been Deleted';
        } catch (Exception $e) {
            $data['error'] = true;
            $data['message'] =  $e->getMessage();
        }
    }

    public function assignPillars($pillar_ids, $user_id)
    {
        $user = User::findOrFail($user_id);
        $pillarIds = collect($pillar_ids)->pluck('id')->toArray();
        // Sync the relationships
        $user->pillars()->sync($pillarIds);
    }

    public function getProfile($user_id)
    {
        return User::where('id', $user_id)
        ->whereHas('employee', function ($q) {
            $q->with('supervisor');
        })
        ->with('employee.supervisor', 'employee') // Eager load the supervisor and employee relationships
        ->first();


    }
}
