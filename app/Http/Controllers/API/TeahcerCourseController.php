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
use App\TeahcerCourse;

class TeahcerCourseController extends Controller
{
    public function AssignTeacherCourse(Request $req)
    { 
        if($req->id==0)
        {

        $programSession=ProgramSession::where('pro_id','=',$req->pro_id)->where('session_id','=',$req->session_id)
        ->where('semester','=',$req->semester)->first();

        $data=TeahcerCourse::create([
            'teacher_id'=>$req->teacher_id,'course_id'=>$req->course_id,'program_session_id'=>$programSession->id,'status'=>'Active'

        ]);
        }else{
            $programSession=ProgramSession::where('pro_id','=',$req->pro_id)->where('session_id','=',$req->session_id)
            ->where('semester','=',$req->semester)->first();
            $user=TeahcerCourse::where('id', '=', $req->id)->update(
                array('teacher_id'=>$req->teacher_id,'course_id'=>$req->course_id,'program_session_id'=>$programSession->id,
                'status'=>'Active'
            ));
        }
        return response()->json(['Success' => "Assign Successfully"], 200);
    }
    public function getTeacherCourse($pro_id,$session_id)
    {
        if($pro_id==0)
        {
       return TeahcerCourse::join('teachers','teachers.id','=','teahcer_courses.teacher_id')
       ->join('program_sessions','program_sessions.id','=','teahcer_courses.program_session_id')
       ->join('sessions','sessions.id','=','program_sessions.session_id')
       ->join('programs','programs.id','=','program_sessions.pro_id')
       ->join('departments','programs.dep_id','=','departments.id')
          ->join('courses','courses.id','=','teahcer_courses.course_id')
        ->select('teahcer_courses.id','teachers.first_name','teachers.last_name','courses.id as course_id','teachers.id as teacher_id'
       , 'program_name','session','sessions.id as session_id','semester','course_title','course_code','teahcer_courses.status'
       ,'programs.id as pro_id','programs.dep_id as dep_id','departments.faculty_id as fac_id'

        )
       ->orderby('id','DESC')
       ->paginate(15);
        }
        else{
           return TeahcerCourse::join('program_sessions','program_sessions.id','=','teahcer_courses.program_session_id')
           ->where('pro_id','=',$pro_id)
           ->where('session_id','=',$session_id)
           ->join('teachers','teachers.id','=','teahcer_courses.teacher_id')
           ->join('sessions','sessions.id','=','program_sessions.session_id')
          ->join('programs','programs.id','=','program_sessions.pro_id')
       ->join('departments','programs.dep_id','=','departments.id')
          ->join('courses','courses.id','=','teahcer_courses.course_id')
        ->select('teahcer_courses.id','teachers.first_name','teachers.last_name','courses.id as course_id','teachers.id as teacher_id'
       , 'program_name','session','sessions.id as session_id','semester','course_title','course_code','teahcer_courses.status'
       ,'programs.id as pro_id','programs.dep_id as dep_id','departments.faculty_id as fac_id'

        )
       ->orderby('id','DESC')
       ->paginate(15);
            
        }
    }
}
