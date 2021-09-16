<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Vaccination;
use App\Models\Test_result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\UserResource as UserResource;
use App\Http\Resources\UserCollection as UserCollection;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use App\Rules\Is_identity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $inputs = $request->all();
            $userQuery = User::filter($inputs);
            $users = new UserCollection($userQuery->paginate(30));
            return $this->sendResponse($users->response()->getData(true));
        }
        catch (Exception $e) {
            return $this->sendError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try{
            $validated = $request->validated();
            $userResult = new UserResource(User::create($validated));
            return $this->sendResponse($userResult, "Successfully");
        }
        catch (Exception $e) {
            return $this->sendError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try{
            $userResult = new UserResource($user);
            return $this->sendResponse($userResult);
        }
        catch (Exception $e) {
            return $this->sendError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try{
            // if(Auth::id() == $user->id)
            // {
            //     return $this->sendResponse('OK');
            // }
            // else {
            //     return $this->sendResponse([Auth::id(),  $user->id], 'Not you');
            // }

            if (Auth::id() != $user->id && $user->role_id == 1)
                return $this->sendResponse([], "You cannot update this user.");
            $validator = Validator::make(
                $request->except(['username', 'role_id']), [
                    'identity_card' => 
                        ['numeric', new Is_identity],
                    'social_insurance' => 'string',
                    'password' => 'min:6',
                    'fullname' => 'string',
                    'birthday' => 'date',
                    'gender' => [Rule::in([0,1])],
                    'address' => 'string',
                    'phone' => 'string',
                    'role_id' => 'numeric|min:0',
                    'village_id' => 'numeric|min:0',
            ]);
            $validated = $validator->validated();
            // Hash password
            if ($validated['password'])
                $validated['password'] = bcrypt($validated['password']);
            $result = 
                $user->update($validated);
            return $this->sendResponse($result, "Successfully");
        }
        catch (Exception $e) {
            return $this->sendError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            if ($user->role_id == 1)
                return $this->sendResponse([], "You cannot delete this user.");
            $userResult = $user->delete();
            return $this->sendResponse($userResult, "Successfully");
        }
        catch (Exception $e) {
            return $this->sendError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    public function ViewProfile($username){
        return DB::select("select * from covid_nienluan.users where covid_nienluan.users.username like concat('%',?,'%')",[$username]);
    }

    public function UserTestResult($username){
        return DB::select ("select a.username,b.id,b.status,b.updated_at,b.user_id,b.create_by,b.created_at from covid_nienluan.users as a join covid_nienluan.result_tests as b on a.id = b.user_id where a.username like concat('%',?,'%');;",[$username]);
        
    }

    public function UserVaccina($username){
        return DB::select ("select a.username,b.id,b.create_by,b.created_at,b.updated_at,b.user_id,b.vaccine_type_id,c.country,c.name from covid_nienluan.users as a join covid_nienluan.vaccinations as b on a.id = b.user_id 
        join covid_nienluan.vaccine_types as c on b.vaccine_type_id = c.id
        where a.username like concat('%',?,'%');",[$username]);
        
    }
}
