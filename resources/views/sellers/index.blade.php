@extends('layouts.dash')
@section('title', 'Sellers')  

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            @can('seller-add')
              <h3 class="card-title"><a href="{{route('seller-add')}} " type="button" class="btn btn-block btn-info">Add Company Info</a></h3>
            @endcan
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Company</th>
                <th>PAN</th>
                <th>GST</th>
                <th>Bank</th>
                <th>Account Holder</th>
                <th>Account No.</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @if(!empty($seller))
                <?php $count = 1?>
                  @foreach ($seller as $key => $seller)
                  <?php 
                    $encyId = App\Http\Controllers\Controller::cryptString($seller->id, 'e'); 
                  ?>
                  <tr>
                    <td>{{$count++}}</td>
                    <td><img class="rounded-circle" width="35" src="{{asset('public/images/logo/'). '/' .$seller->image}}" alt="{{$seller->image}}"></td>
                    <td>{{$seller->name}}</td>
                    <td>{{$seller->pan}}</td>
                    <td>{{$seller->gst}}</td>
                    <td>{{$seller->bank_name}}</td>
                    <td>{{$seller->account_holder}}</td>
                    <td>{{$seller->bank_account}}</td>
                    <td>
                      @if(Gate::check('seller-edit') || Gate::check('seller-delete'))
                        @can('seller-edit')
                          <a href="{{ route('seller-edit', ['id' => $encyId]) }}" class="btn btn-sm"><i class="fas fa-edit"></i>Edit</a>|
                        @endcan
                        @can('seller-delete')
                          <a href="{{ url('/dashboard/'.$seller->id.'/sellers')}}" onclick="return confirm('Are you sure?')" class="btn btn-sm"><i class="fas fa-trash"></i>Delete</a>
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