<?php
include "../../model/model.php";
?>

<div class="modal fade" id="type_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Visa Type</h4>
      </div>
      <div class="modal-body">
        <form id="frm_visa_save">        
          <div class="row">
              <div class="col-md-12 mg_bt_10">
                <input type="text" name="visa_type"  class="form-control" title="Visa Type" placeholder="*Visa Type" id="visa_type">
              </div>
          </div>
          <div class="row text-center mg_tp_20">
              <div class="col-md-12">
                <button class="btn btn-sm btn-success" id="btn_typesave"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>  
              </div>             
            </div>
        </form>
      </div>
</div>
</div>
</div>

<script>
$('#type_save_modal').modal('show');

$(function(){

  $('#frm_visa_save').validate({

    rules:{
            visa_type : { required : true },          
    },

    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var visa_type = $("#visa_type").val();
        $('#btn_typesave').button('loading');
        $.post( 
               base_url+"controller/visa_master/visa_type_master_save.php",
               { visa_type : visa_type},
               function(data) {
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                    $('#btn_typesave').button('reset');
                  }
                  else{
                    $('#btn_typesave').button('reset');
                    $('#type_save_modal').modal('hide');
                    visa_list_reflect();
                    msg_alert(data);
                  }
             });  
      }
  });

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>