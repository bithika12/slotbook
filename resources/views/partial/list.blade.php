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
                  var Base64=
                  {
                    _keyStr:
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
                    encode:function(e){
                      var t="";
                      var n,r,i,s,o,u,a;
                      var f=0;
                      e=Base64._utf8_encode(e);
                      while(f<e.length){
                        n=e.charCodeAt(f++);
                        r=e.charCodeAt(f++);
                        i=e.charCodeAt(f++);
                        s=n>>2;
                        o=(n&3)<<4|r>>4;
                        u=(r&15)<<2|i>>6;
                        a=i&63;
                        if(isNaN(r)){
                          u=a=64}
                          else if(isNaN(i)){
                            a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
                      var string = 'Hello World!';
                      var encodedString = Base64.encode(string);
                      var id=json.id;
                      var deletePostUri ={!! json_encode(url('/slot/edit','"+ id +"')) !!};
                      //console.log(deletePostUri);
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
"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+"<p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href='"+ deletePostUri +"'> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href=''> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"</li>"
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
		  	$("#list_slots").prepend("<h6 class='red-text text-accent-1 center-align'>No Results Found.</h6>");
		  }

                });
               setTimeout(function() {$(".preloader").addClass("hidden");},2000);
            }
        });
    };
});

</script>
