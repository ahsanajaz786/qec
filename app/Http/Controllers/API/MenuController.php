<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Menu;
use App\SubMenu;
use DB;
use App\Faculty;
use App\Department;
use App\Session;
use App\Program;
class MenuController extends Controller
{
    public function getMenu()
    {
        return Menu::with('SubMenu')->get();
        
    }

    public function getDashbordData()
    {
        return response()->json(['F_count' =>Faculty::all()->count() ,'D_count'=>Department::all()->count(),
    'progrme'=>Program::all()->count(),'session'=>Session::all()->count()
    ], 200);
    }
}
