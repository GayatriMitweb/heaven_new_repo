<?php
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];
?>
<div class="panel panel-default panel-body">

<div class="row">
	
	<div class="col-md-8">
	
		<form id="frm_refund_save">
			
			<div class="row mg_bt_20 text-center">    
			    <div class="col-md-4">
			      <input type="text" id="refund_amount" onchange="validate_balance(this.id)" name="refund_amount" placeholder="Amount">
			    </div>
			    <div class="col-md-4">
			      <input type="text" id="refund_date" name="refund_date" placeholder="*Date">
			    </div>   
			    <div class="col-md-4">
				    <select id="refund_mode" name="refund_mode" class="form-control" required title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
				       <?php echo get_payment_mode_dropdown(); ?>
				    </select>  
				</div> 
			</div>
			<div class="row mg_bt_10">
				<div class="col-md-4">
				    <input type="text" id="bank_name" onchange="fname_validate(this.id);" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled />
				</div>      
			    <div class="col-md-4">
			    	<input type="text" id="transaction_id" onchange="validate_balance(this.id);" name="transaction_id" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled />
			  	</div>
			  	<div class="col-md-4">
			  		<select name="bank_id" id="bank_id" title="Bank" disabled>
	                    <?php get_bank_dropdown('Debitor Bank')  ?>
	                </select>
			  	</div>
			</div>
			<div class="row mg_bt_10">
				<div class="col-md-4">
					<input type="text" name="refund_charges" id="refund_charges" onchange="validate_balance(this.id)" placeholder="Refund Charges" title="Refund Charges">
				</div>
				<div class="col-md-4">
				  	<select name="entry_id" id="entry_id" multiple>
				  		<?php 
				  		$sq_hotel_entries = mysql_query("select * from hotel_booking_entries where booking_id='$booking_id' and status='Cancel'");
				  		while($row_entry = mysql_fetch_assoc($sq_hotel_entries)){

				  			$sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_entry[hotel_id]'"));
				  			?>
							<option value="<?= $row_entry['entry_id'] ?>"><?= $sq_hotel_info['hotel_name'] ?></option>
				  			<?php
				  		}
				  		?>
				  	</select>
				 </div>
			</div>

			<div class="row text-center mg_tp_20">
			  <div class="col-md-12">
			      <button id="btn_refund_save" class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
			  </div>
			</div>

		</form>

	</div>
	<div class="col-md-4">

		<?php     
			$sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
			$sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$booking_id'"));
			$sq_refund_info = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from hotel_booking_refund_master where booking_id='$booking_id'"));
			
            begin_widget();
                $title_arr = array("Hotel Amount", "Paid Amount", "Refund Amount");
                $content_arr = array( $sq_hotel_info['booking_amount'] , $sq_payment_info['sum'], $sq_refund_info['sum']);
                $percent = ($sq_payment_info['sum']/$sq_hotel_info['booking_amount'])*100;
                $percent = round($percent, 2);
                $label = "Hotel Fee Paid In Percent";
                widget_element($title_arr, $content_arr, $percent, $label, $head_title);
            end_widget();
        ?>

		
	</div>

</div>

</div>


<div class="row"> 

<div class="col-md-4"> <div class="table-responsive">

<table class="table table-bordered table-hover mg_bt_0">
	<thead>
		<tr>
			<th>Sr. No</th>
			<th>Hotel Name</th>
			<th>Cancel</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$count = 0;
	$sq_hotel_entries = mysql_query("select * from hotel_booking_entries where booking_id='$booking_id'");
	while($row_entry = mysql_fetch_assoc($sq_hotel_entries)){

		$bg = ($row_entry['status']=="Cancel") ? "danger" : "";
		$checked = ($row_entry['status']=="Cancel") ? "checked disabled" : "";

		$sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_entry[hotel_id]'"));
		?>
		<tr class="<?= $bg ?>">
			<td><?= ++$count ?></td>
			<td><?= $sq_hotel_info['hotel_name'] ?></td>
			<td>
				<input type="checkbox" id="chk_entry_id_<?= $count ?>" name="chk_entry_id" <?= $checked ?> value="<?= $row_entry['entry_id'] ?>">
			</td>
		</tr>
		<?php
	}
	?>

	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" class="text-center">
				<button class="btn btn-danger" onclick="cancel_booking()"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel Booking</button>
			</td>
		</tr>
	</tfoot>
