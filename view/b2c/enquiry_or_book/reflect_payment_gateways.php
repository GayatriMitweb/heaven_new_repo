<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT book_enquiry_button FROM `b2c_settings` where setting_id='1'"));
$book_enquiry_button = json_decode($query['book_enquiry_button']);
$p_gateway = $book_enquiry_button[0]->p_gateway;
?>
<div class="col-md-3 mg_bt_10">
    <select name="p_gateway" id="p_gateway" title="Select Payment Gateway" class='form-control' style='width:100%' onchange="get_credentials()" data-toggle="tooltip"required>
        <?php if($p_gateway!=''){?>
            <option value="<?= $p_gateway ?>"><?= $p_gateway ?></option>
        <?php } ?>
        <option value="">*Select Payment Gateway</option>
        <option value="RazorPay">RazorPay</option>
        <option value="CCAvenue">CCAvenue</option>
        <option value="PUMoney">PUMoney</option>
        <option value="Atom">Atom</option>
    </select>
</div>
<div class="col-md-3 mg_bt_10">
    <select id="bank_id" name="bank_id" style="width:100%" title="*Select Creditor Bank" class="form-control" required>
        <?php if($book_enquiry_button[0]->bank!=''){
                $bank_id = $book_enquiry_button[0]->bank;
                $sq_bank = mysql_fetch_assoc(mysql_query("select bank_name from bank_master where bank_id='$bank_id'"));
            ?>
            <option value="<?= $book_enquiry_button[0]->bank ?>"><?= $sq_bank['bank_name'] ?></option>
        <?php } ?>
        <?php get_bank_dropdown(); ?>
    </select>
</div>
<script>
get_credentials();
</script>