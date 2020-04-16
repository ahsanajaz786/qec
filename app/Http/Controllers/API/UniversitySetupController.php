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

class UniversitySetupController extends Controller
{
 
     function getFaculties()
    {
        return Faculty::all();
    }

    function addfaculty(Request $req)
    {
        if($req->is_deleted==true)
        {
            Faculty::find($req->id)->delete();
            return response()->json(['Success' => "Faculty Deleted Successfully"], 200);

        }
        $validator = Validator::make($req->json()->all(), [
            'faculty_name' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
       
       else if($req->id==0)
        {
            $input = array('faculty_name' => $req->faculty_name,'uni_id'=>'1' );
            Faculty::create( $input);
            return response()->json(['Success' => "Faculty Saved Successfully"], 200);
      
          

        }else{
            Faculty::where('id', '=', $req->id)->update(array('faculty_name' =>  $req->faculty_name));
            return response()->json(['Success' => "Faculty Edit Successfully"], 200);
        }
    }
    public function getDepartments()
    {
      return Department::join('faculties','faculties.id','=','departments.faculty_id')
      ->select('departments.id','departments.department_name','faculties.faculty_name','faculties.id as faculty_id')->get();
    }
    public function addDepartment(Request $req)
    
    {
        if($req->is_deleted==true)
        {
            Department::find($req->id)->delete();
            return response()->json(['Success' => "Department Deleted Successfully"], 200);


        }
        $validator = Validator::make($req->json()->all(), [
            'department_name' => 'required',
            'faculty_id'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        else if($req->id==0)
        {
         
            Department::create($req->json()->all());
            return response()->json(['Success' => "Department Saved Successfully"], 200);

        }else{
            Department::where('id', '=', $req->id)->update($req->json()->all());
            return response()->json(['Success' => "Department Edit Successfully"], 200);
           
        }
    }
    function getSessions()
    {
        return Session::all();
    }

    function addSession(Request $req)
    {
        if($req->is_deleted==true)
        {
            Session::find($req->id)->delete();
            return response()->json(['Success' => "Session Deleted Successfully"], 200);


        }
        $validator = Validator::make($req->json()->all(), [
            'session' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
       
       else if($req->id==0)
        {
            $input = array('session' => $req->session,'uni_id'=>'1' );
            Session::create( $input);
            return response()->json(['Success' => "Session Saved Successfully"], 200);
      
          

        }else{
            
            Session::where('id', '=', $req->id)->update(['session'=>$req->session]);
            return response()->json(['Success' => "Department Edit Successfully"], 200);
        }
    }
    function getPrograms()
    {
        return Program::join('departments','departments.id','=','programs.dep_id')
        ->join('faculties','faculties.id','=','departments.faculty_id')
        ->select('programs.id','programs.program_name','departments.department_name'
        ,'faculties.faculty_name','faculties.id as faculty_id',
        'departments.id as dep_id')->get();
      
    }

    function addProgram(Request $req)
    {
        if($req->is_deleted==true)
        {
            Program::find($req->id)->delete();
            return response()->json(['Success' => "Program Deleted Successfully"], 200);


        }
        $validator = Validator::make($req->json()->all(), [
            'program_name' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
       
         if($req->id==0)
        {
            $input = array('program_name' => $req->program_name,'uni_id'=>'1' ,'dep_id'=>$req->dep_id);
            Program::create( $input);
            return response()->json(['Success' => "Program Saved Successfully"], 200);
      
          

        }else{
            Program::where('id', '=', $req->id)->update(['program_name' => $req->program_name,'uni_id'=>'1' ,'dep_id'=>$req->dep_id]);
            
            return response()->json(['Success' => "Program Edit Successfully"], 200);
        }
    }
    public function getDepartmentByID(Request $req)
    {
      
        return Department::where('faculty_id','=',$req->faculty_id)->get();

    }
    function getCourses()
    {
        return Course::paginate(15);
      
    }

    function addCourse(Request $req)
    {
        if($req->is_deleted==true)
        {
            Course::find($req->id)->delete();
            return response()->json(['Success' => "Session Deleted Successfully"], 200);


        }
        $validator = Validator::make($req->json()->all(), [
            'course_title' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
       else if($req->id==0)
        {
            $input = array('uni_id'=>'1' ,'course_title' => $req->course_title
            ,'course_code'=>$req->course_code,'credit_hr'=>$req->credit_hr
            ,'dep_id'=>$req->dep_id);
            Course::create( $input);
            return response()->json(['Success' => "Course Saved Successfully"], 200);
      
          

        }else{
            Course::where('id', '=', $req->id)->update(['course_title' => $req->course_title
            ,'course_code'=>$req->course_code,'credit_hr'=>$req->credit_hr]);
            return response()->json(['Success' => "Course Edit Successfully"], 200);
        }
    }
    public function getProgramByID(Request $req)
    {
      
        return Program::where('dep_id','=',$req->dep_id)->get();


    }
    
  
}
