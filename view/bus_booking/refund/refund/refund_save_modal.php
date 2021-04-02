<?php 
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];

$remaining_val = $_POST['remaining_val'];
?>
<div class="modal fade" id="refund_save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Save Refund</h4>
      </div>
      <div class="modal-body">
        

			<form id="frm_refund_save">				

				<div class="row text-center">  
				    <div class="col-md-4 col-sm-6 mg_bt_20">
				      <input type="text" id="refund_amount" name="refund_amount" title="Refund Amount" placeholder="*Refund Amount" onchange="validate_balance(this.id); payment_amount_validate(this.id,'refund_mode','transaction_id','bank_name')">
              <input type="hidden" name="remaining_val" id="remaining_val" value="<?php echo $remaining_val; ?>">
				    </div>
				    <div class="col-md-4 col-sm-6 mg_bt_20">
				      <input type="text" id="refund_date" name="refund_date" placeholder="*Refund Date" title="Refund Date" value="<?= date('d-m-Y')?>">
				    </div>   
				    <div class="col-md-4 col-sm-6 mg_bt_20">
					    <select id="refund_mode" name="refund_mode" class="form-control" required title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
						<?php get_payment_mode_dropdown(); ?>
					    </select>  
					</div> 
					<div class="col-md-4 col-sm-6 mg_bt_20">
					    <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled/>
					</div>      
				    <div class="col-md-4 col-sm-6 mg_bt_20">
				    	<input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id);" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled/>
				  	</div>
				  	<div class="col-md-4 col-sm-6 mg_bt_20">
				  		<select name="bank_id" id="bank_id" title="Bank" disabled>
		                    <?php get_bank_dropdown('Debitor Bank')  ?>
		                </select>
				  	</div>
				</div>					

				<div class="row text-center mg_tp_20">
				  <div class="col-xs-12">
				      <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
				  </div>
				</div>

			</form>


      </div>      
    </div>
  </div>
</div>


<script>
$('#refund_save_modal').modal('show');

$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$(function(){
  $('#frm_refund_save').validate({
      rules:{
              refund_amount : { required: true, number:true },
              refund_date : { required: true },
              refund_mode : { required : true },
              bank_name : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              bank_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
      },
      submitHandler:function(form){

              var booking_id = $('#booking_id').val();
              var refund_amount = $('#refund_amount').val();
              var refund_date = $('#refund_date').val();
              var refund_mode = $('#refund_mode').val();
              var bank_name = $('#bank_name').val();
              var transaction_id = $('#transaction_id').val();
              var bank_id = $('#bank_id').val();
              var remaining_val = $('#remaining_val').val();
              if(typeof($("#ref_amt")) != "undefined" && (Number($("#ref_amt").val()) ==  Number($('#refund_amount_tobe').val()))){
                error_msg_alert("Refund Already Fully Paid"); return false;
              }
             else if(Number(refund_amount) > Number(remaining_val))
              { error_msg_alert("Amount can not be greater than total refund amount"); return false; }
             
              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');

                        $.ajax({
                          type:'post',
                          url: base_url()+'controller/bus_booking/refund/refund_save.php',
                          data:{ booking_id : booking_id, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
                          success:function(result){
                            msg_alert(result);
                            $('#refund_save_modal').modal('hide');
                            $('#refund_save_modal').on('hidden.bs.modal', function(){
                              refund_reflect();
                            });
                            $('#btn_refund_save').button('reset');
                          }
                        });

                }

              }

            });

      }

  });

});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>