@extends('layouts.app')
@section('title') Reset Your Password @stop
@section('content')

<main class="container login-auth margin-bottom-4x">
    <div class="row center-align">
        <h3 class="title">Reset Password</h3>
        @if (session('status'))
            <div class="alert alert-success">
                    {{ session('status') }}
            </div>
        @endif
        <div class="margin-top-2x white z-depth-1 col s12 m5 card-space clear auto float left-align">
           <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{CSRF_FIELD()}}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row margin-bottom-off">
                  <div class="input-field col s12">
                    <i class="material-icons prefix grey-text text-lighten-2">perm_identity</i>
                    <input id="email" type="text" name="email" value="{{ $email or old('email') }}" required autofocus>
                    <label for="email">Enter Email Address</label>
                 </div>
                </div>

                <div class="row margin-bottom-off">
                  <div class="input-field col s12">
                    <i class="material-icons prefix grey-text text-lighten-2">vpn_key</i>
                    <input id="password" type="password" name="password" required>
                    <label for="password">Enter Password (Must length of 6 digits)</label>
                 </div>
                </div>

                <div class="row margin-bottom-off">
                  <div class="input-field col s12">
                    <i class="material-icons prefix grey-text text-lighten-2">vpn_key</i>
                    <input id="password-confirm" type="password" name="password_confirmation" required>
                    <label for="password-confirm">Confirm Your Password</label>
                 </div>
                </div>
                <button class="waves-effect full-width waves-light btn green accent-4 margin-top-2x margin-bottom-x">
                    RESET PASSWORD
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
