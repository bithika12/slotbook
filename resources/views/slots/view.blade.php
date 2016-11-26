@extends('layouts.app')
@section('title') Anudip SlotBook App @stop
@section('content')
	<main class="container white z-depth-1 center-align view-slots margin-bottom-4x">
		<div class="row heading">
			<h3 class="left-align title left col-s8">View  Booking Slots</h3>
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
			<div class="grey-text left-align margin-top-4x overflow">
				<a class="btn-floating btn-large waves-effect waves-light blue lighten-1 left">
					<i class="small material-icons clear full-width">perm_contact_calendar</i>
				</a>
				<div class="left hero--title">
					<h5 class="title grey-text text-darken-1">Booking Status</h5>
					<span>2 days of available slots</span>
				</div>
			</div>

			<div class="grid calendar--item center-align overflow row slot-wrapper auto margin-top-2x margin-bottom-4x">
				<div class="col s12 m2 border-x slot-info">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-4 slot-box">
						<i class="small material-icons clear full-width">perm_contact_calendar</i>
						<span class="blue-grey-text size-x">25th
						</span>
					</div>
				</div>

				<div class="col s12 m2 border-x slot-info">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-4 slot-box">
						<i class="small material-icons clear full-width">perm_contact_calendar</i>
						<span class="blue-grey-text size-x">25th
						</span>
					</div>
				</div>

				<div class="col s12 m2 slot-info blue lighten-1">
					<div class="card-panel no-box-shadow white-text blue lighten-1 slot-box">
						<i class="small material-icons clear full-width">perm_contact_calendar</i>
						<span class="white-text size-x">26th
						</span>
					</div>
				</div>

				<div class="col s12 m2 border-x slot-info">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-4 slot-box">
						<i class="small material-icons clear full-width">perm_contact_calendar</i>
						<span class="blue-grey-text size-x">27th
						</span>
					</div>
				</div>

				<div class="col s12 m2 border-x slot-info">
					<div class="card-panel no-box-shadow white blue-grey-text text-lighten-4 slot-box">
						<i class="small material-icons clear full-width">perm_contact_calendar</i>
						<span class="blue-grey-text size-x">28th
						</span>
					</div>
				</div>
				
				<div class="col s12 m12 border-blue slot-details white margin-top-2x">
					<div class="card-panel col s12 m3 border-2x no-box-shadow blue-text text-darken-1 slot-box">
						<i class="material-icons">query_builder</i>
					</div>
				</div>

			</div>
		</div>
	</div>
</main>
@endsection