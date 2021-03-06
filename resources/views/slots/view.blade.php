@extends('layouts.app')
@section('title') View Slots @stop
@section('content')
<main class="container white z-depth-1 center-align view-slot margin-bottom-4x">
	<div class="row heading">
		<h3 class="left-align title left col-s8">View  Booking Slots</h3>
		<a class="z-depth-1 margin-top-x waves-effect waves-light btn right col-s4 green accent-4 add-btn" href="{{URL('slot/new')}}"> 
			<i class="material-icons left">launch</i> Book A Slot 
		</a>
	</div>
	<div class="row">
		<p class="left-align grey-text text-darken-1">
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
		</p>
	</div>
	<div class="row">
		<div class="grey-text left-align margin-top-4x overflow">
			<a class="btn-floating btn-large waves-effect waves-light grey lighten-1 left"> <i class="small material-icons clear full-width">today</i> </a>
			<div class="left hero--title">
				<h5 class="title grey-text text-darken-1">Booking Status</h5>
				<span>2 days of available slots</span>
			</div>
		</div>

		<div class="grid calendar--item center-align overflow row slot-wrapper auto margin-top-2x margin-bottom-4x">

			@foreach($calendar_dates as $key)
			<a class="col s12 m2 border-x slot-info @if($key['status']) light-blue @else white pointer @endif"
			data-value="{{$key['date_value']}}">
			<div class="card-panel no-box-shadow @if($key['status']) white-text light-blue @else white blue-grey-text text-lighten-3 @endif slot-box">
				<i class="small material-icons clear full-width">today</i>
				<span class="@if($key['status']) white-text @else blue-grey-text @endif size-x"> {{ $key['wk_day'] }} </span>
				<br/>
				<span class="@if($key['status']) white-text @else blue-grey-text @endif size-x">{{ $key['day'] }}</span>
			</div> </a>
			@endforeach

			<!--Display slots-->
			<div class="col s12 m12 border-x slot-details white margin-top-2x" id="slot-details">
				@if(!empty($today_slots))
				@foreach($today_slots as $slot)
				<div class="card-panel col s12 m3 offset-m1 border-blue white no-box-shadow slot-box left-origin">
				     @if($slot['prior_status']==1)
					<i class="small material-icons red-text text-lighten-1 prior-check absolute tooltipped" data-position="top" data-delay="50" data-tooltip="This slot is reserved on prior basis"> error </i>
					@endif
					<i class="medium material-icons light-blue-text">query_builder</i>
					<p class="slot-time-range blue-grey-text">
						<span class="black-text">{{$slot['slot_fromtime']}} - {{$slot['slot_totime']}}</span>
						<br/>
						<span class="grey-text text-darken-3"> {{$slot['slot_duration']}} minutes</span>
						<br/>
						{{$slot['department']}}
					</p>
				</div>
				@endforeach
				@else
				<b>No slot booking history found</b>
				@endif
			</div>
		</div>
	</div>
	</div>
</main>
@include('partial.slot')
@include('partial.realtime')
@if(Auth::check())
@include('partial.realtime_auth')
@endif
@endsection