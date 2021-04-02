<?php 
include "../../../model/model.php";

$sms_group_id = $_POST['sms_group_id'];

$sq_sms_group_info = mysql_fetch_assoc(mysql_query("select * from sms_group_master where sms_group_id='$sms_group_id'"));
?>
<div class="modal fade" id="sms_group_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update New Sms group</h4>
      </div>
      <div class="modal-body">

		<form id="frm_sms_group_update">

		<input type="hidden" id="sms_group_id" name="sms_group_id" value="<?= $sms_group_id ?>">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="sms_group_name1" name="sms_group_name1"  onchange="validate_spaces(this.id); validate_specialChar(this.id);" value="<?= $sq_sms_group_info['sms_group_name'] ?>" placeholder="Sms group" title="Sms group">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Edit</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$('#sms_group_update_modal').modal('show');

$(function(){
  $('#frm_sms_group_update').validate({
    rules:{ 
        sms_group_id : { required:true },
        sms_group_name1 : { required:true }
    },
    submitHandler:function(form){

      var sms_group_id = $('#sms_group_id').val();
      var sms_group_name = $('#sms_group_name1').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_sms/sms_group/sms_group_update.php',
        data: { sms_group_id : sms_group_id, sms_group_name : sms_group_name },
        success:function(result){
          msg_alert(result);
          $('#sms_group_update_modal').modal('hide');
          $('#sms_group_update_modal').on('hidden.bs.modal', function () {
			    sms_group_list_reflect();
		  });
        }
      });

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>