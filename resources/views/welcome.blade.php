@extends('layouts.app')
@section('title') Anudip SlotBook App @stop
@section('content')
<div class="content center-align">
    <div class="title m-b-md">
        <img src="{{URL::asset('images/logo.png')}}"/>
        <h3 class="center-align">Welcome to Slot Booking App</h3>
        <h6 class="grey-text text-darken-1">Powered by Anudip Foundation - Technology</h6>
        <p class="margin-top-2x">
         <a class="waves-effect waves-light btn-large red" href="{{URL('slot/view')}}"><i class="material-icons left">visibility</i>View Slots</a>
        </p>
    </div>

</div>
@endsection