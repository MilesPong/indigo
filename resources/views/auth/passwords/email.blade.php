@extends('layouts.auth')

@section('html_header_title')
    Reset
@endsection

@section('content')
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>{{ config('app.name') }}</b>
  </div>

  @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
  @endif

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <strong>Whoops!</strong><br><br>
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Reset Password</p>

    <form role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="row">
       <div class="col-xs-2">
       </div><!-- /.col -->
       <div class="col-xs-8">
        <button type="submit" class="btn btn-primary btn-block btn-flat""> Send Password Reset Link </button>
       </div><!-- /.col -->
       <div class="col-xs-2">
       </div><!-- /.col -->
      </div>

    </form>
    
    <a href="{{ route('login') }}">Log in</a><br>
    <a href="{{ route('register') }}" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@include('admin.partials.scripts')

</body>

@endsection

