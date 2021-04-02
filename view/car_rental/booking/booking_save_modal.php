<?php
include '../../../model/model.php';
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id= $_SESSION['emp_id'];
$branch_status= $_POST['branch_status'];
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="car_sc" name="car_sc">
<input type="hidden" id="car_markup" name="car_markup">
<input type="hidden" id="car_taxes" name="car_taxes">
<input type="hidden" id="car_markup_taxes" name="car_markup_taxes">

<form id="frm_booking_save">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="booking_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 70%;">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Booking</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Customer Details</legend>
          <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_sm_xs">
              <select name="customer_id" id="customer_id" class="customer_dropdown" title="Select Customer" style="width:100%" onchange="customer_info_load('');get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','true','service_charge');">
                  <?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
              </select>
            </div>        
            <div id="cust_details">
              <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_sm_xs">
                    <input type="text" id="email_id" name="email_id" class="form-control" title="Email Id" placeholder="Email ID" readonly>
                  </div>    
              <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_sm_xs">
                    <input type="text" id="mobile_no" name="mobile_no" class="form-control" title="Mobile Number" placeholder="Mobile No" readonly>
              </div>  
              <div class="col-md-3 col-sm-4 col-xs-12">
                    <input type="text" id="company_name1" class="hidden form-control" name="company_name" title="Company Name" placeholder="Company Name" readonly>
              </div>    
              <div class="col-md-3 col-sm-4 col-xs-12">
                <input type="text" id="credit_amount" class="hidden form-control" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
              </div>
            </div>
            <div id="new_cust_div"></div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <input type="text" id="pass_name" name="pass_name" class="form-control" title="Passenger Name" placeholder="Passenger Name">
            </div>
          </div>
        </div>
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Quotation Details</legend>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 ">
              <select name="quotation_id" id="quotation_id" style="width:100%" onchange="get_enquiry_details('');get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','true','basic');" class="form-control">
                <option value="">Select Quotation</option>
                <?php
                $query = "SELECT * FROM `car_rental_quotation_master`ORDER BY quotation_id DESC";
                $sq_enq = mysql_query($query);   
                while($row_enq = mysql_fetch_assoc($sq_enq)){
                  ?>
                  <option value="<?= $row_enq['quotation_id'] ?>"><?= get_quotation_id($row_enq['quotation_id'] )?></option>
                  <?php
                }
                ?>
              </select> 
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="vehicle_name" id="vehicle_name" title="Vehicle Name" class="form-control" onchange="get_car_cost()">
                  <option value="">*Select Vehicle</option>
                  <?php
                      $sql = mysql_query("select * from b2b_transfer_master");
                      while($row = mysql_fetch_assoc($sql)){ 
                      ?>
                          <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                  <?php }  ?>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="travel_type" id="travel_type" title="Travel Type" class="form-control" onchange="reflect_feilds();get_car_cost()">
                <option value="">Travel Type</option>
                <option value="Local">Local</option>
                <option value="Outstation">Outstation</option>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10" >
               <input type="text" id="capacity" name="capacity" onchange="validate_balance(this.id);calculate_total_fees(this.id)" placeholder="Capacity" title="Capacity" class="form-control">
            </div>
           
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="number" id="total_pax" name="total_pax" onchange="validate_balance(this.id);calculate_total_fees(this.id);" placeholder="No Of Pax" title="No Of Pax" class="form-control" pattern="[0-9]+">
            </div>  
            
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <textarea type="text" name="local_places_to_visit" class="form-control" id="local_places_to_visit" onchange="validate_spaces(this.id);calculate_total_fees(this.id)" placeholder="Route" title="Route" rows="1"></textarea>

              <input type="text" id="places_to_visit" name="places_to_visit" class="form-control route_suggest" placeholder="Route" title="Route" >
              <!-- <select name="places_to_visit" id="places_to_visit" title="Route" class="form-control" onchange="get_car_cost();">
                <option value="">Select Route</option>
                <?php
                  $sql = mysql_query("select * from car_rental_tariff_entries where tour_type='Outstation'");
                  while($row = mysql_fetch_assoc($sql)){ 
                  ?>
                    <option value="<?= $row['route']?>"><?= $row['route']?></option>
                <?php }  ?>
            </select> -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="from_date" name="from_date" placeholder="From Date" title="From Date" value="<?= date('d-m-Y')?>" class="form-control" onchange="get_to_date(this.id,'to_date');total_days_reflect();calculate_total_fees(this.id)">
            </div> 
          
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="to_date" name="to_date" placeholder="To Date" title="To Date" value="<?= date('d-m-Y')?>" class="form-control" onchange="validate_validDate('from_date','to_date');total_days_reflect();calculate_total_fees(this.id)">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="total_hrs" name="total_hrs" placeholder="Total Hrs" title="Total Hrs"  class="form-control">
            </div> 
          
            
           
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="days_of_traveling" onchange="validate_balance(this.id);calculate_total_fees(this.id);" name="days_of_traveling" class="form-control" placeholder="Days Of Travelling" title="Days Of Travelling">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="rate" class="text-right form-control" name="rate" placeholder="Rate" title="Rate" onchange="calculate_total_fees(this.id);" >
              </div>
           
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="extra_km" name="extra_km" class="text-right form-control" placeholder="Extra Km Rate" title="Extra KM Rate" onchange="calculate_total_fees(this.id);validate_balance(this.id)">
                </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="extra_hr_cost" name="extra_hr_cost" class="text-right form-control" placeholder="Extra Hr Rate" title="Extra Hr Rate" onchange="calculate_total_fees(this.id);validate_balance(this.id);">
            </div> 
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="total_max_km" name="total_max_km" placeholder="Total Max Km" title="Total Max Km"  class="text-right form-control">
              <input type="text" id="total_km" name="total_km" placeholder="Total Km" title="Total Km"  class="form-control">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="traveling_date" name="traveling_date" placeholder="Travelling Date" title="Travelling Date" onchange="calculate_total_fees(this.id);">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default panel-body app_panel_style feildset-panel">
            <legend>Costing Details</legend>

              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="driver_allowance" name="driver_allowance" placeholder="Driver Allowance" class="text-right form-control" title="Driver Allowance" onchange="calculate_total_fees(this.id);validate_balance(this.id)">
                </div>  
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="permit_charges" name="permit_charges" class="text-right form-control" placeholder="Permit Charges" title="Permit Charges" onchange="calculate_total_fees(this.id);validate_balance(this.id)">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="toll_and_parking" name="toll_and_parking" class="text-right form-control" placeholder="Toll & Parking" title="Toll & Parking" onchange="calculate_total_fees(this.id);validate_balance(this.id)">
                </div>            
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="state_entry_tax" name="state_entry_tax" class="text-right form-control" placeholder="State Entry Tax" title="State Entry Tax" onchange="calculate_total_fees(this.id);validate_balance(this.id)">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="other_charges" name="other_charges" class="text-right form-control" placeholder="Other Charges" title="Other Charges" onchange="calculate_total_fees(this.id);validate_balance(this.id)">
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <small id="basic_show">&nbsp;</small>
                  <input type="text" id="basic_amount" name="basic_amount" class="text-right form-control" placeholder="Basic Amount" title="Basic Amount" onchange="calculate_total_fees(this.id);validate_balance(this.id);get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','true','basic',true);">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <small id="service_show">&nbsp;</small>
		        		  <input type="text" name="service_charge" id="service_charge" class="text-right form-control" placeholder="Service Charge" title="Service Charge" onchange="validate_balance(this.id);get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','false','service_charge')">
		        	  </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <small>&nbsp;</small>
				          <input type="text" id="service_tax_subtotal" name="service_tax_subtotal" class="text-right form-control" placeholder="Tax Amount" title="Tax Amount" readonly>
	        		  </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                    <small id="markup_show">&nbsp;</small>
                    <input type="text" id="markup_cost" name="markup_cost" class="text-right form-control" placeholder="Markup Cost" title="Markup Cost" onchange="validate_balance(this.id);get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','false','markup');" value="0.00">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                    <input type="text" id="service_tax_markup" name="service_tax_markup" placeholder="Markup Tax" title="Markup Tax" class="text-right form-control"  readonly>  
                </div>              
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="total_cost" name="total_cost" class="text-right form-control" placeholder="Total" title="Total" onchange="calculate_total_fees(this.id)" readonly>
                </div> 
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="roundoff" class="text-right form-control" name="roundoff" placeholder="Round Off" title="Round Off" readonly>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="total_fees" class="amount_feild_highlight text-right form-control" name="total_fees" placeholder="Net Total" title="Net Total" readonly>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" name="due_date" id="due_date" placeholder="Due Date" title="Due Date" class="form-control" value="<?= date('d-m-Y') ?>">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" name="balance_date" id="balance_date" value="<?= date('d-m-Y') ?>" class="form-control" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','true','service_charge',true);">
                </div>
              </div>

            </div>

          </div>
        </div>

      

        <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Advance Details</legend>
    
            <div class="row ">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="payment_mode" name="payment_mode" class="form-control" required title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','true','service_charge');get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
                    <?php get_payment_mode_dropdown(); ?>
                </select>  
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Amount" title="Amount" onchange="payment_amount_validate(this.id,'payment_mode','transaction_id', 'bank_name','bank_id');validate_balance(this.id);get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');">
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
                <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled />
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_sm_xs">
                <input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled />
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <select name="bank_id" id="bank_id" title="Select Bank" disabled class="text-right form-control" >
                  <?php get_bank_dropdown(); ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9 col-sm-9">
               <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note" class="form-control"><?= $txn_feild_note ?></span>
             </div>
            </div>
        </div>
        <div class="row text-center">
          <div class="col-xs-12">
              <button id="btn_booking_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>

      </div>      
    </div>
  </div>
