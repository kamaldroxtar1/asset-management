@extends('dashboard')
@section('kamal')
<div class="container text-center">
    <h1>Asset Types</h1>
    <hr>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th >Name</th>
          <th >Description</th>
          <th >Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($assettypes as $types)
        <tr>
          <td >{{$types->assettype}}</td>
          <td >{{$types->description}}</td>
          <td>
            <a href="edittype/{{$types->id}}" class="btn btn-info">Update</a>
            <a href="deletetype/{{$types->id}}" onclick="return confirm('Are you sure? If you delete this asset type, all assets under this asset type will be deleted too!')" class="btn btn-danger">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    
    </table>
</div>
@endsection