<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Questionnaire;


class QuestionnaireController extends Controller
{
    public function getQuestionnaire($type)
    {
        return Questionnaire::where('type','=',$type)->orderby('id','ASC')->get();
    }
    public function addQuestionnaire(Request $req)
    {  
        if($req->is_deleted==true)
        {
            Questionnaire::find($req->id)->delete();
            return response()->json(['Success' => "Questionnaire Delete Successfully"], 200);
        }
        if($req->id!=0)
        {
            Questionnaire::where('id','=',$req->id)->update(['questionnaire'=>$req->questionnaire,'type'=>$req->type,'status'=>$req->status]);
     
            return response()->json(['Success' => "Questionnaire Edit Successfully"], 200);
        }else{
            Questionnaire::create(['questionnaire'=>$req->questionnaire,'type'=>$req->type,'status'=>$req->status]);
            return response()->json(['Success' => "Questionnaire Added Successfully"], 200);
        }
    }
}
