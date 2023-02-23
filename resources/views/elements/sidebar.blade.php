<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <span class="d-block text-light" >{{ !empty(Auth::user()->roles[0]['name']) ? Auth::user()->roles[0]['name'] : '' }}</span>
        </div>
      </div> 

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> --}}
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Dashboard
              </p>
            </a>
          </li>
          {{-- profile --}}
          {{-- @php 
              $userParentList  = '';
              $userChildList    = '';
              $UserArr = ['profile', 'profile-add', 'profile-edit'];
              if(in_array(Route::currentRouteName(), $UserArr)){
                  $userParentList  = 'active';
                  $userChildList    = 'show';
              }
          @endphp
          @if(Gate::check('profile'))
            <li class="nav-item">
            <a href="{{route('profile')}}" class="nav-link {{$userParentList}}{{$userChildList}}">
              @can('profile')
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                Profile Info
                </p>
              @endcan
              </a>
            </li>
          @endif --}}
          {{-- users --}}
          @php 
              $userParentList  = '';
              $userChildList    = '';
              $UserArr = ['user', 'user-add', 'user-edit'];
              if(in_array(Route::currentRouteName(), $UserArr)){
                  $userParentList  = 'active';
                  $userChildList    = 'show';
              }
          @endphp
          @if(Gate::check('user'))
            <li class="nav-item">
              <a href="{{route('user')}}" class="nav-link {{ $userParentList }}{{ $userChildList }}">
                @can('user')
                <i class='nav-icon fa fa-users'></i><p>Users</p></p>
                @endcan
              </a>
            </li>
          @endif
          {{-- users- end --}}
          {{-- Roles and permisssion --}}
          @php 
              $roleParentList  = '';
              $roleChildList    = '';
              $roleArr = ['role', 'role-add', 'role-edit'];
              if(in_array(Route::currentRouteName(), $roleArr)){
                  $roleParentList  = 'active';
                  $roleChildList    = 'show';
              }
          @endphp
          @if(Gate::check('role'))
            <li class="nav-item">
              <a href="{{route('role')}}" class="nav-link{{$roleParentList}}{{$roleChildList}}">
                @can('role')
                  <p><i class="nav-icon fas fa-th"></i>Roles & Permissions</p>
                @endcan
              </a>
            </li>
          @endif
          {{-- end roles and permission --}}
          {{-- seller --}}
          @php 
              $roleParentList  = '';
              $roleChildList    = '';
              $roleArr = ['seller', 'seller-add', 'seller-edit'];
              if(in_array(Route::currentRouteName(), $roleArr)){
                  $roleParentList  = 'active';
                  $roleChildList    = 'show';
              }
          @endphp
          @if(Gate::check('seller'))
          <li class="nav-item">
            <a href="{{route('seller')}}" class="nav-link">
              @can('seller')
                <p><i class="nav-icon fas fa-tachometer-alt"></i>Company Info</p>
              @endcan
            </a>
          </li>
          @endif
          {{-- end-seller --}}
          {{-- invoices --}}
          @php 
              $invoiceParentList  = '';
              $invoiceChildList    = '';
              $invoiceArr = ['invoice', 'invoice-add', 'invoice-edit'];
              if(in_array(Route::currentRouteName(), $invoiceArr)){
                  $invoiceParentList  = 'active';
                  $invoiceChildList    = 'show';
              }
          @endphp
          @if(Gate::check('invoice'))
            <li class="nav-item">
              <a href="{{route('invoice')}}" class="nav-link {{$invoiceParentList}}{{$invoiceChildList}}">
                @can('invoice')
                  <p><i class="nav-icon fas fa-file-invoice-dollar"></i>Invoices</p>
                @endcan
              </a>
            </li>
          @endif
          {{-- end invoices --}}
          {{-- estimates --}}
          @php 
              $estimateParentList  = '';
              $estimateChildList    = '';
              $estimateArr = ['estimate', 'estimate-add', 'estimate-edit'];
              if(in_array(Route::currentRouteName(), $estimateArr)){
                  $estimateParentList  = 'active';
                  $estimateChildList    = 'show';
              }
          @endphp
          @if(Gate::check('estimate'))
            <li class="nav-item">
              <a href="{{route('estimate')}}" class="nav-link{{$estimateParentList}}{{$estimateChildList}}">
                @can('estimate')
                  <p><i class="nav-icon fas fa-file-invoice"></i>Estimates</p>
                @endcan
              </a>
            </li>
          @endif
          {{--  end estimates --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>