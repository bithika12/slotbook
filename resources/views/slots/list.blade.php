@extends('layouts.app')
@section('title') View Slots - List View @stop
@section('content')
<main class="container white z-depth-1 center-align list-slot margin-bottom-4x">
	<div class="row heading">
		<h3 class="left-align title left col-s8">My Slots - List View</h3>
	</div>
	<div class="row left-align">
		<ul class="collection" id="list_slots">
			@if(!empty($slots))
			@foreach($slots as $slot)
			<li class="collection-item avatar">
				<i class="material-icons circle blue-grey lighten-2">today</i>
				<span class="title black-text slot-details">{!! date("jS F", strtotime($slot["slot_date"])) !!} | {!! strtoupper(date("g:i a", strtotime($slot["slot_fromtime"]))) !!} - {!! strtoupper(date("g:i a", strtotime($slot["slot_totime"]))) !!}
					@if($slot['status']=='2') 
					<i class="relative material-icons green-text text-accent-4">done</i> @endif </span>

				<!--Only for upcoming request-->
				@if($slot['status']=='1')
				<a class="red-text text-accent-3 mod-action link trash" href="#!"> 
					<i class="material-icons tiny relative">close</i> Cancel Request </a>
				@endif
				@if($slot['status']=='4')
				<a class="red-text text-accent-3"> 
					<i class="material-icons tiny relative">close</i> </a>
				@endif
				@if(Auth::user() -> role == 1 && $slot['status']!='2')
				<a onclick="need_approv({{$slot['id']}});" class="orange-text mod-action" href="#!"> <i class="material-icons tiny relative">warning</i> Need Approval </a>
				@endif
				<p class="blue-grey-text text-darken-4">
					{!! $slot["slot_desc"] !!}
					<br><br>
					@if (Auth::user() -> role == 0)
					<a class="light-blue white-text mod-action modify link" href="{{ url('/slot/edit', (base64_encode(urlencode($slot['id'])))) }}"> <i class="material-icons tiny relative">edit</i>Change </a>
					<a class="light-blue white-text margin-left-0-5x mod-action link repeat" href="{{ url('/slot/repeat', (base64_encode(urlencode($slot['id'])))) }}"> <i class="material-icons tiny relative">loop</i> Repeat </a>
					<!---<a class="light-blue white-text margin-left-0-5x mod-action link swap" href="#!"> <i class="material-icons tiny relative">compare_arrows</i> Swap Request </a>--->
					@elseif(Auth::user() -> role == 1)
						<span class="blue-grey lighten-5 small-font bolder">{{ !empty($slot['department']) ? $slot['department'] : '' }}</span>
					@endif
				</p>
					@if($slot['prior_status']=='1')
					<a href="#!" class="secondary-content"> <i class="material-icons red-text tooltipped" data-position="top" data-delay="50" data-tooltip="This slot is reserved on prior basis">error</i> </a>
					@endif
			</li>
			<!--hidden value for realtime-->
			<input type="hidden" name="slot_from_time" id="slot_from_time" value="{{ !empty($slot['slot_fromtime']) ? $slot['slot_fromtime'] : '' }}">
			<input type="hidden" name="slot_to_time" id="slot_to_time" value="{{ !empty($slot['slot_totime']) ? $slot['slot_totime'] : '' }}">
			<input type="hidden" name="slot_date" id="slot_date" value="{{ !empty($slot['slot_date']) ? $slot['slot_date'] : '' }}">
			<input type="hidden" name="description" id="description" value="{{ !empty($slot['slot_desc']) ? $slot['slot_desc'] : '' }}">
			<input type="hidden" name="prior_status" id="prior_status" value="{{ !empty($slot['prior_status']) ? $slot['prior_status'] : '' }}">
			<input type="hidden" name="hid_slot_id" id="hid_slot_id" value="{{ !empty($slot['id']) ? $slot['id'] : '' }}">
			<input type="hidden" name="department" id="department" value="{{ !empty($slot['department']) ? $slot['department'] : '' }}">
			<!--hidden value for realtime-->

			@endforeach
			@else
			<h6 class="red-text text-accent-1 center-align">You have not created any slot yet.</h6>
			@endif

		</ul>
	</div>
	<div class="fixed-action-btn horizontal slot-add">
		<a class="btn-floating btn-large amber accent-3 z-depth-3" href="{{URL('slot/new')}}"> <i class="large material-icons">add</i> </a>
	</div>
</main>
@include('partial.slot')
@endsection
