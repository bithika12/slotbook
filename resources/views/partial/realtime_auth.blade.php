<script type="text/javascript">

/*
* Ajax slot request submit
*/
                 var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('new_slot', function(json) {
		$('.ajax-response.success').html("<b>New Slot Added");
		            var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var encodedString = json.encodeslot_id;
                    
                     var url = '{{ url("slot/edit", "id") }}';
                      url = url.replace('id', encodedString);

                      var repeat_url = '{{ url("slot/repeat", "id") }}';
                      repeat_url = repeat_url.replace('id', encodedString);
		if(json.created_by == {!! json_encode(Auth::user()->id) !!}){

					$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
					+ json.slot_date +
					"|"
					+ json.start_time +
					"-"
					+ json.end_time +"</span>"
					+(json.status  == 2 ?
					"<i class='relative material-icons green-text text-accent-4'>done</i>" : "")+(json.status!= 4 && json.slot_date >= date ?"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>" : "")+(json.status  == 4?
		"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+"<p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href='"+ url +"'> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href='"+ repeat_url +"'> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"</li>"
					);
         }
		 else if({!! json_encode(Auth::user()->role)!!} == 1){
                
	    if($('#list_slots').find('#hid_li_id'+json.slot_id).length > 0)  {
								//alert('exists');
				$('#hid_li_id'+json.slot_id).html("<i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
						+ json.slot_date +
						" | "
						+ json.start_time +
						" - "
						+ json.end_time +"</span>"
						+(json.status  == 2 ?
						"<i class='relative material-icons green-text text-accent-4'>done</i>" : "")+(json.status!= 4 && json.slot_date >= date ?"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>" : "")+(json.status  == 4?
			"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+(json.status  != 4 && json.status  != 2?
			"<a onclick='need_approv("+ json.slot_id + ");' class='orange-text mod-action' href='#!'> <i class='material-icons tiny relative'>warning</i> Need Approval </a>": "")+"<p class='blue-grey-text text-darken-4'>"
							+ json.slot_desc + "<br><br/><span class='blue-grey lighten-5 small-font bolder'>"+ json.department +"</span><span class='date ng-binding' am-time-ago='m.created_at'>1 minute ago</span></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"");
							}
		else{
				//alert('new');
				$('#list_slots').prepend("<li class='collection-item avatar'id='hid_li_id"+ json.slot_id +"'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
					+ json.slot_date +
					" | "
					+ json.start_time +
					" - "
					+ json.end_time +"</span>"
					+(json.status  == 2 ?
					"<i class='relative material-icons green-text text-accent-4'>done</i>" : "")+(json.status!= 4 && json.slot_date >= date ?"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>" : "")+(json.status  == 4?
		"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+(json.status  != 4 && json.status  != 2?
		"<a onclick='need_approv("+ json.slot_id + ");' class='orange-text mod-action' href='#!'> <i class='material-icons tiny relative'>warning</i> Need Approval </a>": "")+"<p class='blue-grey-text text-darken-4'>"
						+ json.slot_desc + "<br><br/><span class='blue-grey lighten-5 small-font bolder'>"+ json.department +"</span><span class='date ng-binding' am-time-ago='m.created_at'>1 minute ago</span></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"</li>"
					);
			}
                       
	
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
			 var today = new Date();
             var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
             var encodedString = json.encodeslot_id;
                    
             var url = '{{ url("slot/edit", "id") }}';
             url = url.replace('id', encodedString);

             var repeat_url = '{{ url("slot/repeat", "id") }}';
             repeat_url = repeat_url.replace('id', encodedString);

            
   if(json.created_by == {!! json_encode(Auth::user()->id)!!}){

	   if($('#list_slots').find('#hid_li_id'+json.slot_id).length > 0)  {
		    //alert('exists');
	       $('#hid_li_id'+json.slot_id).html("<i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
			+ json.slot_date +
			"|"
			+ json.start_time +
			"-"
			+ json.end_time +
			"<i class='relative material-icons green-text text-accent-4'>done</i>"+(json.status!= 4 && json.slot_date >= date ?"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>" : "")+(json.status  == 4?
		"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+"</span><p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href='"+ url +"'> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href='"+ repeat_url +"'> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : ""));
	   }
	  
    }
	else if({!! json_encode(Auth::user()->role)!!} == 1){
		var s = $('#list_slots').html();
                console.log(s);

           if($('#list_slots').find('#hid_li_id'+json.slot_id).length > 0)  {
			  //alert('exists');

			$('#hid_li_id'+json.slot_id).html("<i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
			+ json.slot_date +
			" | "
			+ json.start_time +
			" - "
			+ json.end_time +
			"<i class='relative material-icons green-text text-accent-4'>done</i>"+(json.status!= 4 && json.slot_date >= date ?"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>" : "")+(json.status  == 4?
		"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+"</span><p class='blue-grey-text text-darken-4'>"
			+ json.slot_desc + "<br><br/><span class='blue-grey lighten-5 small-font bolder'>"+ json.department +"</span></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "")
			);
	}
	
   }
  else{
		  	$("#list_slots").prepend("<h6 class='red-text text-accent-1 center-align'>You have not created any slot yet.</h6>");
	  }
           //location.reload();
	});
	</script>
