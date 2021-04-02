<?php
 include "../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$emp_id=$_SESSION['emp_id']; 
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">New Receipt</h4>

      </div>

      <div class="modal-body">

			

			<form id="frm_payment_save">

		      

		      <div class="row">

		      	<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

		      		<select id="cmb_tourwise_traveler_id" name="cmb_tourwise_traveler_id" onchange="get_outstanding('group',this.id);" style="width:100%;" title="Booking ID">

		                <?php get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id); ?>

		            </select>

		      	</div>

		        <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

		          <input id="txt_payment_date" name="txt_payment_date" class="form-control" title="Date" placeholder="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)"/>

		        </div>

		        <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

		          <select id="cmb_payment_mode" name="cmb_payment_mode" title="Mode" onchange="payment_installment_enable_disable_fields();get_identifier_block('identifier','cmb_payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','cmb_payment_mode','txt_amount','credit_card_details','credit_charges')" class="form-control">

		              <?php get_payment_mode_dropdown() ?>

		          </select>

		        </div>		        

		      	<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

		          <input type="text" class="form-control" id="txt_amount" name="txt_amount" title="Amount" placeholder="*Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'cmb_payment_mode','txt_transaction_id','txt_bank_name','bank_id');payment_amount_validate(this.id,'cmb_payment_mode','transaction_id','bank_name','bank_id');get_credit_card_charges('identifier','cmb_payment_mode','txt_amount','credit_card_details','credit_charges');"/>

		        </div>		        

		      	<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

		          <input type="text" id="txt_bank_name"  name="txt_bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled />

		        </div>      

		        <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">

		          <input type="text" id="txt_transaction_id" onchange="validate_balance(this.id)" name="txt_transaction_id" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled />

		        </div>		        

		      	<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10 hidden">
		          <select id="cmb_payment_of_type" name="cmb_payment_of_type" title="Pay For" onchange="payment_installment_enable_disable_fields1(this.id)" class="form-control">
		                <option value="">*Pay for</option>
		                <option value="Tour">Tour</option>
		                <option value="Travelling">Travelling</option>
		            </select>
		        </div>

		      	<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10 hidden">
		          <select id="cmb_travel_of_type" name="cmb_travel_of_type" title="Travelling Type" class="form-control">
		                <option value="">*Type</option>
		                <option value="All"> All </option>
		                <option value="Train">Train</option>
		                <option value="Flight"> Flight </option>
                    <option value="Cruise"> Cruise </option>
		            </select>   

		        </div>
 </div>
          <div class="row mg_bt_10">
		        <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
		          <select name="bank_id" id="bank_id" title="Bank" class="form-control" disabled>
		            <?php get_bank_dropdown(); ?>
		          </select>
		        </div>
		     
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input class="hidden" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','cmb_payment_mode','credit_card_details')" title="Identifier(4 digit)" required
						><option value=''>Select Identifier</option></select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input class="hidden" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
					</div>
				</div>
        <div class="row">
          <div class="col-md-3 col-sm-3">
            <input type="text" id="outstanding" name="outstanding" class="form-control" placeholder="Outstanding" title="Outstanding" readonly/>
          </div>
          <div class="col-md-9 col-sm-9">
           <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
         </div>
        </div>
		      <div class="row text-center mg_tp_20 mg_bt_10">
		      	<div class="col-xs-12">
		        	<button class="btn btn-sm btn-success" id="btn_payment_installment" name="btn_payment_installment"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>   
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

$('#save_modal').modal('show');

$(function(){



  $('#frm_payment_save').validate({

    rules:{

    		cmb_tourwise_traveler_id : { required : true },

            txt_payment_date : { required : true },

            cmb_payment_mode : { required : true },

            txt_amount : { required : true },

            txt_bank_name : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },

            txt_transaction_id : { required : function(){  if($('#cmb_payment_mode').val()!="Cash" ){ return true; }else{ return false; }  }  },     

            bank_id : { required : function(){  if($('#cmb_payment_mode').val()!="Cash" ){ return true; }else{ return false; }  }  },     

    },

    submitHandler:function(form){



      var base_url = $("#base_url").val();

      var tourwise_id = $("#cmb_tourwise_traveler_id").val();

      var payment_date = $("#txt_payment_date").val();   

      var payment_mode = $("#cmb_payment_mode").val();

      var payment_amount = $("#txt_amount").val();  

      var bank_name = $("#txt_bank_name").val();

      var transaction_id = $("#txt_transaction_id").val();  

      var payment_for = $("#cmb_payment_of_type").val(); 

      var p_travel_type = $("#cmb_travel_of_type").val();

      var bank_id = $('#bank_id').val();

      var emp_id = $("#emp_id").val();  
 
      var branch_admin_id = $('#branch_admin_id1').val();

      var credit_charges = $('#credit_charges').val();
    var credit_card_details = $('#credit_card_details').val();
  

      

      



     

      //Validation for booking and payment date in login financial year
      var base_url = $('#base_url').val();
      var check_date1 = $('#txt_payment_date').val();
      $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
          if(data !== 'valid'){
              error_msg_alert("The Payment date does not match between selected Financial year.");
              return false;
          }else{
            if($('#whatsapp_switch').val() == "on") whatsapp_send_r(tourwise_id, payment_amount, base_url);
            $('#btn_payment_installment').button('loading');
            
            $.post(

                  base_url+"controller/group_tour/booking_payment/payment_installment_modify.php",

                  { tourwise_id : tourwise_id, payment_date : payment_date, payment_mode : payment_mode, payment_amount : payment_amount, bank_name : bank_name, transaction_id : transaction_id, payment_for : payment_for, p_travel_type : p_travel_type, bank_id : bank_id, emp_id : emp_id, branch_admin_id : branch_admin_id ,credit_charges:credit_charges,credit_card_details:credit_card_details},

                  function(data) {
                    $('#btn_payment_installment').button('reset');
                    msg_alert(data);
                    list_reflect();
                    $('#save_modal').modal('hide');
                  });
            }
            });
          }
        });
});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>