</table>

</div> </div> 

<div class="col-md-8"> <div class="table-responsive">
	
<table class="table table-bordered" id="tbl_refund_list">
	<thead>
		<tr>
			<th>Sr. No</th>
			<th>Refund To</th>
			<th>Refund Charges</th>
			<th>Refund Date</th>
			<th>Amount</th>
			<th>Mode</th>
			<th>Bank Name</th>
			<th>Tansaction ID</th>
			<th>Voucher</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$query = "select * from hotel_booking_refund_master where booking_id='$booking_id'";
		$count = 0;
		$sq_hotel_refund = mysql_query($query);
		while($row_hotel_refund = mysql_fetch_assoc($sq_hotel_refund)){

			$count++;

			$total_refund = $total_refund+$row_hotel_refund['refund_amount'];

			$sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$row_hotel_refund[booking_id]'"));
			
			$hotel_name = "";
			$sq_refund_entries = mysql_query("select * from hotel_booking_refund_entries where refund_id='$row_hotel_refund[refund_id]'");
			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){

				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from hotel_booking_entries where entry_id='$row_refund_entry[entry_id]'"));

				$sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$sq_entry_info[hotel_id]'"));
				$hotel_name .= $sq_hotel_info['hotel_name'].', ';
			}
			$hotel_name = trim($hotel_name, ", ");
			?>
			<tr>			
				<td><?= $count ?></td>
				<td><?= $hotel_name ?></td>
				<td><?= $row_hotel_refund['refund_charges'] ?></td>
				<td><?= date('d-m-Y', strtotime($row_hotel_refund['refund_date'])) ?></td>
				<td><?= $row_hotel_refund['refund_amount'] ?></td>
				<td><?= $row_hotel_refund['refund_mode'] ?></td>
				<td><?= $row_hotel_refund['bank_name'] ?></td>
				<td><?= $row_hotel_refund['transaction_id'] ?></td>
				<td>
					<a href="cancel_and_refund/refund_voucher.php?refund_id=<?= $row_hotel_refund['refund_id'] ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i></a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>	
	<tfoot>
		<tr>
			<th colspan="3" class="text-right">Total Refund</th>
			<th><?= $total_refund ?></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>

</div> 

</div>

</div>


<script>
function cancel_booking(){

	var entry_id_arr = new Array();

	$('input[name="chk_entry_id"]:checked').each(function(){
		entry_id_arr.push($(this).val());
	});

	$('#vi_confirm_box').vi_confirm_box({
              message: 'Are you sure?',
      callback: function(data1){
          if(data1=="yes"){
            
              var base_url = $('#base_url').val();
              
              $.ajax({
                type: 'post',
                url: base_url+'controller/hotel/cancel/cancel_booking.php',
                data:{ entry_id_arr : entry_id_arr },
                success: function(result){
                  msg_alert(result);
                  hotel_entries_reflect();
                }
              });

          }
        }
  	});

}

$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$(function(){
  $('#frm_refund_save').validate({
      rules:{
              booking_id : { required: true }, 
              refund_charges : { required: true, number:true },
              refund_amount : { required: true, number:true },
              refund_date : { required: true },
              refund_mode : { required : true },
              bank_name : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              bank_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              entry_id: { required : true },    
      },
      submitHandler:function(form){

              var booking_id = $('#booking_id').val(); 
              var refund_charges = $('#refund_charges').val();
              var refund_amount = $('#refund_amount').val();
              var refund_date = $('#refund_date').val();
              var refund_mode = $('#refund_mode').val();
              var bank_name = $('#bank_name').val();
              var transaction_id = $('#transaction_id').val();
              var bank_id = $('#bank_id').val();

              var entry_id_arr = new Array();
              $('#entry_id option:selected').each(function(){
              	entry_id_arr.push($(this).val());
              });

              var base_url = $('#base_url').val();

              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){
                        
                        $('#btn_refund_save').button('loading');

                        $.ajax({
                          type:'post',
                          url: base_url+'controller/hotel/refund/refund_save.php',
                          data:{ booking_id : booking_id, refund_charges : refund_charges, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, entry_id_arr : entry_id_arr },
                          success:function(result){
                            msg_alert(result);
                            hotel_entries_reflect();
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