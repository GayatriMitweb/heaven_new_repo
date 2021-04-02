<?php
include "../../../../model/model.php";
//include"../../../../../model/app_settings/app_generic_functions.php";

$exc_id = $_POST['exc_id'];

$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$exc_id'"));
$sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from exc_payment_master where exc_id='$exc_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$sq_refund_amount1 = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from exc_refund_master where exc_id='$exc_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$sq_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from exc_refund_master where exc_id='$exc_id'"));
$refund_amount1 = ($sq_pay['sum'] == '')?'0':$sq_pay['sum'];

$sq_pend_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from exc_refund_master where exc_id='$exc_id' and clearance_status='Pending'"));
$pend_amount = ($sq_pend_pay['sum'] == '')?'0':$sq_pend_pay['sum'];

$sq_canl_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from exc_refund_master where exc_id='$exc_id' and clearance_status='Cancelled'"));
$can_amount = ($sq_canl_pay['sum'] == '')?'0':$sq_canl_pay['sum'];

$total_refund_pay=$refund_amount1 - $can_amount;

$sale_Amount = $sq_exc_info['exc_total_cost'];
$paid_amount = $sq_paid_amount['sum'];
$cancel_amount = $sq_exc_info['cancel_amount'];
$refund_amount = $sq_exc_info['total_refund_amount'];

$remaining_pay=$refund_amount-$total_refund_pay;
?>
<input type="hidden" id="refund_amount_tobe" name="refund_amount_tobe" value="<?php echo $refund_amount ?>">
<div class="row mg_tp_20 mg_bt_10">
	<div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12 mg_bt_10_xs">
		<div class="widget_parent-bg-img bg-green">
			<div class="widget_parent">
				<div class="stat_content main_block">
			        <span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Total Sale</span>
						<span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sale_Amount=='')?'0.00': number_format($sale_Amount,2) ?></span>
			        </span>
			        <span class="main_block content_span" data-original-title="" title="">
			         	<span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount</span>
			        	<span class="stat_content-amount pull-right" data-original-title="" title=""> <?= ($paid_amount=='')?'0.00': $paid_amount?></span>
			        </span>	
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?= number_format($cancel_amount, 2); ?></span>
			        </span>	        
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($refund_amount, 2); ?></span>
			        </span>
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Pending Refund</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($remaining_pay, 2); ?></span>
			        </span>
			    </div>	 
			</div>
		</div>		
	</div>
</div>

<hr>

