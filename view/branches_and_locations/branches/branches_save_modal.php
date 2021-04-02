<?php
include "../../../model/model.php";
?>
<form id="frm_branch_save">
<div class="modal fade" id="branches_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Branch</h4>
      </div>
      <div class="modal-body">
        <div class="row"> 
          
            <div class="col-sm-4 mg_bt_10">
              <select name="locations_id" id="locations_id" style="width:100%">
                <option value="">Location</option>
                <?php
                $sq_location = mysql_query("select * from locations where active_flag='Active'");
                while($row_location = mysql_fetch_assoc($sq_location)){
                  ?>
                  <option value="<?= $row_location['location_id'] ?>"><?= $row_location['location_name'] ?></option>
                  <?php
                }  
                ?>
              </select>
            </div>       
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="branch_name" name="branch_name" placeholder="*Company Branch Name" title="Company Branch Name">
            </div>
    
            <div class="col-sm-4 mg_bt_10 hidden">
              <textarea name="branch_address" id="branch_address" onchange="validate_address(this.id);" placeholder="*Branch Address" title="Branch Address" rows="1"></textarea>
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="contact_no" name="contact_no" onchange="mobile_validate(this.id);" placeholder="*Contact No" title="Contact No">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="email_id" name="email_id" placeholder="Email ID" onchange="validate_email(this.id);"  title="Email ID">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="landline_no" name="landline_no" placeholder="Landline No" onchange="mobile_validate(this.id);" title="Landline No">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <textarea name="address1" id="address1" onchange="validate_address(this.id);"  placeholder="*Address1" title="Address1" rows="1"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mg_bt_10">
              <textarea name="address2" id="address2" onchange="validate_address(this.id);"  placeholder="Address2" title="Address2" rows="1"></textarea>
            </div>
             <div class="col-sm-4 mg_bt_10">
              <input type="text" id="city" name="city" onchange="validate_city(this.id);"  placeholder="*City" title="City">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="pincode" name="pincode" onchange="validate_PINCode(this.id);" placeholder="Pincode" title="Pincode">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mg_bt_10">
              <select name="state" id="state" title="Place Of Supply" class='form-control' style='width:100%' required>			
                <?php get_states_dropdown() ?>
              </select>
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="acc_name" name="acc_name" placeholder="A/c Name" title="A/c Name">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="bank_acc_no" name="bank_acc_no" placeholder="A/c No" onchange="validate_accountNo(this.id)" title="A/c No">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="bank_branch_name" onchange="validate_branch(this.id);" name="bank_branch_name" placeholder="Branch Name" title="Branch Name">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="bank_ifsc_code" onchange="validate_IFSC(this.id);" name="bank_ifsc_code" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="branch_tax" name="branch_tax" placeholder="Branch Tax no." title="Branch Tax no." style="text-transform: uppercase;">
            </div>     
            <div class="col-sm-4 mg_bt_10">
              <select name="active_flag" id="active_flag" title="Status" style="width:100%" class="hidden">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div> 
          </div>

          <div class="row text-center mg_tp_10"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="branch_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
          </div> </div>

        </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#branches_save_modal').modal('show');
$('#locations_id,#state').select2();

$('#branches_save_modal').on('shown.bs.modal', function () { $('#locations_id').select2('open'); //focus after modal open 
});

// Below solution is specifically for this page only because of unncessary tooltip occuring bug
$(".select2-container").tooltip({
    title: "Select Location",
    placement: "bottom"
});
$(".select2-selection span").attr('title', '');
// till here


$(function(){
  $('#frm_branch_save').validate({
    rules:{
      branch_name:{ required:true },
      locations_id:{ required:true },
      branch_address:{ required:true },
      active_flag:{ required:true },
      address1 : { required : true},
      city : { required : true },
      contact_no : { required : true },
      bank_acc_no:{ maxlength:50 }
      //email_id : {email: true},
    },
       errorPlacement: function (error, element){
        if(element.attr('id') == "locations_id") {
            error.insertAfter('#select2-locations_id-container');
        }
        else{
            error.insertAfter(element);
        }
      },
    submitHandler:function(form){
      var base_url = $('#base_url').val();
      $('#branch_save').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/branches_and_location/branch_save.php',
        data: $('#frm_branch_save').serialize(),
        success:function(result){
            var msg = result.split('--');				
            if(msg[0]=='error'){
                error_msg_alert(msg[1]);
                $('#branch_save').button('reset');
                return false;
              }
            else{
                msg_alert(result);
                $('#branch_save').button('reset');
                $('#branches_save_modal').modal('hide');
                reset_form('frm_branch_save');
                branches_list_reflect();
            }
        }
      });
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>