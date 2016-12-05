@extends('layouts.app')
@section('title') Anudip SlotBook App @stop
@section('content')
<main class="container book-slot margin-bottom-4x center-align">
    <div class="title m-b-md">
        <img class="box-shadow" src="{{URL::asset('images/approve.png')}}"/>
        <h3 class="center-align">Welcome to Slot Booking App</h3>
        <h6 class="grey-text text-darken-1">
        Powered by Anudip Foundation | Collaboration with iMerit Technology Services</h6>
        <p class="margin-top-2x">
         <a class="waves-effect waves-light btn-large red accent-2" href="{{URL('slot/view')}}">
         	<i class="material-icons left">view_module</i>View Slots</a>
         @if(Auth::check())
         <a class="waves-effect waves-light btn-large amber margin-left-x" href="{{URL('slot/list')}}">
         	<i class="material-icons left">assignment</i>
         	@if (Auth::user() -> role == 0)
         		My Slot List
         	@else
         		All Slots Lists
         	@endif
         </a>
        @endif
        </p>
    </div>

</main>
@endsection