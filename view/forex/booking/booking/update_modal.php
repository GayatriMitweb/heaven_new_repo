<?php

include "../../../../model/model.php";

$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$branch_status = $_POST['branch_status'];

$booking_id = $_POST['booking_id'];

$sq_booking = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$booking_id'"));



$manadatory_docs = $sq_booking['manadatory_docs'];

$manadatory_docs_arr = explode(',', $manadatory_docs);



$photo_proof_given = $sq_booking['photo_proof_given'];

$photo_proof_given_arr = explode(',', $photo_proof_given);



$residence_proof = $sq_booking['residence_proof'];
$residence_proof_arr = explode(',', $residence_proof);
$reflections = json_decode($sq_booking['reflections']);
?>
<input type="hidden" id="forex_taxes" name="forex_taxes" value="<?php echo $reflections[0]->forex_taxes ?>">
<input type="hidden" id="forex_sc" name="forex_sc" value="<?php echo $reflections[0]->forex_sc ?>">
<form id="frm_update">

<input type="hidden" id="booking_id" name="booking_id" value="<?= $booking_id ?>">



<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Booking</h4>

      </div>

      <div class="modal-body">

        

        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">

            <legend>Customer Details</legend>

            

            <div class="row">

              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

                <select name="customer_id1" id="customer_id1" class="customer_dropdown"style="width:100%" title="Customer Name" onchange="customer_info_load('1')" disabled>

                  <?php 

                    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));

                    if($sq_customer['type']=='Corporate'){
                    ?>
                      <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                    <?php }  else{ ?>
                      <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                    <?php } ?>

                <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>

                </select>

              </div>

              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

                <input type="text" id="email_id1" name="email_id" placeholder="Email ID" title="Email ID"  value="<?= $sq_customer['email_id'] ?>" readonly>

              </div>              

              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

                <input type="text" id="mobile_no1" name="mobile_no" placeholder="Mobile No" title="Mobile No"  value="<?= $sq_customer['contact_no'] ?>" readonly>

              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">

                <input type="text" id="company_name1" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>

              </div>

            </div>

            <script>

              customer_info_load('1');

            </script>

        </div>



        <div class="panel panel-default panel-body app_panel_style forex_module feildset-panel mg_tp_30">

            <legend>Document Details</legend>

            

            <div class="row mg_bt_10 mg_tp_10">

              <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">

                <h6>Mandatory documents</h6>

                <div class="forex_chk">

                  <?php $chk = (in_array("Visa", $manadatory_docs_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="visa_manadatory_docs" name="manadatory_docs" value="Visa" <?= $chk ?>>

                  <label for="visa_manadatory_docs">Visa</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Flight Ticket", $manadatory_docs_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="air_ticket_manadatory_docs" name="manadatory_docs" value="Flight Ticket" <?= $chk ?>>

                  <label for="air_ticket_manadatory_docs">Flight Ticket</label>

                </div>

              </div>

              <div class="col-md-9 col-sm-8 col-xs-12 mg_bt_10">          

                <h6>Photo Proof Given</h6>

                <div class="forex_chk">

                  <?php $chk = (in_array("Passport", $photo_proof_given_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="passport_photo_proof" name="photo_proof_given" value="Passport" <?= $chk ?>>

                  <label for="passport_photo_proof">Passport</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Pan Card", $photo_proof_given_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="pan_card_photo_proof" name="photo_proof_given" value="Pan Card" <?= $chk ?>>

                  <label for="pan_card_photo_proof">Pan Card</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Voter Identity Card", $photo_proof_given_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="voter_id_photo_proof" name="photo_proof_given" value="Voter Identity Card" <?= $chk ?>>

                  <label for="voter_id_photo_proof">Voter Identity Card</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Driving Licence", $photo_proof_given_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="driving_photo_proof" name="photo_proof_given" value="Driving Licence" <?= $chk ?>>

                  <label for="driving_photo_proof">Driving Licence</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Aadhaar Card", $photo_proof_given_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="adhar_card_photo_proof" name="photo_proof_given" value="Aadhaar Card" <?= $chk ?>>

                  <label for="adhar_card_photo_proof">Aadhaar Card</label>

                </div>



              </div>              

            </div>



            <div class="row">

              <div class="col-xs-12">

                <h6>Residence Proof</h6>

                <div class="forex_chk">

                  <?php $chk = (in_array("Telephone Bill", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="telephone_bill_residence_proof" name="residence_proof" value="Telephone Bill" <?= $chk ?>>

                  <label for="telephone_bill_residence_proof">Telephone Bill</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Electricity Bill", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="electricity_bill_residence_proof" name="residence_proof" value="Electricity Bill" <?= $chk ?>>

                  <label for="electricity_bill_residence_proof">Electricity Bill</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Ration Card", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="ration_card_residence_proof" name="residence_proof" value="Ration Card" <?= $chk ?>>

                  <label for="ration_card_residence_proof">Ration Card</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Bank Passbook", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="bank_passbook_residence_proof" name="residence_proof" value="Bank Passbook" <?= $chk ?>>

                  <label for="bank_passbook_residence_proof">Bank Passbook</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Bank Statement", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="bank_statement_residence_proof" name="residence_proof" value="Bank Statement" <?= $chk ?>>

                  <label for="bank_statement_residence_proof">Bank Statement</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Employer Letter", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="employer_letter_residence_proof" name="residence_proof" value="Employer Letter" <?= $chk ?>>

                  <label for="employer_letter_residence_proof">Employer Letter</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Employer Invitation", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="employer_invitation_residence_proof" name="residence_proof" value="Employer Invitation" <?= $chk ?>>

                  <label for="employer_invitation_residence_proof">Employer Invitation</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Hotel Advance Receipt Voucher", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="hotel_advance_residence_proof" name="residence_proof" value="Hotel Advance Receipt Voucher" <?= $chk ?>>

                  <label for="hotel_advance_residence_proof">Hotel Advance Receipt Voucher</label>

                </div>

                <div class="forex_chk">

                  <?php $chk = (in_array("Aadhaar  Card", $residence_proof_arr)) ? "checked" : ""; ?>

                  <input type="checkbox" id="adhar_card_residence_proof" name="residence_proof" value="Aadhaar  Card" <?= $chk ?>>

                  <label for="adhar_card_residence_proof">Aadhaar  Card</label>

                </div>

              </div>

            </div>



        </div>



        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

            <legend>Costing Details</legend>



            <div class="row">

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <select name="booking_type" id="booking_type" title="Buy/Sale" disabled>

                  <option value="<?= $sq_booking['booking_type'] ?>"><?=  $sq_booking['booking_type'] ?></option>

                  <option value="">Buy/Sale</option>

                  <option value="Buy">Buy</option>

                  <option value="Sale">Sale</option>

                </select>

              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <select name="currency_code" id="currency_code" style="width:100%" title="Currency">

                  <option value="<?= $sq_booking['currency_code'] ?>"><?= $sq_booking['currency_code'] ?></option>

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
              <?php
                $basic_cost1 = $sq_booking['basic_cost'];
                $service_charge = $sq_booking['service_charge'];
                $bsmValues = json_decode($sq_booking['bsm_values']);
                $service_tax_amount = 0;
                if($sq_booking['service_tax_subtotal'] !== 0.00 && ($sq_booking['service_tax_subtotal']) !== ''){
                  $service_tax_subtotal1 = explode(',',$sq_booking['service_tax_subtotal']);
                  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                    $service_tax = explode(':',$service_tax_subtotal1[$i]);
                    $service_tax_amount = $service_tax_amount + $service_tax[2];
                  }
                }
                foreach($bsmValues[0] as $key => $value){
                  switch($key){
                    case 'basic' : $basic_cost = ($value != "") ? $basic_cost1 + $service_tax_amount : $basic_cost1;$inclusive_b = $value;break;
                    case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
                  }
                }   
              ?>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <input type="text" id="rate" name="rate" placeholder="Rate" title="Rate" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_booking['rate'] ?>">

              </div>              

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <input type="text" id="forex_amount" name="forex_amount" placeholder="Forex Amount" title="Forex Amount" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_booking['forex_amount'] ?>">

              </div>
              

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small id="basic_show"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
                <input type="text" id="basic_cost" name="basic_cost" placeholder="Total" title="Total" onchange="calculate_total_amount(this.id);validate_balance(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','update','true','basic',true);" readonly value="<?= $basic_cost ?>">

              </div>

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <small id="service_show"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
                <input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge"  onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $service_charge ?>">

              </div>     

                     

              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                <input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly value="<?= $sq_booking['service_tax_subtotal'] ?>">

              </div>    
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

                  <input type="text" id="roundoff" class="text-right" name="roundoff" placeholder="Round Off" title="Round Off" value="<?= $sq_booking['roundoff'] ?>" readonly>

              </div> 
              <div class="col-md-4 col-sm-6 col-xs-12">

                <input type="text" id="net_total" class="amount_feild_highlight text-right" name="net_total" placeholder="Net Total" title="Net Total" readonly value="<?= $sq_booking['net_total'] ?>">

              </div>           

              </div>

            <div class="row mg_bt_10">

              
              <div class="col-md-4 col-sm-6 col-xs-12">
                <input type="text" name="booking_date1" id="booking_date1" value="<?= get_date_user($sq_booking['created_at']) ?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','update','true','service_charge',true);">
              </div>

            </div>



        </div> 



        <div class="row text-center">

          <div class="col-xs-12">

            <button id="btn_update" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

          </div>

        </div>



      </div>

    </div>

  </div>

</div>



</form>



<script>

$('#update_modal').modal('show');

$('#customer_id, #currency_code').select2();

$('#payment_date, #journey_date,#booking_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#departure_time').datetimepicker({ datepicker:false, format:'H:i' });



$('#frm_update').validate({

    rules:{

            customer_id1 : { required : true },

            manadatory_docs : { required : true },

            photo_proof_given : { required : true },

            residence_proof : { required : true },



            booking_type : { required : true },

            currency_code : { required : true },

            rate : { required : true },

            forex_amount : { required : true },

            basic_cost : { required : true },

            service_charge : { required : true },

            net_total : { required : true },
			      booking_date1 : { required : true },

            

    },

    submitHandler:function(){

   

            var booking_id = $('#booking_id').val();

            var customer_id = $('#customer_id1').val();
            var booking_date1 = $('#booking_date1').val();


            var manadatory_docs = (function() {  var a = ''; $("input[name='manadatory_docs']:checked").each(function() { a += this.value+','; });  return a; })();

            manadatory_docs = manadatory_docs.slice(0,-1);



            var photo_proof_given = (function() { var a = ''; $("input[name='photo_proof_given']:checked").each(function() { a += this.value+','; }); return a; })();

            photo_proof_given = photo_proof_given.slice(0,-1);



            var residence_proof = (function() { var a = ''; $("input[name='residence_proof']:checked").each(function() { a += this.value+','; }); return a; })();

            residence_proof = residence_proof.slice(0,-1);

            
            if(!($('#visa_manadatory_docs').is(":checked") || $('#air_ticket_manadatory_docs').is(":checked"))){ error_msg_alert("Please select Mandatory Documents"); return false; } 


            var booking_type = $('#booking_type').val();

            var currency_code = $('#currency_code').val();

            var rate = $('#rate').val();

            var forex_amount = $('#forex_amount').val();

            var basic_cost = $('#basic_cost').val();

            var service_charge = $('#service_charge').val();

            var service_tax_subtotal = $('#service_tax_subtotal').val();

            var net_total = $('#net_total').val();
              var forex_taxes = $('#forex_taxes').val();
              var forex_sc = $('#forex_sc').val();
              
              var reflections = [];
              reflections.push({
              
              'forex_taxes':forex_taxes,
              'forex_sc' : forex_sc
              
              });
              var roundoff = $('#roundoff').val();
              var bsmValues = [];
              bsmValues.push({
                "basic" : $('#basic_show').find('span').text(),
                "service" : $('#service_show').find('span').text()
              });
            //Validation for booking and payment date in login financial year
            var base_url = $('#base_url').val();
            var check_date1 = $('#booking_date1').val();
            $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
              if(data !== 'valid'){
                error_msg_alert("The Booking date does not match between selected Financial year.");
                return false;
              }else{

                  $('#btn_update').button('loading');
                  $.ajax({

                    type: 'post',

                    url: base_url+'controller/forex/booking/booking_update.php',

                    data:{  booking_id : booking_id, customer_id : customer_id, manadatory_docs : manadatory_docs, photo_proof_given : photo_proof_given, residence_proof : residence_proof, booking_type : booking_type, currency_code : currency_code, rate : rate, forex_amount : forex_amount, basic_cost : basic_cost, service_charge : service_charge, service_tax_subtotal : service_tax_subtotal, net_total : net_total,booking_date1 : booking_date1,reflections:reflections , roundoff : roundoff, bsmValues : bsmValues},

                    success: function(result){

                      $('#btn_update').button('reset');

                      msg_alert(result);

                      $('#update_modal').modal('hide');

                      list_reflect();

                    }

                  });
                }
              });



    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>