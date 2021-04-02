<?php
    $sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));
    $refund_amount = $sq_car_rental_info['total_refund_amount'];

    $sq_total_pay = mysql_fetch_array(mysql_query("SELECT sum(refund_amount) as sum from car_rental_refund_master where booking_id='$booking_id'"));
    $sq_pending_pay = mysql_fetch_array(mysql_query("SELECT sum(refund_amount) as sum from car_rental_refund_master where booking_id='$booking_id' AND clearance_status='Pending'"));
    $sq_cancel_pay = mysql_fetch_array(mysql_query("SELECT sum(refund_amount) as sum from car_rental_refund_master where booking_id='$booking_id' AND clearance_status='Cancelled'"));
    $totalrefund=$refund_amount;

    $totalpay=$sq_total_pay['sum'] - $sq_cancel_pay['sum'];
    $remaining= $totalrefund - $totalpay;
?>
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Save Refund</h4>
      </div>
      <div class="modal-body">

          <form id="frm_refund_save">       
            <div class="row mg_bt_10 text-center">  
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="hidden" id="remianing_total" name="remianing_total" value="<?php echo $remaining;?>">
                  <input type="text" id="refund_amount" name="refund_amount" title="Refund Amount" placeholder="*Refund Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'refund_mode','transaction_id','bank_name')">
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="refund_date" name="refund_date" title="Refund Date" placeholder="*Refund Date" value="<?= date('d-m-Y')?>">
                </div>   
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <select id="refund_mode" name="refund_mode" class="form-control" required title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
						        <?php get_payment_mode_dropdown(); ?>
                  </select>  
              </div> 
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled/>
              </div>      
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id)" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled/>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                  <select name="bank_id" id="bank_id" title="Bank" disabled>
                            <?php get_bank_dropdown('Debitor Bank')  ?>
                        </select>
                </div>
            </div>
            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                  <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
            </div>
          </form>

      </div>
    </div>
  </div>
</div>

<script>
$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$(function(){
  $('#frm_refund_save').validate({
      rules:{
              booking_id : { required: true },
              refund_amount :{required:true , number : true},
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
              var remianing_total = $('#remianing_total').val();
              console.log(Number(refund_amount),Number(remianing_total));
              var base_url = $('#base_url').val();
              if(typeof($("#ref_amt")) != "undefined" && (Number($("#ref_amt").val()) ==  Number($('#refund_amount_to_give').val()) && (Number($("#ref_amt").val()) != 0))){
                error_msg_alert("Refund Already Fully Paid"); return false;
              }
              else if( Number(refund_amount) > Number(remianing_total)){
                error_msg_alert("Amount can not be greater than total refund amount");
                return false;
              }

              $('#vi_confirm_box').vi_confirm_box({

                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');


                        $.ajax({
                          type:'post',
                          url: base_url+'controller/car_rental/refund/refund_save.php',
                          data:{ booking_id : booking_id, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
                          success:function(result){
                            msg_alert(result);
                            $('#btn_refund_save').button('reset');
                            $('#save_modal').modal('hide');
                            reset_form('frm_refund_save');

                            $('#save_modal').on('hidden.bs.modal', function(){
                              refund_content_reflect();
                            });
                          }
                        });

                }
              }
            });

      }
  });
});
</script>