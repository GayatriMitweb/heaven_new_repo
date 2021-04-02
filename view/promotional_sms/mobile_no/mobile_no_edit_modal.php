<?php 
include "../../../model/model.php";

$mobile_no_id = $_POST['mobile_no_id'];

$sq_mobile_no_info = mysql_fetch_assoc(mysql_query("select * from sms_mobile_no where mobile_no_id='$mobile_no_id'"));
?>
<div class="modal fade" id="mobile_no_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Mobile No</h4>
      </div>
      <div class="modal-body">

		<form id="frm_mobile_no_update">

		<input type="hidden" id="mobile_no_id" name="mobile_no_id" value="<?= $mobile_no_id ?>">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="mobile_no1" name="mobile_no1" onchange="validate_spaces(this.id);mobile_validate(this.id);" value="<?= $sq_mobile_no_info['mobile_no'] ?>" placeholder="Mobile Number" title="Mobile Number">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$('#mobile_no_update_modal').modal('show');

$(function(){
  $('#frm_mobile_no_update').validate({
    rules:{ 
        mobile_no_id : { required:true },
        mobile_no1 : { required:true }
    },
    submitHandler:function(form){

      var mobile_no_id = $('#mobile_no_id').val();
      var mobile_no = $('#mobile_no1').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_sms/mobile_no/mobile_no_update.php',
        data: { mobile_no_id : mobile_no_id, mobile_no : mobile_no },
        success:function(result){
          msg_alert(result);
			    mobile_list_reflect(20,0);
          $('#mobile_no_update_modal').modal('hide');
        }
      });

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>