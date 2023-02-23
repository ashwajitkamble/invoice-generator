@extends('layouts.dash')
@section('title', 'Profile')  

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            @if(Gate::check('user-add'))
                <h3 class="card-title"> Profile Information</h3>
            @endif
            </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p>Name:- <span>{{$users->name}}</span></p>
            <p>Email:- <span>{{$users->email}}</span></p>
            <p>Role:- <span>{{$role->name}}</span></p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
