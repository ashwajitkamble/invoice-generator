@extends('layouts.dash')
@section('title', 'Estimate')  

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            @can('estimate-add')
              <h3 class="card-title"><a href="{{route('estimate-add')}} " type="button" class="btn btn-block btn-info">Add Estimate</a></h3>
            @endcan
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Estimate No.</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @if(!empty($estimates))
                <?php $count = 1?>
                  @foreach ($estimates as $key => $estimate)
                  <?php 
                    $encyId = App\Http\Controllers\Controller::cryptString($estimate->id, 'e'); 
                  ?>
                  <tr>
                    <td>{{$count++}}</td>
                    <td>{{$estimate->custemers->name}}</td>
                    <td>{{$estimate->estimate_no}}</td>
                    <td>{{$estimate->estimate_date}}</td>
                    <td>
                      <a href="{{ route('estimate-download', ['id' => $estimate->id]) }}" target="_blank"  class="btn btn-sm"><i class="fas fa-save"></i>Download</a>|
                      <a href="{{ route('estimate-view', ['id' => $estimate->id]) }}" target="_blank" class="btn btn-sm"><i class="fas fa-barcode"></i>View</a>|
                      @if(Gate::check('estimate-edit') || Gate::check('estimate-delete'))
                        @can('estimate-edit')
                          <a href="{{ route('estimate-edit', ['id' => $encyId]) }}" class="btn btn-sm"><i class="fas fa-edit"></i>Edit</a>|
                        @endcan
                        @can('estimate-delete')
                          <a href="{{ url('/dashboard/'.$estimate->id.'/estimates')}}" onclick="return confirm('Are you sure?')" class="btn btn-sm"><i class="fas fa-trash"></i>Delete</a>
                        @endcan
                      @endif
                    </td>
                  </tr>  
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection