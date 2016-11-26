@extends('layouts.app')
@section('title') Anudip SlotBook App @stop
@section('content')
<main class="container book-slot margin-bottom-4x center-align">
    <div class="title m-b-md">
        <img src="{{URL::asset('images/logo.png')}}"/>
        <h3 class="center-align">Welcome to Slot Booking App</h3>
        <hr/>
        <h6 class="grey-text text-darken-1">
        Powered by Anudip Foundation | Collaboration with iMerit Technology Services</h6>
        <p class="margin-top-2x">
         <a class="waves-effect waves-light btn-large red" href="{{URL('slot/view')}}"><i class="material-icons left">visibility</i>View Slots</a>
         @if(Auth::check())
         <a class="waves-effect waves-light btn-large amber margin-left-x" href="{{URL('slot/list')}}">
         	<i class="material-icons left">assignment</i>
         	My Slots
         </a>
        @endif
        </p>
    </div>

</main>
@endsection