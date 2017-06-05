<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ config('app.locale') }}">

@include('admin.partials.html-header')

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini" id="app" v-cloak>
<div class="wrapper">

  @include('admin.partials.header')

  @include('admin.partials.sidebar')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    @include('admin.partials.content-header')

    <!-- Main content -->
    <section class="content">

      <!-- Content Header (Page header) -->
      @include('admin.partials.alerts')

      <!-- Your Page Content Here -->
      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('admin.partials.footer')

  @include('admin.partials.control-sidebar')
  
</div>
<!-- ./wrapper -->

@include('admin.partials.scripts')

</body>
</html>
