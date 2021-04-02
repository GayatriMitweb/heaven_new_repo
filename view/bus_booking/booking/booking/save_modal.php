<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<form id="frm_save">
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="hotel_sc" name="hotel_sc">
<input type="hidden" id="hotel_markup" name="hotel_markup">
<input type="hidden" id="hotel_taxes" name="hotel_taxes">
<input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes">
<input type="hidden" id="hotel_tds" name="hotel_tds">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document" style="width: 60%">
    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Booking</h4>
      </div>
      <div class="modal-body">

        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
            <legend>Customer Details</legend>

            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
                <select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="customer_info_load();get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount');">
                <?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status);?>
                </select>
              </div>
              <div id="new_cust_div"></div>
              <div id="cust_details">      
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
                  <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" title="Mobile No" readonly>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
                  <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
                </div> 
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <input type="text" id="credit_amount" class="hidden" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
                </div>
            </div>
          </div>
        </div>

        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

            <legend>Bus Details</legend>

            <div class="row mg_bt_10">
                <div class="col-xs-12 text-right">

                  <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_bus_booking')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                  <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_bus_booking')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                    <table id="tbl_dynamic_bus_booking" name="tbl_dynamic_bus_booking" class="table table-bordered no-marg" style="width:1300px;">
                      <?php $update_form = false; ?>
                      <?php include_once('bus_booking_tbl.php'); ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
            <legend>Costing Details</legend>
            <div class="row mg_bt_10">

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small id="basic_show" style="color:#000000">&nbsp;</small>
                <input type="text" id="basic_cost" name="basic_cost" placeholder="*Amount" title="Amount" onchange="calculate_total_amount();get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','basic','basic');validate_balance(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small id="service_show" style="color:#000000">&nbsp;</small>
                <input type="text" id="service_charge" name="service_charge" placeholder="*Service Charge" title="Service Charge"  onchange="calculate_total_amount();validate_balance(this.id);get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount')">
              </div>   
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small>&nbsp;</small>
                <input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="*Tax Amount" title="Tax Amount" readonly>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <small id="markup_show" style="color:#000000">&nbsp;</small>
                <input type="text" id="markup" name="markup" placeholder="Markup " title="Markup" onchange="calculate_total_amount();get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','markup','discount');validate_balance(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <small>&nbsp;</small>
                  <input type="text" id="service_tax_markup" name="service_tax_markup" placeholder="*Tax on Markup" title="Tax on Markup" readonly>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <small>&nbsp;</small>
                <input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" readonly>
              </div> 
              <div class="col-md-4 col-sm-6 col-xs-12 mg_tp_10 mg_bt_10">
                <input type="text" id="net_total" class="amount_feild_highlight text-right" name="net_total" placeholder="*Net Total" title="Net Total" readonly>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_tp_10">
                <input type="text" name="balance_date" id="balance_date" value="<?= date('d-m-Y') ?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount',true);">
              </div>
        </div>
        </div>

        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
            <legend>Advance Details</legend>
              <div class="row mg_bt_10">
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="payment_date" name="payment_date" placeholder="Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount',true);get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
                    <?php get_payment_mode_dropdown(); ?>
                  </select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="payment_amount_validate(this.id,'payment_mode','transaction_id', 'bank_name','bank_id');validate_balance(this.id);get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');">
                </div>
              </div>

              <div class="row mg_bt_10">
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <input class="hidden" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','payment_mode','credit_card_details')" title="Identifier(4 digit)" required
                  ><option value=''>Select Identifier</option></select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <input class="hidden" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
                </div>
              </div>
              <div class="row mg_bt_10">
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                  <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" class="bank_suggest" title="Bank Name" readonly>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                  <input type="text" id="transaction_id" onchange="validate_specialChar(this.id);" name="transaction_id" placeholder="Cheque No/ID" title="Cheque No/ID" readonly>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                        <select name="bank_id" id="bank_id" title="Select Bank" disabled>
                          <?php get_bank_dropdown(); ?>
                        </select>
                </div>
              </div>

          <div class="row">
            <div class="col-md-9 col-sm-9">
             <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
           </div>
          </div>



        </div>



        <div class="row text-center">

          <div class="col-md-12">

            <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

          </div>

        </div>



      </div>

    </div>

  </div>

</div>



</form>



<script>

$('#save_modal').modal('show');

