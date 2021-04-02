<?php
include "../../../../../model/model.php";

$train_ticket_id = $_POST['train_ticket_id'];
?>

<div class="row mg_tp_20">

	<div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
		<div class="widget_parent-bg-img bg-img-red">
			<?php     
				$sq_train_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$train_ticket_id'"));
				$sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$train_ticket_id' AND clearance_status!='Pending' AND clearance_status!='Cancelled'"));
				$service_tax_amount = 0;
				if($sq_train_ticket_info['service_tax_subtotal'] !== 0.00 && ($sq_train_ticket_info['service_tax_subtotal']) !== ''){
					$service_tax_subtotal1 = explode(',',$sq_train_ticket_info['service_tax_subtotal']);
					for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
						$service_tax = explode(':',$service_tax_subtotal1[$i]);
						$service_tax_amount = $service_tax_amount + $service_tax[2];
					}
				}
				
	            begin_widget();
	                $title_arr = array("Booking Amount", "Service Charge", "Delivery Charge","Tax","Roundoff","Total Amount");
	                $content_arr = array( $sq_train_ticket_info['basic_fair'] , $sq_train_ticket_info['service_charge'],$sq_train_ticket_info['delivery_charges'], $service_tax_amount,$sq_train_ticket_info['roundoff'],$sq_train_ticket_info['net_total']);
	                $percent = ($sq_payment_info['sum']/$sq_train_ticket_info['net_total'])*100;
	                $percent = round($percent, 2);
	                $label = "Ticket Fee Paid In Percent";
	                widget_element($title_arr, $content_arr, $percent, $label, $head_title);
	            end_widget();
	        ?>
	            <input type="hidden" id="total_sale" name="total_sale" value="<?= $sq_train_ticket_info['net_total']?>">	        
	            <input type="hidden" id="total_paid" name="total_paid" value="<?= $sq_payment_info['sum']?>">	  
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-10  col-xs-12 mg_tp_10">
		<input type="checkbox" id="check_all" name="check_all" onClick="select_all_check(this.id,'traveler_names')">&nbsp;&nbsp;&nbsp;<span style="text-transform: initial;">Check All</span>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3 col-xs-12"> <div class="table-responsive">

		<table class="table table-bordered table-hover mg_bt_0">
			<thead>
				<tr class="table-heading-row">
					<th>S_No.</th>
					<th>Guest_Name</th>
					<th>Cancel</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 0;
			$disabled_count= 0;
			$sq_train_ticket_entries = mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id'");
			while($row_entry = mysql_fetch_assoc($sq_train_ticket_entries)){

				if($row_entry['status']=="Cancel"){
					$bg = "danger"; 
					$checked = "checked disabled";
					++$disabled_count;
				}
				else{
					$bg = ""; 
					$checked = "";
				}
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= $row_entry['first_name'].' '.$row_entry['last_name'] ?></td>
					<td>
						<input type="checkbox" id="chk_entry_id_<?= $count ?>" class="traveler_names" name="chk_entry_id" <?= $checked ?> value="<?= $row_entry['entry_id'] ?>">
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
			
		</table>
		<input type="hidden" id="pass_count" name="pass_count" value="<?= $count ?>">
		<input type="hidden" id="disabled_count" name="disabled_count" value="<?= $disabled_count ?>">
		<div class="panel panel-default panel-body text-center">
			<button class="btn btn-danger btn-sm ico_left" onclick="cancel_booking()"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel Booking</button>
		</div>
		<div class="note"><span style="color: red;line-height: 35px;" data-original-title="" title=""><?= $cancel_feild_note ?></span></div>
	</div> </div> 

</div>
<hr>
<?php 
$sq_cancel_count = mysql_num_rows(mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id' and status='Cancel'"));
if($sq_cancel_count>0){
	$sq_train_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$train_ticket_id'"));
?>
<form id="frm_refund" class="mg_bt_150">

	<div class="row text-center">
		<div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" name="cancel_amount" id="cancel_amount" class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_train_ticket_info['cancel_amount'] ?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_train_ticket_info['refund_net_total'] ?>">
		</div>
	</div>
	<?php if($sq_train_ticket_info['cancel_amount'] == "0.00"){ ?>
	<div class="row mg_tp_20">
	  <div class="col-md-4 col-md-offset-4 text-center">
	      <button id="btn_refund_save" class="btn btn-sm btn-success" id="cancel_booking"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
	  </div>
	</div>
	<?php } ?>

</form>
<?php } ?>

<script>
function cancel_booking(){

	var entry_id_arr = new Array();
	$('input[name="chk_entry_id"]:checked').each(function(){
		entry_id_arr.push($(this).val());
	});

	//Validaion to select complete tour cancellation 
	var pass_count = $('#pass_count').val();
	var disabled_count = $('#disabled_count').val();
	var len = $('input[name="chk_entry_id"]:checked').length;
	if(len!=pass_count){
		error_msg_alert('Please select all guest for cancellations.');
	}
	else if(pass_count == disabled_count){
		error_msg_alert('All the Passengers have been already cancelled');
	}
	else
	{
		$('#vi_confirm_box').vi_confirm_box({
	              message: 'Are you sure?',
	      callback: function(data1){
	          if(data1=="yes"){

	              var base_url = $('#base_url').val();
	              $('#cancel_booking').button('loading');
	              $.ajax({
	                type: 'post',
	                url: base_url+'controller/visa_passport_ticket/train_ticket/cancel/cancel_booking.php',
	                data:{ entry_id_arr : entry_id_arr },
	                success: function(result){
	                  msg_alert(result);
	                  $('#cancel_booking').button('reset');
	                  content_reflect();
	                }
	              });

	          }
	        }
	  	});
	}
}

function calculate_total_refund()
{
	var total_refund_amount = 0;
	var cancel_amount = $('#cancel_amount').val();
	var total_sale = $('#total_sale').val();
	var total_paid = $('#total_paid').val();

	if(cancel_amount==""){ cancel_amount = 0; }
	if(total_paid==""){ total_paid = 0; }

	if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); }
	var total_refund_amount = parseFloat(total_paid) - parseFloat(cancel_amount);
	
	if(parseFloat(total_refund_amount) < 0){ 
		total_refund_amount = 0;
	}
	$('#total_refund_amount').val(total_refund_amount.toFixed(2));
}

$(function(){
  $('#frm_refund').validate({
      rules:{
              train_ticket_id : { required: true },
			  refund_basic_fair : { required : true, number : true },
			  refund_service_charge : { required : true, number : true },
			  refund_delivery_charges : { required : true, number : true },
			  refund_service_tax_subtotal : { required : true, number : true },
			  refund_net_total : { required : true, number : true }
      },
      submitHandler:function(form){

              var train_ticket_id = $('#train_ticket_id').val();
              var cancel_amount = $('#cancel_amount').val();
              var total_refund_amount = $('#total_refund_amount').val();
			  var total_sale = $('#total_sale').val();
			  var total_paid = $('#total_paid').val();

			  if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); return false; }

              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');

                        $.ajax({
                          type:'post',
                          url: base_url()+'controller/visa_passport_ticket/train_ticket/cancel/refund_estimate_update.php',
                          data:{ train_ticket_id : train_ticket_id, cancel_amount : cancel_amount, total_refund_amount : total_refund_amount },
                          success:function(result){
                            msg_alert(result);
                            content_reflect();
                            $('#btn_refund_save').button('reset');
                          },
                          error:function(result){
                            console.log(result.responseText);
                          }
                        });

                }
              }
            });


      }

  });

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>