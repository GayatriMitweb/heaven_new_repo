<?php include "../../../../../model/model.php"; ?>
<?php 
$payment_mode = $_GET['payment_mode'];
?>

<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover">
<thead>
<tr>
    <th></th>
    <th>S.N.</th>
    <th>Receipt ID</th>
    <th>Booking ID</th>
    <th>Customer Name</th>
    <th>Payment Date</th>
    <th>Tour Name</th>
    <th>Tour Group</th>
    <th>Amount</th>
    <th>Payment Mode</th>
    <?php 
    if($payment_mode=="Cheque"){
      ?>
      <th>Branch Name</th>
      <?php
    }
    ?>
</tr>
</thead>
<tbody>
<?php
$count=0;

$payment_query = "select * from payment_master where amount!='0' ";

if($payment_mode!=""){
  $payment_query .=" and payment_mode='$payment_mode' ";  
}
if(isset($_GET['tour_id']))
{
 	$tour_id = $_GET['tour_id'];
 	$tour_group_id = $_GET['tour_group_id'];

 	if($tour_id!="")
 	{
 		$payment_query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where tour_id='$tour_id' ";
 		if($tour_group_id!="")
 		{	
 			$payment_query .= " and tour_group_id='$tour_group_id' )";
 		}	
 		else
 		{
 			$payment_query .= " )";
 		}	
 	}	
}

$sq_payment = mysql_query($payment_query);

while($row_payment = mysql_fetch_assoc($sq_payment))
{
  $count++;

  $sq_receipt = mysql_fetch_assoc(mysql_query("select * from receipt_master where payment_id='$row_payment[payment_id]' "));
  $receipt_id = $_SESSION['unique_receipt_id'].''.$sq_receipt['receipt_id'];

  $sq_tourwise_det = mysql_fetch_assoc(mysql_query("select tour_id, tour_group_id, traveler_group_id from tourwise_traveler_details where id='$row_payment[tourwise_traveler_id]'"));

  $sq_traveler_det = mysql_fetch_assoc(mysql_query("select first_name, last_name from travelers_details where traveler_group_id='$sq_tourwise_det[traveler_group_id]'"));

  $tour_name1 = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id= '$sq_tourwise_det[tour_id]'"));
  $tour_name = $tour_name1['tour_name'];

  $tour_group1 = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where group_id= '$sq_tourwise_det[tour_group_id]'"));
  $tour_group = date("d-m-Y", strtotime($tour_group1['from_date']))." to ".date("d-m-Y", strtotime($tour_group1['to_date']));

?>
<tr>
  <td><input type="checkbox" id="chk_receipt_<?= $count ?>" name="chk_receipt" data-amount="<?= $row_payment['amount'] ?>" data-payment-id="<?= $row_payment['payment_id'] ?>" data-offset="<?= $count ?>"></td>
	<td><?php echo $count; ?></td>
	<td><?php echo get_group_booking_payment_id($receipt_id); ?></td>
	<td><?php echo get_group_booking_id($row_payment['tourwise_traveler_id']); ?></td>
	<td><?php echo $sq_traveler_det['first_name']." ".$sq_traveler_det['last_name']; ?></td>
	<td><?php echo date('d-m-Y', strtotime($row_payment['date'])); ?></td>
	<td><?php echo $tour_name; ?></td>
	<td><?php echo $tour_group; ?></td>
	<td><?php echo $row_payment['amount']; ?></td>
	<td><?php echo $row_payment['payment_mode']; ?></td>
  <?php 
    if($payment_mode=="Cheque"){
      ?>
      <th>
        <input type="text" id="branch_name_<?= $count ?>" name="branch_name" placeholder="Branch Name">
      </th>
      <?php
    }
  ?>
</tr>	
<?php 
}	
?>
</tbody>
</table>
</div>  </div> </div>

</div>

<?php if($payment_mode=="cheque" || $payment_mode=="cash"): ?>
<div class="panel panel-default panel-body pad_8">
<div class="row">
  <div class="col-md-4">
    <select name="bank_name_reciept" id="bank_name_reciept" title="Bank Name" class="form-control">
      <?php 
      $sq_bank = mysql_query("select * from bank_name_master");
      while($row_bank = mysql_fetch_assoc($sq_bank)){
        ?>
        <option value="<?= $row_bank['label'] ?>"><?= $row_bank['bank_name'] ?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="col-md-4">
   <?php 
    if($payment_mode=="cheque"){
      ?>
      <button class="btn btn-danger ico_left" onclick="cheque_bank_receipt_generate()"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Bank Receipt</button>
      <?php
    }
    if($payment_mode=="cash"){
      ?>
      <button class="btn btn-danger ico_left" onclick="cash_bank_receipt_generate()"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Bank Receipt</button>
      <?php
    } 
    ?>
  </div>
</div>
</div>
<?php endif; ?>

<script>
paginate_table();
function cash_bank_receipt_generate()
{
  var bank_name_reciept = $('#bank_name_reciept').val();

  var payment_amount = 0;
  var payment_type = 'cash';
  var payment_id = '';

  if($('input[name="chk_receipt"]:checked').length==0){
    error_msg_alert('Please select at leaste 1 payment for bank receipt;');
    return false;
  }

  $('input[name="chk_receipt"]:checked').each(function(){

    var amount = $(this).attr('data-amount');
    payment_amount = parseFloat(payment_amount) + parseFloat(amount);

  });

  var base_url = $('#base_url').val();

  url = base_url+'view/bank_receipts/group_tour_payment/cash_payment_receipt.php?payment_amount='+payment_amount+'&payment_type='+payment_type+'&payment_id='+payment_id+'&bank_name_reciept='+bank_name_reciept;
                window.open(url, '_blank');  
}


function cheque_bank_receipt_generate()
{
  var bank_name_reciept = $('#bank_name_reciept').val();
  var payment_amount = 0;
  var payment_id_arr = new Array();
  var branch_name_arr = new Array();

  $('input[name="chk_receipt"]:checked').each(function(){

    var amount = $(this).attr('data-amount');
    var payment_id = $(this).attr('data-payment-id');
    var offset = $(this).attr('data-offset');
    var branch_name = $('#branch_name_'+offset).val();

    payment_amount = parseFloat(payment_amount) + parseFloat(amount);

    payment_id_arr.push(payment_id);
    branch_name_arr.push(branch_name);

  });
    
  var base_url = $('#base_url').val();  

  url = url = base_url+'view/bank_receipts/group_tour_payment/cheque_payment_receipt.php?payment_id='+payment_id_arr+'&branch_name='+branch_name_arr+'&total_amount='+payment_amount+'&bank_name_reciept='+bank_name_reciept;
                window.open(url, '_blank');  
}

</script>