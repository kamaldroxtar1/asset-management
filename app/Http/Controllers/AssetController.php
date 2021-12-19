<?php

namespace App\Http\Controllers;
use App\Models\assets;
use App\Models\assettype;
use Illuminate\Http\Request;

class AssetController extends Controller
{

    public function AddAssetForm()
    {
        $uuid = random_int(100000, 999999) . random_int(100000, 999999) . random_int(1000, 9999);
        $AssetTypeModal = new assettype();
        $AssetType = $AssetTypeModal::all();
        return view('pages.AddAsset', ['uuid' => $uuid, 'AssetType' => $AssetType]);
    }


    public function ShowAssets()
    {
        $AssetModel = new assets();
        $data = $AssetModel::all();
        return view('pages.showassets', ['data' => $data]);
    }

    public function InsertAsset(Request $request)
    {
        $validated = $request->validate(
            [
                'asset_name' => 'required',
                'assettype' => 'required',
                'status' => 'required',
                'uuid' => 'required',
            ],
            [
                'asset_name.required' => 'Asset name is required',
                'status.required' => 'status is required',
                'assettype.required' => 'asset type is not in the database',
                'uuid.required' => 'uuid required'
            ]
        );
        if ($validated) {
            $name = $request->asset_name;
            $uuid = $request->uuid;
            $AssetTypes = $request->assettype;
            $status = $request->status;

            $dataname = new assettype();
            $dataname1 = $dataname::find($AssetTypes);
            $typename = $dataname1->assettype;

            $AddAssetModel = new assets();
            $AddAssetModel->assetname = $name;
            $AddAssetModel->typeid = $AssetTypes;
            $AddAssetModel->typename = $typename;
            $AddAssetModel->uuid = $uuid;
            $AddAssetModel->status = $status;
            if ($AddAssetModel->save()) {
                return back()->with('success', 'Asset added successfully');
            } else {
                return back()->with('error', 'Asset not added');
            }
        }
    }


    public function DeleteAsset($id)
    {
        $data = new assets();
        $datatodelete = $data::find($id);
        $datatodelete->delete();
        return back();
    }


    public function EditAsset($id)
    {
        $data=new assets();
        $dataasset=$data::find($id);
        $AssetTypeModal = new assettype();
        $assettype = $AssetTypeModal::all();
        $dataname = new assettype();
            $dataname1 = $dataname::all();

        return view('pages.editasset',['dataasset'=>$dataasset,'dataname1'=>$dataname1]);
    }


    public function UpdateAsset(Request $request,$id)
    {
        $validated = $request->validate(
            [
                'asset_name' => 'required',
                'asset_image' => 'mimes:jpg,png',
                'assettype' => 'required',
                'status' => 'required',
                'uuid' => 'required'
            ],
            [
                'asset_name.required' => 'Asset name is required',
                'asset_image.mimes' => 'only jpg and png formats are allowed',
                'status.required' => 'status is required',
                'assettype.required' => 'Choose asset type from the dropdown only',
                'uuid.required' => 'uuid is required'
            ]
        );
        if ($validated) {
            $name = $request->asset_name;
            $uuid = $request->uuid;
            $AssetTypes = $request->assettype;
            $status = $request->status;

            $dataname = new assettype();
            $dataname1 = $dataname::find($AssetTypes);
            $typename = $dataname1->assettype;

            $AddAssetModel =assets::find($id);
            $AddAssetModel->assetname = $name;
            $AddAssetModel->typeid = $AssetTypes;
            $AddAssetModel->typename = $typename;
            $AddAssetModel->uuid = $uuid;
            // $AddAssetModel->asset_image=$;
            $AddAssetModel->status = $status;
            if ($AddAssetModel->save()) {
                return redirect("showAssets")->with('success','updated successfully');
            } else {
                return back()->with('error', 'Asset not updated');
            }
        }
    }

}
