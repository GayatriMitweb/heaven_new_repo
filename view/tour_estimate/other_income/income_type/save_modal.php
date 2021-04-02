<?php
include "../../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Income Type</h4>
      </div>
      <div class="modal-body">
          
          <div class="row">
            <div class="col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="income_type" id="income_type" placeholder="Income Type" title="Income Type">
            </div>
            <div class="col-sm-6 col-xs-12 mg_bt_20">
                <select id="gl_id" name="gl_id" title="Gl Code" style="width:100%">
                  <option value="">GL Code</option>
                  <?php get_gl_dropdown(); ?>
                </select>
            </div>
          </div>

          <div class="row text-center">
              <div class="col-xs-12">
                  <button class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
          </div>

      </div>
    </div>
  </div>
</div>
</form>
<script>
$('#save_modal').modal('show');
$('#gl_id').select2();

$('#frm_save').validate({
  rules:{
          gl_id : { required : true },
          income_type : { required:true },
  },
  submitHandler:function(form){
    
    var income_type = $('#income_type').val();
    var gl_id = $('#gl_id').val();

    $.ajax({
      type:'post',
      url:base_url()+'controller/tour_estimate/other_income/income_type_save.php',
      data: { income_type : income_type, gl_id : gl_id },
      success:function(result){          
        msg_alert(result);
        var msg = result.split('--');
        if(msg[0]!="error"){
          $('#save_modal').modal('hide');
        }
      }     
    });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>