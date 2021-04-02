<?php
include "../../model/model.php";

$terms_and_conditions_id = $_POST['terms_and_conditions_id'];
$sq_terms = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where terms_and_conditions_id='$terms_and_conditions_id'"));
?>
<form id="frm_update">
<input type="hidden" id="terms_and_conditions_id" name="terms_and_conditions_id" value="<?= $terms_and_conditions_id ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Terms & Conditions</h4>
      </div>
      <div class="modal-body">

        <div class="row mg_bt_20">
          <div class="col-md-6">
           <select id="type2" name="type2" style="width: 100%;" title="Select Type">
              <option value="<?= $sq_terms['type'] ?>"><?= $sq_terms['type'] ?></option>
              <option value="">*Select Type</option>
              <option value="Package Quotation">Package Quotation</option>
              <option value="Group Quotation">Group Quotation</option>
              <option value="Hotel Quotation">Hotel Quotation</option>
              <option value="Car Rental Quotation">Car Rental Quotation</option>
              <option value="Flight Quotation">Flight Quotation</option>
              <option value="Group Sale">Group Sale</option>
              <option value="Package Sale">Package Sale</option>
              <option value="Receipt">Receipt</option>
              <option value="Invoice">Invoice</option>
              <option value="Flight E-Ticket">Flight E-Ticket</option>
              <option value="Package Service Voucher">Package Service Voucher</option>
              <option value="Hotel Service Voucher">Hotel Service Voucher</option>
              <option value="Transport Service Voucher">Transport Service Voucher</option>
              <option value="Excursion Service Voucher">Excursion Service Voucher</option>
              <option value="B2B Quotation">B2B Quotation</option>
           </select>
          </div>
          <div class="col-md-6">
            <select name="active_flag" id="active_flag" title="Status" class="form-control">
                <option value="<?= $sq_terms['active_flag'] ?>"><?= $sq_terms['active_flag'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div> 
    		

  	  	<div class="row mg_bt_20">
  	  	  	<div class="col-md-12">
            <h3 class="editor_title">Terms & Conditions</h3>
  	  	  		<textarea class="feature_editor" name="terms_and_conditions_p" id="terms_and_conditions_p" style="width:100% !important" rows="15" ><?= $sq_terms['terms_and_conditions'] ?></textarea>
  	  	  	</div>
  	  	</div>

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#update_modal').modal('show');
$('#type2').select2();

$(document).ready(function(){
  $('#terms_and_conditions_p').wysiwyg({
    controls:"bold,italic,|,undo,redo,image",
    initialContent: '',
  });
});


$(function(){
  $('#frm_update').validate({
    rules:{
		
			active_flag : { required : true },
       type : { required : true }, 
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();
        
        var type = $('#type2').val();
      
        var terms_and_conditions = $('#terms_and_conditions_p').val();
        var active_flag = $('#active_flag').val();
        var terms_and_conditions_id = $('#terms_and_conditions_id').val();
        
        if(terms_and_conditions==""){
          error_msg_alert("Please enter terms and conditions!");
          return false;
        }
        
 
        $('#btn_save').button('loading');

        $.post(
               base_url+"controller/terms_and_conditions/terms_and_conditions_update.php",
               { type : type,terms_and_conditions_id : terms_and_conditions_id,  terms_and_conditions : terms_and_conditions, active_flag : active_flag },
               function(data) {
                  $('#btn_save').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    update_b2c_cache();
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