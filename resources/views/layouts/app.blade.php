@include('layouts.header')
<body class="blue-grey lighten-5">
	@include('includes.message')
	@include('includes.navbar')
	@yield('content')
@include('layouts.footer')
