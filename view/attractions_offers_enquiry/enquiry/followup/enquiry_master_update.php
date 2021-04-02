<?php
include "../../../../model/model.php";
/*======******Header******=======*/
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$enquiry_id = $_POST['enquiry_id'];
$branch_status = $_POST['branch_status'];

$sq_enquiry = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
?>
<form id="frm_emquiry_update">
  <div class="container">
    <div class="row">
      <div class="col-md-12 no-pad-sm-xs">

      <input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>">

          <div class="mg_bt_10">
              
              <div class="row mg_bt_20">
                  <div class="col-md-4 col-sm-6 col-sm-offset-4">
                      <select name="enquiry_type" id="enquiry_type" title="Enquiry For" class="form-control" disabled>
                          <option value="<?= $sq_enquiry['enquiry_type'] ?>"><?= $sq_enquiry['enquiry_type'] ?></option>
                          <option value="Flight Ticket">Flight Ticket</option>
                              <option value="Bus">Bus</option>
                              <option value="Car Rental">Car Rental</option>
                              <option value="Group Booking">Group Booking</option>
                              <option value="Hotel">Hotel</option>
                              <option value="Package Booking">Package Booking</option>
                              <option value="Passport">Passport</option>
                              <option value="Train Ticket">Train Ticket</option>
                              <option value="Visa">Visa</option> 
                      </select>
                  </div>
              </div>  

              <div class="row">
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" id="txt_name" name="txt_name" onchange="name_validate(this.id)" placeholder="Customer Name" title="Customer Name" value="<?= $sq_enquiry['name'] ?>">
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10c">
                      <input type="text" class="form-control" id="txt_mobile_no" name="txt_mobile_no" onchange="mobile_validate(this.id);" placeholder="Mobile Number" title="Mobile No" value="<?= $sq_enquiry['mobile_no'] ?>">            
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" id="txt_landline_no" name="txt_landline_no" onchange="mobile_validate(this.id);" placeholder="WhatsApp No with country code" title="WhatsApp No with country code" value="<?= $sq_enquiry['landline_no'] ?>"> 
                  </div>  
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" id="txt_email_id" name="txt_email_id"  placeholder="Email ID" title="Email ID" value="<?= $sq_enquiry['email_id'] ?>">            
                  </div>
                  <div class="col-md-3 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" id="txt_location" name="txt_location"  placeholder="Location" title="Location" value="<?= $sq_enquiry['location'] ?>">
                  </div>
              </div>   
              <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
                  <legend>Service Information</legend>
                  <div id="div_enquiry_fields"></div>
              </div>
              <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
                <legend>Office Information</legend>
              <div class="row">
                  <div class="col-md-4 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" id="txt_enquiry_date" name="txt_enquiry_date" placeholder="Enquiry Date" title="Enquiry Date" value="<?= date('d-m-Y', strtotime($sq_enquiry['enquiry_date'])) ?>">
                  </div>
                  <div class="col-md-4 col-sm-6 mg_bt_10">
                      <input type="text" class="form-control" id="txt_followup_date" name="txt_followup_date"  placeholder="Followup Date" title="Followup Date & Time" value="<?= date('d-m-Y H:i', strtotime($sq_enquiry['followup_date'])) ?>">
                  </div>
                  <div class="col-md-4 col-sm-6 mg_bt_10">
                      <select name="reference_id" id="reference_id" title="Reference" class="form-control">
                          <?php
                          $sq_ref = mysql_fetch_assoc(mysql_query("select * from references_master where reference_id='$sq_enquiry[reference_id]'"));
                          ?>
                          <?php if($sq_enquiry['reference_id']!='0'){?>
                          <option value="<?= $sq_enquiry['reference_id'] ?>"><?= $sq_ref['reference_name'] ?></option>
                          <?php }
                          else{?>
                          <option value="">Reference</option>
                          <?php }$sq_ref = mysql_query("select * from references_master where active_flag!='Inactive'");
                          while($row_ref = mysql_fetch_assoc($sq_ref)){
                            ?>
                            <option value="<?= $row_ref['reference_id'] ?>"><?= $row_ref['reference_name'] ?></option>
                            <?php
                          }
                          ?>
                      </select>
                  </div>
              </div>
              <div class="row mg_bt_20">
                  <div class="col-md-4 col-sm-6 mg_bt_10">
                      <select name="assigned_emp_id" id="assigned_emp_id" title="Allocate To"class="form-control">
                          <?php 
                          $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_enquiry[assigned_emp_id]'"));
                          ?>
                          <?php if($sq_enquiry['assigned_emp_id']!='0'){?><option value="<?= $sq_enquiry['assigned_emp_id'] ?>"><?= $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></option>
                          <?php } 
                          else{
                              ?>
                              <option value="">*Allocate To</option>
                          <?php } if($role=='Admin' || ($branch_status!='yes' && $role=='Branch Admin')){
                                    $query = "select * from emp_master where active_flag='Active' order by first_name asc";
                                  $sq_emp = mysql_query($query);
                                  while($row_emp = mysql_fetch_assoc($sq_emp)){
                                      ?>
                                      <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                                      <?php
                                    }
                                  }
                                 elseif($branch_status=='yes' && $role=='Branch Admin'){
                                    $query = "select * from emp_master where active_flag='Active' and branch_id='$branch_admin_id' order by first_name asc";
                                  $sq_emp = mysql_query($query);
                                  while($row_emp = mysql_fetch_assoc($sq_emp)){
                                      ?>
                                      <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                                      <?php
                                    }
                                  }
                          ?>
                      </select>
                  </div>
                  <div class="col-md-4 col-sm-6 mg_bt_10">
                    <select name="enquiry1" id="enquiry1" title="Enquiry Type" class="form-control">
                        <?php if($sq_enquiry['enquiry']!=''){?><option value="<?php echo $sq_enquiry['enquiry']; ?>"><?php echo $sq_enquiry['enquiry']; ?></option><?php } ?>
                        <option value="">Enquiry Type</option>
                        <option value="<?= "Strong" ?>">Strong</option>
                        <option value="<?= "Hot" ?>">Hot</option>
                        <option value="<?= "Cold" ?>">Cold</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                      <textarea class="form-control" id="txt_enquiry_specification" onchange="validate_spaces(this.id);" name="txt_enquiry_specification" placeholder="Other Enquiry specification (If any)" title="Enquiry Specification" rows="1" ><?= $sq_enquiry['enquiry_specification'] ?></textarea>
                  </div>
              </div>
              </div>

              <div class="row col-md-12 text-center mg_tp_20">
                  <button class="btn btn-success" id="btn_enq_update"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
              </div>

          </div>

      </div>    
      </div>
  </div>
