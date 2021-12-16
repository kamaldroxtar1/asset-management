<?php

namespace App\Http\Controllers;

use App\Models\assets;
use App\Models\assettype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class my_controller extends Controller
{
    public function show()
    {
        return view('pages.addtypes');
    }
    public function show_types()
    {
        $showmodeltype = new assettype();
        $assetstypes = $showmodeltype::all();
        return view('pages.showtypes', ['assettypes' => $assetstypes]);
    }
    public function show2()
    {
        $uuid = random_int(100000, 999999) . random_int(100000, 999999) . random_int(1000, 9999);
        $assettypemodel = new assettype();
        $assettype = $assettypemodel::all();
        return view('pages.addasset', ['uuid' => $uuid, 'assettype' => $assettype]);
    }
    public function show_assets()
    {
        $modelassets = new assets();
        $data = $modelassets::all();
        return view('pages.showassets', ['data' => $data]);
    }
    public function insert_type(Request $request)
    {
        $validated = $request->validate(
            [
                'type' => 'required',
                'description' => 'required|max:200'
            ],
            [
                'type.required' => 'Asset type is required',
                'description.required' => 'Description is required',
                'description.max' => 'maximum words allowed is 200.'
            ]
        );
        if ($validated) {
            $type = $request->type;
            $description = $request->description;

            $typemodel = new assettype();
            $typemodel->assettype = $type;
            $typemodel->description = $description;
            if ($typemodel->save()) {
                return back()->with('success', 'Asset type added successfully');
            } else {
                return back()->with('error', 'Asset type not added ');
            }
        }
    }
    public function insert_asset(Request $request)
    {
        $validated = $request->validate(
            [
                'asset_name' => 'required',
                'assettypes' => 'required',
                'asset_image' => 'mimes:jpg,png',
                'assettypes' => 'required',
                'status' => 'required',
                'uuid' => 'required'
            ],
            [
                'asset_name.required' => 'Asset name is required',
                'assettypes.required' => 'Choose asset type from the dropdown only',
                'asset_image.mimes' => 'only jpg and png formats are allowed',
                'status.required' => 'status is required',
                'assettypes.required' => 'asset type is not in the database',
                'uuid.required' => 'uuid is required'
            ]
        );
        if ($validated) {
            $name = $request->asset_name;
            $uuid = $request->uuid;
            $assettypes = $request->assettypes;
            $status = $request->status;

            $dataname = new assettype();
            $dataname1 = $dataname::find($assettypes);
            $typename = $dataname1->assettype;

            $addassetmodel = new assets();
            $addassetmodel->assetname = $name;
            $addassetmodel->typeid = $assettypes;
            $addassetmodel->typename = $typename;
            $addassetmodel->uuid = $uuid;
            // $addassetmodel->asset_image=$;
            $addassetmodel->status = $status;
            if ($addassetmodel->save()) {
                return back()->with('success', 'Asset added successfully');
            } else {
                return back()->with('error', 'Asset not added');
            }
        }
    }
    public function delete_asset($id)
    {
        $data = new assets();
        $datatodelete = $data::find($id);
        $datatodelete->delete();
        return back();
    }

    public function delete_type($id)
    {

        $datanew = new assets();
        $abc = $datanew::where('typeid', '=', $id)->get();
        foreach ($abc as $a) {
            $a->delete();
        }

        $data = new assettype();
        $datatodelete = $data::find($id);
        $datatodelete->delete();


        return back();
    }

    public function pie_chart()
    {
        $data = DB::select(DB::raw('select count(*) as total_asset, typename from assets group by typename'));
        $chardata = "";
        foreach ($data as $item) {
            $chardata .= "['$item->typename',$item->total_asset],";
        }
        $chardatapie = rtrim($chardata, ',');
        return view('pages.piechart', ['chardatapie' => $chardatapie]);
    }

    public function bar_chart()
    {
        $data = DB::select(DB::raw('select count(*) as active, count(*) as inactive from assets group by status'));
        
    
        $inactive=(($data[0]->active));
        $active=($data[1]->active);
        
        return view('pages.barchart', ['active' => $active ,'inactive'=>$inactive]);
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'assets.csv';
        $modelass=new assets();
        $assets = $modelass::all();

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

            foreach ($assets as $task) {
                $row['Name']  = $task->assetname;
                $row['Asset types']    = $task->typename;
                $row['Asset code']    = $task->uuid;
                $row['Status']  = $task->status;
                fputcsv($file, array($row['Name'], $row['Asset types'], $row['Asset code'], $row['Status']));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function edit($id){
        $data=new assets();
        $dataasset=$data::find($id);
        $assettypemodel = new assettype();
        $assettype = $assettypemodel::all();
        $dataname = new assettype();
            $dataname1 = $dataname::all();

        return view('pages.editasset',['dataasset'=>$dataasset,'dataname1'=>$dataname1]);
    }

    public function edittype($id){
        $data=new assettype();
        $dataasset=$data::find($id);
        return view('pages.edittype',['dataasset'=>$dataasset]);
    }

    public function update_asset(Request $request,$id)
    {
        $validated = $request->validate(
            [
                'asset_name' => 'required',
                'assettypes' => 'required',
                'asset_image' => 'mimes:jpg,png',
                'assettypes' => 'required',
                'status' => 'required',
                'uuid' => 'required'
            ],
            [
                'asset_name.required' => 'Asset name is required',
                'assettypes.required' => 'Choose asset type from the dropdown only',
                'asset_image.mimes' => 'only jpg and png formats are allowed',
                'status.required' => 'status is required',
                'assettypes.required' => 'asset type is not in the database',
                'uuid.required' => 'uuid is required'
            ]
        );
        if ($validated) {
            $name = $request->asset_name;
            $uuid = $request->uuid;
            $assettypes = $request->assettypes;
            $status = $request->status;

            $dataname = new assettype();
            $dataname1 = $dataname::find($assettypes);
            $typename = $dataname1->assettype;

            $addassetmodel =assets::find($id);
            $addassetmodel->assetname = $name;
            $addassetmodel->typeid = $assettypes;
            $addassetmodel->typename = $typename;
            $addassetmodel->uuid = $uuid;
            // $addassetmodel->asset_image=$;
            $addassetmodel->status = $status;
            if ($addassetmodel->save()) {
                return redirect('/showassets')->with('success','updated successfully');
            } else {
                return back()->with('error', 'Asset not updated');
            }
        }
    }

    public function update_type(Request $request,$id)
    {
        $validated = $request->validate(
            [
                'type' => 'required',
                'description' => 'required|max:200'
            ],
            [
                'type.required' => 'Asset type is required',
                'description.required' => 'Description is required',
                'description.max' => 'maximum words allowed is 200.'
            ]
        );
        if ($validated) {
            $type = $request->type;
            $description = $request->description;

            $typemodel =assettype::find($id);
            $typemodel->assettype = $type;
            $typemodel->description = $description;
            if ($typemodel->save()) {
                return redirect('/showtypes')->with('success','updated successfully');
            } else {
                return back()->with('error', 'Asset type not updated ');
            }
        }
    }
}
