<?php
include "../../../model/model.php";
$sq_settings = mysql_fetch_assoc(mysql_query("select payment_gateway from b2b_settings_second"));
$payment_gateway = json_decode($sq_settings['payment_gateway']);
?>
<form id="frm_basic_info">
	<div class="row mg_bt_30">
    <div class="col-md-2 text-right"><label for="state">Payment Gateway</label></div> 
        <div class="col-sm-4 ">
		    <select name="p_gateway" id="p_gateway" title="Select Payment Gateway" class='form-control' style='width:100%' onchange="get_credentials()" data-toggle="tooltip">
                <?php if($payment_gateway[0]->name!=''){?>
                    <option value="<?= $payment_gateway[0]->name ?>"><?= $payment_gateway[0]->name ?></option>
                <?php } ?>
                <option value="">Select Payment Gateway</option>
                <option value="RazorPay">RazorPay</option>
                <option value="CCAvenue">CCAvenue</option>
                <option value="PUMoney">PUMoney</option>
                <option value="Atom">Atom</option>
		    </select>
	    </div>
        <div class="col-md-2 text-right"><label for="state">Select Bank</label></div> 
        <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
        <select id="bank_id" name="bank_id" style="width:100%" title="Select Creditor Bank" class="form-control">
                <?php if($payment_gateway[0]->bank_id!=''){
                     $bank_id = $payment_gateway[0]->bank_id;
                     $sq_bank = mysql_fetch_assoc(mysql_query("select bank_name from bank_master where bank_id='$bank_id'"));
                    ?>
                    <option value="<?= $payment_gateway[0]->bank_id ?>"><?= $sq_bank['bank_name'] ?></option>
                <?php } ?>
            <?php get_bank_dropdown(); ?>
        </select>
        </div>
    </div>
    <div id="payment_credentials">
    </div>

    <div class="row text-center mg_tp_20">
        <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="setting_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script type="text/javascript">
function get_credentials(){
    var p_gateway = $('#p_gateway').val();
    $.ajax({
    type:'post',
    url: 'basic_info/get_paymentgateway_credentials.php',
    data:{ p_gateway : p_gateway},
    success:function(result){
        $('#payment_credentials').html(result);
    }
    });
}
get_credentials();
$(function(){
	$('#frm_basic_info').validate({
    rules:{
        bank_id:{required:true}
    },

submitHandler:function(form){

    var p_gateway = $('#p_gateway').val();
    var bank_id = $('#bank_id').val();
    var base_url = $('#base_url').val();
    var p_gateway_array = [];
    var cred_array = [];
    if(p_gateway == "RazorPay"){
        var api_key = $('#api_key').val();
        var api_secret = $('#api_secret').val();
        if(api_key==''){
            error_msg_alert("Enter API Key"); return false;
        }
        if(api_secret==''){
            error_msg_alert("Enter API Secret"); return false;
        }
        cred_array.push({
            'api_key' : api_key,
            'api_secret':api_secret
        })
    }
    if(p_gateway == "CCAvenue"){
        var merchant_id = $('#merchant_id').val();
        var access_code = $('#access_code').val();
        var enc_key = $('#enc_key').val();
        if(merchant_id==''){
            error_msg_alert("Enter Merchant ID"); return false;
        }
        if(access_code==''){
            error_msg_alert("Enter Access Code"); return false;
        }
        if(enc_key==''){
            error_msg_alert("Enter Encryption Key"); return false;
        }
        cred_array.push({
            'merchant_id' : merchant_id,
            'access_code':access_code,
            'enc_key':enc_key,
        })
    }
    p_gateway_array.push({
        'name' : p_gateway,
        'bank_id':bank_id
    })
    $('#setting_save').button('loading');
    if($('#frm_basic_info').valid()){
        $('#vi_confirm_box').vi_confirm_box({
        callback: function(data1){
            if(data1=="yes"){
                $.ajax({
                type:'post',
                url:base_url+'controller/b2b_settings/basic_info_save.php',
                data:{ p_gateway : p_gateway_array,cred_array:cred_array,bank_id:bank_id},
                success:function(result){
                    msg_popup_reload(result);
                    $('#setting_save').button('reset');
                }
                });
            }
            else{
                $('#setting_save').button('reset');
            }
            }
    });
    }
    return false;			
}
});

});
</script>