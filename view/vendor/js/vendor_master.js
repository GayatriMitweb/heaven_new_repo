function payment_for_data_load(estimate_type, for_id, offset='', estimate_type_id='')
{  
  var base_url = $('#base_url').val();
  var branch_status = $('#branch_status').val();
  $.post(base_url+'view/vendor/inc/payment_for_data_load.php', { estimate_type : estimate_type, offset : offset, estimate_type_id : estimate_type_id , branch_status : branch_status  }, function(data){
    console.log(data);
    $('#'+for_id).html(data);
  });
}
function get_supplier_costing(estimate_type_id,estimate_type,for_id)
{
    var base_url = $('#base_url').val();
    $.post(base_url+'view/vendor/inc/costing_check.php', { estimate_type : estimate_type, estimate_type_id : estimate_type_id }, function(data){    
    $('#'+for_id).val(data);
  });
}
function vendor_type_data_load(vendor_type, for_id, offset='', vendor_type_id='',page='other')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/vendor_type_data_load.php', { vendor_type : vendor_type, offset : offset, vendor_type_id : vendor_type_id ,page: page}, function(data){
    $('#'+for_id).html(data);   
  });
}
function vendor_type_data_load_p(vendor_type, for_id, vendor_type_id='')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/payment_for_purchases_supplier.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
function vendor_data_for_pay(vendor_type, for_id, vendor_type_id='')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/dashboard/multiple_invoice_payment/payment_for_purchases_supplier.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
function payment_for_purchases(vendor_type_id,vendor_type,for_id)
{
  var vendor_type_id = $('#'+vendor_type_id).val();
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/payment_for_purchases_load.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id,for_id : for_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
function payment_for_single_purch(vendor_type_id,vendor_type,for_id)
{
  var vendor_type_id = $('#'+vendor_type_id).val();
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/dashboard/multiple_invoice_payment/payment_for_purchases_load.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id,for_id : for_id }, function(data){
    $('#'+for_id).html(data);  
  });
}

function pay_amount_nullify(advance_amount,advance_nullify){
  var advance_amount = $('#'+advance_amount).val();
  var advance_nullify = $('#'+advance_nullify).val();

  if(parseFloat(advance_amount) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should not be more than Advance amount"); return false; }
}

function validate_estimate_vendor(estimate_id='', vendor_id, offset='')
{
  var estimate_type = $('#'+estimate_id).val();
  var vendor_type = $('#'+vendor_id).val();

  if(estimate_id!=""){    

    if(estimate_type=="Group Tour"){
      var tour_group_id = $('#tour_group_id'+offset).val();
      if(tour_group_id==""){
        error_msg_alert("Please select tour group");
        return false;
      }
    }
    if(estimate_type=="Package Tour"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select package booking");
        return false;
      }
    }
    if(estimate_type=="Car Rental"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select car rental booking");
        return false;
      }
    }
    if(estimate_type=="Visa Booking"){
      var booking_id = $('#visa_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select visa booking");
        return false;
      }
    }
    if(estimate_type=="Passport Booking"){
      var booking_id = $('#passport_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select passport booking");
        return false;
      }
    }
    if(estimate_type=="Ticket Booking"){
      var booking_id = $('#ticket_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select ticket booking");
        return false;
      }
    }
    if(estimate_type=="Train Ticket Booking"){
      var booking_id = $('#train_ticket_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select ticket booking");
        return false;
      }
    }
    if(estimate_type=="Hotel Booking"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select hotel booking");
        return false;
      }
    }

    if(estimate_type=="Bus Booking" || estimate_type=="Forex Booking" || estimate_type=="Miscellaneous Booking"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select "+estimate_type);
        return false;
      }
    }

  }

  if(vendor_id!=""){ 


    if(vendor_type=="Hotel Vendor"){
      var hotel_id = $('#hotel_id'+offset).val();
      if(hotel_id==""){
        error_msg_alert("Please select hotel");
        return false;
      }
    }
    if(vendor_type=="Transport Vendor"){
      var transport_agency_id = $('#transport_agency_id'+offset).val();
      if(transport_agency_id==""){
        error_msg_alert("Please select transport");
        return false;
      }
    }    
    if(vendor_type=="DMC Vendor"){
      var dmc_id = $('#dmc_id'+offset).val();
      if(dmc_id==""){
        error_msg_alert("Please select car rental vendor");
        return false;
      }
    }
    if(vendor_type=="Car Rental Vendor" || vendor_type=="Visa Vendor" || vendor_type=="Passport Vendor" || vendor_type=="Ticket Vendor" || vendor_type=="Train Ticket Vendor" || vendor_type=="Itinerary Vendor" || vendor_type=="Insurance Vendor" || vendor_type=="Other Vendor"){
      var vendor_id = $('#vendor_id'+offset).val();
      if(vendor_id==""){
        error_msg_alert("Please select "+vendor_type);
        return false;
      }
    }    

  }

  return true;
}

function get_estimate_type_id(estimate_id, offset='')
{

  var estimate_type = $('#'+estimate_id).val();
  
  if(estimate_type=="Group Tour"){
    var tour_group_id = $('#tour_group_id'+offset).val();
    return tour_group_id;
  }
  else if(estimate_type=="Package Tour"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Car Rental"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Visa Booking"){
    var visa_id = $('#visa_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Passport Booking"){
    var visa_id = $('#passport_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Ticket Booking"){
    var visa_id = $('#ticket_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Train Ticket Booking"){
    var visa_id = $('#train_ticket_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Hotel Booking"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Bus Booking" || estimate_type=="Forex Booking" ){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Miscellaneous Booking"){
    var misc_id = $('#misc_id'+offset).val();   
 
    return misc_id;
  }
  else if(estimate_type=="Excursion Booking"){
    var exc_id = $('#exc_id'+offset).val();    
    return exc_id;
  }
  else if(estimate_type=="B2B Booking"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Other Booking"){
    return '';
  }
  else{
    return '';
  }
}

function get_vendor_type_id(vendor_id, offset='')
{
  var vendor_type = $('#'+vendor_id).val();

  if(vendor_type=="Hotel Vendor"){
    var hotel_id = $('#hotel_id'+offset).val();
    return hotel_id;
  }
  else if(vendor_type=="Transport Vendor"){
    var transport_agency_id = $('#transport_agency_id'+offset).val();
    return transport_agency_id;
  }
  else if(vendor_type=="Car Rental Vendor"){
    var vendor_id = $('#vendor_id'+offset).val();
    return vendor_id;
  }
  else if(vendor_type=="DMC Vendor"){
    var dmc_id = $('#dmc_id'+offset).val();
    return dmc_id;
  }
  else if(vendor_type=="Cruise Vendor"){
    var cruise_id = $('#cruise_id'+offset).val();
    return cruise_id;
  }
  else if(vendor_type=="Visa Vendor" || vendor_type=="Passport Vendor" || vendor_type=="Ticket Vendor" || vendor_type=="Train Ticket Vendor" || vendor_type=="Excursion Vendor" || vendor_type=="Insurance Vendor" || vendor_type=="Other Vendor"){
    var vendor_id = $('#vendor_id'+offset).val();
    return vendor_id;
  }  
  else{
    return '';
  }
}