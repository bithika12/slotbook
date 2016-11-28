$(document).ready(function() {

	//datepicker call
	$('.datepicker').pickadate({
		selectMonths : true, // Creates a dropdown to control month
		selectYears : 15 // Creates a dropdown of 15 years to control year
	});

	//timepicker call
	var options = {
		//now: 'hh::mm', //hh:mm 24 hour format only, defaults to current time
		twentyFour : false //Display 24 hour format, defaults to false
	};
	$('.timepicker').wickedpicker(options);

	var time = $("#slot_from_time").val();
	converttimeformat(time);

	$("#join-range").ionRangeSlider({
    type: "single",
    min: 0,
    max: 100,
    from: 50,
    keyboard: true,
    onStart: function (data) {
        console.log("onStart");
    },
    onChange: function (data) {
        console.log("onChange");
    },
    onFinish: function (data) {
        console.log("onFinish");
    },
    onUpdate: function (data) {
        console.log("onUpdate");
    }
});
});

function converttimeformat(time) {
	// var time = $("#starttime").val();
	var hrs = Number(time.match(/^(\d+)/)[1]);
	var mnts = Number(time.match(/ : (\d+)/)[1]);
	var format = time.slice(-2);
	if (format == "PM" && hrs < 12)
		hrs = hrs + 12;
	if (format == "AM" && hrs == 12)
		hrs = hrs - 12;
	var hours = hrs.toString();
	var minutes = mnts.toString();
	if (hrs < 10)
		hours = "0" + hours;
	if (mnts < 10)
		minutes = "0" + minutes;
	//console.log(hours + ":" + minutes);
}