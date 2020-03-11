if (/Mobi/.test(navigator.userAgent)) {
    // if mobile device, use native pickers
    $(".date-time input").attr("type", "datetime-local");
    $(".date input").attr("type", "date");
    $(".time input").attr("type", "time");
  } else {
    // if desktop device, use DateTimePicker

    $("#timepicker").datetimepicker({
      format: "LT",
      icons: {
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down"
      }
    });
  }
  