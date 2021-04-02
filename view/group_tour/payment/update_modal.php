<?php
include "../../../model/model.php";

$payment_id = $_POST['payment_id'];
$sq_payment = mysql_fetch_assoc(mysql_query("select * from payment_master where payment_id='$payment_id'"));
$sq_tour = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$sq_payment[tourwise_traveler_id]'"));
$date = $sq_tour['form_date'];
$yr = explode("-", $date);
$year =$yr[0];
$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_tour[customer_id]'"));

$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from payment_master where payment_id='$payment_id'"));
$enable = ($sq_payment_info['payment_mode']=="Cash" || $sq_payment_info['payment_mode']=="Credit Note" || $sq_payment_info['payment_mode']=="Credit Card" ) ? "disabled" : "";

// $state_change = ($sq_payment['payment_for']=="Tour") ? "disabled" : "";

?>

<input type="hidden" id="payment_id" name="payment_id" value="<?= $payment_id ?>">

<input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment['amount'] ?>">


<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Receipt</h4>

      </div>

      <div class="modal-body">
			<form id="frm_payment_update">

		      <div class="row mg_bt_10">
            <div class="col-md-4">
                <select id="cmb_tourwise_traveler_id" name="cmb_tourwise_traveler_id" style="width:100%" title="Booking ID" disabled>
                    <?php
                       if($sq_cust['type'] == 'Corporate'){ ?>
                         <option value="<?= $sq_payment['tourwise_traveler_id'] ?>"><?= get_group_booking_id($sq_payment['tourwise_traveler_id'],$year) .':'. $sq_cust['company_name'] ?></option>
                       <?php }else{ ?> 
                    <option value="<?= $sq_payment['tourwise_traveler_id'] ?>"><?= get_group_booking_id($sq_payment['tourwise_traveler_id'],$year) .':'. $sq_cust['first_name'].' '.$sq_cust['last_name'] ?></option>
    
                    <?php } get_group_booking_dropdown() ?>

                </select>

            </div>
		        <div class="col-md-4">

		          <input id="txt_payment_date" name="txt_payment_date" class="form-control" title="Date" placeholder="Date" value="<?= get_date_user($sq_payment['date']) ?>" readonly/>

		        </div>

		        <div class="col-md-4">

		          <select id="cmb_payment_mode" name="cmb_payment_mode" title="Mode" onchange="payment_installment_enable_disable_fields()" disabled>

                  <option value="<?= $sq_payment['payment_mode'] ?>"><?= $sq_payment['payment_mode'] ?></option>

		              <?php get_payment_mode_dropdown() ?>

		          </select>

		        </div>   	        

		      </div>



		      <div class="row mg_bt_10">    

            <div class="col-md-4">

              <input type="text" id="txt_amount" name="txt_amount" title="Amount" placeholder="Amount" value="<?= $sq_payment['amount'] ?>" onchange="validate_balance(this.id);get_credit_card_charges('identifier','cmb_payment_mode','txt_amount','credit_card_details1','credit_charges1');" />

            </div>      

		      	<div class="col-md-4">

		          <input type="text" id="txt_bank_name" name="txt_bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_payment['bank_name'] ?>" <?= $enable ?> />

		        </div>      

		        <div class="col-md-4">

		          <input type="text" id="txt_transaction_id" onchange="validate_balance(this.id);" name="txt_transaction_id" class="form-control" placeholder="Cheque No/ID" title="Cheque No / ID" value="<?= $sq_payment['transaction_id'] ?>" <?= $enable ?> />

		        </div>	      

		      </div>



		      <div class="row mg_bt_10">

            <div class="col-md-4 hidden">

              <select id="cmb_payment_of_type" name="cmb_payment_of_type" title="Pay for" onchange="payment_installment_enable_disable_fields1(this.id)">

                    <option value="<?= $sq_payment['payment_for'] ?>"><?= $sq_payment['payment_for'] ?></option>

                    <option value="">Pay for</option>

                    <option value="Tour">Tour</option>

                    <option value="Travelling">Travelling</option>                            

                </select>

            </div>    

		      	<div class="col-md-4 hidden">

		          <select id="cmb_travel_of_type" name="cmb_travel_of_type" title="Type" class="form-control" <?= $state_change ?>>

              <?php if($sq_payment['travel_type']!=''){ ?>

                    <option value="<?= $sq_payment['travel_type'] ?>"><?= $sq_payment['travel_type'] ?></option>

                    <?php } ?>

		                <option value="">Type</option>

                    <option value="All"> All </option>
                    <option value="Train">Train</option>
                    <option value="Flight"> Flight </option>   
                    <option value="Cruise"> Cruise </option>                           

		            </select>   

		        </div>

		        <div class="col-md-4">

		          <select name="bank_id" id="bank_id" title="Select Bank" class="form-control" <?= $enable ?> disabled>

                <?php 
                if($sq_payment['bank_id'] != '0'){
                $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment[bank_id]'"));
                ?>
                <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                
		            <?php } get_bank_dropdown(); ?>

		          </select>

		        </div>

		      </div>
            <?php if($sq_payment['payment_mode'] == 'Credit Card'){?>
          <div class="row mg_tp_10">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="credit_charges1" name="credit_charges1" title="Credit card charges" value="<?=$sq_payment['credit_charges']?>" disabled>
              <input type="hidden" id="credit_charges_old" name="credit_charges_old" title="Credit card charges" value="<?=$sq_payment['credit_charges']?>" disabled>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input class="text" type="text" id="credit_card_details1" name="credit_card_details1" title="Credit card details"  value="<?= $sq_payment['credit_card_details'] ?>" disabled>
            </div>
          </div>
          <?php } ?>


		      <div class="row text-center mg_tp_20 mg_bt_10">

		      	<div class="col-md-12">

		        	<button class="btn btn-sm btn-success" id="btn_payment_installment" name="btn_payment_installment"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>   

		        </div>

		      </div>



		    </form>





      </div>

    </div>

  </div>

