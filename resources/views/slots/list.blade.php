@extends('layouts.app')
@section('title') View Slots - List View @stop
@section('content')
<main class="container row left-align list-slot margin-bottom-4x">

	<div class="row heading white col s3 z-depth-2 margin-top-4x">
		<h5 class="row title left-align title left col s12 grey-text text-darken-1">Filter Slots</h5>
		<hr/>
       <form action="{{url('/slot/list')}}" method="post" name="filter_frm" id="filter_frm">
       {!! csrf_field() !!}
		<div class="row left-align margin-bottom-off">
			<div class="input-field col s12">
				<i class="material-icons prefix grey-text text-lighten-2">today</i>
				<input id="slot_date" type="date" name="slot_date" class="datepicker pointer" value="{{ isset($slotToUpdate) ? date('j F, Y',strtotime($slotToUpdate->slot_date)) : date('j F, Y') }}">
				<label for="slot_date">Select Date</label>
			</div>
		</div>

		<div class="row left-align margin-bottom-off">
			<div class="input-field col s12">
				<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
				<input type="text" id="slot_from_time" value="hh" name="slot_from_time" class="timepicker"/>
				<label for="slot_from_time">Select Time From</label>
			</div>
			<div class="input-field col s12 margin-bottom-off">
				<i class="material-icons prefix grey-text text-lighten-2">query_builder</i>
				<input type="text" id="slot_to_time" name="slot_to_time" class="timepicker"/>
				<label for="slot_to_time">Select Time To</label>
			</div>
		</div>

		<div class="row margin-bottom-off">
			<div class="input-field col s12 margin-top-off margin-bottom-2x">
				<input type="checkbox" class="filled-in" id="prior_status" name="prior_status" checked="checked" />
				<label for="prior_status">Show only prior slots ?</label>
			</div>
		</div>

		<button type="submit" value="filter_btn" name="btn_sub" id="btn_sub" class="waves-effect waves-light btn margin-bottom-x margin-top-x green accent-4">
			<i class="material-icons left">search</i>Filter Details
		</button>
		</form>
	</div>

	<div class="col s8 offset-s1">
		<h4 class="row left-align left col s12 margin-top-off"> My Slots - List View </h4>
		<div class="row left-align">
			<ul class="collection" id="list_slots">
				@if(!empty($slots))
					@foreach($slots as $slot)
						<li class="collection-item avatar">
							<i class="material-icons circle blue-grey lighten-2">today</i>
							<span class="title black-text slot-details">{!! date("jS F", strtotime($slot["slot_date"])) !!} | {!! strtoupper(date("g : i a", strtotime($slot["slot_fromtime"]))) !!} - {!! strtoupper(date("g : i a", strtotime($slot["slot_totime"]))) !!}
								@if($slot['status']=='2') <i class="relative material-icons green-text text-accent-4">done</i> @endif </span>
								
							<!--Only for upcoming request-->
							@if($slot['status']=='1')
							<a class="red-text text-accent-3 mod-action link cancel" href="#!"> <i class="material-icons tiny relative">warning</i> Cancel Request </a>
							@endif
		
							@if($slot['status']=='4')
							<a class="red-text text-accent-3 mod-action"> <i class="material-icons tiny relative">close</i> Cancelled </a>
							@endif
		
							@if(Auth::user()->role == 1 && $slot['status']!='2' && $slot['status']!='4')
							<a onclick="need_approv({{$slot['id']}});" class="orange-text mod-action" href="#!"> <i class="material-icons tiny relative">warning</i> Need Approval </a>
							@endif
		
							<p class="blue-grey-text text-darken-4">
								{!! $slot["slot_desc"] !!}
								<br>
								<br>
								@if (Auth::user()->role == 0)
									<a class="light-blue white-text mod-action modify link" href="{{ url('/slot/edit', (base64_encode(urlencode($slot['id'])))) }}"> <i class="material-icons tiny relative">edit</i>Modify </a>
									<a class="light-blue white-text margin-left-0-5x mod-action link repeat" href="{{ url('/slot/repeat', (base64_encode(urlencode($slot['id'])))) }}"> <i class="material-icons tiny relative">loop</i> Repeat </a>
									<!---<a class="light-blue white-text margin-left-0-5x mod-action link swap" href="#!"> <i class="material-icons tiny relative">compare_arrows</i> Swap Request </a>--->
								@elseif(Auth::user()->role == 1)
									<span class="blue-grey lighten-5 small-font bolder">
										{{ !empty($slot['department']) ? $slot['department'] : '' }}
									</span>
								@endif
								@if($slot['prior_status']=='1')
									<a href="#!" class="secondary-content"> <i class="material-icons red-text tooltipped" data-position="top" data-delay="50" data-tooltip="This slot is reserved on prior basis">error</i> </a>
								@endif
							</p>
						</li>

						<!--hidden value for realtime-->
						<input type="hidden" name="slot_from_time" id="slot_from_time" value="{{ !empty($slot['slot_fromtime']) ? strtoupper(date("g : i a", strtotime($slot['slot_fromtime']))) : '' }}">
						<input type="hidden" name="slot_to_time" id="slot_to_time" value="{{ !empty($slot['slot_totime']) ? strtoupper(date("g : i a", strtotime($slot['slot_totime']))) : '' }}">
						<input type="hidden" name="slot_date" id="slot_date" value="{{ !empty($slot['slot_date']) ? $slot['slot_date'] : '' }}">
						<input type="hidden" name="description" id="description" value="{{ !empty($slot['slot_desc']) ? $slot['slot_desc'] : '' }}">
						<input type="hidden" name="prior_status" id="prior_status" value="{{ !empty($slot['prior_status']) ? $slot['prior_status'] : '' }}">
						<input type="hidden" name="hid_slot_id" id="hid_slot_id" value="{{ !empty($slot['id']) ? $slot['id'] : '' }}">
						<input type="hidden" name="department" id="department" value="{{ !empty($slot['department']) ? $slot['department'] : '' }}">
						<input type="hidden" name="created_by" id="created_by" value="{{ !empty($slot['created_by']) ? $slot['created_by'] : '' }}">
						<!--hidden value for realtime-->
					@endforeach
				@else
				<h6 class="red-text text-accent-1 center-align">You have not created any slot yet.</h6>
				@endif
			</ul>
		</div>
	</div>
	<div class="fixed-action-btn horizontal slot-add">
		<a class="btn-floating btn-large light-blue z-depth-4" href="{{URL('slot/new')}}"> <i class="large material-icons">add</i> </a>
	</div>
</main>


@include('partial.slot')
@endsection
