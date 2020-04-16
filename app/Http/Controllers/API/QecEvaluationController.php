<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QecEvaluation;
use App\QecEvaluationProgramSession;


class QecEvaluationController extends Controller
{
    public function saveQecEvaluation(Request $req)
    {
        if($req->is_deleted==true)
        {
            QecEvaluationProgramSession::where('qec_evaluation_id','=',$req->id)->delete();
            QecEvaluation::find($req->id)->delete();
            return response()->json(['Success' => "QEC Delete Successfully"], 200);


        }
        if($req->id==0)
        {
            $qec=QecEvaluation::create(['title'=>$req->title,'startDate'=>$req->startDate,'endDate'=>$req->endDate,'status'=>$req->status]);
             foreach($req->programSession as $p)
             {
                QecEvaluationProgramSession::create(['qec_evaluation_id'=>$qec->id,'program_session_id'=>$p]);
             }
            return response()->json(['Success' => "QEC Open Successfully"], 200);
        }else{
            QecEvaluationProgramSession::where('qec_evaluation_id','=',$req->id)->delete();
            QecEvaluation::find($req->id)->update(['title'=>$req->title,'startDate'=>$req->startDate,'endDate'=>$req->endDate,'status'=>$req->status]);
            foreach($req->programSession as $p)
             {
                QecEvaluationProgramSession::create(['qec_evaluation_id'=>$req->id,'program_session_id'=>$p]);
             }

        }
    }
    public function GetQecEvaluationProgramSession($id)
    {
        return QecEvaluationProgramSession::where('qec_evaluation_id','=',$id)->get('program_session_id as id');
    }
    public function GetQecEvaluation($id)
    {
        if($id==0)
        return QecEvaluation::All();
        else{
            return QecEvaluationProgramSession::where('qec_evaluation_id','=',$id)
            ->join('program_sessions','program_sessions.id','=','qec_evaluation_program_sessions.program_session_id')
            ->join('sessions','program_sessions.session_id','=','sessions.id')
            ->join('programs','program_sessions.pro_id','=','programs.id')
            ->distinct()->get(['qec_evaluation_program_sessions.id as id','semester','sessions.session','programs.program_name']);
           
        }
    }
}
