<script type="text/javascript">

/*
* Ajax slot request submit
*/
$(document).ready(function() {
		$("#request_btn").click(function(e) {
			e.preventDefault();
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
					'slot_action' :  $('#slot_action').val(),
					'no_of_joinee' : $("input[name='no_of_joinee']").val()
				},
				dataType : "json",
				success : function(json) {
				//console.log(json);
					if (json.hasOwnProperty('slot_status')) {
						$(".fixed-message.error").removeClass("hidden").html("Slot already exists on this time.");
					}
					else if(!json.status){
						$(".fixed-message.error").removeClass("hidden").html("Error occured. Try again.");
					} else {
					var $toastContent = $('<span>Slot Request Submitted Successfully.</span>');
					var socket = io.connect('http://' + window.location.hostname + ':3000');
					socket.emit('new_slot', {
					start_time : json.start_time,
					end_time : json.end_time,
					duration : json.duration,
					department : json.department,
					slot_date : json.slot_date,
					prior_status : json.prior_status,
					created_by : json.created_by,
					auth_user_id : json.auth_user_id,
					auth_user_role : json.auth_user_role,
					slot_desc : json.slot_desc
					});
					swal("Success!", "Slot operation updated successfully!", "success");
						setTimeout(function() {
						window.location = {!! json_encode(url('/slot/list')) !!}
						}, 2500);

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
			setTimeout(function() {$(".preloader").addClass("hidden");}, 500);
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
		$("a.link.cancel").click(function(e) {
			e.preventDefault();
			$slot_id = $(this).attr("data-slot-id");
	      	swal({
				  title: "Are you sure to cancel?",
				  text: "Give a comment to cancel the slot",
				  type: "input",
				  showCancelButton: true,
				  closeOnConfirm: false,
				  confirmButtonColor: "#DD6B55",
				  cancelButtonText: "Get Back",
				  confirmButtonText: "Cancel Slot !",
				  animation: "slide-from-top",
				  inputPlaceholder: "Write something"
				},
				function(inputValue){
				  if (inputValue === false) return false;

				  else if (inputValue === "") {
				    swal.showInputError("You need to write something!");
				    return false
				  }
				  else{
				  	$.ajax({
							type: "POST",
							url: {!! json_encode(url('/slot/cancel')) !!},
						    data: {
							'_token': $("input[name='_token']").val(),
							'slot_id' : $slot_id,
							'comment' : inputValue
			               },
					dataType : "json",
					success : function(json) {
						//console.log(json);
						}
				  });
               }
			swal("Cancelled!", "You wrote: " + inputValue, "success");
			setTimeout(function() {
				location.reload(1)
				}, 1000);
			});
		});
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
	//$get_cal_from_time = converttimeformat($("#slot_from_time").val());
	//$get_cal_to_time = converttimeformat($("#slot_to_time").val());

	swal({
	  title: "Are you sure to approve?",
	  text: "Click ok to submit the slot else cancel it",
	  type: "info",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  showLoaderOnConfirm: true,
	},
	function(){
	  setTimeout(function(){
	  	$.ajax({
		type: "POST",
		url: {!! json_encode(url('/slot/approve')) !!},
		data: {
			'_token': $("input[name='_token']").val(),

			'hid_slot_id' :id
		}, dataType : "json",
		success : function(json) {

			if (!json) {
				$(".fixed-message.error").removeClass("hidden").html("Error occured. Try at your end.");
			}
			else {
				var $toastContent = $('<span>Slot Request Approved Successfully.</span>');
				var socket = io.connect('http://' + window.location.hostname + ':3000');
				socket.emit('approve_slot', {
					start_time : json.start_time,
					end_time : json.end_time,
					duration : json.duration,
					department : json.department,
					slot_date : json.slot_date,
					slot_desc : json.slot_desc,
					prior_status : json.prior_status,
					created_by : json.created_by,
					status : json.status,
					auth_user_id : json.auth_user_id,
					auth_user_role : json.auth_user_role
				});
				swal("Slot Approved!");
				//location.reload(1);
			}
			} , error: function(xhr, status, error) {
				alert(error);
			},
		});
	  }, 2000);
	});
	};

	</script>
