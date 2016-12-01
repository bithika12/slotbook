@extends('layouts.app')
@section('title') Book New Slot @stop
@section('content')
<main class="container book-slot margin-bottom-4x">
	<div class="row">
		<div class="white z-depth-1 col s12 m8 auto float card-space">
			<div class="heading row">
				<h3 class="left-align title left col-s8 grey-text text-darken-2">Book A Slot</h3>
			</div>
			<form name="slot-book" role="form" action="" method="post" enctype="multipart/form-data">
				{{CSRF_FIELD()}}
				<input type="hidden" name="slot_status" value="@if(isset($slotToUpdate))0 @else 1 @endif">

				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix grey-text text-lighten-2">today</i>
						<input id="slot_date" type="date" name="slot_date" class="datepicker pointer" value="{{ isset($slotToUpdate) ? date('F j, Y',strtotime($slotToUpdate->slot_date)) : date('F j, Y') }}">
						<label for="slot_date">Select Date</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
						<input type="text" id="slot_from_time" value="hh" name="slot_from_time" class="timepicker" value=""/>
						<label for="slot_from_time">Select Time From</label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
						<input type="text" id="slot_to_time" name="slot_to_time" class="timepicker"/>
						<label for="slot_to_time">Select Time To</label>
					</div>

				</div>

				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix grey-text text-lighten-2">rate_review</i>
						<textarea id="description" name="description" class="materialize-textarea" length="50">{{ isset($slotToUpdate) ? $slotToUpdate->slot_desc : '' }}</textarea>
						<label for="description">Give A Description</label>
					</div>

					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">person_pin</i>
						<label for="description">Possible Attendees (Approx no.)</label>
						<input type="text" id="no_of_joinee" name="no_of_joinee" value="
						{{ isset($slotToUpdate) ? $slotToUpdate->no_of_joinee : '' }}" />
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12 margin-top-off margin-bottom-2x">
						<input type="checkbox" id="prior_status" @if(isset($slotToUpdate) && 
						$slotToUpdate->prior_status==1)
						checked
						@endif
						name="prior_status">
						<label for="prior_status" class="red-text text-darken-1"> Important? Mark for attention (Admin Approval Required). </label>
					</div>
				</div>
                <input type="hidden" name="hid_slot_id" id="hid_slot_id" value="
                {{ isset($slotToUpdate) ? $slotToUpdate->id : '' }}">
				<button class="waves-effect waves-light btn-large green accent-4 margin-bottom-x" id="request_btn">
					<i class="material-icons left">input</i>
					Request Booking
				</button>
			</form>
		</div>

	</div>
</main>
@include('partial.slot')
@endsection
