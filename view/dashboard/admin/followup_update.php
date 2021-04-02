<?php 
include_once('../../../model/model.php');
$enquiry_id = $_POST['enquiry_id'];
?>
<form id="frm_followup_reply">
<div class="modal fade" id="followup_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Followup Details</h4>
      </div>
      <div class="modal-body">
      <input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>" />
		<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <select name="followup_status" id="followup_status" title="Followup Status" class="form-control" onchange="followup_type_reflect(this.value)">
            <option value="">*Status</option>
            <option value="Active">Active</option>
						<option value="In-Followup">In-Followup</option>
            <option value="Dropped">Dropped</option>
            <option value="Converted">Converted</option>
          </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <select id="followup_type" name="followup_type" title="Followup Type" class="form-control">
              <option value="">*Type</option>
          </select>
        </div>
        
        <div class="col-md-3 col-sm-6 mg_bt_10">
              <select name="followup_stage" id="followup_stage" title="Enquiry Type" class="form-control">
                <option value="">Stage</option>
                <option value="<?= "Strong" ?>">Strong</option>
                <option value="<?= "Hot" ?>">Hot</option>
                <option value="<?= "Cold" ?>">Cold</option>
              </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="followup_date" name="followup_date" placeholder="Next Followup Date" title="Next Followup Date" value="<?= date('d-m-Y H:i')?>" style="min-width:136px;" class="form-control">
        </div>
	</div>
	   <div class="row mg_bt_10">
		 <div class="col-md-12">
			<textarea id="followup_reply" name="followup_reply" onchange="validate_spaces(this.id);" placeholder="*Followup Description" class="form-control"></textarea>
		 </div>		
	   </div>
	<div class="row text-center mg_bt_20">
		<div class="col-md-12">
			<button class="btn btn-sm btn-success" id="btn_followup_reply"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
		</div>
	</div>
	 </div>
    </div>
  </div>
</div>
    </form>
 
<script>
	$('#followup_date').datetimepicker({ format:'d-m-Y H:i:s' });
	$(function(){
  	$('#frm_followup_reply').validate({
    rules:{
      followup_reply: "required",
      followup_date:"required",
      followup_type: "required",
      followup_status: "required",
    },
    submitHandler:function(form){
      var enquiry_id = $("#enquiry_id").val(); 
      var followup_reply = $("#followup_reply").val(); 
      var followup_date = $('#followup_date').val();
      var followup_type = $('#followup_type').val();
      var followup_status = $('#followup_status').val();
      var followup_stage = $('#followup_stage').val();

      var base_url = $('#base_url').val();
       $('#btn_followup_reply').button('loading');
      $.post( 
        base_url+"controller/attractions_offers_enquiry/followup_reply_save.php",
        { enquiry_id : enquiry_id, followup_reply : followup_reply, followup_date : followup_date, followup_type : followup_type, followup_status : followup_status, followup_stage : followup_stage },
        function(data) {  
          msg_alert(data);
          $('#followup_save_modal').modal('hide');
          followup_reflect();
      });
    }
  });
});
</script>
<script type="text/javascript">
$('#followup_save_modal').modal('show');
</script>