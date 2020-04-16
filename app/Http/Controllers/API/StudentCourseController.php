<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Faculty;
use App\Department;
use App\Session;
use App\Program;
use App\Course;
use App\Student;
use App\ProgramSession;
use App\StudentCourse;
use App\Teacher;

class StudentCourseController extends Controller
{
    public function filterCourse($q)
    {
     return   Course::where('course_title', 'LIKE', '%' . $q . '%')
     ->paginate(15);
     
    }
    public function filterTeacher($q)
    {
     return   Teacher::where('first_name', 'LIKE', '%' . $q . '%')
     ->paginate(15);
     
    }
    public function getStudentbyprogrm($pro_id,$sessionId)
    {
       
        return Student::where("status",'=','Active')
        ->where('session_id','=', $sessionId )
        ->where('program_id','=',$pro_id)
        ->orderBy('roll_number', 'DESC')
        ->select("roll_number","first_name","last_name","id")
        ->get();

       
    }
    public function AssignCourseStudent(Request $req)
    {
        
       
        $proSession=ProgramSession::where('pro_id','=',$req->pro_id)
        ->where('session_id','=',$req->session_id)
        ->where('semester','=',$req->semester)->first();
      if($proSession)
      {

      }else{
     $proSession=ProgramSession::create([
       'pro_id'=>$req->pro_id,'semester'=>$req->semester,'session_id'=>$req->session_id,'status'=>'Active'
     ]);
      }
      if($req->atype=="2")
      {
      
         
        foreach ($req->students as  $s) {
            foreach ($req->course as  $c) {
                $cont=StudentCourse::where('program_session_id','=',$proSession->id)
                ->where('student_id','=',$s)
                ->where('course_id','=',$c)->first();
                if( $cont)
                {

                }else {
                    
                StudentCourse::create([
                    'program_session_id'=>$proSession->id,'student_id'=>$s,'course_id'=>$c,'status'=>'Active'
                ]);
                }
               
            }
           
        }
        return response()->json(['Success' => "Assign Successfully"], 200);
      }else if( $req->atype=="1"){
          
         $stu=Student::where('program_id','=',$req->pro_id)
         ->where('session_id','=',$req->session_id)
         ->where("status",'=','Active')
         ->get();
         foreach($stu as $s)
         {
        foreach ($req->course as  $c) {
            $cont=StudentCourse::where('program_session_id','=',$proSession->id)
                ->where('student_id','=',$s->id)
                ->where('course_id','=',$c)->first();
                if( $cont)
                {

                }else{
            StudentCourse::create([
                'program_session_id'=>$proSession->id,'student_id'=>$s->id,'course_id'=>$c,'status'=>'Active'
            ]);
        }}
         }
        return response()->json(['Success' => "Assign Successfully"], 200);

      }
      return response()->json(['Error' => "Error"], 200);

    }
    public function DeleteProgramCourse(Request $req)
    {
       
        StudentCourse::where('program_session_id','=',$req->id)
        ->where('course_id','=',$req->course_id)->delete();
        return response()->json(['Success' => "Delete Successfully"], 200);
    
    }

    
    public function getCourseByP_S_S($pro_id,$session_id,$semester)
    {
        return ProgramSession::where('pro_id','=',$pro_id)
        ->where('session_id','=',$session_id)
        ->where('semester','=',$semester)
         ->join('student_courses','student_courses.program_session_id','=','program_sessions.id')
         ->join('courses','student_courses.course_id','=','courses.id')
         ->distinct()->get(['course_id as course_id','course_title','program_sessions.id'])
         ;

    }
    public function getProgramSession()
    { 
        return ProgramSession::where('status','=','Active')
         ->join('programs','program_sessions.pro_id','=','programs.id')
         ->join('sessions','program_sessions.session_id','=','sessions.id')
         ->distinct()->get(['program_sessions.id','semester','programs.program_name','sessions.session'])
         ;
    }

    public function getProgramCourse($pro_id,$session_id,$id)
    {
        if($pro_id!=0 )
        {
            return ProgramSession::where('pro_id','=',$pro_id)
            ->where('session_id','=',$session_id)
            ->join('sessions','program_sessions.session_id','=','sessions.id'
            )->join('programs','program_sessions.pro_id','=','programs.id')
            ->join('departments','programs.dep_id','=','departments.id')
            ->orderby('program_sessions.id','DESC')
            ->orderby('program_sessions.status','ASC')
            ->select('program_sessions.id','program_sessions.semester','program_sessions.status','sessions.session','programs.program_name','departments.department_name','departments.id as dep_id','departments.faculty_id')
            ->paginate(15);;

        }else if($id!=0){
            return StudentCourse::where('program_session_id','=',$id)
           
            
            ->join('program_sessions','program_sessions.id','=','student_courses.program_session_id')
            
            ->join('sessions','program_sessions.session_id','=','sessions.id')
            ->join('programs','program_sessions.pro_id','=','programs.id')
            ->join('courses','courses.id','=','course_id')
            ->join('departments','programs.dep_id','=','departments.id')
            ->distinct()->get(['program_session_id as id','course_id','semester','program_session_id','sessions.session','sessions.id as session_id','programs.id as pro_id','programs.program_name','course_title','course_code','department_name','departments.id as dep_id','departments.faculty_id as fac_id'])
           // ->select('program_sessions.id','program_sessions.semester','program_sessions.status','sessions.session','programs.program_name','departments.department_name','departments.id as dep_id','departments.faculty_id')
           ;

        }else{
            return ProgramSession::join('sessions','program_sessions.session_id','=','sessions.id'
            )->join('programs','program_sessions.pro_id','=','programs.id')
            ->join('departments','programs.dep_id','=','departments.id')
            ->orderby('program_sessions.id','DESC')
            ->orderby('program_sessions.status','ASC')
            ->select('program_sessions.id','program_sessions.semester','program_sessions.status','sessions.session','programs.program_name','departments.department_name','departments.id as dep_id','departments.faculty_id')
            ->paginate(15);;
         
        }


    }
}
