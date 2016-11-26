@extends('layouts.app')
@section('title') View Slots @stop
@section('content')
	<main class="container white z-depth-1 center-align view-slot margin-bottom-4x">
		<div class="row heading">
			<h3 class="left-align title left col-s8">View  Booking Slots</h3>
			<a class="z-depth-1 margin-top-x waves-effect waves-light btn right col-s4 green accent-4 add-btn" href="{{URL('slot/new')}}">
				<i class="material-icons left">launch</i>
				Book A Slot
			</a>
		</div>
		<div class="row">
			<p class="left-align grey-text text-darken-1">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
			</p>
		</div>
		<div class="row">
			<div class="grey-text left-align margin-top-4x overflow">
				<a class="btn-floating btn-large waves-effect waves-light blue lighten-1 left">
					<i class="small material-icons clear full-width">today</i>
				</a>
				<div class="left hero--title">
					<h5 class="title grey-text text-darken-1">Booking Status</h5>
					<span>2 days of available slots</span>
				</div>
			</div>

			<div class="grid calendar--item center-align overflow row slot-wrapper auto margin-top-2x margin-bottom-4x">
				<div class="col s12 m2 border-x slot-info pointer">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-3 slot-box">
						<i class="small material-icons clear full-width">today</i>
						<span class="blue-grey-text text-lighten-1 size-x">25th
						</span>
					</div>
				</div>

				<div class="col s12 m2 border-x slot-info pointer">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-3 slot-box">
						<i class="small material-icons clear full-width">today</i>
						<span class="blue-grey-text text-lighten-1 size-x">25th
						</span>
					</div>
				</div>

				<div class="col s12 m2 slot-info blue lighten-1 ">
					<div class="card-panel no-box-shadow white-text blue lighten-1 slot-box">
						<i class="small material-icons clear full-width">today</i>
						<span class="white-text size-x">26th
						</span>
					</div>
				</div>

				<div class="col s12 m2 border-x slot-info pointer">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-3 slot-box">
						<i class="small material-icons clear full-width">today</i>
						<span class="blue-grey-text text-lighten-1  size-x">27th
						</span>
					</div>
				</div>

				<div class="col s12 m2 border-x slot-info pointer">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-3 slot-box">
						<i class="small material-icons clear full-width">today</i>
						<span class="blue-grey-text text-lighten-1 size-x">28th
						</span>
					</div>
				</div>
				
				<!--Display slots-->
				<div class="col s12 m12 border-x slot-details white margin-top-2x">

					<div class="card-panel col s12 m3 offset-m1 border-blue white  no-box-shadow slot-box left-origin">				
						<i class="small material-icons red-text text-lighten-1 prior-check absolute tooltipped" data-position="top" data-delay="50" data-tooltip="This slot is reserved on prior basis">
						error
						</i>
						<i class="medium material-icons blue-text text-lighten-1">query_builder</i>
						<p class="slot-time-range blue-grey-text">
							<b>Duration - 45 minutes</b><br/>
							Technology Department
							<br/>
							<span class="black-text">12:00 AM - 02:00 PM</span>
						</p>
					</div>

					<div class="card-panel col s12 m3 offset-m1 left-origin border-blue white no-box-shadow slot-box">
						<i class="medium material-icons blue-text text-lighten-1">query_builder</i>
						<p class="slot-time-range blue-grey-text">
							<b>Duration - 45 minutes</b><br/>
							Diya Project Department
							<br/>
							<span class="black-text">03:00 AM - 04:00 PM</span>
						</p>
					</div>

					<div class="card-panel col s12 m3 offset-m1 border-blue white no-box-shadow slot-box left-origin">
						<i class="medium material-icons blue-text text-lighten-1">query_builder</i>
						<p class="slot-time-range blue-grey-text">
							<b>Duration - 45 minutes</b><br/>
							SAVE Project Department
							<br/>
							<span class="black-text">04:00 AM - 05:00 PM</span>
						</p>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>
@endsection