</div>



<script>

$('#cmb_tourwise_traveler_id').select2();

$( "#txt_payment_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#update_modal').modal('show');

$(function(){



  $('#frm_payment_update').validate({
    rules:{
            txt_payment_date : { required : true },
            cmb_payment_mode : { required : true },
            txt_amount : { required : true },
            cmb_payment_of_type : { required : true },
            cmb_travel_of_type : { required : true },
            txt_bank_name : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
            txt_transaction_id : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
            bank_id : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
    },

    submitHandler:function(form){

      var payment_id = $("#payment_id").val();
      var tourwise_traveler_id = $("#cmb_tourwise_traveler_id").val();  
      var payment_date = $("#txt_payment_date").val();   
      var payment_mode = $("#cmb_payment_mode").val();
      var payment_amount = $("#txt_amount").val();  
      var bank_name = $("#txt_bank_name").val();
      var transaction_id = $("#txt_transaction_id").val();  
      var payment_for = $("#cmb_payment_of_type").val(); 
      var p_travel_type = $("#cmb_travel_of_type").val();
      var bank_id = $('#bank_id').val();
      var payment_old_value = $('#payment_old_value').val();
      var credit_charges = $('#credit_charges1').val();
      var credit_card_details = $('#credit_card_details1').val();
      var credit_charges_old = $('#credit_charges_old').val();

      if(!check_updated_amount(payment_old_value,payment_amount)){
      error_msg_alert("You can update receipt to 0 only!");
      return false;
    }



      $('#btn_payment_installment').button('loading');



      $.post( 

             base_url()+"controller/group_tour/booking_payment/payment_master_update.php",

             { tourwise_traveler_id : tourwise_traveler_id, payment_id : payment_id, payment_date : payment_date, payment_mode : payment_mode, payment_amount : payment_amount, bank_name : bank_name, transaction_id : transaction_id, payment_for : payment_for, p_travel_type : p_travel_type, bank_id : bank_id, payment_old_value : payment_old_value ,credit_charges:credit_charges,credit_card_details:credit_card_details,credit_charges_old:credit_charges_old },

             function(data) { 

                $('#btn_payment_installment').button('reset');                   

                 msg_alert(data);

                 list_reflect();

                 $('#update_modal').modal('hide');

             });



          





    }

  });



});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>