</div>
</form>


<script>
$('#booking_save_modal').modal('show');
$('#quotation_id,#customer_id').select2();
$('#from_date,#to_date,#traveling_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#payment_date,#due_date,#balance_date').datetimepicker({ timepicker:false, format:'d-m-Y' });


$('#from_date,#to_date,#total_hrs,#total_km,#total_max_km,#driver_allowance,#permit_charges,#toll_and_parking,#state_entry_tax,#other_charges,#local_places_to_visit,#places_to_visit,#traveling_date').hide();
function reflect_feilds(){
	var type = $('#travel_type').val();
	
	if(type=='Local'){
		$('#from_date,#to_date,#total_hrs,#total_km,#local_places_to_visit').show();
		$('#total_max_km,#driver_allowance,#permit_charges,#toll_and_parking,#state_entry_tax,#other_charges,#places_to_visit,#traveling_date').hide();
	}
	if(type=='Outstation'){
		$('#from_date,#to_date,#total_hrs,#total_km,#local_places_to_visit').hide();
		$('#total_max_km,#driver_allowance,#permit_charges,#toll_and_parking,#state_entry_tax,#other_charges,#places_to_visit,#traveling_date').show();
	}
}
function business_rule_load(){
	get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','true','service_charge',false, true);
}
$(function(){
  $('#frm_booking_save').validate({
      rules:{
          payment_amount : { required : true },
          vehicle_name : { required : true },
          customer_id : { required : true },
          balance_date : { required : true },
          bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
          transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
          places_to_visit : { required : function(){  if($('#travel_type').val()=="Outstation"){ return true; }else{ return false; }  }  },     
          country_code : { required : function(){  if($('#customer_id').val()=='0'){ return true; }else{ return false; }  }  },
          bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
      },
      submitHandler:function(form,e){
            // e.preventDefault();
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
              var total_pax = $('#total_pax').val();
              var days_of_traveling = $('#days_of_traveling').val();
              var travel_type = $('#travel_type').val();
              var places_to_visit = $('#places_to_visit').val();
              var credit_amount = $('#credit_amount').val();
              var pass_name = $('#pass_name').val();
              var quotation_id = $('#quotation_id').val();
              var vehicle_name = $('#vehicle_name').val();
              var extra_km = $('#extra_km').val();
              var service_charge = $('#service_charge').val();
              var service_tax_subtotal = $('#service_tax_subtotal').val();
              var total_cost = $('#total_cost').val();
              var driver_allowance = $('#driver_allowance').val();
              var permit_charges = $('#permit_charges').val();
              var toll_and_parking = $('#toll_and_parking').val();
              var state_entry_tax = $('#state_entry_tax').val();
              var total_fees = $('#total_fees').val();
              var due_date = $('#due_date').val();
              var booking_date = $('#balance_date').val();
              var payment_amount = $('#payment_amount').val();
              var payment_date = $('#payment_date').val();
              var payment_mode = $('#payment_mode').val();
              var bank_name = $('#bank_name').val();
              var transaction_id = $('#transaction_id').val();
              var bank_id = $('#bank_id').val();
              var capacity = $('#capacity').val();
              var from_date = $('#from_date').val();
              var to_date = $('#to_date').val();
              var total_hrs = $('#total_hrs').val();
              var total_km = $('#total_km').val();
              var rate = $('#rate').val();
              var total_max_km = $('#total_max_km').val();
              var extra_hr_cost = $('#extra_hr_cost').val();
              var other_charges = $('#other_charges').val();
              var basic_amount = $('#basic_amount').val();
              var markup_cost = $('#markup_cost').val();
              var markup_cost_subtotal = $('#service_tax_markup').val();
              var credit_charges = $('#credit_charges').val();
	          	var credit_card_details = $('#credit_card_details').val();
              var local_places_to_visit = $('#local_places_to_visit').val();
              var traveling_date = $('#traveling_date').val();
              var markup_show = $('#markup_show').val();
              if(credit_amount != ''){ 
                if(parseFloat(payment_amount) > parseFloat(credit_amount)) { error_msg_alert('Low Credit note balance'); return false; }
              }
              var car_sc = $('#car_sc').val();
              var car_markup = $('#car_markup').val();
              var car_taxes = $('#car_taxes').val();
              var car_markup_taxes = $('#car_markup_taxes').val();
              var reflections = [];
              reflections.push({
              'car_sc':car_sc,
              'car_markup':car_markup,
              'car_taxes':car_taxes,
              'car_markup_taxes':car_markup_taxes
              });
              var roundoff = $('#roundoff').val();
              var bsmValues = [];
              bsmValues.push({
                "basic" : $('#basic_show').find('span').text(),
                "service" : $('#service_show').find('span').text(),
                "markup" : $('#markup_show').find('span').text()
              });
            //Validation for booking and payment date in login financial year
            $('#btn_booking_save').button('loading');
            var check_date1 = $('#balance_date').val();
            $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
              if(data !== 'valid'){
                error_msg_alert("The Booking date does not match between selected Financial year.");
                $('#btn_booking_save').button('reset');
                return false;
              }else{
                var payment_date = $('#payment_date').val();
                $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
                  console.log(data)
                if(data !== 'valid'){
                  error_msg_alert("The Payment date does not match between selected Financial year.");
                  $('#btn_booking_save').button('reset');
                  return false;
                }else{
                  
                    $('#btn_booking_save').button('loading');

                    if($('#whatsapp_switch').val() == "on") whatsapp_send(emp_id, customer_id, booking_date, base_url);
                    $.post(base_url+'controller/car_rental/booking/booking_save.php', { emp_id : emp_id, customer_id : customer_id,quotation_id : quotation_id, total_pax : total_pax,pass_name : pass_name, days_of_traveling : days_of_traveling,  travel_type : travel_type, places_to_visit : places_to_visit, extra_km : extra_km, service_charge : service_charge, service_tax_subtotal : service_tax_subtotal, total_cost : total_cost, driver_allowance : driver_allowance, permit_charges : permit_charges, toll_and_parking : toll_and_parking, state_entry_tax : state_entry_tax, total_fees : total_fees, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id , due_date : due_date,booking_date : booking_date, branch_admin_id : branch_admin_id,capacity:capacity,places_to_visit:places_to_visit,from_date:from_date,to_date:to_date,total_hrs:total_hrs,total_km:total_km,rate:rate,total_max_km:total_max_km,extra_hr_cost:extra_hr_cost,state_entry_tax:state_entry_tax,other_charges:other_charges,basic_amount:basic_amount,markup_cost:markup_cost,markup_cost_subtotal:markup_cost_subtotal,vehicle_name:vehicle_name,local_places_to_visit:local_places_to_visit,traveling_date:traveling_date,reflections:reflections, roundoff : roundoff, bsmValues : bsmValues,credit_charges:credit_charges,credit_card_details:credit_card_details}, function(result){
                      console.log(result);
                        $('#btn_booking_save').button('reset');
                        var msg = "Booking saved successfully!";
                        msg_popup_reload(msg);
                    });
							}
						});
					}
				});


      }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>