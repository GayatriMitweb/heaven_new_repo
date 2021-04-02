<?php
include "../../../../model/model.php";
$payment_mode = $_POST['payment_mode'];
if($payment_mode=="Cheque" || $payment_mode=="Cash"): ?>
<div class="row pd_bt_51">
	<div class="col-md-4 mg_tp_10">
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
	<div class="col-md-4 mg_tp_10">
	<?php 
	if($payment_mode=="Cheque"){
		?>
		<button class="btn btn-danger ico_left" onclick="cheque_bank_receipt_generate()"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Bank Receipt</button>
		<?php
	}
	if($payment_mode=="Cash"){
		?>
		<button class="btn btn-danger ico_left" onclick="cash_bank_receipt_generate()"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Bank Receipt</button>
		<?php
	}	
	?>
	</div>
</div>
<?php endif; ?>