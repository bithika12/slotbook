<script type="text/javascript">
/*
* Ajax slot request submit
*/
$(document).ready(function() {
    //loadResults(0);
    $(window).scroll(function(){
        
        if ( $(".preloader").hasClass("hidden") ) {
            if($(window).scrollTop() == $(document).height() - $(window).height()) {
                var limitStart = $("#list_slots li").length;
                console.log(limitStart);
                loadResults(limitStart);
            }
        }
    });

    //called function for Ajax
    function loadResults(limitStart) {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        $.ajax({
            url: {!! json_encode(url('/slot/list/fetch')) !!},
            type: "GET",
            dataType: "json",
            beforeSend: function(json) {
			    setTimeout(function() {$(".preloader").removeClass("hidden");}, 2000);
		    },
            data: {
                'limitStart' : limitStart
            },
            success: function(data) {
                console.log(data);
                $.each(data, function(index, json) {
                    var id=base64.encode(encodeURI(json.slot_id));
                    if(json.created_by == {!! json_encode(Auth::user()->id)!!}){

		  $("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
		  	+ json.slot_date +
		  	"|"
		  	+ json.slot_fromtime +
		  	"-"
		  	+ json.slot_totime +"</span>"
            +(json.status  == 2 ?   
		  	"<i class='relative material-icons green-text text-accent-4'>done</i>" : "")+(json.status  != 4 && json.slot_date  >= date?
"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>":"")+(json.status  == 4?
"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+"<p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href='"+ {!! json_encode('/slot/edit','+ Base64.encode(encodeURI(json.slot_id)) +')!!}+ "'> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href=''> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"</li>"
		  	);

		  }
		  else if({!! json_encode(Auth::user()->role)!!} == 1){

		  	$("#list_slots").prepend("<li class='collection-item avatar'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
		  	+ json.slot_date +
		  	" | "
		  	+ json.slot_fromtime +
		  	" - "
		  	+ json.slot_totime +"</span>"
            +(json.status  == 2 ?  
		  	"<i class='relative material-icons green-text text-accent-4'>done</i>" : "")+(json.status  != 4 && json.slot_date  >= date?
"<a class='red-text text-accent-3 mod-action link cancel' href='#!' onclick='slot_cancel("+ json.slot_id + ");'><i class='material-icons tiny relative'>close</i> Cancel Request </a>":"")+(json.status  == 4?
"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+(json.status  != 4 && json.status  != 2?
"<a onclick='need_approv("+ json.slot_id + ");' class='orange-text mod-action' href='#!'> <i class='material-icons tiny relative'>warning</i> Need Approval </a>": "")+"<p class='blue-grey-text text-darken-4'>"
				+ json.slot_desc + "<br><br/><span class='blue-grey lighten-5 small-font bolder'>"+ json.department +"</span></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"</li>"
		  	);

		  }
		  else
		  {
		  	$("#list_slots").prepend("<h6 class='red-text text-accent-1 center-align'>You have not created any slot yet.</h6>");
		  }

                });
               setTimeout(function() {$(".preloader").addClass("hidden");},2000);    
            }
        });
    };
});

</script>