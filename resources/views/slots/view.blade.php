@extends('layouts.app')
@section('title') Anudip SlotBook App @stop
@section('content')
<main class="container white z-depth-1 center-align view-slots">
	<div class="row heading">
		<h3 class="left-align title left col-s8">View Slot Booking</h3>
		<a class="z-depth-1 margin-top-x waves-effect waves-light btn right col-s4 green accent-4 add-btn">
			Book A Slot
		</a>
	</div>
	<div class="row">
		<p class="left-align grey-text text-darken-1">
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
		</p>
	</div>
	<div class="row">
		<div class="grey-text left-align margin-top-4x">
		  <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 left">
		  	<i class="material-icons">perm_contact_calendar</i>
		  </a>
		  <h5 class="title grey-text text-darken-1 left">Booking Status</h5>
		</div>
	</div>
</main>
@endsection