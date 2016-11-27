@extends('layouts.app')
@section('title') View Slots - List View @stop
@section('content')
<main class="container white z-depth-1 center-align list-slot margin-bottom-4x">
	<div class="row heading">
		<h3 class="left-align title left col-s8">My Slots - List View</h3>
	</div>
	<div class="row left-align">
		<ul class="collection">
			<li class="collection-item avatar">
				<i class="material-icons circle grey lighten-1">today</i>
				<span class="title black-text slot-details">26th October | 08:00 PM - 12:00 AM</span>
				
				<!--Only for upcoming request-->
				<a class="red-text text-accent-3 mod-action" href="#!">
					<i class="material-icons tiny relative">close</i> Cancel Slot Request
				</a>


				<p class="blue-grey-text text-darken-4">Material icons are beautifully crafted, delightful, and easy to use in your web
					<br><br/>
					<a class="blue accent-3 white-text mod-action" href="#!">
						<i class="material-icons tiny relative">edit</i>Change
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">delete</i> Trash
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">loop</i> Repeat
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">compare_arrows</i> Swap Request
					</a>
				</p>
			</li>
			<li class="collection-item avatar">
				<i class="material-icons circle grey lighten-1">today</i>
				<span class="title black-text slot-details">26th October | 08:00 PM - 12:00 AM </span>

				<!--Only for admin role-->
				<a class="orange-text text-accent-5 mod-action" href="#!">
					<i class="material-icons tiny relative">warning</i> Not Approved yet
				</a>


				<p class="blue-grey-text text-darken-4">Material icons are beautifully crafted, delightful, and easy to use in your web
					<br><br/>
					<a class="blue accent-3 white-text mod-action" href="#!">
						<i class="material-icons tiny relative">edit</i>Change
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">delete</i> Trash
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">loop</i> Repeat
					</a>
				</p>
			</li>
			<li class="collection-item avatar">
				<i class="material-icons circle grey lighten-1">today</i>
				<span class="title black-text slot-details">26th October | 08:00 PM - 12:00 AM
					<i class="relative material-icons green-text text-accent-4">done</i>
				</span>
				<p class="blue-grey-text text-darken-4">Material icons are beautifully crafted, delightful, and easy to use in your web
					<br><br/>
					<a class="blue accent-3 white-text mod-action" href="#!">
						<i class="material-icons tiny relative">edit</i>Change
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">delete</i> Trash
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">loop</i> Repeat
					</a>
				</p>

				<a href="#!" class="secondary-content">
					<i class="material-icons red-text tooltipped" data-position="top" data-delay="50" data-tooltip="This slot is reserved on prior basis">error</i>
				</a>
			</li>
			<li class="collection-item avatar">
				<i class="material-icons circle grey lighten-1">today</i>
				<span class="title black-text slot-details">26th October | 08:00 PM - 12:00 AM
					<i class="relative material-icons green-text text-accent-4">done</i>
				</span>
				<p class="blue-grey-text text-darken-4 slot-desc">Material icons are beautifully crafted, delightful, and easy to use in your web
					<br><br/>
					<a class="blue accent-3 white-text mod-action" href="#!">
						<i class="material-icons tiny relative">edit</i>Change
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">delete</i> Trash
					</a>
					<a class="blue accent-3 white-text margin-left-0-5x mod-action" href="#!">
						<i class="material-icons tiny relative">loop</i> Repeat
					</a>
				</p>
			</li>
		</ul>
	</div>
	<div class="fixed-action-btn horizontal slot-add">
		<a class="btn-floating btn-large amber accent-3 z-depth-3" href="{{URL('slot/new')}}">
			<i class="large material-icons">add</i>
		</a>
	</div>
</main>

@endsection