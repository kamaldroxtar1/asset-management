@extends('dashboard')
@section('kamal')
<div class="container text-center">
    <h1>Assets</h1>
    <hr>

     <!-- for downloading csv file. -->
    <span data-href="/tasks" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">Download All assets</span>
    <script>
      function exportTasks(_this) {
          let _url = $(_this).data('href');
          window.location.href = _url;
      }
    </script>
    <br>
    <br>
    <!-- /closing for download -->
    <table class="table ">
      <thead>
        <tr>
          <th>Name</th>
          <th>Asset Type</th>
          <th>Asset code</th>
          <th>Images</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $asset)
        <tr>
          <td>{{$asset->assetname}}</td>
          <td>{{$asset->typename}}</td>
          <td>{{$asset->uuid}}</td>
          <td>{{$asset->asset_image}}</td>
          <?php
          if($asset->status==1){
            $new="Active";
          }
          else{
            $new="Inactive";
          }
          ?>
          <td>{{$new}}</td>
          <td><a href="edit/{{$asset->id}}" class="btn btn-info">Update</a>
              <a href="delete/{{$asset->id}}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    
    </table>
    
</div>
@endsection