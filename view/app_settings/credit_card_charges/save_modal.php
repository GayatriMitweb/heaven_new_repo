<?php
include "../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Credit Card Company</h4>
      </div>
      <div class="modal-body">
              
    		<div class="row">
          <div class="col-md-4">
            <input type="text" id="company_name" name="company_name" class="form-control" placeholder="*Company Name" title="Company Name" required>
          </div>
          <div class="col-md-4">
            <select name="charges_in" id="charges_in" title="Credit Card Charges In" required>
              <option value="">*Credit Card Charges In</option>
              <option value="Percentage">Percentage</option>
              <option value="Flat">Flat</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="number" id="credit_card_charges" name="credit_card_charges" class="form-control" placeholder="*Credit Card Charges" title="Credit Card Charges" min="0" required>
          </div>
        </div>

    		<div class="row mg_tp_10">
          <div class="col-md-4 mg_bt_10">
            <select name="tax_charges_in" id="tax_charges_in" title="Tax on Credit Card Charges In" required>
              <option value="">*Tax On Credit Card Charges In</option>
              <option value="Percentage">Percentage</option>
              <option value="Flat">Flat</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="text" id="tax_on_credit_card_charges" name="tax_on_credit_card_charges" class="form-control" placeholder="*Tax on Credit Card Charges" title="Tax on Credit Card Charges" min="0" required>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <select name="bank_id" id="bank_id" title="*Select Bank" required>
              <?php get_bank_dropdown(); ?>
            </select>
          </div>
        </div>
        
			  <input type="hidden" id="dynamic_div_count" name="dynamic_div_count" value="0">
    		<div class="row mg_tp_10 mg_bt_10">
          <div class="col-md-4">
            <input type="text" id="membership_no" name="membership_no" class="form-control" placeholder="*Membership Establishment No1" title="Membership Establishment No" required>
          </div>
          <div class="col-md-4">
            <input type="number" id="identifier_count" name="identifier_count" onchange="generate_identifier_block(this.id,'')" title="Identifier No Count" placeholder="*Identifier No Count" min='0' maxlength="9" required/>
          </div>
          <div class="col-xs-4 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onclick="generate_membership_block()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
          </div>
        </div>
        <div class="row mg_tp_10">
          <div id="credit_identifier_block"></div>
        </div>
        <hr/>
        <div id="credit_membership_block">
        </div>

        <div class="row mg_tp_10 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');

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
  $('#frm_save').validate({
    rules:{},
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var company_name = $('#company_name').val();
        var charges_in = $('#charges_in').val();
        var credit_card_charges = $('#credit_card_charges').val();
        var tax_charges_in = $('#tax_charges_in').val();
        var tax_on_credit_card_charges = $('#tax_on_credit_card_charges').val();
        var bank_id = $('#bank_id').val();
        var dynamic_div_count = $('#dynamic_div_count').val();
        var membership_no = $('#membership_no').val();
        var identifier_count = $('#identifier_count').val();
        
        if(identifier_count=='' || parseInt(identifier_count) > 9){
              error_msg_alert('Enter valid identifier count(should not greater than 9)'); return false;
        }
        var identifier_no_arr = []; 
        for(var i=1; i<=identifier_count;i++){
          var ident = $('#identifier'+i).val();
          if(ident!=''){
            identifier_no_arr.push(parseInt(ident));
          }else{
            error_msg_alert('Enter Identifier no'+i); return false;
          }
        }

        var membership_details_arr = [];
        membership_details_arr.push({
          'membership_no' : membership_no,
          'identifier_count' : parseInt(identifier_count),
          'status' : 'Active',
          'nos':identifier_no_arr
        });

        for(var d=1; d<=dynamic_div_count;d++){

          var identifier_no_arr1 = []; 
          var membership_no = $('#membership_no'+d).val();
          var identifier_count = $('#identifier_count'+d).val();
          
          if(identifier_count=='' || parseInt(identifier_count) > 9){
              error_msg_alert('Enter valid identifier count(should not greater than 9)'); return false;
          }
          
          for(var i=1; i<=identifier_count;i++){

            var idend1 = $('#identifier'+d+i).val();
            
            if(idend1!=''){
              identifier_no_arr1.push(parseInt(idend1));
            }else{
              error_msg_alert('Enter Identifier no'+i+' of ME No'+(d+1)); return false;
            }
          }
          membership_details_arr.push({
            'membership_no' : membership_no,
            'identifier_count' : parseInt(identifier_count),
            'status' : 'Active',
            'nos':identifier_no_arr1
          });
        }

        $('#btn_save').button('loading');
        $.post(base_url+"controller/app_settings/credit_card_charges/save.php",
          { company_name : company_name, charges_in : charges_in, credit_card_charges : credit_card_charges,tax_charges_in:tax_charges_in,bank_id:bank_id,tax_on_credit_card_charges:tax_on_credit_card_charges,membership_details_arr:membership_details_arr },
          function(data) {
            $('#btn_save').button('reset');
            var msg = data.split('--');
            if(msg[0]=="error"){
              error_msg_alert(msg[1]);
            }else{
              msg_alert(data);
              $('#save_modal').modal('hide');  
              $('#save_modal').on('hidden.bs.modal', function(){
                update_cache();
                list_reflect();
              });
            }
        });
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>