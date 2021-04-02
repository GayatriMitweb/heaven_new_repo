<?php 
include "../../../model/model.php";
$template_type = $_POST['template_type'];
$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_type'"));
?>

<form id="frm_save">
	<input type="hidden" name="template_type_id" class="form-control" id="template_type_id" value="<?php echo $template_type; ?>">
<div class="row"> 
	<div class="col-md-4 mg_tp_20">
		<input type="text" name="offer_amount" onchange="validate_balance(this.id)" placeholder="*Offer Amount" title="Offer Amount" class="form-control" id="offer_amount" value="<?php echo $sq_template['offer_amount']; ?>">
	</div>
  <div class="col-md-8 mg_tp_20">
    <label class="mg_tp_10" style="color: red">Enter Offer Amount Ex. Rs. 1000 OR 5%</label>
  </div>
	<div class="col-xs-12 mg_tp_20">
		<textarea name="description" id="description" onchange="validate_limit(this.id);" placeholder="*Description" title="Description" class="form-control" rows="3"><?php echo $sq_template['description']; ?></textarea>
	</div>
	<div class="col-md-3 mg_tp_20">
		<button class="btn btn-sm btn-success ico_left" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
	</div>	
</div> 
</form>
<script>

$(function(){
  $('#frm_save').validate({
    rules:{
            offer_amount : { required : true },
            description : { maxlength : 350 , required : true },
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var offer_amount = $('#offer_amount').val();
    		var description = $('#description').val();
    		var template_type_id = $('#template_type_id').val();

        $('#btn_save').button('loading');
        $.post( 
               base_url+"controller/promotional_email/template/template_details_save.php",
               { offer_amount : offer_amount, description : description, template_type_id : template_type_id},
               function(data) {
                  $('#btn_save').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#btn_save').button('reset');
                  }
                  
               });  
		      }
		  });
		});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>