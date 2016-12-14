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
                  var Base64 = {


    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",


    encode: function(input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

        }

        return output;
    },


    decode: function(input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    _utf8_encode: function(string) {
        string = string.toString().replace(/\r\n/g, "\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if ((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    _utf8_decode: function(utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while (i < utftext.length) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if ((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i + 1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i + 1);
                c3 = utftext.charCodeAt(i + 2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}
                      
                     var encodedString = Base64.encode(json.id);
                    
                     var url = '{{ url("slot/edit", "id") }}';
                      url = url.replace('id', encodedString);

                      var repeat_url = '{{ url("slot/repeat", "id") }}';
                      repeat_url = repeat_url.replace('id', encodedString);
                          
                     
                      
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
"<a class='red-text text-accent-3 mod-action'> <i class='material-icons tiny relative'>close</i> Cancelled</a>": "")+"<p class='blue-grey-text text-darken-4'>"+ json.slot_desc +"<br><br/><a class='light-blue white-text mod-action modify link' href='"+ url +"'> <i class='material-icons tiny relative'>edit</i>Modify </a><a class='light-blue white-text margin-left-0-5x mod-action link repeat' href='"+ repeat_url +"'> <i class='material-icons tiny relative'>loop</i> Repeat </a></p>"+(json.prior_status  == 1 ? "<a href='#!' class='secondary-content'> <i class='material-icons red-text tooltipped' data-position='top' data-delay='50' data-tooltip='This slot is reserved on priority basis'>error</i></a>" : "") +"</li>"
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
