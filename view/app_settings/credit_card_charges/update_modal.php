<?php
include "../../../model/model.php";

$entry_id = $_POST['entry_id'];
$sq_credit = mysql_fetch_assoc(mysql_query("select * from credit_card_company where entry_id='$entry_id'"));
$membership_details_arr = json_decode($sq_credit['membership_details_arr']);
?>
<form id="frm_update">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Credit Card Company</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" value="<?= $entry_id ?>" id="entry_id" name="entry_id"/>
    		<div class="row">
          <div class="col-md-4">
            <input type="text" id="company_name" name="company_name" class="form-control" placeholder="*Company Name" title="Company Name" value="<?= $sq_credit['company_name'] ?>" required disabled>
          </div>
          <div class="col-md-4">
            <select name="charges_in" id="charges_in" title="Credit Card Charges In" required>
              <option value="<?= $sq_credit['charges_in'] ?>"><?= $sq_credit['charges_in'] ?></option>
              <option value="">Credit Card Charges In</option>
              <option value="Percentage">Percentage</option>
              <option value="Flat">Flat</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="number" id="credit_card_charges" name="credit_card_charges" class="form-control" placeholder="Credit Card Charges" title="Credit Card Charges" value="<?= $sq_credit['credit_card_charges'] ?>" min="0" required>
          </div>
        </div>

    		<div class="row mg_tp_10">
          <div class="col-md-4 mg_bt_10">
            <select name="tax_charges_in" id="tax_charges_in" title="Tax on Credit Card Charges In" required>
              <option value="<?= $sq_credit['tax_charges_in'] ?>"><?= $sq_credit['tax_charges_in'] ?></option>
              <option value="">Tax On Credit Card Charges In</option>
              <option value="Percentage">Percentage</option>
              <option value="Flat">Flat</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="text" id="tax_on_credit_card_charges" name="tax_on_credit_card_charges" class="form-control" placeholder="Tax on Credit Card Charges" title="Tax on Credit Card Charges" value="<?= $sq_credit['tax_on_credit_card_charges'] ?>" min="0" required>
          </div>
          <div class="col-md-4">
            <select name="bank_id1" id="bank_id1" title="Select Bank" required>
              <?php 
              $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_credit[bank_id]'"));
              if($sq_credit['bank_id'] != ''){
              ?>
              <option value="<?= $sq_credit['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
              <?php } ?>
              <?php get_bank_dropdown(); ?>
            </select>
          </div>
          </div>
          <div class="row">
          <div class="col-md-4">
            <select name="cstatus" id="cstatus" title="Status" required>
              <option value="<?= $sq_credit['status'] ?>"><?= $sq_credit['status'] ?></option>
              <?php if($sq_credit['status'] != 'Active'){ ?>
              <option value="Active">Active</option>
              <?php } ?>
              <?php if($sq_credit['status'] != 'Inactive'){ ?>
              <option value="Inactive">Inactive</option>
              <?php } ?>
            </select>
          </div>
        </div>
        
			  <input type="hidden" id="dynamic_div_count" name="dynamic_div_count" value="<?= sizeof($membership_details_arr)-1 ?>">
    		<div class="row">
        <div class="col-md-4 col-md-offset-8 text-right">
          <button type="button" class="btn btn-info btn-sm ico_left" onclick="generate_membership_block()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
        </div>
        </div>
        <?php for($i=0;$i<sizeof($membership_details_arr);$i++){ ?>
        <div class="row mg_tp_10 mg_bt_10">
          <div class="col-md-4 mg_bt_10">
            <label>Membership Establishment No <?=$i+1?></label>
            <input type="text" id="membership_no<?=$i?>" name="membership_no" class="form-control" placeholder="Membership Establishment No1" title="Membership Establishment No" value="<?= $membership_details_arr[$i]->membership_no ?>" required disabled>
          </div>
          <div class="col-md-4 mg_bt_10">
            <label>Identifier No Count</label>
            <input type="number" id="identifier_count<?=$i?>" name="identifier_count" onchange="generate_identifier_block(this.id,'<?=$i?>')" title="Identifier No Count" placeholder="Identifier No Count" value="<?= $membership_details_arr[$i]->identifier_count ?>"  min='0' maxlength="9" required disabled/>
          </div>
          <div class="col-md-4 mg_bt_10">
            <label>Status</label>
            <select name="status" id="status<?= $i ?>" title="Status" required>
              <option value="<?= $membership_details_arr[$i]->status ?>"><?= $membership_details_arr[$i]->status ?></option>
              <?php if($membership_details_arr[$i]->status != 'Active'){ ?>
              <option value="Active">Active</option>
              <?php } ?>
              <?php if($membership_details_arr[$i]->status != 'Inactive'){ ?>
              <option value="Inactive">Inactive</option>
              <?php } ?>
            </select>
          </div>
          </div>
          <div class="row mg_bt_10">
            <div class="col-md-4"><label>Identifier No's</label></div>
          </div>
          <div class="row mg_bt_10">
          <?php for($j=0;$j<sizeof($membership_details_arr[$i]->nos);$j++){?>
                <div class="col-md-4 mg_bt_10">
                    <input type="number" id="identifier<?= $i.($j+1) ?>" name="identifier<?= ($j+1) ?>" class="form-control" placeholder="Identifier No <?= $j+1 ?>" title="Identifier No" value="<?= $membership_details_arr[$i]->nos[$j] ?>" max="9" required disabled>
                </div>
          <?php } ?>
        </div>
        <hr/>
        <?php } ?>
        <div class="row mg_tp_10">
          <div id="credit_identifier_block"></div>
        </div>
        <div id="credit_membership_block">
        </div>

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
<script>
$('#update_modal').modal('show');

