$(document).ready(function(){
	
	//datepicker call
	$('.datepicker').pickadate({
    	selectMonths: true, // Creates a dropdown to control month
    	selectYears: 15 // Creates a dropdown of 15 years to control year
  	});

	//timepicker call
  	$('.timepicker').wickedpicker();
});
