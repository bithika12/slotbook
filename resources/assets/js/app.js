$(document).ready(function() {

	//datepicker call
	$('.datepicker').pickadate({
		min: new Date(),
		max: 2
	});
	
	//timepicker call
	$('.timepicker').wickedpicker();
	
	//checking slot time value
	var slot_status = parseInt($("input[name='slot_status']").val());
	if(!slot_status){
		$('.timepicker').val('');
		$("input[name='slot_status']").val();
		$("input[name='slot_from_time']").val($("input[name='slot_fromtime']").val());
		$("input[name='slot_to_time']").val($("input[name='slot_totime']").val());
		var options = {
        	clearable: true, //Make the picker's input clearable (has clickable "x")
    	};
		$('.timepicker').wickedpicker(options);
	}
	else{
		$('.timepicker').wickedpicker();
	}
	
	//range value
	$("#no_of_joinee").ionRangeSlider({
	    type: "single",
	    min: 0,
	    max: 20,
	    grid: true,
	    keyboard: true
	});
});
