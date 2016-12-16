<script type="text/javascript">

	var socket = io.connect('http://' + window.location.hostname + ':3000');
	socket.on('approve_slot', function(json) {
		$('.mess').html("<b>New Slot Added");
         
		$("#slot-details").append("<div class='card-panel col s12 m3 offset-m1 border-blue white  no-box-shadow slot-box left-origin'>"
		+(json.prior_status  == 1 ? "<i class='small material-icons red-text text-lighten-1 prior-check absolute tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i>" : "") +
		"<i class='medium material-icons blue-text text-lighten-1'>query_builder</i><p class='slot-time-range blue-grey-text'><span class='black-text'>"+ json.start_time +"-"+ json.end_time +"</span><br/><span class='grey-text text-darken-3'>"
		+ json.duration +"minutes</span><br/>"+ json.department +"</p></div>");
         //location.reload();
			});</script>
