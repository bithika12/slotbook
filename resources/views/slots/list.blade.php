@extends('layouts.app')
@section('title') View Slots - List View @stop
@section('content')
<main class="container row left-align list-slot margin-bottom-4x">

	<div class="row heading white col s3 z-depth-2 margin-top-4x">
		<h5 class="row title left-align title left col s12 grey-text text-darken-1">Filter Slots</h5>
		<hr/>
       <form action="" method="post" name="filter_frm" id="filter_frm">
       {!! csrf_field() !!}
      
		<div class="row left-align margin-bottom-off">
			<div class="input-field col s12">
				<i class="material-icons prefix grey-text text-lighten-2">today</i>
				<input id="slot_date" type="date" name="slot_date" class="datepicker pointer" value="{{ isset($session_array['slot_date']) && !empty($session_array['slot_date']) ? $session_array['slot_date'] : date('j F, Y') }}">
				<label for="slot_date">Select Date</label>
			</div>
		</div>

		<div class="row left-align margin-bottom-off">
			 <div class="input-field col s12">
			    <select name="department">
			      <option value="" disabled selected>Choose your option</option>
			      @foreach($users as $user)
			       <option @if(isset($session_array) && !empty($session_array) && $session_array['department']==$user->department)selected @endif value="{!! $user->department !!}">{!! $user->department !!}</option>
			      @endforeach
			    </select>
			    <label>Select Department</label>
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
		<h4 class="row left-align left col s12 margin-top-off"> @if (Auth::user() -> role == 0)
			My Slots - List View
			@else
			All Slots - List View
			@endif </h4>
		<div class="row left-align">
		<ul class="collection white" id="list_slots">
			@if(!empty($slots))
			@foreach($slots as $slot)
			<li class="collection-item avatar">
				<i class="material-icons circle blue-grey lighten-2">today</i>
				<span class="title black-text slot-details">{!! date("jS F", strtotime($slot["slot_date"])) !!} | {!! strtoupper(date("g : i a", strtotime($slot["slot_fromtime"]))) !!} - {!! strtoupper(date("g : i a", strtotime($slot["slot_totime"]))) !!}
					@if($slot['status']=='2') 
					<i class="relative material-icons green-text text-accent-4">done</i> @endif </span>

				<!--Only for upcoming request-->
				@if($slot['status']=='1')
				<a class="red-text text-accent-3 mod-action link cancel" data-slot-id="{{$slot['id']}}" href="#!"> 
					<i class="material-icons tiny relative">close</i> Cancel Request </a>
				@endif
				@if($slot['status']=='4')
				<a class="red-text text-accent-3 mod-action"> 
					<i class="material-icons tiny relative">close</i> Cancelled</a>
				@endif
				@if(Auth::user() -> role == 1 && $slot['status']!='2' && $slot['status']!='4')
				<a onclick="need_approv({{$slot['id']}});" class="orange-text mod-action" href="#!"> 
					<i class="material-icons tiny relative">warning</i> Need Approval </a>
				@endif
				<p class="blue-grey-text text-darken-4">
					{!! $slot["slot_desc"] !!}
					<br><br>
					@if (Auth::user() -> role == 0)
					<a class="light-blue white-text mod-action modify link" href="{{ url('/slot/edit', (base64_encode(urlencode($slot['id'])))) }}"> <i class="material-icons tiny relative">edit</i>Modify </a>
					<a class="light-blue white-text margin-left-0-5x mod-action link repeat" href="{{ url('/slot/repeat', (base64_encode(urlencode($slot['id'])))) }}"> <i class="material-icons tiny relative">loop</i> Repeat </a>
					<!---<a class="light-blue white-text margin-left-0-5x mod-action link swap" href="#!"> <i class="material-icons tiny relative">compare_arrows</i> Swap Request </a>-->
					@elseif(Auth::user() -> role == 1)
						<span class="blue-grey lighten-5 small-font bolder">{{ !empty($slot['department']) ? $slot['department'] : '' }}</span>
					@endif
				</p>
					@if($slot['prior_status']=='1')
					<a href="#!" class="secondary-content"> <i class="material-icons red-text tooltipped" data-position="top" data-delay="50" data-tooltip="This slot is reserved on prior basis">error</i> </a>
					@endif
			</li>
            <input type="hidden" name="hid_slot_id" id="hid_slot_id" value="{{$slot['id']}}">
			@endforeach
			@else
			<h6 class="blank-slot-info red-text text-accent-2 center-align">You have not created any slot yet.</h6>
			@endif

		</ul>
	</div>
	</div>

	<div class="fixed-action-btn horizontal slot-add">
		<a class="btn-floating btn-large light-blue z-depth-4" href="{{URL('slot/new')}}"> <i class="large material-icons">add</i> </a>
	</div>
</main>
@include('partial.slot')
@include('partial.realtime')
@include('partial.realtime_auth')

@endsection
