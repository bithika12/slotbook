<script type="text/javascript">

/*
* Ajax slot request submit
*/
$(document).ready(function() {
		$("#request_btn").click(function(e) {
			e.preventDefault();
			console.log($("#slot_from_time").val());
			$get_cal_from_time = converttimeformat($("#slot_from_time").val());
			$get_cal_to_time = converttimeformat($("#slot_to_time").val());
			$chk_bx = $('#prior_status').prop('checked');
			$.ajax({
				type: "POST",
				url: {!! json_encode(url('/slot/save')) !!}, 
				data: {
					'_token': $("input[name='_token']").val(),
					'slot_date' : $("input[name='slot_date']").val(),
					'slot_from_time' : $get_cal_from_time,
					'slot_to_time' : $get_cal_to_time,
					'description' :  $("textarea[name='description']").val(),
					'prior_status' : $('#prior_status').is(':checked'),
					'hid_slot_id' :  $('#hid_slot_id').val(),
					'no_of_joinee' : $("input[name='no_of_joinee']").val()
				}, 
				dataType : "json",
				success : function(json) {
					if (!json.status) {
					alert('Sorry');
					} else {
					var $toastContent = $('<span>Slot Request Submitted Successfully.</span>');
					var socket = io.connect('http://' + window.location.hostname + ':3000');
					socket.emit('new_slot', {
					start_time : json.start_time,
					end_time : json.end_time,
					duration : json.duration,
					department : json.department,
					slot_date : json.slot_date,
					prior_status : json.prior_status
					});
					Materialize.toast($toastContent, 5000);
					setTimeout(function() {
					window.location = {!! json_encode(url('/slot/list')) !!}
					}, 1000);
					}
				} , error: function(xhr, status, error) {
				alert(error);
				},
			});
		});
	
	/*
	* Ajax Slot view on date-selection
	*/
	$("a.slot-info").click(function() {
		$("a.slot-info").addClass("white pointer").removeClass("light-blue active");
		$("a.slot-info .slot-box").addClass("white blue-grey-text text-lighten-3").removeClass("light-blue white-text");
		$("a.slot-info .slot-box span").addClass("white blue-grey-text").removeClass("light-blue white-text");
	
		$(this).addClass("active").removeClass("pointer white");
		$(this).children(".slot-box").removeClass("white blue-grey-text text-lighten-3");
		$(this).children(".slot-box").children(".slot-box span").removeClass("white blue-grey-text text-lighten-3");
	
		$.ajax({
			type: "GET",
			url: {!! json_encode(url('/slot/load')) !!},
			data: {
			'slot_date' : $(this).attr("data-value")
			},
			dataType : "json",
			beforeSend: function(json) {
			$('.preloader').removeClass("hidden");
		},
		success : function(json) {
			$('.preloader').addClass("hidden");
			var getParse = JSON.parse(json);
			var ar=getParse[0];
			$("#slot-details").empty();
			if(getParse.length >0){
				for (var i = 0; i < getParse.length; i++) {
				var slot_fromtime=getParse[i]['slot_fromtime'];
				var slot_totime=getParse[i]['slot_totime'];
				var duration=getParse[i]['slot_duration'];
				var prior_status=getParse[i]['prior_status'];
				var department=getParse[i]['department'];
				$("#slot-details").append("<div class='card-panel col s12 m3 offset-m1 border-blue white  no-box-shadow slot-box left-origin'>"
				+
				(prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on prior basis'>error</i>" : "") +
				"<i class='medium material-icons blue-text text-lighten-1'>query_builder</i><p class='slot-time-range blue-grey-text'><span class='black-text'>"
				+ slot_fromtime +
				" - "
				+ slot_totime +
				"</span><br/><span class='grey-text text-darken-3'>"
				+ duration +
				" minutes </span><br/>"
				+ department +
				"</p></div>");
				}
			}
			else
			{
				$("#slot-details").html("<b>No slot booking history found</b>");
			}
		}
	
	});
});
	
	//Delete Slot Booking
		$("a.link.trash").click(function() {
			swal({
				title : "Are you sure?",
				text : "You will not be able to recover this slot!",
				type : "warning",
				showCancelButton : true,
				confirmButtonColor : "#DD6B55",
				confirmButtonText : "Yes, delete it!",
				cancelButtonText : "No, changed my mind!",
				closeOnConfirm : false,
				closeOnCancel : false
			}, function(isConfirm) {
			if (isConfirm) {
				swal("Deleted!", "Your slot has been deleted.", "success");
			} else {
				swal("Cancelled", "Your imaginary file is safe :)", "error");
				}
			});
		});
	});
	
	
	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('new_slot', function(json) {
		$('.ajax-response.success').html("<b>New Slot Added");
		$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text slot-details'>"
		+ json.slot_date +"|"+ json.start_time +"-"+ json.end_time +"</span><a class='orange-text text-darken-2 mod-action' href='#!'><i class='material-icons tiny relative'>warning</i>Need Approval</a><p class='blue-grey-text text-darken-4'>Material icons are beautifully crafted, delightful, and easy to use in your web<br><br/><a class='blue accent-3 white-text mod-action modify link' href='#!'><i class='material-icons tiny relative'>edit</i>Change</a><a class='blue accent-3 white-text margin-left-0-5x mod-action trash link' href='#!'><i class='material-icons tiny relative'>delete</i> Trash</a><a class='blue accent-3 white-text margin-left-0-5x mod-action repeat link' href='#!'><i class='material-icons tiny relative'>loop</i> Repeat</a></p></li>"
		);
	});
	
	function converttimeformat(time) {
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
		return hours + ":" + minutes;
	}

	/*
	* Realtime after Admin Approval
	*/

	function need_approv(id){
	$get_cal_from_time = $("#slot_from_time").val();
	$get_cal_to_time = $("#slot_to_time").val();
	$.ajax({
		type: "POST",
		url: {!! json_encode(url('/slot/approve')) !!}, data: {
			'_token': $("input[name='_token']").val(),
			'slot_date' : $("input[name='slot_date']").val(),
			'slot_from_time' : $("#slot_from_time").val(),
			'slot_to_time' : $("#slot_to_time").val(),
			'prior_status' : $('#prior_status').val(),
			'department' : $('#department').val(),
			'hid_slot_id' :id
		}, dataType : "json",
		success : function(json) {
			console.log(json);
			if (!json) {
				alert('Sorry');
			} 
			else {
				var $toastContent = $('<span>Slot Request Submitted Successfully.</span>');
				var socket = io.connect('http://' + window.location.hostname + ':3000');
				socket.emit('approve_slot', {
					start_time : json.start_time,
					end_time : json.end_time,
					duration : json.duration,
					department : json.department,
					slot_date : json.slot_date,
					prior_status : json.prior_status
				});
				Materialize.toast($toastContent, 5000);
				setTimeout(function() {
					
				}, 5000);
			}
			} , error: function(xhr, status, error) {
				alert(error);
			},
		});
	};

	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('approve_slot', function(json) {
		$('.ajax-response.success').html("<b>New Slot Added");
		$("#slot-details").append("<div class='card-panel col s12 m3 offset-m1 border-blue white  no-box-shadow slot-box left-origin'>"
		+(json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on prior basis'>error</i>" : "") +
		"<i class='medium material-icons blue-text text-lighten-1'>query_builder</i><p class='slot-time-range blue-grey-text'><span class='black-text'>"+ json.start_time +"-"+ json.end_time +"</span><br/><span class='grey-text text-darken-3'>"
		+ json.duration +"minutes</span><br/>"+ json.department +"</p></div>");$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"+ json.slot_date +
		"|"+ json.start_time +"-"+ json.end_time +"</span><i class='relative material-icons green-text text-accent-4'>done</i><p class='blue-grey-text text-darken-4'>Material icons are beautifully crafted, delightful, and easy to use in your web<br><br/><a class='blue accent-3 white-text mod-action modify link' href='#!'><i class='material-icons tiny relative'>edit</i>Change</a><a class='blue accent-3 white-text margin-left-0-5x mod-action trash link' href='#!'><i class='material-icons tiny relative'>delete</i> Trash</a><a class='blue accent-3 white-text margin-left-0-5x mod-action repeat link' href='#!'><i class='material-icons tiny relative'>loop</i> Repeat</a></p></li>"
		);
	});</script>