function close_block(id){
    $('#'+id).remove();
}
function generate_identifier_block(identifier_count,i){

  var identifier_count = $('#'+identifier_count).val();
  if(identifier_count === '' || parseInt(identifier_count) === 0){
    error_msg_alert("Enter valid identifier count!"); return false;
  }
  if(identifier_count <=9){
    $.post('credit_card_charges/generate_identifier_block.php', {identifier_count:identifier_count,membership_no:i}, function(data){
        $('#credit_identifier_block'+i).html(data);
    });
  }else{
    error_msg_alert("Identifier count should be less than or equal to 9!"); return false;
  }
}
function generate_membership_block(){

  var dynamic_div_count = $('#dynamic_div_count').val();
  dynamic_div_count = parseFloat(dynamic_div_count) + 1;

  $.post('credit_card_charges/generate_membership_block.php', { dynamic_div_count:dynamic_div_count }, function(data){
      $('#credit_membership_block').append(data);
		  $('#dynamic_div_count').val(dynamic_div_count);
  });
}

$(function(){
  $('#frm_update').validate({
    rules:{},
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var entry_id = $('#entry_id').val();
        var company_name = $('#company_name').val();
        var charges_in = $('#charges_in').val();
        var credit_card_charges = $('#credit_card_charges').val();
        var tax_charges_in = $('#tax_charges_in').val();
        var tax_on_credit_card_charges = $('#tax_on_credit_card_charges').val();
        var bank_id = $('#bank_id1').val();
        var cstatus = $('#cstatus').val();
        var dynamic_div_count = $('#dynamic_div_count').val();

        var membership_details_arr = [];
        for(var d=0; d<=dynamic_div_count;d++){

          var identifier_no_arr1 = []; 
          var membership_no = $('#membership_no'+d).val();
          var identifier_count = $('#identifier_count'+d).val();
          var status = $('#status'+d).val();
          
          if(identifier_count=='' || parseInt(identifier_count) > 9){
              error_msg_alert('Enter valid identifier count(should not greater than 9)'); return false;
          }
          
          if(status !== "Inactive" && membership_no !== undefined){
            for(var i=1; i<=identifier_count;i++){
              let id_no = $('#identifier'+d+i).val();
              if(id_no === ''){ error_msg_alert('Enter identifier no'+i+' of ME No'+(d+1)); return false;}
              identifier_no_arr1.push(parseInt(id_no));
            }
            membership_details_arr.push({
              'membership_no' : membership_no,
              'identifier_count' : parseInt(identifier_count),
              'status' : 'Active',
              'nos':identifier_no_arr1
            });
          }
        }
        if(membership_details_arr.length === 0){
          error_msg_alert("Enter atleast one Membership Establishment No!");
          return false;
        }
        $('#btn_update').button('loading');
        
        $.post(base_url+"controller/app_settings/credit_card_charges/update.php",
          { entry_id:entry_id,company_name : company_name, charges_in : charges_in, credit_card_charges : credit_card_charges,tax_charges_in:tax_charges_in,tax_on_credit_card_charges:tax_on_credit_card_charges,bank_id:bank_id,membership_details_arr:membership_details_arr,cstatus:cstatus },
          function(data) {
            $('#btn_update').button('reset');
            var msg = data.split('--');
            if(msg[0]=="error"){
              error_msg_alert(msg[1]);
            }else{
              msg_alert(data);
              update_cache();
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