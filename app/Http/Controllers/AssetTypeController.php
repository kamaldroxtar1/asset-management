<?php

namespace App\Http\Controllers;
use App\Models\assets;
use App\Models\assettype;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    public function AddAssetTypeForm()
    {
        return view('pages.AddTypes');
    }


    public function ShowAsssetsType()
    {
        $ShowTypeModel = new assettype();
        $AssetTypes = $ShowTypeModel::all();
        return view('pages.ShowTypes', ['AssetTypes' => $AssetTypes]);
    }
    
    
    public function InsertAssetType(Request $request)
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

            $TypeModel = new assettype();
            $TypeModel->assettype = $type;
            $TypeModel->description = $description;
            if ($TypeModel->save()) {
                return back()->with('success', 'Asset type added successfully');
            } else {
                return back()->with('error', 'Asset type not added ');
            }
        }
    }

    
    public function DeleteAssetType($id)
    {

        $AssetModel = new assets();
        $Assets = $AssetModel::where('typeid', '=', $id)->get();
        foreach ($Assets as $asset) {
            $asset->delete();
        }

        $AssetTypeModel = new assettype();
        $AssetTypesDelete = $AssetTypeModel::find($id);
        $AssetTypesDelete->delete();


        return back();
    }
    
    public function EditAssetType($id){
        $AssetTypeModel=new assettype();
        $AssetTypeData=$AssetTypeModel::find($id);
        return view('pages.EditType',['AssetTypeData'=>$AssetTypeData]);
    }


    public function UpdateAssetType(Request $request,$id)
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

            $TypeModel =assettype::find($id);
            $TypeModel->assettype = $type;
            $TypeModel->description = $description;
            if ($TypeModel->save()) {
                return redirect('/showTypes')->with('success','updated successfully');
            } else {
                return back()->with('error', 'Asset type not updated ');
            }
        }
    }
}
