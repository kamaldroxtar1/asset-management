@extends('dashboard')
@section('kamal')

<div class="container text-center">
    <h1 class="">Update Asset Types</h1>
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
        <form class="container bg-light col-md-6" method="post" action="/updatetype/{{$AssetTypeData->id}}">
            @csrf
             <div class="form-group ">
                <label>Type Name</label>
                @error('type')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <input type="text" class="form-control " name="type" value="{{$AssetTypeData->assettype}}" >
             </div>
             <div class="form-group">
                <label>Description</label>
                @error('description')
                <span class="text-danger">
                    {{$message}}
                </span>
                @enderror
                <textarea type="text" class="form-control" name="description" >{{$AssetTypeData->description}}</textarea>
                <small>Maximum 200 words allowed.</small>
             </div>
             <input type="submit" value="submit" class="btn btn-success">
        </form>
</div>
@endsection