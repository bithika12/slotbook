  <nav class="grey lighten-5 no-box-shadow">
    <div class="nav-wrapper">
      <a href="{{URL('/')}}" class="brand-logo light-blue-text">
        <i class="material-icons light-blue-text">home</i>
      </a>
      <ul class="right hide-on-med-and-down top-navbar">
       @if(Auth::check())
       {{-- <span class="notify red accent-1 radius absolute">
        <i class="count radius relative"><b>5</b></i>
       </span> --}}
       {{-- <li class="center-align">
        <a href="#!">
          <i class="size-2x large material-icons light-blue-text">add_alert</i>
        </a>
      </li> --}}
      <li class="center-align">
        <a href="{{URL('view/account')}}">
          <i class="size-2x material-icons light-blue-text">perm_identity</i>
        </a>
      </li>
      <span class="name-title red accent-1 small-font">Hi, <b>{{Auth::user()->fname}}</b></span>
      <li class="center-align">
        <a href="{{URL('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="size-2x material-icons light-blue-text">power_settings_new</i>
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
      @else
      <li class="center-align">
        <a href="{{URL('login')}}">
          <i class="size-2x large material-icons light-blue-text">lock_outline</i>
        </a>
      </li>
      {{-- <li class="center-align">
        <a href="{{URL('register')}}">
          <i class="size-2x material-icons light-blue-text">note_add</i>
        </a>
      </li> --}}
      @endif

    </ul>
  </div>
</nav>