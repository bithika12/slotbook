<script type="text/javascript">

/*
* Ajax slot request submit
*/

	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('new_slot', function(json) {
		$('.ajax-response.success').html("<b>New Slot Added");
		if(json.created_by == {!! json_encode(Auth::user()->id) !!}){

		 $("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
			 + json.slot_date +
			 "|"
			 + json.start_time +
			 "-"
			 + json.end_time +
			 "</span><a class='red-text text-accent-3 mod-action link cancel' href='#!'><i class='material-icons tiny relative'>close</i> Cancel Request </a><p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href=''> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href=''> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i>" : "") +"</li>"
			 );

		 }
		 else if({!! json_encode(Auth::user()->role)!!} == 1){

			 $("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
			 + json.slot_date +
			 " | "
			 + json.start_time +
			 " - "
			 + json.end_time +
			 "</span><a class='red-text text-accent-3 mod-action link cancel' href='#!'><i class='material-icons tiny relative'>close</i> Cancel Request </a><a class='orange-text mod-action' href='#!'><i class='material-icons tiny relative'>warning</i> Need Approval </a><p class='blue-grey-text text-darken-4'>"
			 + json.slot_desc + "<br><br/><span class='blue-grey lighten-5 small-font bolder'>"+ json.department +"</span></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i> </a>" : "") +"</li>"
			 );

		 }
		 else
		 {
			 $("#list_slots").prepend("<h6 class='blank-slot-info red-text text-accent-1 center-align'>You have not created any slot yet.</h6>");
		 }
		 $(".blank-slot-info").remove();
	});


    /*
		*approve slot emit
		*/
	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('approve_slot', function(json) {
		$('.mess').html("<b>New Slot Added");
         $("#list_slots").empty();
		if(json.created_by == {!! json_encode(Auth::user()->id)!!}){

		  $("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
		  	+ json.slot_date +
		  	"|"
		  	+ json.start_time +
		  	"-"
		  	+ json.end_time +
		  	"<i class='relative material-icons green-text text-accent-4'>done</i></span><p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href=''> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href=''> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i>" : "") +"</li>"
		  	);

		  }
		  else if({!! json_encode(Auth::user()->role)!!} == 1){

		  	$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
		  	+ json.slot_date +
		  	" | "
		  	+ json.start_time +
		  	" - "
		  	+ json.end_time +
		  	"<i class='relative material-icons green-text text-accent-4'>done</i></span><p class='blue-grey-text text-darken-4'>"
				+ json.slot_desc + "<br><br/><span class='blue-grey lighten-5 small-font bolder'>"+ json.department +"</span></p>"+(json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i>" : "") +"</li>"
		  	);

		  }
		  else
		  {
		  	$("#list_slots").prepend("<h6 class='red-text text-accent-1 center-align'>You have not created any slot yet.</h6>");
		  }
      location.reload();
			});</script>
