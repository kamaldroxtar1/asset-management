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
        foreach ($data as $item) {
            $chardata .= "['$item->typename',$item->total_asset],";
        }
        $chardatapie = rtrim($chardata, ',');
        // return view('pages.piechart', ['chardatapie' => $chardatapie]);

        $data = DB::select(DB::raw('select count(*) as active, count(*) as inactive from assets group by status'));
        
    
        $inactive=(($data[0]->active));
        $active=($data[1]->active);
        
        // return view('pages.barchart', ['active' => $active ,'inactive'=>$inactive]);
        return view('newdashboard',['chardatapie' => $chardatapie,'active' => $active ,'inactive'=>$inactive]);
    }
}
