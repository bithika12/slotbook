$(document).ready(function() {

	//datepicker call
	$('.datepicker').pickadate({
		selectMonths : true, // Creates a dropdown to control month
		selectYears : 15 // Creates a dropdown of 15 years to control year
	});
	
	//page-loader
	$(".preloader").delay(1000).fadeOut("slow");	


	//timepicker call
	var options = {
		//now: 'hh::mm', //hh:mm 24 hour format only, defaults to current time
		twentyFour : false, //Display 24 hour format, defaults to false
		title : 'Choose Slot Time'
	};
	$('.timepicker').wickedpicker(options);

	$("#no_of_joinee").ionRangeSlider({
	    type: "single",
	    min: 0,
	    max: 20,
	    grid: true,
	    keyboard: true
	});
});
