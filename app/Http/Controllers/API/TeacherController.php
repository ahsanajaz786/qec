<?php


namespace App\Http\Controllers;


namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Teacher;
use Illuminate\Support\Str;


class TeacherController extends Controller
{
  public function Rrgister(Request $request)
  {
      $file="";
      
    if ($request->hasFile('img')) {
        $image = $request->file('img');
    
        $fileName = $image->getClientOriginalName();
        $file=Str::random().Str::random().$fileName;
        $destinationPath = base_path() . '/public/img/';
        $image->move($destinationPath,  $file  );
    
      
      
    }
  
    if($request->id==0)
    {
    $emailValidate=User::where('email','=',$request->input('email'))->get();
    if($emailValidate->count()>0)
    {
        return response()->json(['data' => $request->input('email').' is  Already exist.','error'=>'1' ], 200);
    }
    $input['user_name'] = $request->input('first_name');
    $input['email'] = $request->input('email');
    $input['role_id'] = "3";
    $input['password'] = bcrypt("uokTeacher@123890");
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->accessToken;
    $success['name'] =  $user->user_name;
    
   

        $stu=Teacher::create([
            'first_name'=>$request->input('first_name'),'last_name'=>$request->last_name,
            'dep_id'=>$request->dep_id,
            'picture'=>$file,'user_id'=>$user->id,'status'=>$request->input('status'),'cnic'=>$request->input('cnic'),
            'date_of_birth'=>'','phone'=>''
        ]);


    
    return response()->json(['data' => 'Registration successfully.After Activation email sent this email '.$request->email,'error'=>'0' ], 200);
        }
    else{
        $input["first_name"]=$request->first_name;
        $input["last_name"]=$request->last_name;
        $input["status"]=$request->status;
        $input["cnic"]=$request->cnic;
        if($request->hasFile('img'))
        {
            $input["picture"]=$file;
        }
       $user=Teacher::where('id', '=', $request->id)->update($input);
       return response()->json(['data' => 'Update successfully. ' ], 200);
   
    }    
  }

   /* public function studentdupm()
    {
         $roll=0;
        for ($i=0; $i < 500; $i++) { 
            
            $pro_id;
            $sess_id;
            $studen_name="stundet ".$i;
            $user = User::create([
                'user_name'=>$studen_name,
                'email'=>$studen_name."@gmail.com",
                'password'=>bcrypt('test'),
                'api_token'=>'',
                'role_id'=>'2'

            ]);
           if($i<100)
           {
               $roll++;
            $pro_id=1;
            $sess_id=1;


           }else if($i>100 && 1<200){
              
            $pro_id=2;
            $sess_id=1;
            $roll++;
               
           }else if($i>200 && $i<300){
           
            $pro_id=3;
            $sess_id=2;
            $roll++;
               
        }else if($i>400){
            
            $pro_id=4;
            $sess_id=2;
            $roll++;
               
        }
        $stu=Student::create([
            'first_name'=>$studen_name,'last_name'=>'last 1'.$i,
            'program_id'=>$pro_id,'session_id'=>$sess_id,
            'picture'=>'default.jpg','user_id'=>$user->id,'status'=>'panding','roll_number'=>$roll,
            'date_of_birth'=>''
        ]);
        }
        return "ok";
    }*/
    public function getTeacher($dep_id)
    {
       if($dep_id==0)
       {
        return Teacher::join('departments','departments.id','=','teachers.dep_id')
        ->join('users','users.id','=','teachers.user_id')
        ->select('teachers.id','users.email','teachers.picture','teachers.status','teachers.date_of_birth','teachers.first_name','teachers.last_name','teachers.cnic','departments.department_name','departments.id as dep_id','departments.faculty_id')
     
        ->paginate(15);
       }else{
        return Teacher::where('dep_id','=', $dep_id )
        ->join('departments','departments.id','=','teachers.dep_id')
        ->join('users','users.id','=','teachers.user_id')

        ->select('teachers.id','users.email','teachers.picture','teachers.status','teachers.date_of_birth','teachers.first_name','teachers.last_name','teachers.cnic','departments.department_name','departments.id as dep_id','departments.faculty_id')
     
        
        ->paginate(15);

       }

    }
     function UpdateStudent(Request $req)
    {
  
    } 



}
