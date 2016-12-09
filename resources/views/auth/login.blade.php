@extends('layouts.app')
@section('title') Login to App @stop
@section('content')

<main class="container login-auth margin-bottom-4x">
    <div class="row center-align">
        <h3 class="title">Login to Authenticate</h3>
        <div class="margin-top-2x white z-depth-1 col s12 m5 card-space clear auto float left-align">
           <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{CSRF_FIELD()}}
                <div class="row margin-bottom-off">
                  <div class="input-field col s12">
                    <i class="material-icons prefix grey-text text-lighten-2">perm_identity</i>
                    <input id="email" type="text" name="email" value="{{old('email')}}">
                    <label for="email">Enter Email Address</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix grey-text text-lighten-2">vpn_key</i>
                    <input type="password" name="password" id="password" />
                    <label for="password">Enter Password</label>
                </div>
            </div>
            <a class="link red-text text-accent-3" href="{{ url('/password/reset') }}">
                    <i class="material-icons relative icons grey-text text-lighten-2">error</i>
                Forgot Your Password?</a>

            <button class="waves-effect full-width waves-light btn green accent-4 margin-top-2x margin-bottom-x">
                GET STARTED</button>

            </form>
        </div>
    </div>
</main>
@endsection
