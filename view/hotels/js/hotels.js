$(document).ready(function() {
    $("#cmb_city_id").select2();   
});

///////////////////////***Hotel Master Save start*********//////////////
$(function(){
  $('#frm_hotel_save').validate({
    rules:{
            cmb_city_id : { required: true },
            txt_hotel_name : { required: true },
            txt_mobile_no : { required: true, number: true },
            /*txt_email_id : { required: true, email:true },
            txt_contact_person_name : { required: true },
            txt_hotel_address : { required: true },*/
    },
    submitHandler:function(form){
      var base_url = $("#base_url").val();
      var city_id = $("#cmb_city_id").val();

      var hotel_name = $("#txt_hotel_name").val();
      var mobile_no = $("#txt_mobile_no").val();
      var landline_no = $('#txt_landline_no').val();
      var email_id = $("#txt_email_id").val();
      var contact_person_name = $("#txt_contact_person_name").val();
      var hotel_address = $("#txt_hotel_address").val();

      $.post( 
                   base_url+"controller/hotel/hotel_master_save_c.php",
                   { city_id : city_id, hotel_name : hotel_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, hotel_address : hotel_address },
                   function(data) {  
                        var msg = data.split('--');
                        if(msg[0]=="error"){
                          msg_alert(data);  
                        }
                        else{
                          msg_alert(data);  
                          reset_form('frm_hotel_save');  
                        }                       
                        
                   });
    }
  });
});
///////////////////////***Hotel Master Save ens*********//////////////

///////////////////////***Hotel Master Update start*********//////////////
$(function(){
  $('#frm_hotel_update').validate({
    rules:{
            cmb_city_id : { required: true },
            txt_hotel_name : { required: true },
            txt_mobile_no : { required: true, number: true },
            /*txt_email_id : { required: true, email:true },
            txt_contact_person_name : { required: true },
            txt_hotel_address : { required: true },*/
    },
    submitHandler:function(form){

      var hotel_id = $("#txt_hotel_id").val();

      var base_url = $("#base_url").val();
      var city_id = $("#cmb_city_id").val();

      var hotel_name = $("#txt_hotel_name").val();
      var mobile_no = $("#txt_mobile_no").val();
      var landline_no = $('#txt_landline_no').val();
      var email_id = $("#txt_email_id").val();
      var contact_person_name = $("#txt_contact_person_name").val();
      var hotel_address = $("#txt_hotel_address").val();

      $.post( 
                   base_url+"controller/hotel/hotel_master_update_c.php",
                   { hotel_id : hotel_id, city_id : city_id, hotel_name : hotel_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, hotel_address : hotel_address },
                   function(data) {  
                        msg_alert(data);
                   });
    }
  });
});
///////////////////////***Hotel Master Update end*********//////////////


//*******************Hotel list of city relect end******************/////////////////////