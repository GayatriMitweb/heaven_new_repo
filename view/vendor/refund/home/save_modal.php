<?php
include "../../../../model/model.php";
include_once('../../inc/vendor_generic_functions.php');
?>
<form id="frm_save">

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Save Refund</h4>
      </div>
      <div class="modal-body">
		<div class="row mg_bt_10"> 
			<div class="col-md-4 col-md-offset-4">
				<select id="estimate_id" name="estimate_id" style="width:100%" title="Supplier Costing" onchange="estimate_id_reflect()">
			        <option value="">*Supplier Costing</option>
			        <?php 
			        $sq_estimate = mysql_query("select * from vendor_estimate where status='Cancel' order by estimate_id desc");
			        while($row_estimate = mysql_fetch_assoc($sq_estimate)){
                $date = $row_estimate['purchase_date'];
                $yr = explode("-", $date);
                $year =$yr[0];
			          $vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);
			          ?>
			          <option value="<?= $row_estimate['estimate_id'] ?>"><?= get_vendor_estimate_id($row_estimate['estimate_id'],$year)." : ".$vendor_type_val."(".$row_estimate['vendor_type'].")" ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
      </div>
      <div class="row mg_bt_10 mg_tp_20">
        <div id="div_refund_estimate"></div>   
      </div>
      <div class=" row mg_bt_10 mg_bt_10">
          <div class="col-md-12 mg_tp_10">        
          <div class="row mg_tp_10">                    
              <div class="col-md-4">
                <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="*Payment Date" title="Payment Date" value="<?= date('d-m-Y')?>">
              </div>                  
              <div class="col-md-4">
                <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Amount" title="Payment Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name')">
              </div>
              <div class="col-md-4">
                <select name="payment_mode" id="payment_mode" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                    <option value="">*Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="NEFT">NEFT</option>
                    <option value="RTGS">RTGS</option>
                    <option value="IMPS"> IMPS </option>
                    <option value="DD"> DD </option>
                    <option value="Debit Note">Debit Note</option>
                    <option value="Other"> Other </option>
                </select>
              </div> 
          </div>
          <div class="row mg_tp_10">
            <div class="col-md-4">
              <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
            </div>
            <div class="col-md-4">
              <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id)" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
            </div>
            <div class="col-md-4">
              <select name="bank_id" id="bank_id" title="Creditor Bank" class="form-control" disabled>
                <?php get_bank_dropdown(); ?>
              </select>
            </div>  
          </div> 
          <div class="row text-center mg_tp_10">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>     
  </div>
</div>
</div>

</form>

<script>
$('#estimate_id').select2();
$('#save_modal').modal('show');

$('#payment_date').datetimepicker({timepicker:false, format:'d-m-Y'});

$(function(){
	$('#frm_save').validate({
		rules:{
				estimate_id : { required : true },
				payment_amount : { required: true, number:true },
        payment_date : { required: true },
        payment_mode : { required : true },
        bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
        transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
        bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },   
		},
		submitHandler:function(form){

				var estimate_id = $('#estimate_id').val();     
        var estimate_type_id = $('#estimate_type_id').val();     
        var vendor_type = $('#vendor_type').val();  
        var vendor_type_id = $('#vendor_type_id').val();     
 				var payment_amount = $('#payment_amount').val();
        var payment_date = $('#payment_date').val();
        var payment_mode = $('#payment_mode').val();
        var bank_name = $('#bank_name').val();
        var transaction_id = $('#transaction_id').val();
        var bank_id = $('#bank_id').val();
        var remaining_amount = $('#remaining_amount').val();

        if( Number(remaining_amount) < Number(payment_amount) )
        { error_msg_alert("Amount can not be greater than total refund amount"); return false; }

        $('#btn_update').button('loading');

 				var base_url = $('#base_url').val();

	            $.ajax({
	              type:'post',
	              url: base_url+'controller/vendor/refund/refund_save.php',
	              data:{ estimate_id : estimate_id,estimate_type_id : estimate_type_id,vendor_type : vendor_type,vendor_type_id : vendor_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
	              success:function(result){
                  $('#btn_update').button('reset');
	                  msg_alert(result);

	                  $('#save_modal').modal('hide');
	                  $('#save_modal').on('hidden.bs.modal', function(){
	                    list_reflect();
	                  });               
	              }
	            });
 
		}
	});
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>