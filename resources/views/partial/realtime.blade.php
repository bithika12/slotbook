<script type="text/javascript">

/*
* Ajax slot request submit
*/

	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('new_slot', function(json) {
		console.log(json);
		alert(auth_user_role);
		$created_by=$('#created_by').val();
		$('.ajax-response.success').html("<b>New Slot Added");
		
		
	/* if($created_by==json.auth_user_id && auth_user_role==0){
		$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text slot-details'>"
		+ json.slot_date +"|"+ json.start_time +"-"+ json.end_time +"</span><a class='orange-text text-darken-2 mod-action' href='#!'><i class='material-icons tiny relative'>warning</i>Need Approval</a><p class='blue-grey-text text-darken-4'>Material icons are beautifully crafted, delightful, and easy to use in your web<br><br/><a class='blue accent-3 white-text mod-action modify link' href='#!'><i class='material-icons tiny relative'>edit</i>Change</a><a class='blue accent-3 white-text margin-left-0-5x mod-action trash link' href='#!'><i class='material-icons tiny relative'>delete</i> Trash</a><a class='blue accent-3 white-text margin-left-0-5x mod-action repeat link' href='#!'><i class='material-icons tiny relative'>loop</i> Repeat</a></p></li>"
		);
	}
	  elseif(auth_user_role==1){
			var html='';
			html+="<li class='collection-item avatar'>";
			html+="<i class='material-icons circle grey lighten-1'>today</i>";
			html+="<span class='title black-text slot-details'>";
			html+=+ json.slot_date +"|";
			html+=+ json.start_time +"-";
			html+=+ json.end_time +;
			html+="</span>";

			html+="<a class='orange-text text-darken-2 mod-action' href='#!'>";
			html+="<i class='material-icons tiny relative'>warning</i>";
			html+="Need Approval</a>";
			html+="<p class='blue-grey-text text-darken-4'>";
			html+=+ json.slot_desc +;
			html+="<br><br/>";
			html+="<span class='blue-grey lighten-5 small-font bolder'>";
			html+=+ json.department +;
			html+="</span>";
			html+="<a class='red-text text-accent-3 mod-action link cancel' href='#!'>";
			html+="<i class='material-icons tiny relative'>close</i> Cancel Request </a>";
			html+="</li>";
		  $("#list_slots").prepend(html);

	}*/
	});

	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('approve_slot', function(json) {
		


		$('.mess').html("<b>New Slot Added");
         $("#list_slots").empty();

		$("#slot-details").append("<div class='card-panel col s12 m3 offset-m1 border-blue white  no-box-shadow slot-box left-origin'>"
		+(json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on prior basis'>error</i>" : "") +
		"<i class='medium material-icons blue-text text-lighten-1'>query_builder</i><p class='slot-time-range blue-grey-text'><span class='black-text'>"+ json.start_time +"-"+ json.end_time +"</span><br/><span class='grey-text text-darken-3'>"
		+ json.duration +"minutes</span><br/>"+ json.department +"</p></div>");

		


		 if(json.created_by == {!! json_encode(Auth::user()->id)!!}){

		  $("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
		  	+ json.slot_date +
		  	"|"
		  	+ json.start_time +
		  	"-"
		  	+ json.end_time +
		  	"</span><i class='relative material-icons green-text text-accent-4'>done</i><p class='blue-grey-text text-darken-4'>Material icons are beautifully crafted, delightful, and easy to use in your web<br><br/><a class='blue accent-3 white-text mod-action modify link' href='#!'><i class='material-icons tiny relative'>edit</i>Change</a><a class='blue accent-3 white-text margin-left-0-5x mod-action trash link' href='#!'><i class='material-icons tiny relative'>delete</i> Trash</a><a class='blue accent-3 white-text margin-left-0-5x mod-action repeat link' href='#!'><i class='material-icons tiny relative'>loop</i> Repeat</a></p></li>"
		  	);
		  }
		  else if({!! json_encode(Auth::user()->role)!!} == 1){

		  	$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
		  	+ json.slot_date +
		  	"|"
		  	+ json.start_time +
		  	"-"
		  	+ json.end_time +
		  	"</span><i class='relative material-icons green-text text-accent-4'>done</i><p class='blue-grey-text text-darken-4'>Material icons are beautifully crafted, delightful, and easy to use in your web<br><br/><a class='blue accent-3 white-text mod-action modify link' href='#!'><i class='material-icons tiny relative'>edit</i>Change</a><a class='blue accent-3 white-text margin-left-0-5x mod-action trash link' href='#!'><i class='material-icons tiny relative'>delete</i> Trash</a><a class='blue accent-3 white-text margin-left-0-5x mod-action repeat link' href='#!'><i class='material-icons tiny relative'>loop</i> Repeat</a></p></li>"
		  	);

		  }
		  else
		  {
		  	$("#list_slots").prepend("<h6 class='red-text text-accent-1 center-align'>You have not created any slot yet.</h6>");
		  }
	});</script>
