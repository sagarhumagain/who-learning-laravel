<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Course;
use App\Models\CourseAssignmentSetting;
use App\Models\Designation;
use App\Models\Pillar;
use App\Models\StaffCategory;
use App\Models\StaffType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if (auth()->user()->hasRole('supervisor')) {
            $data= $this->user->with('roles', 'employee', 'pillars')->with('courses', function ($q) {
                $q->where('courses.is_approved', 1)->orWhereNull('courses.is_approved');
            })->with('contracts', function ($q) {
                $q->latest()->get();
            })->whereHas('employee', function ($q) {
                $q->where('supervisor_user_id', auth()->user()->id);
            })->latest()->paginate(50);
        } else {
            $data= $this->user->with('roles', 'employee', 'pillars')->with('courses', function ($q) {
                $q->where('courses.is_approved', 1)->orWhereNull('courses.is_approved');
            })->with('contracts', function ($q) {
                $q->latest()->get();
            })->latest()->paginate(50);
        }


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
        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['is_first_time_login'] = 1;
            $user = User::create($input);
            $user->assignRole($request['roles']);
            //#TODO assign course assignment settings during registration
            // try {
            //     $contract = Contract::create($input);
            // } catch (Exception $e) {
            //     return response()->json(['error' => $e->getMessage()], 500);
            // }
            $data['error']= false ;
            $data['message']='User Info! Has Been Created';

            return response()->json($data);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

            if ($request->roles) {
                $roles = [];
                foreach ($request->roles as $role) {
                    array_push($roles, $role['name']);
                }
                $user->syncRoles($roles);
            }
            if (!empty($request->password)) {
                $request->merge(['password' => Hash::make($request['password'])]);
            }
            //assign courses after approving user
            if ($user->is_first_time_login == 1 && $request->is_first_time_login == 0) {
                $this->assignCourse($id);
            }
            $user->update($request->all());
            $data['error']= false ;
            $data['message']='User Info! Has Been Updated';
        } catch (\Exception $exception) {
            $data['error']= true;
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

    public function assignCourse($id)
    {
        try {
            $course_assignment_settings = CourseAssignmentSetting::get();

            foreach ($course_assignment_settings as $assignment) {
                $this->assignIndividualCourse($id, $assignment);
            }
            $response['error'] = false;
            $response['message'] = 'Course assigned to users successfully';
            return $response;
        } catch(\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            return $response;
        }
    }
    public function assignIndividualCourse($id, $assignment)
    {
        //check if contract has assignment settings

        $users = User::leftJoin(DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
            $join->on('users.id', '=', 't2.user_id');
        })
        ->where('users.id', $id)
        ->where(function ($q) use ($assignment) {
            $q->whereHas('pillars', function ($q) use ($assignment) {
                $q->whereIn('pillar_id', $assignment['pillar_ids']);
            })
            ->orWhereIn('staff_type_id', $assignment['staff_type_ids'])
            ->orWhereIn('contract_type_id', $assignment['contract_type_ids'])
            ->orWhereIn('staff_category_id', $assignment['staff_category_ids'])
            ->orWhereIn('designation_id', $assignment['staff_designation_ids']);
        })->select('users.id as id')->get();

        if ($users->count() == 0) {
            return;
        }
        $course = Course::findOrFail($assignment->course_id);
        $course->users()->syncWithoutDetaching($users);
    }
}
