<script>
  $("#booking_type").select2();   
  function all_bookings_report_filter(report){
    
    $('#div_report_content1').append('<div class="loader"></div>');
    var base_url = $('#base_url').val();
    if(report=="B2B Booking"){
      $.get( base_url+"view/b2b_sale/summary/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Group Tour"){
      $.get( base_url+"view/booking/summary/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Package Tour"){
      $.get( base_url+"view/package_booking/summary/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Visa Booking"){
      $.get( base_url+"view/visa_passport_ticket/visa/payment_status/index.php" , { } , function ( data ) {               
                $("#div_report_content1").html( data ) ;

            });
    }
    if(report=="Flight Booking"){
      $.get( base_url+"view/visa_passport_ticket/ticket/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Train Booking"){
      $.get( base_url+"view/visa_passport_ticket/train_ticket/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Hotel Booking"){
      $.get( base_url+"view/hotels/booking/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Bus Booking"){
      $.get( base_url+"view/bus_booking/booking/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Car Rental Booking"){
      $.get( base_url+"view/car_rental/summary/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Passport Booking"){
      $.get( base_url+"view/visa_passport_ticket/passport/payment_report/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Forex Booking"){
      $.get( base_url+"view/forex/booking/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Excursion Booking"){
      $.get( base_url+"view/excursion/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
    if(report=="Miscellaneous Booking"){
      $.get( base_url+"view/miscellaneous/payment_status/index.php" , { } , function ( data ) {
                $("#div_report_content1").html( data ) ;
            });
    }
  }

</script>
<div class="col-md-3 col-sm-6 mg_tp_20">
  <select style="width:100%;" id="booking_type" name="booking_type" onchange="all_bookings_report_filter(this.value)"> 
      <option value="Group Tour">Group Tour</option>
      <option value="Package Tour">Package Tour</option>
      <option value="Visa Booking">Visa</option>
      <option value="Flight Booking">Flight</option>
      <option value="Train Booking">Train</option>
      <option value="Hotel Booking">Hotel</option>
      <option value="Bus Booking">Bus</option>
      <option value="Car Rental Booking">Car Rental</option>
      <option value="Passport Booking">Passport</option>
      <option value="Forex Booking">Forex</option>
      <option value="Excursion Booking">Activity</option>
      <option value="Miscellaneous Booking">Miscellaneous</option>
      <option value="B2B Booking">B2B</option>
  </select>
</div>
<div id="div_report_content1" class="main_block loader_parent">
  <script type="text/javascript">all_bookings_report_filter('Group Tour');</script>
</div>
