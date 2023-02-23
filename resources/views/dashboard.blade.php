@extends('layouts.dash')
@section('title', 'Dashboard')  

@section('content')

    <?php
    $count1 = 0;
    $count2 = 0;
    $Estmate = App\Models\estimate::where('status', 1)->get();
    $Invoice = App\Models\InvoiceList::where('status', 1)->get();
       foreach ($Estmate as $key => $value) {
        $count1++;
       } 
       foreach ($Invoice as $key => $value) {
        $count2++;
       } 
    ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$count2}}</h3>
              <p>Invoices</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('invoice')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$count1}}</h3>
              <p>Estimates</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('estimate')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
@endsection