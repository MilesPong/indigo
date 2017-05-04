@extends('layouts.auth')

@section('html_header_title')
    Password Reset
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

    <form role="form" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

      <input type="hidden" name="token" value="{{ $token }}">

      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" value="{{ $email or old('email') }}" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>

      <div class="row">
       <div class="col-xs-2">
       </div><!-- /.col -->
       <div class="col-xs-8">
        <button type="submit" class="btn btn-primary btn-block btn-flat""> Reset Password </button>
       </div><!-- /.col -->
       <div class="col-xs-2">
       </div><!-- /.col -->
      </div>

    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@include('admin.partials.scripts')

</body>

@endsection


