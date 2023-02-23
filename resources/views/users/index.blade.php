@extends('layouts.dash')
@section('title', 'Users')  

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            @if(Gate::check('user-add'))
                <h3 class="card-title"><a href="{{route('user-add')}} " type="button" class="btn btn-block btn-info">Add Users</a></h3>
            @endif
            </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
                <table id="example3" class="display table table-bordered table-hover" style="min-width: 845px">
                    <thead>
                        <tr>
                            <th width="10%">Sr. No.</th>
                            <th>Name</th>
                            <th>Email/Login Id</th>
                            <th>Role</th>
                            @if(Gate::check('user-edit') || Gate::check('user-delete'))
                                <th width="10%">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($users) && count($users) > 0)
                            <?php  $count = $users->firstItem(); ?>
                            @foreach($users as $key => $user)
                                <?php 
                                    $roleName = '';
                                    $encyId = App\Http\Controllers\Controller::cryptString($user->id, 'e'); 
                                    if(!empty($user->roles) && count($user->roles) > 0){
                                        $roleName = $user->roles[0]->name;
                                    } 
                                ?>
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $roleName }}</td>
                                    @if(Gate::check('user-edit') || Gate::check('user-delete'))
                                        <td>
                                            <div class="btn-group">
                                                @can('user-edit')
                                                    <a href="{{ route('user-edit', ['id' => $encyId]) }}" class="btn btn-sm "><i class="fas fa-edit"></i>edit</a>|
                                                @endcan
                                                @can('user-delete')   
                                                    <a href="{{ url('/dashboard/'.$user->id.'/users')}}" class="btn btn-sm " onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>delete</a>
                                                @endcan
                                            </div>
                                        </td>
                                    @endif  
                                </tr> 
                            @endforeach
                        @endif  
                    </tbody> 
                </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
