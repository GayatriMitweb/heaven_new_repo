<?php
include "../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">HSN/SAC Code</h4>
      </div>
      <div class="modal-body">
        
    		<div class="row">
    			<div class="col-sm-6 mg_bt_10">
    				<input type="text" id="service_name" onchange="fname_validate(this.id)" name="service_name" placeholder="*Service Name" title="Service Name">
    			</div>
          <div class="col-sm-6 mg_bt_10">
            <input type="text" id="hsn_sac_code" name="hsn_sac_code" placeholder="*HSN/SAC Code" title="HSN/SAC Code">
          </div>          
        </div>
 

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');
</script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
$(function(){
  $('#frm_save').validate({
    rules:{
          service_name : { required : true },
          hsn_sac_code : { required : true, number : true },
          
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var service_name = $('#service_name').val();
        var hsn_sac_code = $('#hsn_sac_code').val();
        
        $('#btn_save').button('loading');

        $.post(
               base_url+"controller/finance_master/sac_master/sac_master_save.php",
               { service_name : service_name, hsn_sac_code : hsn_sac_code},
               function(data) {
                  $('#btn_save').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#save_modal').modal('hide');  
                    $('#save_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>