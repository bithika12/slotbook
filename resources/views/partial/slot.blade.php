<script type="text/javascript">

    /* 
    * Ajax slot request submit
    */
    $("#request_btn").click(function(e){

      e.preventDefault();
      var get_cal_from_time = converttimeformat($("#slot_from_time").val());
      var get_cal_to_time = converttimeformat($("#slot_to_time").val());
      //console.log(get_cal_from_time,get_cal_to_time);
      $.ajax({
        type: "POST",
        url: {!! json_encode(url('/slot/save')) !!},
        data: {
          '_token': $("input[name='_token']").val(),
          'slot_date' : $("input[name='slot_date']").val(),
          'slot_from_time' : get_cal_from_time,
          'slot_to_time' : $get_cal_to_time,
          'description' : $("input[name='description']").val(),
          'prior_status' : $("input[name='prior_status']").val(),
          'no_of_joinee' : $("input[name='no_of_joinee']").val()
        },
        dataType : "json",
        success : function(json) {
          alert(json);
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