$('#customer_id').select2();

$('#payment_date,#balance_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#journey_date').datetimepicker({ format:'d-m-Y H:i:s' });



$('#frm_save').validate({

    rules:{

            customer_id : { required : true },

            balance_date : { required:true},

            basic_cost : { required : true },

            service_charge : { required : true },

            net_total : { required : true },

            payment_date : { required : true },

            payment_amount : { required : true, number: true },

            payment_mode : { required : true },

            bank_name : { required : function(){  if($('#payment_mode').val()!="Cash" && $('#payment_amount').val() != '0'){ return true; }else{ return false; }  }  },

            transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     

            bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },  

    },
    submitHandler:function(){
          var base_url = $('#base_url').val();
          var customer_id = $('#customer_id').val();
          var first_name = $('#cust_first_name').val();
          var cust_middle_name = $('#cust_middle_name').val();
          var cust_last_name = $('#cust_last_name').val();
          var gender = $('#cust_gender').val();
          var birth_date = $('#cust_birth_date').val();
          var age = $('#cust_age').val();
          var contact_no = $('#cust_contact_no').val();
          var email_id = $('#cust_email_id').val();
          var address = $('#cust_address1').val();
          var address2 = $('#cust_address2').val();
          var city = $('#city').val();
          var service_tax_no = $('#cust_service_tax_no').val();  
          var landline_no = $('#cust_landline_no').val();
          var alt_email_id = $('#cust_alt_email_id').val();
          var company_name = $('#corpo_company_name').val();
          var cust_type = $('#cust_type').val();
          var country_code = $('#country_code').val();
          var state = $('#cust_state').val();
          var active_flag = 'Active';
          var branch_admin_id = $('#branch_admin_id1').val();
          var credit_amount = $('#credit_amount').val();
          var credit_charges = $('#credit_charges').val();
          var credit_card_details = $('#credit_card_details').val();

          //New Customer save
          if(customer_id == '0'){
              $.ajax({
                  type: 'post',
                  url: base_url+'controller/customer_master/customer_save.php',
                  data:{ first_name : first_name, middle_name : cust_middle_name, last_name : cust_last_name, gender : gender, birth_date : birth_date, age : age, contact_no : contact_no, email_id : email_id, address : address,address2 : address2,city:city,  active_flag : active_flag ,service_tax_no : service_tax_no, landline_no : landline_no, alt_email_id : alt_email_id,company_name : company_name, cust_type : cust_type,state : state, branch_admin_id : branch_admin_id, country_code : country_code},
                  success: function(result){
                  }
              });
          }

          //Bus save
          var emp_id = $('#emp_id').val();
          var basic_cost = $('#basic_cost').val();
          var service_charge = $('#service_charge').val();
          var taxation_type = $('#taxation_type').val();
          var taxation_id = $('#taxation_id').val();
          var service_tax = $('#service_tax').val();
          var service_tax_subtotal = $('#service_tax_subtotal').val();
          var net_total = $('#net_total').val();
          var balance_date = $('#balance_date').val();

          var payment_date = $('#payment_date').val();
          var payment_amount = $('#payment_amount').val();
          var payment_mode = $('#payment_mode').val();
          var bank_name = $('#bank_name').val();
          var transaction_id = $('#transaction_id').val();  
          var bank_id = $('#bank_id').val();    
          var hotel_sc = $('#hotel_sc').val();
          var hotel_markup = $('#hotel_markup').val();
          var hotel_taxes = $('#hotel_taxes').val();
          var hotel_markup_taxes = $('#hotel_markup_taxes').val();
          var hotel_tds = $('#hotel_tds').val();
          var markup = $('#markup').val();
          var service_tax_markup = $('#service_tax_markup').val();
         
        var roundoff = $('#roundoff').val();
          var reflections = [];
          reflections.push({
            'hotel_sc':hotel_sc,
            'hotel_markup':hotel_markup,
            'hotel_taxes':hotel_taxes,
            'hotel_markup_taxes':hotel_markup_taxes,
            'hotel_tds':hotel_tds
          });
          var bsmValues = [];
          bsmValues.push({
          "basic" : $('#basic_show').find('span').text(),
          "service" : $('#service_show').find('span').text(),
          "markup" : $('#markup_show').find('span').text(),
          "discount" : $('#discount_show').find('span').text()
          });

          if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; }
          
          var company_name_arr = new Array();

          var bus_type_arr = new Array();

          var bus_type_new_arr = new Array();

          var pnr_no_arr = new Array();

          var origin_arr = new Array();

          var destination_arr = new Array();

          var date_of_journey_arr = new Array();

          var reporting_time_arr = new Array();

          var boarding_point_access_arr = new Array();

          if(credit_amount != ''){ 
            if(parseFloat(payment_amount) > parseFloat(credit_amount)) { error_msg_alert('Low Credit note balance'); return false; }
          }
          var msg = "";
          var table = document.getElementById("tbl_dynamic_bus_booking");
          var rowCount = table.rows.length;
          for(var i=0; i<rowCount; i++)
          {
            var row = table.rows[i];
            if(rowCount == 1){
              if(!row.cells[0].childNodes[0].checked){
                error_msg_alert("Atleast one Bus details is required!");
                return false;
              }
            }
          
            if(row.cells[0].childNodes[0].checked)
            {                 
                var company_name = row.cells[2].childNodes[0].value;

                var bus_type = row.cells[3].childNodes[0].value;

                var bus_type_new = row.cells[4].childNodes[0].value; 

                var pnr_no = row.cells[5].childNodes[0].value;

                var origin = row.cells[6].childNodes[0].value;

                var destination = row.cells[7].childNodes[0].value;

                var date_of_journey = row.cells[8].childNodes[0].value;

                var reporting_time = row.cells[9].childNodes[0].value;

                var boarding_point_access = row.cells[10].childNodes[0].value;                  

                if(company_name == ''){
                  error_msg_alert("Enter Company name at row "+(i+1));
                  return false;
                }


                company_name_arr.push(company_name);

                bus_type_arr.push(bus_type);

                bus_type_new_arr.push(bus_type_new);

                pnr_no_arr.push(pnr_no);

                origin_arr.push(origin);

                destination_arr.push(destination);

                date_of_journey_arr.push(date_of_journey);

                reporting_time_arr.push(reporting_time);

                boarding_point_access_arr.push(boarding_point_access);
            }      
          }



          if(msg!=""){

            error_msg_alert(msg);

            return false;

          }



          
				//Validation for booking and payment date in login financial year
        $('#btn_save').button('loading');
				var check_date1 = $('#balance_date').val();
				$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
					if(data !== 'valid'){
						error_msg_alert("The Booking date does not match between selected Financial year.");
            $('#btn_save').button('reset');
						return false;
					}else{
						var payment_date = $('#payment_date').val();
						$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
						if(data !== 'valid'){
							error_msg_alert("The Payment date does not match between selected Financial year.");
              $('#btn_save').button('reset');
							return false;
						}else{
              $('#btn_save').button('loading');

              if($('#whatsapp_switch').val() == "on") whatsapp_send(emp_id, customer_id, balance_date, base_url);
    
              $.ajax({
                type: 'post',
                url: base_url+'controller/bus_booking/booking/booking_save.php',
                data:{ emp_id : emp_id,customer_id : customer_id, basic_cost : basic_cost, service_charge : service_charge, taxation_type : taxation_type, taxation_id : taxation_id, service_tax : service_tax, service_tax_subtotal : service_tax_subtotal, net_total : net_total, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, company_name_arr : company_name_arr, bus_type_arr : bus_type_arr,bus_type_new_arr : bus_type_new_arr, pnr_no_arr : pnr_no_arr, origin_arr : origin_arr, destination_arr : destination_arr, date_of_journey_arr : date_of_journey_arr, reporting_time_arr : reporting_time_arr, boarding_point_access_arr : boarding_point_access_arr, balance_date : balance_date, branch_admin_id : branch_admin_id,reflections:reflections,service_tax_markup:service_tax_markup,markup:markup,bsmValues:bsmValues,roundoff:roundoff,credit_charges:credit_charges,credit_card_details:credit_card_details},

                success: function(result){
                  var msg =result.split('--');
                  if(msg[0]=='error'){
                    $('#btn_save').button('reset');
                    error_msg_alert(msg[1]);
                    return false;
                  }else{
                    $('#btn_save').button('reset');
                    msg_alert(result);
                    $('#save_modal').modal('hide');
                    list_reflect();
                  }
                }

              });
							}
						});
					}
				});



  }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>