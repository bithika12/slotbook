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
                    $("#list_slots").append("<li class='collection-item avatar animated fadeIn</fad>'><i class='material-icons circle grey lighten-1'>today</i><span class='title black-text'>"
			 + json.slot_date +
			 "|"
			 + json.start_time +
			 "-"
			 + json.end_time +
			 "</span><a class='red-text text-accent-3 mod-action link cancel' href='#!'><i class='material-icons tiny relative'>close</i> Cancel Request </a><p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href=''> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href=''> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on prior basis'>error</i> </a>" : "") +"</li>");
                });
               setTimeout(function() {$(".preloader").addClass("hidden");},2000);    
            }
        });
    };
});

</script>