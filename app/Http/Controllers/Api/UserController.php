<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Designation;
use App\Models\Pillar;
use App\Models\StaffCategory;
use App\Models\StaffType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $folder = 'user';
    protected $panel='User';
    protected $folder_path;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $data['data']= $this->user->with('roles', 'employee', 'pillars')->with('courses', function ($q) {
            $q->where('courses.is_approved', 1)->orWhereNull('courses.is_approved');
        })->with('contracts', function ($q) {
            $q->latest()->get();
        })->latest()->paginate(100);
        $data['roles'] = Role::select('name', 'id')->get();
        $data['pillars'] = Pillar::select('name', 'id')->get();
        $data['supervisors'] = User::role('supervisor')->pluck('name', 'id');
        $data['contract_types'] = ContractType::pluck('name', 'id');
        $data['designation_types'] = Designation::pluck('name', 'id');
        $data['staff_categories'] = StaffCategory::pluck('name', 'id');
        $data['staff_types'] = StaffType::pluck('name', 'id');

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request['roles']);
        // try {
        //     $contract = Contract::create($input);
        // } catch (Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }

        return response()->json($user);
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
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $pillars = [];
            foreach ($request->pillar_id as $pillar) {
                array_push($pillars, $pillar['id']);
            }
            $user->pillars()->detach();
            $user->pillars()->attach($pillars);
            $roles = [];
            foreach ($request->roles as $role) {
                array_push($roles, $role['name']);
            }
            if (!empty($request->password)) {
                $request->merge(['password' => Hash::make($request['password'])]);
            }
            $user->update($request->all());
            $user->syncRoles($roles);
           
            $data['error']='false';
            $data['message']='User Info! Has Been Updated';
        } catch (\Exception $exception) {
            $data['error']='true';
            $data['message']=$exception->getMessage();
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
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' =>'User Deleted'];
    }
}
