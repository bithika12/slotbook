@extends('layouts.app')
@section('title') Book New Slot @stop
@section('content')
<main class="container book-slot margin-bottom-4x">
	<div class="row">
		<div class="white z-depth-1 col s12 m8 auto float card-space">
			<div class="heading row">
				<h3 class="left-align title left col-s8 grey-text text-darken-2">Book A Slot</h3>
			</div>
			<form name="slot-book" role="form" action="{{URL('slot/save')}}" method="post" enctype="multipart/form-data">
				{{CSRF_FIELD()}}
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">today</i>
						<input id="slot_date" type="date" name="slot_date" class="datepicker pointer" value="{{date("F j, Y") }}">
						<label for="slot_date">Select Date</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
						<input type="text" id="slot_from_time" name="slot_from_time" class="timepicker"/>
						<label for="slot_from_time">Time Range From</label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
						<input type="text" id="slot_to_time" name="slot_to_time" class="timepicker"/>
						<label for="slot_to_time">Time Range To</label>
					</div>

				</div>

				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix grey-text text-lighten-2">rate_review</i>
						<textarea id="description" name="description" class="materialize-textarea" length="50"></textarea>
						<label for="description">Give A Description</label>
					</div>
				
					<div class="input-field col s6 margin-top-off">
						<label for="slot_date">Number of joinees</label>
						<p class="range-field margin-top-3x">
							<input type="range" id="test5" min="0" max="20" />
						</p>
					</div>
				</div>
				
				<div class="row">
					<div class="input-field col s12 margin-top-off margin-bottom-2x">
						<input type="checkbox" id="slot-prior" name="slot-prior"/>
						<label for="slot-prior" class="red-text text-darken-1"> Important? Mark for prior basis (Admin Approval Required). </label>
					</div>
				</div>

				<button class="waves-effect waves-light btn-large green accent-4 ">
					<i class="material-icons left">input</i>
					Request Booking
				</button>
			</form>
		</div>

	</div>
</main>
@endsection
