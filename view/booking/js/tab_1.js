function customer_info_load(div_id,offset=''){
  var customer_id = $('#'+div_id).val();
  $.ajax({
    type:'post',
    url:'../inc/customer_info_load.php',
    dataType:'json',
    data:{ customer_id : customer_id },
    success:function(result){
      $('#txt_m_mobile_no'+offset).val(result.contact_no);
      $('#txt_m_email_id'+offset).val(result.email_id);
      $('#txt_m_address'+offset).val(result.address);
      if(result.company_name != ''){
        $('#company_name'+offset).removeClass('hidden');
        $('#company_name'+offset).val(result.company_name); 
      }
      else{
        $('#company_name'+offset).addClass('hidden');
      }
      if(result.payment_amount != '' || result.payment_amount != '0'){
        $('#credit_amount'+offset).removeClass('hidden');
        $('#credit_amount'+offset).val(result.payment_amount);  
      }
      else{
        $('#credit_amount'+offset).addClass('hidden');
      }
    }
  });
}

$('#frm_tab_1').validate({
    rules:{
            taxation_type: { required : true },
            customer_id_p: { required : true },
            cmb_tour_name: { required:true }, 
            cmb_tour_group: { required:true },
    },
    submitHandler:function(form){

         var count = 0;
         var err_msg = "";
         var passport_no_arr = new Array();
         var tour_type = $('#tour_type_r').val();

         var operation = $("#operation").val();
         var available_seats = $("#txt_available_seats").val();
         var total_pax = $("#txt_stay_total_seats").val();

         var customer_id= $('#customer_id_p').val();
         if(customer_id == ''){ error_msg_alert("Select Customer!");return false;}
          var entry_id_array = new Array();
          var table = document.getElementById("tbl_member_dynamic_row");
          var rowCount = table.rows.length;
          for(var i=0; i<rowCount; i++)
          {
            var row = table.rows[i];
            if(row.cells[0].childNodes[0].checked)
            {  
              var first_name = row.cells[3].childNodes[0].value;
              var birth_date1 = row.cells[7].childNodes[0];
              var age = row.cells[8].childNodes[0].value;
              var adolescence = row.cells[9].childNodes[0].value;
              var passport_no = row.cells[10].childNodes[0].value;
              var passport_issue_date = row.cells[11].childNodes[0].value;              
              var passport_expiry_date = row.cells[12].childNodes[0].value;
              if(row.cells[13]){
                (row.cells[13].childNodes[0].value=='')?entry_id_array.push(row.cells[13].childNodes[0].value):'';
              }
              if(row.cells[0].childNodes[0].checked && tour_type=='International')
                {
                  if (row.cells[10].childNodes[0].value == '') {
                    err_msg += 'Enter traveller Passport no in row-' + (i + 1) + '<br>';
                  }
                  if (row.cells[11].childNodes[0].value == '') {
                    err_msg += 'Enter traveller Passport issue date in row-' + (i + 1) + '<br>';
                  }
                  if (row.cells[12].childNodes[0].value == '') {
                    err_msg += 'Enter traveller Passport expiry date in row-' + (i + 1) + '<br>';
                  }
                }
              passport_issue_date = php_to_js_date_converter(passport_issue_date);
              passport_expiry_date = php_to_js_date_converter(passport_expiry_date);

              var current_row = parseInt(i) + 1;
              if(!isInArray(passport_no, passport_no_arr) && passport_no!="" && passport_no!="Na" && passport_no!="NA"){ err_msg += "Passport no repeated in row"+current_row+"<br>"; }
              passport_no_arr.push(passport_no);

              if(first_name == ""){ err_msg += "Enter first name of traveller in row"+current_row+"<br>"; } 
              else if(!first_name.match(/^[A-z ]+$/)){ err_msg += "Enter valid first name of traveller in row"+current_row+"<br>";} 
              else if(!first_name.replace(/\s/g, '').length){ err_msg += "Enter valid first name of traveller in row"+current_row+"<br>";} 
             
              if(adolescence == ""){ err_msg += "Enter Proper birth-date in row"+current_row+"<br>"; }
              if(age == ""){ err_msg += "Enter Age in row"+current_row+"<br>"; }
              count++;
            } 
          }

          if(count == 0){
            error_msg_alert("Please select at least one travellers information.");
            return false;
          }
          if(operation=='save'){
            if(parseInt(available_seats)<parseInt(total_pax)){
              error_msg_alert('Only '+available_seats+' seats available!');
              return false;
            }
          }else{
            var new_count = entry_id_array.length;
            if(parseInt(available_seats)<parseInt(new_count)){
              error_msg_alert('Only '+available_seats+' seats available!');
              return false;
            }
          }
          if(err_msg!=""){
            error_msg_alert(err_msg, 10000);
            return false;
          }

          $('#tab_1_head').addClass('done');
          $('#tab_2_head').addClass('active');
          $('.bk_tab').removeClass('active');
          $('#tab_2').addClass('active');
          $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
          return false;
    }
});
/*customer_info_load();*/