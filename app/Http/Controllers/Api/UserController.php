<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pillar;
use App\Models\User;
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
        $data['data']= $this->user->with('roles:name,id', 'employee')->latest()->paginate(100);
        $data['roles'] = Role::select('name', 'id')->get();
        $data['pillars'] = Pillar::pluck('name', 'id');
        $data['supervisors'] = User::role('supervisor')->pluck('name', 'id');
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

            try {
                $user->pillars()->attach([$request->pillar_id]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            $roles = [];
            foreach ($request->roles as $role) {
                array_push($roles, $role['name']);
            }

            /*If user change the password*/
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

    public function getProfile()
    {
        $user = auth()->user();
        $data = $user->toArray();
        $data['employee'] = $user->employee();
        $data['permissions'] = $user->getAllPermissions()->pluck('name');
        $data['roles'] = $user->getRoleNames();
        return $data;
    }
}
