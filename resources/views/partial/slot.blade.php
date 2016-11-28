<script type="text/javascript">
    $("#request_btn").click(function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: {!! json_encode(url('/slot/save')) !!},
        data: {
          '_token': $("input[name='_token']").val(),
          'slot_date' : $("input[name='slot_date']").val(),
          'slot_from_time' : $("input[name='slot_from_time']").val(),
          'slot_to_time' : $("input[name='slot_to_time']").val(),
          'description' : $("input[name='description']").val(),
          'no_of_joinee' : $("input[name='no_of_joinee']").val()
        },
        dataType : "json",
        success : function(json) {
          alert(json);

        }
      });
    });
  </script>
