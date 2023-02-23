@extends('layouts.dash')
@section('title', 'Invoice')  

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            @can('invoice-add')
              <h3 class="card-title"><a href="{{route('invoice-add')}} " type="button" class="btn btn-block btn-info">Add Invoice</a></h3>
            @endcan
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Invoice No.</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @if(!empty($invoiceLists))
                <?php $count = 1?>
                  @foreach ($invoiceLists as $key => $invoice)
                  <?php 
                    $encyId = App\Http\Controllers\Controller::cryptString($invoice->id, 'e'); 
                  ?>
                  <tr>
                    <td>{{$count++}}</td>
                    <td>{{$invoice->custemers->name}}</td>
                    <td>{{$invoice->invoice_no}}</td>
                    <td>{{$invoice->invoice_date}}</td>
                    <td>
                      <a href="{{ route('invoice-download', ['id' => $invoice->id]) }}" target="_blank" class="btn btn-sm"><i class="fas fa-save"></i>Download</a>|
                      <a href="{{ route('invoice-view', ['id' => $invoice->id]) }}" target="_blank" class="btn btn-sm"><i class="fas fa-barcode"></i>View</a>|
                      @if(Gate::check('invoice-edit') || Gate::check('invoice-delete'))
                        @can('invoice-edit')
                          <a href="{{ route('invoice-edit', ['id' => $encyId]) }}" class="btn btn-sm"><i class="fas fa-edit"></i>Edit</a>|
                        @endcan
                        @can('invoice-delete')
                          <a href="{{ url('/dashboard/'.$invoice->id.'/invoice_lists')}}" onclick="return confirm('Are you sure?')" class="btn btn-sm"><i class="fas fa-trash"></i>Delete</a>
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