<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Student;

class UserController extends Controller
{
    
    public function me() 
    { 
        $user = Auth::user(); 
        if($user)
        {
            return true;
        }else
         return false;
     } 
    public $successStatus = 200;
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
           // $success['rol_id']=$user->role_id;
            return response()->json($success); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $emailValidate=User::where('email','=',$request->email)->get();
        if($emailValidate->count()>0)
        {
            return response()->json(['data' => $request->email.' is  Already exist.','error'=>'1' ], 200);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->user_name;
        if($request->type=='student')
        {
            $stu=Student::create([
                'first_name'=>$request->first_name,'last_name'=>$request->last_name,
                'program_id'=>$request->pro_id,'session_id'=>$request->session_id,
                'picture'=>'default.jpg','user_id'=>$user->id,'status'=>'panding','roll_number'=>$request->roll_number,
                'date_of_birth'=>''
            ]);

        }
        return response()->json(['data' => 'Registration successfully.After Activation email sent this email '.$request->email,'error'=>'0' ], 200);
    }
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}
