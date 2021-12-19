<?php

namespace App\Http\Controllers;

use App\Models\assets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    

    public function Piechart()
    {
        $data = DB::select(DB::raw('select count(*) as total_asset, typename from assets group by typename'));
        $chardata = "";
        foreach ($data as $item) {
            $chardata .= "['$item->typename',$item->total_asset],";
        }
        $chardatapie = rtrim($chardata, ',');
        return view('pages.piechart', ['chardatapie' => $chardatapie]);
    }

    public function BarChart()
    {
        $active = DB::select(DB::raw('SELECT count(*) as active FROM `assets` WHERE status=1'));
        $inactive = DB::select(DB::raw('SELECT count(*) as inactive FROM `assets` WHERE status=0'));
        // return response($active[0]->active);
        return view('pages.barchart', ['active' => $active[0]->active ,'inactive'=>$inactive[0]->inactive]);
    }

    public function DownloadAssets()
    {
        $fileName = 'assets.csv';
        $AssetModel=new assets();
        $assets = $AssetModel::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Name', 'Asset types', 'Asset code', 'Status');

        $callback = function () use ($assets, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($assets as $asset) {
                $row['Name']  = $asset->assetname;
                $row['Asset types']    = $asset->typename;
                $row['Asset code']    = $asset->uuid;
                $row['Status']  = $asset->status;
                fputcsv($file, array($row['Name'], $row['Asset types'], $row['Asset code'], $row['Status']));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    

}
