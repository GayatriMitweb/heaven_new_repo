<?php 
include_once('../../../model/model.php');

$expense_id = $_POST['expense_id'];
$q_expense = mysql_fetch_assoc(mysql_query("select * from other_expense_master where expense_id='$expense_id'"));
?>
<form id="frm_expense_update">
<input type="hidden" name="expense_id" value="<?= $expense_id ?>" id="expense_id"/>
<div class="modal fade" id="expense_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Expense</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
      	<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>" >
			<div class="panel panel-default panel-body app_panel_style feildset-panel">
			<legend>*Expense For</legend>				
				<div class="row">
          <?php if($q_expense['expense_type_id'] != '0'){
              $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$q_expense[expense_type_id]'")); ?>
           <div class="col-md-3">
            <select name="expense_type2" id="expense_type2" class="form-control" title="Expense Type" style="width:100%" disabled>
              <option value="<?= $sq_ledger['ledger_id'] ?>"><?= $sq_ledger['ledger_name'] ?></option>
            </select>
          </div>
          <?php } ?> 
          <?php if($q_expense['supplier_id'] != '0'){ ?>
					<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<select name="supplier_type2" id="supplier_type2" title="Supplier Type" class="form-control" style="width:100%" disabled>
							<?php 
							$sq_supp = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$q_expense[supplier_id]'"));
							?>
							<option value="<?= $sq_supp['vendor_id'] ?>"><?= $sq_supp['vendor_name'] ?></option>
						</select>
					</div> <?php } ?>
				</div>
			</div><div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
          <legend>Payment Details</legend>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="sub_total1" name="sub_total1" value="<?= $q_expense['amount'] ?>" placeholder="*Amount" title="Amount" class="form-control" onchange="validate_balance(this.id);total_fun_update();">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="service_tax_subtotal1" name="service_tax_subtotal1" placeholder="Tax Amount" title="Tax Amount" onchange="validate_balance(this.id);total_fun_update();" value="<?= $q_expense['service_tax_subtotal'] ?>">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="ledger_ids[]" id="ledger_ids1" title="Select Ledger for posting" size="3" class="form-control" style="width:100%" disabled multiple>
                <option value="">*Select Ledger</option>
                <?php
                $sq = mysql_query("select * from ledger_master where group_sub_id in('99','106') order by ledger_name");
                while($row = mysql_fetch_assoc($sq)){
                    if(strpos($q_expense['ledgers'],$row['ledger_id']) !== false ){
                    ?>
                    <option value="<?= $row['ledger_id'] ?>" selected><?= $row['ledger_name'] ?></option>
                <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row mg_bt_10">
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="text" id="tds1" name="tds1" placeholder="TDS" title="TDS" value="<?= $q_expense['tds'] ?>" class="form-control" onchange="validate_balance(this.id);total_fun_update();">
            </div>            
            <div class="col-md-4 col-sm-6 col-xs-12">
                <input type="text" name="total_fee1" id="total_fee1" class="amount_feild_highlight text-right form-control" placeholder="*Net Total" title="Net Total" value="<?= $q_expense['total_fee'] ?>" readonly>
             </div>                        
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="text" name="due_date1" id="due_date1" placeholder="Due Date" title="Due Date" value="<?= get_date_user($q_expense['due_date']) ?>" class="form-control">
            </div>        
          </div>
          <div class="row mg_bt_10">               
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="text" name="booking_date1" id="booking_date1" placeholder="Booking Date" value="<?= get_date_user($q_expense['expense_date']) ?>" class="form-control" title="Booking Date" onchange="check_valid_date(this.id)">
            </div>       
            <div class="col-md-4 col-sm-6 col-xs-12">
                <input type="text" name="invoice_no1" id="invoice_no1" placeholder="Invoice No" value="<?= $q_expense['invoice_no'] ?>" class="form-control" title="Invoice No">
            </div>  
            <div class="col-xs-4 mg_bt_10_sm_xs">     
                    <div class="div-upload">
                      <div id="id_upload_btn1" class="upload-button1"><span>Upload Invoice</span></div>
                      <span id="id_proof_status" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="id_upload_url1" name="id_upload_url1" value="<?= $q_expense['invoice_url'] ?>">
                    </div> 
            </div>	
          </div>
          <div class="row">
            <div class="col-xs-12 text-center">
              <button class="btn btn-sm btn-success" id="btn_update_expense"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>
	    </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#expense_update_modal').modal('show');
$('#expense_type2,#supplier_type2,#ledger_ids1').select2();
$('#payment_date1,#due_date1,#booking_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });


function total_fun_update()
{ 
    var service_tax = $('#service_tax1').val();
    var service_tax_subtotal = $('#service_tax_subtotal1').val();   
    var sub_total = $('#sub_total1').val();   
    var tds = $('#tds1').val();

    if(sub_total==""){ sub_total = 0; }
    if(service_tax_subtotal==""){ service_tax_subtotal = 0; }
    if(tds==""){ tds = 0; }

    var total_amount = (parseFloat(sub_total) + parseFloat(service_tax_subtotal)) + parseFloat(tds);
    var total=total_amount.toFixed(2);
    $('#total_fee1').val(total);
}

function upload_hotel_pic_attch()
{
    var btnUpload=$('#id_upload_btn1');
    $(btnUpload).find('span').text('Upload Invoice');
    
    new AjaxUpload(btnUpload, {
      action: 'booking/upload_invoice_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $("#id_upload_url1").val(response);
        }
      }
    });
}
upload_hotel_pic_attch();
$(function(){
	$('#frm_expense_update').validate({
		rules:{	
        expense_type: { required: true  },
        sub_total1:{ required : true, number: true },
		},
		submitHandler:function(form){

        var base_url = $('#base_url').val();
 				var expense_id = $('#expense_id').val();
				var expense_type = $('#expense_type2').val();
				var supplier_type = $('#supplier_type2').val();
				var sub_total = $('#sub_total1').val();
        var service_tax_subtotal = $('#service_tax_subtotal1').val();
        var ledger_ids = $('#ledger_ids1').val();
        if(parseFloat(service_tax_subtotal) !== 0 && ledger_ids.length < 1){
          error_msg_alert('Please select ledger for posting!'); return false;
        }
        ledger_ids = ledger_ids.toString();
				var tds = $('#tds1').val();
				var net_total = $('#total_fee1').val();
				var due_date = $('#due_date1').val();
				var booking_date = $('#booking_date1').val();
				var invoice_no = $('#invoice_no1').val();
				var id_upload_url = $('#id_upload_url1').val();
		    var taxation_id = $('#taxation_id1').val();
        
        //Validation for booking and payment date in login financial year
        var check_date1 = $('#booking_date1').val();
        $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
          if(data !== 'valid'){
            error_msg_alert("The Booking date does not match between selected Financial year.");
            return false;
          }else{
				      $('#btn_update_expense').button('loading');
	            $.ajax({
	              type:'post',
	              url: base_url+'controller/other_expense/expense_booking_update.php',
	              data:{ expense_id : expense_id,expense_type : expense_type, supplier_type : supplier_type, sub_total : sub_total,ledger_ids : ledger_ids, service_tax_subtotal : service_tax_subtotal, tds : tds, net_total : net_total, due_date : due_date, booking_date : booking_date, invoice_no : invoice_no, id_upload_url : id_upload_url },
	              success:function(result){
	              	$('#btn_update_expense').button('reset');
	                msg_alert(result);	                
	                $('#expense_update_modal').modal('hide');
	                $('#expense_update_modal').on('hidden.bs.modal', function(){
	                	expense_dashboard_content_reflect();
	                });
	              }
              });
            }
          });
        }
      });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>