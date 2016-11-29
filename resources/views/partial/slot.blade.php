<script type="text/javascript">
	/*
	 * Ajax slot request submit
	 */
	$(document).ready(function() {
		$("#request_btn").click(function(e) {
				e.preventDefault();
				$get_cal_from_time = converttimeformat($("#slot_from_time").val());
				$get_cal_to_time = converttimeformat($("#slot_to_time").val());
				$.ajax({
				type: "POST",
				url: {!! json_encode(url('/slot/save')) !!}, data: {
					'_token': $("input[name='_token']").val(),
					'slot_date' : $("input[name='slot_date']").val(),
					'slot_from_time' : $get_cal_from_time,
					'slot_to_time' : $get_cal_to_time,
					'description' : $("textarea[name='description']").val(),
					'prior_status' : $("input[name='prior_status']").val(),
					'no_of_joinee' :
					$("input[name='no_of_joinee']").val()
				}, dataType : "json",
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
							department : json.department
						});
						Materialize.toast($toastContent, 5000);
						setTimeout(function() {
							window.location.reload(1);
						}, 5000);
					}
				} , error: function(xhr, status, error) {
					alert(error);
				},
			});
		});
	});
	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('new_slot', function(json) {
		console.log(json);
		$("#slot-details").prepend('<tr><td>' + json.start_time + '</td><td>' + json.end_time + '</td><td>' + json.duration + '</td><td>' + json.department + '</td></tr>');
	});

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
</script>
