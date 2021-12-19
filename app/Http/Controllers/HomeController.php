<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = DB::select(DB::raw('select count(*) as total_asset, typename from assets group by typename'));
        $chardata = "";
        if(count($data)>0){
        foreach ($data as $item) {
            $chardata .= "['$item->typename',$item->total_asset],";
                }
            $chardatapie = rtrim($chardata, ',');
        }
        else{
            $chardatapie="";
        }


        $active = DB::select(DB::raw('SELECT count(*) as active FROM `assets` WHERE status=1'));
        $inactive = DB::select(DB::raw('SELECT count(*) as inactive FROM `assets` WHERE status=0'));


        return view('newdashboard',['chardatapie' => $chardatapie,'active' => $active[0]->active ,'inactive'=>$inactive[0]->inactive]);
    }
}
