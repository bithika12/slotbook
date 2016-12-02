<!--Ajax messages/realtime-->
<div class="success ajax-response hidden fixed-message fixed message center-align white-text animated full-width bounceInUp green accent-4"></div>
<div class="error ajax-response hidden fixed-message fixed message left-align white-text animated full-width bounceInUp red accent-3"></div>

<div class="preloader grey lighten-5 hidden"></div>

@if (Session::has('success'))
<div class="success fixed-message fixed message success-message center-align white-text animated slideInDown green accent-4 full-width">
	<i class="material-icons relative">done</i>
	<b>{{ Session::get('success') }}</b>
</div>
@endif

@if (Session::has('danger'))
<div class="error fixed-message fixed message success-message center-align white-text animated full-width slideInDown full-width red accent-4">
	<i class="material-icons relative">error</i>
	<b>{{ Session::get('danger') }}</b>
</div>
@endif

@if (Session::has('warning'))
<div class="amber fixed-message fixed message success-message center-align white-text animated full-width slideInDown amber full-width accent-4">
	<i class="material-icons relative">warning</i>
	<b>{{ Session::get('warning') }}</b>
</div>
@endif

@if (isset($errors) && count($errors) > 0)
<div class="error fixed-message fixed error-message white-text animated bounceInUp full-width red accent-3 full-width full-width">
	<ul>
		@foreach ($errors->all() as $error)
		<li>
			<i class="material-icons relative">warning</i><b> {{ $error }} </b>
		</li>
		@endforeach
	</ul>
</div>
@endif