<?php
include_once("../../../model/model.php");
$entry_id =$_POST['entry_id'];
$sq_tax = mysql_fetch_assoc(mysql_query("select * from tax_master where entry_id='$entry_id'"));
?>
<input type="hidden" id="modal_type" name="modal_type">
<div class="modal fade" id="taxes_update_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Tax</h4>
      </div>
      <div class="modal-body">

        <div class="row">
          <input type="hidden" id="entry_id" value="<?= $sq_tax['entry_id'] ?>"/>
          <div class="col-md-6"> 
            <input type="text" placeholder="*Code" title="Code" id="code" value="<?= $sq_tax['code'] ?>" class="form-control" />
          </div>
          <div class="col-md-6">
            <input type="text" placeholder="*Name" title="Name" id="name" value="<?= $sq_tax['name'] ?>" class="form-control" />
          </div>
          <div class="col-md-6 mg_tp_10">
            <select name="rate_in" id="rate_in" data-toggle="tooltip" class="form-control" title="*Rate In">
              <option value="<?= $sq_tax['rate_in'] ?>"><?= $sq_tax['rate_in'] ?></option>
              <?php
              if($sq_tax['rate_in']!='Percentage'){ ?><option value="Percentage">Percentage</option><?php } ?>
              <?php
              if($sq_tax['rate_in']!='Flat'){ ?><option value="Flat">Flat</option> <?php } ?>
            </select>
          </div>
          <div class="col-md-6 mg_tp_10">
            <input type="number" placeholder="*Rate" min="0" title="Rate" id="rate" value="<?= $sq_tax['rate'] ?>" class="form-control" onchange="toggle_rate_validation(this.id)" required />
          </div> 
          <div class="col-md-6 mg_tp_10">
            <select name="status" id="status" data-toggle="tooltip" class="form-control" title="*Status">
              <option value="<?= $sq_tax['status'] ?>"><?= $sq_tax['status'] ?></option>
              <?php
              if($sq_tax['rate_in']!='Active'){ ?><option value="Active">Active</option><?php } ?>
              <?php
              if($sq_tax['rate_in']!='Inactive'){ ?><option value="Inactive">Inactive</option> <?php } ?>
            </select>
          </div>
        </div>
      
        <div class="row mg_tp_20">
          <div class="col-md-12 text-center">
            <button class="btn btn-sm btn-success" onclick="taxes_master_update()" id="btn_taxes_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>

<script>
$('#taxes_update_modal').modal('show');
function taxes_master_update(){

  var base_url = $('#base_url').val();
  var entry_id = $('#entry_id').val();
  var code = $('#code').val();
  var name = $('#name').val();
  var rate_in = $('#rate_in').val();
  var rate = $('#rate').val();
  var status = $('#status').val();
  
  if(code==""){
    error_msg_alert("Enter Code");
    return false;
  }
  if(name==""){
    error_msg_alert("Enter Name");
    return false;
  }
  if(rate==""){
    error_msg_alert("Enter Rate");
    return false;
  }
  if(parseFloat(rate) < 0){
    error_msg_alert("Rate should not be less than 0 in row"+(i+1));
    return false;
  }
  if(status==""){
    error_msg_alert("Select status");
    return false;
  }

  $('#btn_taxes_update').button('loading');
  $.post( 
        base_url+"controller/business_rules/taxes/update.php",
        { entry_id:entry_id,code : code, name : name,rate_in:rate_in,rate:rate,status:status },
        function(data) {
          var msg = data.split('--');
          if(msg[0].replace(/\s/g, '') === "error"){
            error_msg_alert(msg[1]);
            $('#btn_taxes_update').button('reset');
            return false;
          }
          else{
              success_msg_alert(data);
              $('#btn_taxes_update').button('reset');
              $('#taxes_update_modal').modal('hide');
              update_cache();
              list_reflect();
          }
  });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>