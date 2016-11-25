@extends('layouts.app')
@section('title') Anudip SlotBook App @stop
@section('content')
<div class="content center-align">
    <div class="title m-b-md ">
        <img src="{{URL::asset('images/logo.png')}}"/>
        <h2 class="center-align">Room Slot Booking App</h2>
        <h6 class="grey-text text-darken-1">Powered by Anudip Foundation - Technology</h6>
        <p>
        <a class="waves-effect waves-light btn-large red"><i class="material-icons left">developer_board</i>View Slots</a>
        </p>
    </div>

</div>
@endsection