<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="cache-control" content="private, max-age=0, no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('images/logo.png') }}" type="image/gif" sizes="16x16">
	<link href="https://fonts.googleapis.com/css?family=Oxygen:300,400" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/wickedpicker/stylesheets/wickedpicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/ion-rangeSlider/css/ion.rangeSlider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/ion-rangeSlider/css/ion.rangeSlider.skinHTML5.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/sweetalert/dist/sweetalert.css') }}">
	<script type="text/javascript" src="{{ URL::asset('js/vendor.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
	<!--<script type="text/javascript" src="{{ URL('node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.min.js') }}"></script>---->
	<script type="text/javascript" src="{{ URL('node_modules/socket.io/node_modules/socket.io-client/socket.io.min.js') }}"></script>
	<title>@yield('title')</title>
</head>