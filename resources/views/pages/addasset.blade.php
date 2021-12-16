@extends('dashboard')
@section('kamal')
<div class="container text-center">
    <h1 class="">Add Assets</h1>
    <hr>
        @if(Session::has('success'))
        <div class="alert alert-success">
        {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
        {{Session::get('error')}}
        </div>
        @endif
        <form class="container bg-light col-md-6" method="post" action="/addasset_insert" enctype="multipart/form-data">
            @csrf
             <div class="form-group ">
                <label>Asset Name</label>
                @error('asset_name')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <input type="text" class="form-control " name="asset_name" placeholder="Asset name" >
             </div>
             <div class="form-group">
                <label>Asset code(uuid)</label>
                @error('uuid')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <input type="text" class="form-control "  name="uuid" placeholder="Asset code" value="{{$uuid}}">
             </div>

             <div class="form-group">
                <label>Asset Type</label>
                @error('assettypes')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <select class="form-control " name="assettypes" placeholder="Asset Type" >
                @foreach($assettype as $asset)
                    <option value="{{$asset->id}}">{{$asset->assettype}}</option>
                    
                 @endforeach
                </select>
             </div>

             <div class="form-group">
                <label>Asset Image</label>
                @error('asset_image')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <input type="file" class="form-control" name="asset_image">
             </div>

             <div class="form-group">
                <label>Status</label>
                @error('status')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <div class="form-control col-md-4 m-auto">
                    Active
                    <input type="radio"  name="status" value="1">
                    Inactive
                    <input type="radio"  name="status" value="0">
                </div>
                
             </div>
             <input type="submit" value="submit" class="btn btn-success">
        </form>
        
</div>
@endsection