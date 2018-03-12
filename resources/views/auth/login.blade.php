@extends('layouts.auth')

@section('content')
    <div class="row materialize-red lighten-2 login-page">

        @if(count($errors) > 0)
            <div class="col l4 offset-l4 s10 offset-s1 error-msg">
                <div class="card-panel z-depth-4">
                    <ul class="red-text">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="col l4 offset-l4 s10 offset-s1">
            <div class="card-panel z-depth-4 hoverable">
                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="input-field col s12 center">
                            <h4 class="center materialize-red-text text-lighten-2">{{ config('app.name') }} Dashboard</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="username" type="email" class="validate" name="email" value="{{ old('email') }}">
                            <label for="username" class="center-align" data-error="Wrong email format">Username</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" type="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label>
                                <input type="checkbox" class="filled-in" name="remember" />
                                <span>Remember me</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn waves-effect waves-light col s12">Login</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m6 l6">
                            <p class=""><a href="#">Register Now!</a></p>
                        </div>
                        <div class="input-field col s6 m6 l6">
                            <p class="right-align"><a href="#">Forgot password ?</a></p>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
