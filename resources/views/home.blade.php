@extends('layouts.app')
@section('title') View Slots @stop
@section('content')
<main class="container row left-align view-slot margin-bottom-4x">
	<div class="row heading white col s8 z-depth-1">
		<h4 class="row left-align title left col s12">My Account</h4>
		<ul class="collection">
			<li class="collection-item avatar">
				<img src="{{URL('images/worker.png')}}" alt="" class="circle">
				<span class="title grey-text">Yes, it's You</span>
				<br>{{Auth::user()->name}}
			</li>
			<li class="collection-item avatar">
				<i class="material-icons circle">email</i>
				<span class="title grey-text">Authentication / Communication</span>
				<br>{{Auth::user()->email}}
			</li>
			<li class="collection-item avatar">
				<i class="material-icons circle light-blue">store</i>
				<span class="title grey-text">Department</span>
				<br>{{Auth::user()->department}}
			</li>
			<li class="collection-item avatar">
				<i class="material-icons circle amber white-text">grade</i>
				<span class="title grey-text">Role</span>
				<p>
					@if(Auth::user()->role)
						You are using as Admin
					@else
						You are using as Site User
					@endif
				</p>
			</li>
		</ul>
	</div>

	<div class="heading white col s3 offset-s1 z-depth-1 padding-x">
		<h5 class="left-align left grey-text text-darkensmall-font">Update Settings</h5>
		<br/><br/>
		<p>Last profile updated <b>Today</b></p>
		<a class="waves-effect waves-light btn margin-top-x margin-bottom-x full-width green accent-4" onclick="Materialize.toast('This feature will be available on next release', 4000)">
			Update My Profile
		</a>
		
	</div>
</main>
@include('partial.slot')
@endsection