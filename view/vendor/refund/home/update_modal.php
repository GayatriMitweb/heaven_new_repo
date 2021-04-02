<?php 
include_once('../../../../model/model.php');
include_once('../../inc/vendor_generic_functions.php');

$refund_id = $_POST['refund_id'];
$sq_vendor_refund_master = mysql_fetch_assoc(mysql_query("select * from vendor_refund_master where refund_id='$refund_id'"));
$sq_estimate = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$sq_vendor_refund_master[estimate_id]'"));

$purchase = $sq_estimate['estimate_amount'] - $sq_estimate['refund_total_amount'];

$vendor=$sq_estimate['vendor_type'];
$vendor_id=$sq_estimate['vendor_type_id'];

$sq_payment_info1 = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sumpay from vendor_payment_master where vendor_type='$vendor' and vendor_type_id='$vendor_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_refunded_info1 = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sumpay from vendor_refund_master where estimate_id='$sq_vendor_refund_master[estimate_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));


$refund_amount =$sq_payment_info1['sumpay']-$purchase;

$total_refund =$refund_amount - $sq_refunded_info1['sumpay'];


$enable = ($sq_vendor_refund_master['payment_mode']=="Cash") ? "disabled" : "";
?>
<form id="frm_update">
<input type="hidden" id="refund_id" name="refund_id" value="<?= $refund_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Refund</h4>
      </div>
      <div class="modal-body">

				
		<div class="row mg_bt_10">                      
			  <div class="col-md-4 col-md-offset-4">
				<select id="estimate_id" name="estimate_id" style="width:100%" title="Supplier Costing" onchange="estimate_id_reflect()">
			        <?php 
			        $vendor_type_val = get_vendor_name($sq_estimate['vendor_type'], $sq_estimate['vendor_type_id']);
			        ?>
			        <option value="<?= $sq_estimate['estimate_id'] ?>"><?= get_vendor_estimate_id($sq_estimate['estimate_id'])." : ".$vendor_type_val."(".$sq_estimate['vendor_type'].")" ?></option>
			        <option value="">Supplier Costing</option>
			        <?php 
			        $sq_estimate1 = mysql_query("select * from vendor_estimate where status='Cancel' order by estimate_id desc");
			        while($row_estimate = mysql_fetch_assoc($sq_estimate1)){
			          $vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);
			          ?>
			          <option value="<?= $row_estimate['estimate_id'] ?>"><?= get_vendor_estimate_id($row_estimate['estimate_id'])." : ".$vendor_type_val."(".$row_estimate['vendor_type'].")" ?></option>
			          <?php
			        }
			        ?>
			    </select>
			  </div>  
    </div>
        <div class="row">
          <div id="div_refund_estimate">
            <div class="col-md-6 mg_tp_10">
              <div class="row">
                  <div class="col-md-12">
                    <div class="widget_parent-bg-img bg-img-red">
                     <div class="widget_parent">
                        <div class="stat_content main_block">
                            <span class="main_block content_span" data-original-title="" title="">
                                <span class="stat_content-tilte pull-left" data-original-title="" title="">Estimate Amount </span>
                                <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_estimate['estimate_amount']=="") ? 0 : $sq_estimate['estimate_amount'] ?></span>
                            </span> 
                           <span class="main_block content_span" data-original-title="" title="">                    
                                <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
                                <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_estimate['refund_total_amount']=="") ? 0 : $sq_estimate['refund_total_amount'] ?></span>
                            </span> 
                            <span class="main_block content_span" data-original-title="" title="">
                                <span class="stat_content-tilte pull-left" data-original-title="" title="">Purchase Amount</span>
                                <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($purchase=="") ? 0 : $purchase ?></span>
                            </span>
                        </div> 
                    </div>
                 </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mg_tp_10">
              <div class="row">
                <div class="col-md-12">
                  <div class="widget_parent-bg-img bg-img-purp">
                     <div class="widget_parent">
                        <div class="stat_content main_block">
                            <span class="main_block content_span" data-original-title="" title="">
                                <span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount </span>
                                <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_payment_info1['sumpay']=="") ? 0 : $sq_payment_info1['sumpay'] ?></span>
                            </span> 
                           <span class="main_block content_span" data-original-title="" title="">                    
                                <span class="stat_content-tilte pull-left" data-original-title="" title="">Purchase Amount</span>
                                <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($purchase=="") ? 0 : $purchase ?></span>
                            </span> 
                            <span class="main_block content_span" data-original-title="" title="">
                                <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
                                <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($refund_amount=="") ? 0 : $refund_amount ?></span>
                            </span>
                        </div> 
                    </div>
                 </div>
                </div>
              </div>
            </div>              
            <div class="col-md-6 mg_tp_10">
              <div class="widget_parent-bg-img bg-img-green">
               <div class="widget_parent">
                  <div class="stat_content main_block">
                      <span class="main_block content_span" data-original-title="" title="">
                          <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount </span>
                          <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($refund_amount=="") ? 0 : $refund_amount ?></span>
                      </span> 
                     <span class="main_block content_span" data-original-title="" title="">                    
                          <span class="stat_content-tilte pull-left" data-original-title="" title="">Refunded Amount</span>
                          <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_refunded_info1['sumpay']=="") ? 0 : $sq_refunded_info1['sumpay'] ?></span>
                      </span> 
                      <span class="main_block content_span" data-original-title="" title="">
                          <span class="stat_content-tilte pull-left" data-original-title="" title="">Total Amount</span>
                          <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($total_refund=="") ? 0 : $total_refund ?></span>
                      </span>
                  </div> 
              </div>
           </div>
            </div>             
          </div>           
        </div>
        <hr>
        <div class="row ">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-4">
                  <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="Date" title="Payment Date" value="<?= date('d-m-Y', strtotime($sq_vendor_refund_master['payment_date'])) ?>">
                </div>                    
                <div class="col-md-4">
                  <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="Amount" title="Payment Amount" value="<?= $sq_vendor_refund_master['payment_amount'] ?>" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name')">
                </div>
                <div class="col-md-4">
                  <select name="payment_mode" id="payment_mode" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                    <option value="<?= $sq_vendor_refund_master['payment_mode'] ?>"><?= $sq_vendor_refund_master['payment_mode'] ?></option>
                    <?php get_payment_mode_dropdown(); ?>
                  </select>
                </div>  
              </div>
              <div class="row mg_tp_10">                
                <div class="col-md-4">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_vendor_refund_master['bank_name'] ?>" <?= $enable ?>>
                </div>                        
                <div class="col-md-4">
                  <input type="text" id="transaction_id" onchange="validate_balance(this.id)" name="transaction_id" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_vendor_refund_master['transaction_id'] ?>" <?= $enable ?>>
                </div>
                <div class="col-md-4">
                  <select name="bank_id" id="bank_id" title="Creditor Bank" <?= $enable ?>>
                    <?php 
                    $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_vendor_refund_master[bank_id]'"));
                    if($sq_bank['bank_id'] != ''){
                    ?>
                    <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                    <?php } get_bank_dropdown(); ?>
                  </select>
                </div>  
              </div>
              <div id="div_vendor_bid1"></div>
              <div class="row text-center mg_tp_10 mg_bt_10">
                <div class="col-md-12">
                  <button class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
                </div>
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
$('#request_id1').select2();
$('#update_modal').modal('show');
estimate_id_reflect();
$(function(){
	$('#frm_update').validate({
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

				var refund_id = $('#refund_id').val();

				var estimate_id = $('#estimate_id').val();
 				var payment_amount = $('#payment_amount').val();
                var payment_date = $('#payment_date').val();
                var payment_mode = $('#payment_mode').val();
                var bank_name = $('#bank_name').val();
                var transaction_id = $('#transaction_id').val();
                var bank_id = $('#bank_id').val();


 				var base_url = $('#base_url').val();

	            $.ajax({
	              type:'post',
	              url: base_url+'controller/vendor/refund/refund_update.php',
	              data:{ refund_id : refund_id, estimate_id : estimate_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
	              success:function(result){
	                  msg_alert(result);
	                  $('#update_modal').modal('hide');
	                  $('#update_modal').on('hidden.bs.modal', function(){
	                    list_reflect();
	                  });               
	              }
	            });
 
		}
	});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>