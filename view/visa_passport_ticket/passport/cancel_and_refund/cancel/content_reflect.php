<?php
include "../../../../../model/model.php";

$passport_id = $_POST['passport_id'];
?>

<div class="row mg_tp_20">

	<div class="col-md-7 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-12 mg_bt_20_xs">
		<div class="widget_parent-bg-img bg-img-red">
			<?php     
				$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
				$sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from passport_payment_master where passport_id='$passport_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
				$sq_refund_info = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from passport_refund_master where passport_id='$passport_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

				$service_tax_amount = 0;
				if($sq_passport_info['service_tax_subtotal'] !== 0.00 && ($sq_passport_info['service_tax_subtotal']) !== ''){
					$service_tax_subtotal1 = explode(',',$sq_passport_info['service_tax_subtotal']);
					for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
						$service_tax = explode(':',$service_tax_subtotal1[$i]);
						$service_tax_amount = $service_tax_amount + $service_tax[2];
					}
				}

	            begin_widget();
	                $title_arr = array("Booking","Serv_Charge", "Tax", "Total_Amount", "Paid_Amount");
		            $content_arr = array( $sq_passport_info['passport_issue_amount'] ,$sq_passport_info['service_charge'], $service_tax_amount, $sq_passport_info['passport_total_cost'], $sq_payment_info['sum']);
		            $percent = ($sq_payment_info['sum']/$sq_passport_info['passport_total_cost'])*100;
	                $percent = round($percent, 2);
	                $label = "Passport Fees Paid In Percent";
	                widget_element($title_arr, $content_arr, $percent, $label, $head_title);
	            end_widget();
	        ?>
	            <input type="hidden" id="total_sale" name="total_sale" value="<?= $sq_passport_info['passport_total_cost']?>">	        
	            <input type="hidden" id="total_paid" name="total_paid" value="<?= $sq_payment_info['sum']?>">
		</div>
		
	</div>

	<div class="col-md-5 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-12"> <div class="table-responsive">
	<input type="checkbox" id="check_all" name="check_all" onClick="select_all_check(this.id,'traveler_names')">&nbsp;&nbsp;&nbsp;<span style="text-transform: initial;">Check All</span>
		<table class="table table-hover table-bordered mg_bt_0" style="margin: 0 !important;">
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
			$sq_passport_entries = mysql_query("select * from passport_master_entries where passport_id='$passport_id'");
			while($row_entry = mysql_fetch_assoc($sq_passport_entries)){
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
			<button class="btn btn-danger btn-sm ico_left" id="cancel_booking" onclick="cancel_booking()"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel Booking</button>
		</div>
		<div class="note"><span style="color: red;line-height: 35px;" data-original-title="" title=""><?= $cancel_feild_note ?></span></div>
		</div> </div> 

</div>
<hr>
	<?php 
	$sq_cancel_count = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$passport_id' and status='Cancel'"));
	if($sq_cancel_count>0){
		$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
	?>	
	<form id="frm_refund">

		<div class="row text-center">
			<div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" name="cancel_amount" id="cancel_amount" class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_passport_info['cancel_amount'] ?>">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_passport_info['total_refund_amount'] ?>">
			</div>
		</div>
		<?php if($sq_passport_info['cancel_amount'] == "0.00"){ ?>
		<div class="row mg_tp_20">
		  <div class="col-md-3 col-md-offset-5">
		      <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
		  </div>
		</div>
		<?php } ?>

	</form>
	<?php 
	}
	?>


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
	                url: base_url+'controller/visa_passport_ticket/passport/cancel/cancel_booking.php',
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
              passport_id : { required: true },
              refund_amount : { required : true, number : true },
              total_refund_amount : { required : true, number : true },
      },
      submitHandler:function(form){

              var passport_id = $('#passport_id').val();
              var cancel_amount = $('#cancel_amount').val();
              var total_refund_amount = $('#total_refund_amount').val();
			  var total_sale = $('#total_sale').val();
			  var total_paid = $('#total_paid').val();


              var base_url = $('#base_url').val();
              if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); return false; }

              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');

                        $.ajax({
                          type:'post',
                          url: base_url+'controller/visa_passport_ticket/passport/cancel/refund_estimate_update.php',
                          data:{ passport_id : passport_id, cancel_amount : cancel_amount, total_refund_amount : total_refund_amount },
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