<?php

include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="forex_taxes" name="forex_taxes">
<input type="hidden" id="forex_sc" name="forex_sc">

<form id="frm_save">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

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

                <select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="customer_info_load();get_auto_values('balance_date','basic_cost','payment_mode','service_charge','save','true','service_charge');">

                 <?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status); ?>

                </select>

              </div>
              <div id="new_cust_div"></div>
              <div id="cust_details">     
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

                  <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>

                </div>              

                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

                  <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" title="Mobile No" readonly>

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



        <div class="panel panel-default panel-body app_panel_style forex_module feildset-panel mg_tp_30">

            <legend>Document Details</legend>

            

            <div class="row mg_bt_10 mg_tp_10">

              <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">

                <h6>Mandatory documents</h6>

                <div class="forex_chk">

                  <input type="checkbox" id="visa_manadatory_docs" name="manadatory_docs" value="Visa">

                  <label for="visa_manadatory_docs">Visa</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="air_ticket_manadatory_docs" name="manadatory_docs" value="Flight Ticket">

                  <label for="air_ticket_manadatory_docs">Flight Ticket</label>

                </div>

              </div>

              <div class="col-md-9 col-sm-8 col-xs-12 mg_bt_10">          

                <h6>Photo Proof Given</h6>

                <div class="forex_chk">

                  <input type="checkbox" id="passport_photo_proof" name="photo_proof_given" value="Passport">

                  <label for="passport_photo_proof">Passport</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="pan_card_photo_proof" name="photo_proof_given" value="Pan Card">

                  <label for="pan_card_photo_proof">Pan Card</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="voter_id_photo_proof" name="photo_proof_given" value="Voter Identity Card">

                  <label for="voter_id_photo_proof">Voter Identity Card</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="driving_photo_proof" name="photo_proof_given" value="Driving Licence">

                  <label for="driving_photo_proof">Driving Licence</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="adhar_card_photo_proof" name="photo_proof_given" value="Aadhaar Card">

                  <label for="adhar_card_photo_proof">Aadhaar Card</label>

                </div>



              </div>              

            </div>



            <div class="row">

              <div class="col-xs-12">

                <h6>Residence Proof</h6>

                <div class="forex_chk">

                  <input type="checkbox" id="telephone_bill_residence_proof" name="residence_proof" value="Telephone Bill">

                  <label for="telephone_bill_residence_proof">Telephone Bill</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="electricity_bill_residence_proof" name="residence_proof" value="Electricity Bill">

                  <label for="electricity_bill_residence_proof">Electricity Bill</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="ration_card_residence_proof" name="residence_proof" value="Ration Card">

                  <label for="ration_card_residence_proof">Ration Card</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="bank_passbook_residence_proof" name="residence_proof" value="Bank Passbook">

                  <label for="bank_passbook_residence_proof">Bank Passbook</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="bank_statement_residence_proof" name="residence_proof" value="Bank Statement">

                  <label for="bank_statement_residence_proof">Bank Statement</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="employer_letter_residence_proof" name="residence_proof" value="Employer Letter">

                  <label for="employer_letter_residence_proof">Employer Letter</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="employer_invitation_residence_proof" name="residence_proof" value="Employer Invitation">

                  <label for="employer_invitation_residence_proof">Employer Invitation</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="hotel_advance_residence_proof" name="residence_proof" value="Hotel Advance Receipt Voucher">

                  <label for="hotel_advance_residence_proof">Hotel Advance Receipt Voucher</label>

                </div>

                <div class="forex_chk">

                  <input type="checkbox" id="adhar_card_residence_proof" name="residence_proof" value="Aadhaar  Card">

                  <label for="adhar_card_residence_proof">Aadhaar  Card</label>

                </div>

              </div>

            </div>



        </div>



        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

            <legend>Costing Details</legend>



            <div class="row">

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <select name="booking_type" id="booking_type" title="Buy/Sale">

                  <option value="">*Buy/Sale</option>

                  <option value="Buy">Buy</option>

                  <option value="Sale">Sale</option>

                </select>

              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <select name="currency_code" id="currency_code" style="width:100%" title="Currency">
                <option value="">*Select Currency</option>
                  <?php 

                  $sq_currency = mysql_query("select * from currency_name_master order by default_currency desc");

                  while($row_currency = mysql_fetch_assoc($sq_currency)){

                    ?>

                    <option value="<?= $row_currency['currency_code'] ?>"><?= $row_currency['currency_code'] ?></option>

                    <?php

                  }

                  ?>

                </select>

              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <input type="text" id="rate" name="rate" placeholder="*Rate" title="Rate" onchange="calculate_total_amount(this.id);validate_balance(this.id)">

              </div>              

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small>&nbsp;</small>
                <input type="text" id="forex_amount" name="forex_amount" placeholder="*Forex Amount" title="Forex Amount" onchange="calculate_total_amount(this.id);validate_balance(this.id)">

              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small id="basic_show">&nbsp;</small>
                <input type="text" id="basic_cost" class="text-right" name="basic_cost" placeholder="Total" title="Total" onchange="calculate_total_amount(this.id);validate_balance(this.id);get_auto_values('balance_date','basic_cost','payment_mode','service_charge','save','true','basic','basic',true);" readonly>

              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                
                <small id="service_show">&nbsp;</small>
                <input type="text" id="service_charge" class="text-right" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="get_auto_values('balance_date','basic_cost','payment_mode','service_charge','save','false','service_charge','discount');validate_balance(this.id);">

              </div>

              
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <input type="text" id="service_tax_subtotal" class="text-right" name="service_tax_subtotal" placeholder="*Tax Amount" title="Tax Amount" readonly>

              </div>      
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                
                <input type="text" id="roundoff" class="text-right" name="roundoff" placeholder="Round Off" title="Round Off" onchange="validate_balance(this.id);" readonly>

              </div>


              <div class="col-md-4 col-sm-6 col-xs-12">

                <input type="text" id="net_total" class="amount_feild_highlight text-right" name="net_total" placeholder="*Net Total" title="Net Total" readonly>

              </div>

            </div>

            <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <input type="text" name="balance_date" id="balance_date" value="<?= date('d-m-Y') ?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('balance_date','basic_cost','payment_mode','service_charge','save','true','service_charge','discount',true);">
              </div>
            </div>

        </div>



        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

            <legend>Advance details</legend>
            
              <div class="row mg_bt_10">
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <input type="text" id="payment_date" name="payment_date" placeholder="*Date" title="Date" value="<?= date('d-m-Y') ?>" onchange="check_valid_date(this.id)">
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id,'bank_name', 'transaction_id', 'bank_id');get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
                    <?php get_payment_mode_dropdown(); ?>
                  </select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id');number_validate(this.id);get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');">
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
                  <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" class="bank_suggest" title="Bank Name" disabled>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                  <input type="text" id="transaction_id" onchange="validate_specialChar(this.id);" name="transaction_id" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
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
          <div class="col-xs-12">
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

