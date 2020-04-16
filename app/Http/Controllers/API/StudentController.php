<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Student;

class StudentController extends Controller
{
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
    public function getStudent($sessionId,$pro_id)
    {
       if($sessionId==0 && $pro_id==0)
       {
        return Student::join('sessions','students.session_id','=','sessions.id'
        )->join('programs','students.program_id','=','programs.id')
        ->join('departments','programs.dep_id','=','departments.id')
        ->select('students.id','students.picture','students.status','students.date_of_birth','students.first_name','students.last_name','students.program_id','students.session_id','students.roll_number','students.status','programs.program_name','sessions.session','departments.department_name','departments.id as dep_id','departments.faculty_id')
     
        ->paginate(15);
       }else{
        return Student::where('session_id','=', $sessionId )
        ->where('program_id','=',$pro_id)
        ->join('sessions','students.session_id','=','sessions.id'
        )->join('programs','students.program_id','=','programs.id')
        ->join('departments','programs.dep_id','=','departments.id')
        
        ->select('students.id','students.picture','students.status','students.date_of_birth','students.first_name','students.last_name','students.program_id','students.session_id','students.roll_number','students.status','programs.program_name','sessions.session','departments.department_name','departments.id as dep_id','departments.faculty_id')
     
        ->paginate(15);

       }

    }
     function UpdateStudent(Request $req)
    {
       

       $user=Student::where('id', '=', $req->id)->update(array('status' => $req->status));

      // $user->status=$req->status;
      // $user->save();
       return response()->json(['Success' => "Successfully"], 200);


    } 



}
