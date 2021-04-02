<?php
include '../../../model/model.php';
$p_gateway = $_POST['p_gateway'];
$sq_settings = mysql_fetch_assoc(mysql_query("select credentials from b2b_settings_second"));
$credentials = json_decode($sq_settings['credentials']);
if($p_gateway == 'RazorPay'){
?>
    <div class="row mg_bt_10">
        <div class="col-md-2 text-right"><label for="state">API Key</label></div> 
        <div class="col-md-4">
            <input type="text" name='api_key' title="Enter API Key" id='api_key' class="form-control" placeholder="*Enter API Key" value='<?= $credentials[0]->api_key?>'/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 text-right"><label for="state">API Secret</label></div> 
        <div class="col-md-4">
            <input type="text" name='api_secret' title="Enter API Secret" id='api_secret' class="form-control" placeholder="*Enter API Secret" value='<?= $credentials[0]->api_secret?>'/>
        </div>
    </div>
<?php
}
else if($p_gateway == 'CCAvenue'){
?>
    <div class="row mg_bt_10">
        <div class="col-md-2 text-right"><label for="state">Merchant ID</label></div> 
        <div class="col-md-4">
            <input type="text" name='merchant_id' title="Enter Merchant ID" id='merchant_id' class="form-control" placeholder="*Enter Merchant ID" value='<?= $credentials[0]->merchant_id?>'/>
        </div>
    </div>
    <div class="row mg_bt_10">
        <div class="col-md-2 text-right"><label for="state">Access Code</label></div> 
        <div class="col-md-4">
            <input type="text" name='access_code' title="Enter Access Code" id='access_code' class="form-control" placeholder="*Enter Access Code" value='<?= $credentials[0]->access_code?>'/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 text-right"><label for="state">Encryption Key</label></div> 
        <div class="col-md-4">
            <input type="text" name='enc_key' title="Enter Encryption Key" id='enc_key' class="form-control" placeholder="*Enter Encryption Key" value='<?= $credentials[0]->enc_key?>'/>
        </div>
    </div>
<?php } ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>