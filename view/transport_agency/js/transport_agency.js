$(document).ready(function() {
    //$("#cmb_city_id").select2();   
});

$(function(){
  $('.form-control').each(function(){
    var placeholder = $(this).attr('placeholder');
    $(this).attr('title', placeholder);
    $(this).tooltip({placement: 'bottom'});
  });
});

///////////////////////***Transport Agency Master save start*********//////////////
$(function(){
  $('#frm_transport_agency_save').validate({
    rules:{
            cmb_city_id : { required : true },
            txt_transport_agency_name : { required : true },
            txt_mobile_no : { required : true, number: true },
            txt_email_id : { email:true },
            txt_contact_person_name : { required : true },
            txt_transport_agency_address : { required : true },
    },
    submitHandler:function(form){

        var base_url = $("#base_url").val();
        var city_id = $("#cmb_city_id").val();

        var transport_agency_name = $("#txt_transport_agency_name").val();
        var mobile_no = $("#txt_mobile_no").val();
        var email_id = $("#txt_email_id").val();
        var contact_person_name = $("#txt_contact_person_name").val();
        var transport_agency_address = $("#txt_transport_agency_address").val();       

        $.post( 
               base_url+"controller/group_tour/transport_agency/transport_agency_master_c.php",
               {  city_id : city_id, transport_agency_name : transport_agency_name, mobile_no : mobile_no, email_id : email_id, contact_person_name : contact_person_name, transport_agency_address : transport_agency_address },
               function(data) {  
                      msg_alert(data);  
                      reset_form('frm_transport_agency_save');                    
               });
    }
  });
});
///////////////////////***Transport Agency Master save end*********//////////////

///////////////////////***Transport Agency Master Update start*********//////////////
$(function(){
  $('#frm_transport_agency_update').validate({
    rules:{
            cmb_city_id : { required : true },
            txt_transport_agency_name : { required : true },
            txt_mobile_no : { required : true, number: true },
            txt_email_id : { email:true },
            txt_contact_person_name : { required : true },
            txt_transport_agency_address : { required : true },
    },
    submitHandler:function(form){

        var base_url = $("#base_url").val();
        var transport_agency_id = $("#txt_transport_agency_id").val();
        var city_id = $("#cmb_city_id").val();

        var transport_agency_name = $("#txt_transport_agency_name").val();
        var mobile_no = $("#txt_mobile_no").val();
        var email_id = $("#txt_email_id").val();
        var contact_person_name = $("#txt_contact_person_name").val();
        var transport_agency_address = $("#txt_transport_agency_address").val();

        $.post( 
               base_url+"controller/group_tour/transport_agency/transport_agency_master_update_c.php",
               {  transport_agency_id : transport_agency_id, city_id : city_id, transport_agency_name : transport_agency_name, mobile_no : mobile_no, email_id : email_id, contact_person_name : contact_person_name, transport_agency_address : transport_agency_address },
               function(data) {  
                      msg_alert(data);  
               });
    }
  });
});
///////////////////////***Transport Agency Master Update end*********//////////////

//*******************Container Transport Agency start******************/////////////////////

  
  function shift_container_data(name)
  {        
      var arr = name.split("2");
      var from = arr[0];        
      var to = arr[1];      
      $("#" + from + " option:selected").each(function(){
         $("#" + to).append($(this).clone());
      $("#"+from+" option:selected").remove();
      });
  }

  
  function busselectAll1(chkObj)
  {
    var multi=document.getElementById('cmb_bus_list_left');
    
    if(chkObj.checked)
      for(i=0;i<multi.options.length;i++)
      multi.options[i].selected=true;
    else
      for(i=0;i<multi.options.length;i++)
      multi.options[i].selected=false;      
  }


    function busselectAll2(){
    
    //alert("tets");
      var multi=document.getElementById('cmb_bus_list_right');
      var chkObj = document.getElementById('chk_select_all');
      if(chkObj.checked)
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=true;
      else
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=false;      
      
    }

    function carselectAll1(chkObj)
    {
      var multi=document.getElementById('cmb_car_list_left');
      
      if(chkObj.checked)
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=true;
      else
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=false;      
    }


    function carselectAll2(){
    
    //alert("tets");
      var multi=document.getElementById('cmb_car_list_right');
      var chkObj = document.getElementById('car_chk_select_all');
      if(chkObj.checked)
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=true;
      else
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=false;      
      
    }
//*******************Container Transport Agency end******************/////////////////////