<?php
include "../../../model/model.php";

$sac_id = $_POST['sac_id'];
$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where sac_id='$sac_id'"));
if($sac_id <= '12'){
  $disabled = 'readonly';
}else{
  $disabled ='';
}
?>
<form id="frm_update">
<input type="hidden" id="sac_id" name="sac_id" value="<?= $sac_id ?>">
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update HSN/SAC</h4>
      </div>
      <div class="modal-body">
        
    		<div class="row">
    			<div class="col-sm-6 mg_bt_10">
    				<input type="text" id="service_name" name="service_name" placeholder="SAC Name" onchange="fname_validate(this.id)" title="SAC Name" value="<?= $sq_sac['service_name'] ?>" <?= $disabled ?>>
    			</div>
          <div class="col-sm-6 mg_bt_10">
            <input type="text" id="hsn_sac_code" name="hsn_sac_code" placeholder="HSN/SAC Code" title="HSN/SAC Code" value="<?= $sq_sac['hsn_sac_code'] ?>">
          </div>          
        </div>

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#update_modal').modal('show');

$(function(){
  $('#frm_update').validate({
    rules:{
          service_name : { required : true },
          hsn_sac_code: { required : true, number : true },
          
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var sac_id = $('#sac_id').val();
        var service_name = $('#service_name').val();
        var hsn_sac_code = $('#hsn_sac_code').val();
         

        $('#btn_update').button('loading');

        $.post(
               base_url+"controller/finance_master/sac_master/sac_master_update.php",
               {sac_id : sac_id ,service_name : service_name , hsn_sac_code : hsn_sac_code},
               function(data) {
                  $('#btn_update').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#update_modal').modal('hide');  
                    $('#update_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>