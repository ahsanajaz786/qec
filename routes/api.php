<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('getDepartments','API\UniversitySetupController@getDepartments');

Route::post('getProgramByID','API\UniversitySetupController@getProgramByID');
Route::group(['middleware' => 'auth:api'], function(){
Route::get("me",'API\UserController@me');
Route::GET('getStudent/{sessionId}/{pro_id}','API\StudentController@getStudent');
Route::post('details', 'API\UserController@details');
Route::get('getfaculties','API\UniversitySetupController@getFaculties');
Route::post('addfaculty','API\UniversitySetupController@addFaculty');
Route::post('addDepartment','API\UniversitySetupController@addDepartment');
Route::post('addfaculty','API\UniversitySetupController@addFaculty');
Route::get('getSessions','API\UniversitySetupController@getSessions');
Route::post('addSesssion','API\UniversitySetupController@addSession');
Route::get('getPrograms','API\UniversitySetupController@getPrograms');
Route::post('addProgram','API\UniversitySetupController@addProgram');
Route::post('getDepartmentByID','API\UniversitySetupController@getDepartmentByID');

Route::get('getCourses','API\UniversitySetupController@getCourses');
Route::post('addCource','API\UniversitySetupController@addCourse');
Route::post('getCourseByID','API\UniversitySetupController@getCourseByID');

Route::post('UpdateStudent','API\StudentController@UpdateStudent');

Route::post('RrgisterTeacher','API\TeacherController@Rrgister');
Route::get('getTeacher/{dep_id}','API\TeacherController@getTeacher');

Route::post('AssignCourseStudent','API\StudentCourseController@AssignCourseStudent');

Route::post('DeleteProgramCourse','API\StudentCourseController@DeleteProgramCourse');
Route::GET('getProgramCourse/{sessionId}/{pro_id}/{id}','API\StudentCourseController@getProgramCourse');
Route::GET('getStudentbyprogrm/{pro_id}/{sessionId}','API\StudentCourseController@getStudentbyprogrm');
Route::GET('getCourseByP_S_S/{pro_id}/{sessionId}/{semester}','API\StudentCourseController@getCourseByP_S_S');
Route::get('filterCourse/{q}','API\StudentCourseController@filterCourse');
Route::get('filterTeacher/{q}','API\StudentCourseController@filterTeacher');

Route::post('AssignTeacherCourse','API\TeahcerCourseController@AssignTeacherCourse');
Route::GET('getTeacherCourse/{pro_id}/{sessionId}','API\TeahcerCourseController@getTeacherCourse');


Route::Get("getMenu","API\MenuController@getMenu");


Route::Get("getQuestionnaire/{type}","API\QuestionnaireController@getQuestionnaire");

Route::post("addQuestionnaire","API\QuestionnaireController@addQuestionnaire");

Route::get('getProgramSession','API\StudentCourseController@getProgramSession');

Route::post('saveQecEvaluation','API\QecEvaluationController@saveQecEvaluation');

Route::get('GetQecEvaluation/{id}','API\QecEvaluationController@GetQecEvaluation');


Route::get('GetQecEvaluationProgramSession/{id}','API\QecEvaluationController@GetQecEvaluationProgramSession');


Route::get('getDashbordData','API\MenuController@getDashbordData');
});

