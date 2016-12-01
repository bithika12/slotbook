
<script type="text/javascript">
	/*
	 * Ajax slot request submit
	 */
	$(document).ready(function() {
		$("#request_btn").click(function(e) {
				e.preventDefault();
				$get_cal_from_time = converttimeformat($("#slot_from_time").val());
				$get_cal_to_time = converttimeformat($("#slot_to_time").val());
				$chk_bx=$('#prior_status').is(':checked');
				
				$.ajax({
				type: "POST",
				url: {!! json_encode(url('/slot/save')) !!}, data: {
					'_token': $("input[name='_token']").val(),
					'slot_date' : $("input[name='slot_date']").val(),
					'slot_from_time' : $get_cal_from_time,
					'slot_to_time' : $get_cal_to_time,
					'description' : $("textarea[name='description']").val(),
					'prior_status' : $('#prior_status').is(':checked'),
					'hid_slot_id' : $('#hid_slot_id').val(),
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
							department : json.department,
							slot_date : json.slot_date,
							prior_status : json.prior_status
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
		  $('.ajax-response.success').html("<b>New Slot Added");	
		  $("#slot-details").append("<div class='card-panel col s12 m3 offset-m1 border-blue white  no-box-shadow slot-box left-origin'>"
		  	 + 
            (json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on prior basis'>error</i>" : "") +
		  	"<i class='medium material-icons blue-text text-lighten-1'>query_builder</i><p class='slot-time-range blue-grey-text'><span class='black-text'>" 
			+ json.start_time + 
			"-" 
			+ json.end_time + 
			"</span><br/><span class='grey-text text-darken-3'>" 
			+ json.duration + 
			"</span><br/>" 
			+ json.department + 
			"</p></div>");

		  $("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text slot-details'>"
		  	+ json.slot_date + 
		  	"|"
		  	+ json.start_time + 
		  	"-"
		  	+ json.end_time + 
		  	"</span><a class='orange-text text-darken-2 mod-action' href='#!'><i class='material-icons tiny relative'>warning</i>Need Approval</a><p class='blue-grey-text text-darken-4'>Material icons are beautifully crafted, delightful, and easy to use in your web<br><br/><a class='blue accent-3 white-text mod-action modify link' href='#!'><i class='material-icons tiny relative'>edit</i>Change</a><a class='blue accent-3 white-text margin-left-0-5x mod-action trash link' href='#!'><i class='material-icons tiny relative'>delete</i> Trash</a><a class='blue accent-3 white-text margin-left-0-5x mod-action repeat link' href='#!'><i class='material-icons tiny relative'>loop</i> Repeat</a></p></li>"
		  	);
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

		$("a.slot-info").click(function() {
			alert($(this).attr("data-value"));

			$.ajax({
	type: "GET",
	url: {!! json_encode(url('/slot/load')) !!},
	data: {
    'slot_date' : $(this).attr("data-value")
	},
	dataType : "json",
	beforeSend: function(data) {
       			$('.preloader').fadeIn("slow");
                $("a.slot-info").removeClass("light-blue");
       			$("a.slot-info .slot-box").removeClass("light-blue white-text");
       			$("a.slot-info .slot-box span").removeClass("light-blue white-text");
       			
       			$("a.slot-info").addClass("white");
       			$("a.slot-info .slot-box").addClass("white blue-grey-text text-lighten-3");
       			$("a.slot-info .slot-box span").addClass("white blue-grey-text");
       			
       			$(this).addClass("light-blue white-text");
       		},

	     success : function(json) {
		  console.log(json);
		   $('.preloader').fadeOut("slow");
           var getParse = JSON.parse(json);
            var ar=getParse[0];
            console.log(getParse.length);
            
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
			"-" 
			+ slot_totime + 
			"</span><br/><span class='grey-text text-darken-3'>" 
			+ duration + 
			"</span><br/>" 
			+ department + 
			"</p></div>");
	}
}
	else
	{
		$("#slot-details").append("No Data Available");
	}

        }

		});
		});

function convertTime(time) {

    var hours = Number(time.match(/^(\d\d?)/)[1]);
    var minutes = Number(time.match(/:(\d\d?)/)[1]);
    var AMPM = time.match(/\s(.AM|PM)$/i)[1];

    if (AMPM == 'PM' || AMPM == 'pm' && hours<12) 
    {
        hours = hours+12;
    }
    else if (AMPM == 'AM' || AMPM == "am" && hours==12)
    {
        hours = hours-12;
    }

    var sHours = hours.toString();
    var sMinutes = minutes.toString();

    if(hours<10)
    {
        sHours = "0" + sHours;
    }
    else if(minutes<10) {
        sMinutes = "0" + sMinutes;
    }

    return sHours + ":" + sMinutes; 

}

</script>
