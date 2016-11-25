@include('layouts.header')
<body class="grey lighten-5">
@include('includes.navbar')
    @include('includes.message')
    @yield('content')
@include('layouts.footer')
