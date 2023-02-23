@extends('layouts.dash')
@section('title', 'Users-add')  

@section('content')
<?php use App\Http\Controllers\Controller; 
    $reqLabel = '<sup class="text-danger">*</sup>'; 
    $prevRoleId = !empty($user->roles[0]) ? $user->roles[0]->id : NULL;
    $prevSchoolId = !empty($user->schools[0]) ? $user->schools[0]->id : NULL;
?> 

<form role="form"  class="form-horizontal form-label-left" action="{{ route('user-edit', ['id' => isset($user->id) ? Controller::cryptString($user->id, 'e') : '']) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <h3 class="card-title"><a href="{{route('user')}} " type="button" class="btn btn-block btn-info">Back</a></h3>
    </div>
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">User Details</h2>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="">Name <?php echo $reqLabel; ?></label>
                <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ old('name', isset($user->name) ? $user->name : '' ) }}">
                @if ($errors->has('name'))
                    <span class="text-danger">
                        <small>{{ $errors->first('name') }}</small>
                    </span>
                @endif
            </div>
            <div class="form-group col-sm-3">
                <label for="">Email <?php echo $reqLabel; ?></label>
                <input type="text" class="form-control" placeholder="Enter email" name="email" value="{{ old('email', isset($user->email) ? $user->email : '' ) }}">
                @if ($errors->has('email'))
                    <span class="text-danger">
                        <small>{{ $errors->first('email') }}</small>
                    </span>
                @endif
            </div>
            <div class="form-group col-sm-3">
                <label for="">Role <?php echo $reqLabel; ?></label>
                <select name="role_id" id="" class="form-control">
                    <option value="">Select role</option>
                    @foreach($roles as $id => $name)
                        <option value="{{ $id }}" @if(old('role_id', $prevRoleId) == $id) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('role_id'))
                    <span class="text-danger" role="alert">
                        <small>{{ $errors->first('role_id') }}</small>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="">Password <?php echo $reqLabel; ?></label>
                <input type="password" class="form-control" placeholder="Enternew password" name="password" value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <span class="text-danger">
                        <small>{{ $errors->first('password') }}</small>
                    </span>
                @endif
            </div>
            <div class="form-group col-sm-3">
                <label for="">Confirm New Password <?php echo $reqLabel; ?></label>
                <input type="password" class="form-control" placeholder="Enter confirm password" name="confirm_password" value="{{ old('confirm_password') }}">
                @if ($errors->has('confirm_password'))
                    <span class="text-danger">
                        <small>{{ $errors->first('confirm_password') }}</small>
                    </span>
                @endif
            </div>
        </div>
        <div class="row clearfix">    
            <button type="submit" class="btn btn-info mr-2">Submit</button>
            <button class="btn btn-light" type="reset">Reset</button>
        </div>
    </div>
</form>
@endsection
