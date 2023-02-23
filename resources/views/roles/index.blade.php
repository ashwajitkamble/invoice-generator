@extends('layouts.dash')
@section('title', 'Roles')  

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            @if(Gate::check('role-add'))
                <h3 class="card-title"><a href="{{route('role-add')}} " type="button" class="btn btn-block btn-info">Add Roles</a></h3>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
                <table id="example3" class="display table table-bordered table-hover" style="min-width: 845px">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            @if(Gate::check('role-edit') || Gate::check('role-delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($allroles) && count($allroles) > 0)
                            <?php  $count = $allroles->firstItem(); ?>
                            @foreach($allroles as $id => $role)
                                @php $encyId = App\Http\Controllers\Controller::cryptString($role->id, 'e') @endphp
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $role->name }}</td>
                                    @if(Gate::check('role-edit') || Gate::check('role-delete'))
                                        <td>
                                            <div class="btn-group">
                                                @can('role-edit')
                                                    <a href="{{ route('role-edit', ['id' => $encyId]) }}" class="btn btn-sm "><i class="fas fa-edit"></i>edit</a>|
                                                @endcan
                                                @can('role-delete') 
                                                    <a href="{{ url('/dashboard/'.$role->id.'/roles')}}" class="btn btn-sm " onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>delete</a>
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