</form>

<script>
$("#txt_enquiry_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });
$("#txt_followup_date" ).datetimepicker({  format:'d-m-Y H:i' });
$('#assigned_emp_id').select2();

function enquiry_fields_reflect()
{
  var enquiry_id = $('#enquiry_id').val();
  var enquiry_type = $('#enquiry_type').val();

  $.post('../enquiry_fields_reflect.php', { enquiry_id : enquiry_id, enquiry_type : enquiry_type }, function(data){
      $('#div_enquiry_fields').html(data);
  });
}
enquiry_fields_reflect();

///////////////////////***Enquiry Master update start*********//////////////
$(function(){
  $('#frm_emquiry_update').validate({
    rules:{
            txt_followup_date : { required : true },
            txt_enquiry_date : { required : true },
            enquiry1 : { required : true },
            txt_mobile_no : { required : true },
    },
    submitHandler:function(form){

       var base_url = $('#base_url').val();   
       var name = $("#txt_name").val(); 
       var enquiry_id = $("#enquiry_id").val(); 
       var enquiry = $('#enquiry1').val(); 
       var mobile_no = $("#txt_mobile_no").val(); 
       var email_id = $("#txt_email_id").val();
       var location = $("#txt_location").val();
       var landline_no = $("#txt_landline_no").val(); 
       var enquiry_date = $("#txt_enquiry_date").val();
       var followup_date = $("#txt_followup_date").val();
       var reference  = $('#reference_id').val();
       var assigned_emp_id = $("#assigned_emp_id").val();
       var enquiry_specification = $('#txt_enquiry_specification').val();
       var enquiry_content = $('#div_enquiry_fields').find('select, input, textarea').serializeArray();
       var err_msg = "";

       for(arr1 in enquiry_content){
          var row = enquiry_content[arr1];
          var field = row['name'];
          var field_val = $('#'+field).val();
          if(field_val==""){
             var placeholder = $('#'+field).attr('name');
             if(placeholder != 'Child Without Bed' && placeholder !='Child With Bed' && placeholder !='budget'){
             err_msg += placeholder+" is required!<br>"; }
          }
       }
       if(err_msg!=""){
          error_msg_alert(err_msg);
          return false;
       }

       $('#btn_enq_update').button('loading');
       $.post( 
                   base_url+"controller/attractions_offers_enquiry/enquiry_master_update_c.php",
                   { enquiry_id : enquiry_id, mobile_no : mobile_no, email_id : email_id,location :location, landline_no : landline_no ,enquiry : enquiry, enquiry_date : enquiry_date , followup_date : followup_date, reference : reference,enquiry_content : enquiry_content, enquiry_specification : enquiry_specification,assigned_emp_id : assigned_emp_id, name : name},
                   function(data){
                           $('#btn_enq_update').button('reset');
                           msg_alert(data);
                   });
    }
  });
});
///////////////////////***Enquiry Master save end*********//////////////
</script>

<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>