@extends('layouts.app')
@section('title') Book New Slot @stop
@section('content')
<main class="container book-slot margin-bottom-4x">
	<div class="row">
		<div class="white z-depth-1 col s12 m8 auto float card-space">
			<div class="heading row">
				@if($slotAction==1)
				<h3 class="left-align title left col-s8 grey-text text-darken-2">Update A Slot</h3>
				@else
				<h3 class="left-align title left col-s8 grey-text text-darken-2">Book A Slot</h3>
				@endif
			</div>
			<form name="slot-book" role="form" action="" method="post" enctype="multipart/form-data">
				{{CSRF_FIELD()}}
				<input type="hidden" name="slot_status" value="@if(isset($slotToUpdate))0 @else 1 @endif">
				<input type="hidden" name="slot_fromtime" value="@if(isset($slotToUpdate->slot_fromtime)){{strtoupper(date("g : i a", strtotime($slotToUpdate->slot_fromtime)))}}@endif">
				<input type="hidden" name="slot_totime" value="@if(isset($slotToUpdate->slot_totime)){{strtoupper(date("g : i a", strtotime($slotToUpdate->slot_totime)))}}@endif">
				
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix grey-text text-lighten-2">today</i>
						<input id="slot_date" type="date" name="slot_date" class="datepicker pointer" value="{{ isset($slotToUpdate) ? date('j F, Y',strtotime($slotToUpdate->slot_date)) : date('j F, Y') }}">
						<label for="slot_date">Select Date</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
						<input type="text" id="slot_from_time" value="hh" name="slot_from_time" class="timepicker"/>
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
						<textarea id="description" name="description" class="materialize-textarea" maxlength="50" placeholder="50 characters allowed.." length="50">{{ isset($slotToUpdate) ? $slotToUpdate->slot_desc : '' }}</textarea>
						<label for="description">Give A Description</label>
					</div>

					<div class="input-field col s6">
						<i class="material-icons prefix grey-text text-lighten-2">person_pin</i>
						<label for="description">Possible Attendees (Approx no.)</label>
						<input type="text" id="no_of_joinee" name="no_of_joinee" value="
						{{ isset($slotToUpdate) ? $slotToUpdate->no_of_joinee :'1' }}" />
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12 margin-top-off margin-bottom-2x">
						<input type="checkbox" id="prior_status" @if(isset($slotToUpdate) && 
						$slotToUpdate->prior_status==1)
						checked
						@endif
						name="prior_status">
						<label for="prior_status" class="red-text text-darken-1"> Mark it as important </label>
					</div>
				</div>
                <input type="hidden" name="hid_slot_id" id="hid_slot_id" value="
                {{ isset($slotToUpdate) ? $slotToUpdate->id : '' }}">
                <input type="hidden" id="slot_action" name="slot_action" value="{{$slotAction}}">
                @if($slotAction==1)
                <button class="waves-effect waves-light btn-large green accent-4 margin-bottom-x" id="request_btn">
					<i class="material-icons left">input</i>
					Update Booking
				</button>
				@else
				<button class="waves-effect waves-light btn-large green accent-4 margin-bottom-x" id="request_btn">
					<i class="material-icons left">input</i>
					Request Booking
				</button>
				@endif
			</form>
		</div>

	</div>
</main>
@include('partial.slot')
@include('partial.realtime')
@endsection
