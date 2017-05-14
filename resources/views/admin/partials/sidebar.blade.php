<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ Gravatar::src(Auth::user()->email) }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">HEADER</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Home</span></a></li>
      <li class="treeview">
      <a href="#"><i class="fa fa-user-secret"></i> <span>RBAC</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ route('roles.index') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
        <li><a href="{{ route('permissions.index') }}"><i class="fa fa-circle-o"></i>Permissions</a></li>
      </ul>
      </li>
      <li><a href="#"><i class="fa fa-users"></i> <span>Users</span></a></li>
      <li><a href="#"><i class="fa fa-list"></i> <span>Posts</span></a></li>
      <li><a href="#"><i class="fa fa-tag"></i> <span>Tags</span></a></li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>