$('#customer_id, #currency_code').select2();

$('#payment_date, #journey_date,#balance_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#departure_time').datetimepicker({ datepicker:false, format:'H:i' });

function business_rule_load(){
  get_auto_values('balance_date','basic_cost','payment_mode','service_charge','save','true','service_charge','discount')
}

$('#frm_save').validate({

    rules:{

            customer_id : { required : true },

            manadatory_docs : { required : true },

            photo_proof_given : { required : true },

            residence_proof : { required : true },

            balance_date : {required:true},

            booking_type : { required : true },

            currency_code : { required : true },

            rate : { required : true },

            forex_amount : { required : true },

            basic_cost : { required : true },

            net_total : { required : true },

            payment_date : { required : true },

            payment_amount : { required : true, number: true },

            payment_mode : { required : true },

            bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },

            transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     

            bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },

    },

    submitHandler:function(){

            var base_url = $('#base_url').val();
            var customer_id = $('#customer_id').val();
            var cust_first_name = $('#cust_first_name').val();
            var cust_middle_name = $('#cust_middle_name').val();
            var cust_last_name = $('#cust_last_name').val();
            var gender = $('#cust_gender').val();
            var cust_birth_date = $('#cust_birth_date').val();
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
                    data:{ first_name : cust_first_name, middle_name : cust_middle_name, last_name : cust_last_name, gender : gender, birth_date : cust_birth_date, age : age, contact_no : contact_no, email_id : email_id, address : address,address2 : address2,city:city,  active_flag : active_flag ,service_tax_no : service_tax_no, landline_no : landline_no, alt_email_id : alt_email_id,company_name : company_name, cust_type : cust_type,state : state, branch_admin_id : branch_admin_id, country_code : country_code},
                    success: function(result){
                    }
                });
            }


            var emp_id = $('#emp_id').val();            
            var manadatory_docs = (function() {  var a = ''; $("input[name='manadatory_docs']:checked").each(function() { a += this.value+','; });  return a; })();
            manadatory_docs = manadatory_docs.slice(0,-1);


            var photo_proof_given = (function() { var a = ''; $("input[name='photo_proof_given']:checked").each(function() { a += this.value+','; }); return a; })();
            photo_proof_given = photo_proof_given.slice(0,-1);


            var residence_proof = (function() { var a = ''; $("input[name='residence_proof']:checked").each(function() { a += this.value+','; }); return a; })();
            residence_proof = residence_proof.slice(0,-1);


            var branch_admin_id = $('#branch_admin_id1').val();
            var booking_type = $('#booking_type').val();
            var currency_code = $('#currency_code').val();
            var rate = $('#rate').val();
            var forex_amount = $('#forex_amount').val();
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

            if(!($('#visa_manadatory_docs').is(":checked") || $('#air_ticket_manadatory_docs').is(":checked"))){ error_msg_alert("Please select Mandatory Documents"); return false; }                         
            if(booking_type=='Sale'){
              if(payment_mode == 'Credit Note' && credit_amount != ''){ 
                if(parseFloat(payment_amount) > parseFloat(credit_amount)) { error_msg_alert('Low Credit note balance'); return false; }
              }
            } 
              var forex_taxes = $('#forex_taxes').val();   
              var forex_sc = $('#forex_sc').val();           
              var reflections = [];
              reflections.push({
              'forex_taxes':forex_taxes,
              'forex_sc' : forex_sc
              });
              var bsmValues = [];
              bsmValues.push({
                "basic" : $('#basic_show').find('span').text(),
                "service" : $('#service_show').find('span').text(),
              });
              var roundoff = $('#roundoff').val();
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

                      url: base_url+'controller/forex/booking/booking_save.php',

                      data:{  emp_id : emp_id,customer_id : customer_id, manadatory_docs : manadatory_docs, photo_proof_given : photo_proof_given, residence_proof : residence_proof, booking_type : booking_type, currency_code : currency_code, rate : rate, forex_amount : forex_amount, basic_cost : basic_cost, service_charge : service_charge, taxation_type : taxation_type, taxation_id : taxation_id, service_tax : service_tax, service_tax_subtotal : service_tax_subtotal, net_total : net_total, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id,balance_date : balance_date, branch_admin_id : branch_admin_id, reflections:reflections, roundoff : roundoff, bsmValues : bsmValues,credit_charges:credit_charges,credit_card_details:credit_card_details},

                      success: function(result){

                        $('#btn_save').button('reset');

                        msg_alert(result);

                        $('#save_modal').modal('hide');

                        list_reflect();

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