<div class="row">

	<div class="col-md-5 col-sm-12 col-xs-12 mg_bt_20_xs">

		<form id="frm_refund_save">
        <h3 class="editor_title">Refund Details</h3>
    	<div class="panel panel-default panel-body mg_bt_10">

			<div class="row  text-center">    
			    <div class="col-sm-6 col-xs-12 mg_bt_10">
			      <input type="text" id="refund_amount" name="refund_amount" title="Refund Amount" placeholder="*Refund Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'refund_mode','transaction_id','bank_name')">

			    <input type="hidden" name="remaining_pay" id="remaining_pay" value="<?php echo $remaining_pay; ?>">
			    </div>
			    <div class="col-sm-6 col-xs-12 mg_bt_10">
			      <input type="text" id="refund_date" name="refund_date" title="Refund Date"  placeholder="*Refund Date" value="<?= date('d-m-Y')?>">
			    </div>   			    
				<div class="col-sm-6 col-xs-12 mg_bt_10">
				    <select id="refund_mode" name="refund_mode" class="form-control" required title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
						<?php get_payment_mode_dropdown(); ?>
				    </select>  
				</div> 
				<div class="col-sm-6 col-xs-12 mg_bt_10">
				    <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled/>
				</div>      			    
				<div class="col-sm-6 col-xs-12 mg_bt_10">
			    	<input type="text" id="transaction_id" onchange="validate_balance(this.id)" name="transaction_id" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled/>
			  	</div>
			  	<div class="col-sm-6 col-xs-12 mg_bt_10">
			  		<select name="bank_id" id="bank_id" title="Bank" disabled>
	                    <?php get_bank_dropdown('Debitor Bank')  ?>
	                </select>
			  	</div>
			</div>
			<div class="row mg_bt_10">				
				<div class="col-xs-12">
				  	<select name="entry_id" id="entry_id" multiple>
				  		<?php 
				  		$sq_exc_entries = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$exc_id'"));
				  		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc_entries[customer_id]'"));
				  		?>
							<option value="<?= $sq_cust['customer_id'] ?>"><?= $sq_cust['first_name'].' '.$sq_cust['last_name'] ?></option>
				  	</select>
				 </div>
			</div>
			<div class="row text-center mg_tp_20">
			  <div class="col-xs-12">
			      <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
			  </div>
			</div>
		</div>
		</form>

	</div>

	<div class="col-md-7 col-sm-12 col-xs-12">
        <h3 class="editor_title">Refund History</h3>
    	<div class="panel panel-default panel-body no-pad"> 
		<div class="table-responsive">
		<table class="table table-hover table-bordered" id="tbl_refund_list" style="margin: 0 !important;">
			<thead>
				<tr class="table-heading-row">
					<th>S_No.</th>
					<th>Refund_To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th>Refund_Date</th>
					<th>Amount</th>
					<th>Mode</th>
					<th>Bank_Name</th>
					<th>Cheque_No/ID</th>
					<th>Voucher</th>
				</tr>
			</thead>
			<tbody>
				<?php 				

				$total_refund = 0;
				$query = "select * from exc_refund_master where exc_id='$exc_id' and refund_amount!='0'";
				$count = 0;
				$bg;
				$sq_exc_refund = mysql_query($query);				
				while($row_exc_refund = mysql_fetch_assoc($sq_exc_refund)){

					$count++;

					$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$row_exc_refund[exc_id]'"));

					$cust_name = "";
					$sq_refund_entries = mysql_query("select * from exc_refund_entries where refund_id='$row_exc_refund[refund_id]'");
					if($row_exc_refund['clearance_status']=='Pending'){ $bg = "warning"; }
					else if($row_exc_refund['clearance_status']=='Cancelled'){ $bg = "danger"; }
					else{ $bg = ""; }

					while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){
						$sq_cust = mysql_fetch_assoc(mysql_query("select * from excursion_master where customer_id='$row_refund_entry[entry_id]'"));
						  $date = $sq_cust['created_at'];
				          $yr = explode("-", $date);
				          $year =$yr[0];
						$s_query = "select * from customer_master where customer_id='$sq_cust[customer_id]'";
						$sq_entry_info = mysql_fetch_assoc(mysql_query($s_query));
						$cust_name = $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'];												
					

					$v_voucher_no = get_exc_booking_refund_id($row_exc_refund['refund_id'],$year);
					$v_refund_date = $row_exc_refund['refund_date'];
					$v_refund_to = $cust_name;
					$v_service_name = "Excursion Booking";
					$v_refund_amount = $row_exc_refund['refund_amount'];
					$v_payment_mode = $row_exc_refund['refund_mode'];
					$customer_id = $sq_entry_info['customer_id'];
					$refund_id = $row_exc_refund['refund_id'];
					$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode&customer_id=$customer_id&refund_id=$refund_id";				
					?>
					<tr class="<?= $bg ?>">			
						<td><?= $count ?></td>
						<td><?= $cust_name ?></td>
						<td><?= date('d/m/Y', strtotime($row_exc_refund['refund_date'])) ?></td>
						<td><?= $row_exc_refund['refund_amount'] ?></td>
						<td><?= $row_exc_refund['refund_mode'] ?></td>
						<td><?= $row_exc_refund['bank_name'] ?></td>
						<td><?= $row_exc_refund['transaction_id'] ?></td>
						<td><a href="<?= $url ?>" class="btn btn-danger btn-sm" target="_blank" title="Voucher"><i class="fa fa-file-pdf-o"></i></a></td>
					</tr>
					<?php
				}
			}
				?>
			</tbody>	
			<tfoot>
				<?php 
				
				?>
				<tr class="active">
					<th colspan="2" class="info">Refund : <?= number_format($refund_amount1,2); ?></th>
					<th colspan="2" class="warning">Pending : <?= number_format($pend_amount,2); ?></th>
					<th colspan="2" class="danger">Cancelled : <?= number_format($can_amount,2); ?></th>
					<th colspan="2" class="success">Total Refund : <?= number_format($refund_amount1-$pend_amount-$can_amount,2); ?></th>
				</tr>
			</tfoot>
		</table>
		</div> 
		</div> 
		</div>
		<input type="hidden" id="ref_amt" value="<?= ($refund_amount1=="") ? 0 : $refund_amount1 ?>">
</div>
<script>
$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$(function(){
  $('#frm_refund_save').validate({
      rules:{
              exc_id : { required: true },
              refund_amount : { required: true, number:true },
              refund_date : { required: true },
              refund_mode : { required : true },
              bank_name : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              transaction_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              bank_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              entry_id: { required : true },    
      },
      submitHandler:function(form){

              var exc_id = $('#exc_id').val();
              var refund_amount = $('#refund_amount').val();
              var refund_date = $('#refund_date').val();
              var refund_mode = $('#refund_mode').val();
              var bank_name = $('#bank_name').val();
              var bank_id = $('#bank_id').val();
              var transaction_id = $('#transaction_id').val();
              var remaining_pay = $('#remaining_pay').val();

              var entry_id_arr = new Array();
              $('#entry_id option:selected').each(function(){
              	entry_id_arr.push($(this).val());
              });

              var base_url = $('#base_url').val();
			  if(typeof($("#ref_amt")) != "undefined" && (Number($("#ref_amt").val()) ==  Number($('#refund_amount_tobe').val()))){
                error_msg_alert("Refund Already Fully Paid"); return false;
              }
              else if(Number(refund_amount) > Number(remaining_pay))
              { error_msg_alert("Amount can not be greater than total refund amount"); return false; }
             
              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');


                        $.ajax({
                          type:'post',
                          url: base_url+'controller/excursion/refund/refund_save.php',
                          data:{ exc_id : exc_id, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, entry_id_arr : entry_id_arr },
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