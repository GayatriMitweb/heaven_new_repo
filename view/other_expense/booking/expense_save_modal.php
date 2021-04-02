<form id="frm_vendor_expense_save">
<div class="modal fade" id="expense_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Expense</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
      	<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>" >
			<div class="panel panel-default panel-body app_panel_style feildset-panel">
			<legend>*Expense For</legend>				
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<select name="expense_type" id="expense_type" title="Expense Type" class="form-control" style="width:100%">
							<option value="">*Expense Type</option>
							<?php 
							$sq_expense = mysql_query("select * from ledger_master where group_sub_id in ('84','44','47','43','75','81','82','59','103','51','35','69','97','98','76','57','88','80','92','72','9','7','8')");
							while($row_expense = mysql_fetch_assoc($sq_expense)){
								?>
								<option value="<?= $row_expense['ledger_id'] ?>"><?= $row_expense['ledger_name'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<select name="supplier_type" id="supplier_type" title="Supplier Name" class="form-control" style="width:100%" required>
							<option value="">*Supplier Name</option>
							<?php 
							$sq_expense = mysql_query("select * from other_vendors order by vendor_name");
							while($row_expense = mysql_fetch_assoc($sq_expense)){
								?>
								<option value="<?= $row_expense['vendor_id'] ?>"><?= $row_expense['vendor_name'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
				</div>
			</div>
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
          <legend>Payment Details</legend>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="sub_total" name="sub_total" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);total_fun();">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" onchange="validate_balance(this.id);total_fun();">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="ledger_ids[]" id="ledger_ids" title="Select Ledger for posting" size="3" class="form-control" style="width:100%" multiple>
                <?php
                $sq = mysql_query("select * from ledger_master where group_sub_id in('99','106') order by ledger_name");
                ?>
                <option value="">*Select Ledger</option>
                <?php while($row = mysql_fetch_assoc($sq)){ ?>
                  <option value="<?= $row['ledger_id'] ?>"><?= $row['ledger_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="tds" name="tds" placeholder="TDS" title="TDS" onchange="validate_balance(this.id);total_fun();">
            </div>            
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="total_fee" id="total_fee" class="amount_feild_highlight text-right" placeholder="*Net Total" title="Net Total" readonly>
             </div>                        
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" name="due_date" id="due_date" id="due_date" value="<?= date('d-m-Y') ?>" placeholder="Due Date" title="Due Date">
            </div>                     
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" name="booking_date" id="booking_date" placeholder="Booking Date" value="<?= date('d-m-Y') ?>" title="Booking Date" onchange="check_valid_date(this.id)">
            </div>         
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="invoice_no" id="invoice_no" placeholder="Invoice No" title="Invoice No">
            </div> 
    				<div class="col-md-4">
    			          <div class="div-upload">
    			            <div id="id_upload_btn" class="upload-button1"><span>Upload Invoice</span></div>
    			            <span id="id_proof_status" ></span>
    			            <ul id="files" ></ul>
    			            <input type="hidden" id="id_upload_url" name="id_upload_url1">
    			          </div> 
    				</div> 	
          </div>
        </div>

        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
        <legend>Advance Payment Details</legend>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="*Payment Date" title="Payment Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
               <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Payment Amount" title="Payment Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_id')">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="payment_mode" id="payment_mode" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                <?php echo get_payment_mode_dropdown(); ?>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
               <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="transaction_id" name="transaction_id" class="form-control" onchange="validate_balance(this.id);" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
            </div>  
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
             <select name="bank_id" id="bank_id" title="Select Bank" disabled>
              <?php get_bank_dropdown(); ?>
            </select>
          </div>
        </div>
        <div class="row">     
              <div class="col-md-3 mg_bt_10_sm_xs">
                <div class="div-upload pull-left" id="div_upload_button">
                    <div id="payment_evidence_upload" class="upload-button1"><span>Payment Evidence</span></div>
                    <span id="payment_evidence_status" ></span>
                    <ul id="files" ></ul>
                    <input type="hidden" id="payment_evidence_url" name="payment_evidence_url">
                </div>
              </div>  
               <div class="col-md-9 col-sm-9 no-pad mg_bt_20">
                 <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
               </div>   
        </div>
      </div> 
			<div class="row">
				<div class="col-xs-12 text-center">
					<button class="btn btn-sm btn-success" id="btn_save_expense"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
				</div>
			</div>
	    </div>      
    </div>
  </div>
</div>
</form>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>

$('#expense_type,#supplier_type,#ledger_ids').select2();
$('#payment_date,#due_date,#booking_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
//Payment Evidence  Upload
function payment_evidance_upload()
{ 
    var btnUpload=$('#payment_evidence_upload');
    $(btnUpload).find('span').text('Payment Evidence');
    $('#payment_evidence_url').val('');
    
    new AjaxUpload(btnUpload, {
      action: 'payment/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF or pdf files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload Again');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $('#payment_evidence_url').val(response);
        }
      }
    });
}
payment_evidance_upload();

//Invoice Upload
function upload_invoice_pic_attch()
{	
    var btnUpload=$('#id_upload_btn');
    $(btnUpload).find('span').text('Upload Invoice');
    $('#id_upload_url').val('');
    
    new AjaxUpload(btnUpload, {
      action: 'booking/upload_invoice_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF or pdf files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload Again');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $('#id_upload_url').val(response);
        }
      }
    });
}

upload_invoice_pic_attch();

function total_fun(){

    var service_tax = $('#service_tax').val();
    var service_tax_subtotal = $('#service_tax_subtotal').val();   
    var sub_total = $('#sub_total').val();   
    var tds = $('#tds').val();

    if(sub_total==""){ sub_total = 0; }
    if(service_tax_subtotal==""){ service_tax_subtotal = 0; }
    if(tds==""){ tds = 0; }
    
    var total_amount = parseFloat(sub_total) + parseFloat(service_tax_subtotal) + parseFloat(tds);
    var total=total_amount.toFixed(2);
    $('#total_fee').val(total);
}
$(function(){
	$('#frm_vendor_expense_save').validate({
		rules:{

				expense_type: { required: true  },
				sub_total:{ required : true, number: true },
        payment_amount: { required : true }, 
        payment_mode : { required : true }, 
        payment_date : { required : true }, 
        bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
        transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
        bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },   
		},
		submitHandler:function(form){
				var base_url = $('#base_url').val();

				var expense_type = $('#expense_type').val();
				var supplier_type = $('#supplier_type').val();
				var sub_total = $('#sub_total').val();
        var service_tax_subtotal = $('#service_tax_subtotal').val();
        var ledger_ids = $('#ledger_ids').val();
        if(service_tax_subtotal !== '' && ledger_ids.length < 1){
          error_msg_alert('Please select ledger for posting!'); return false;
        }
        if(ledger_ids.length > 2){
          error_msg_alert('You can select max 2 ledgers!'); return false;
        }
        ledger_ids = ledger_ids.toString();

				var tds = $('#tds').val();
				var net_total = $('#total_fee').val();
				var due_date = $('#due_date').val();
				var booking_date = $('#booking_date').val();
				var invoice_no = $('#invoice_no').val();
				var id_upload_url = $('#id_upload_url').val();
        var payment_date = $('#payment_date').val();
        var payment_amount = $('#payment_amount').val();
        var payment_mode = $('#payment_mode').val();
        var bank_name = $('#bank_name').val();
        var transaction_id = $('#transaction_id').val();
        var bank_id = $('#bank_id').val();
        var payment_evidence_url = $('#payment_evidence_url').val();
        var emp_id = $('#emp_id').val();        
        var branch_admin_id = $('#branch_admin_id1').val(); 

        //Validation for booking and payment date in login financial year
        var check_date1 = $('#booking_date').val();
        $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
          if(data !== 'valid'){
            error_msg_alert("The Booking date does not match between selected Financial year.");
            return false;
          }else{
            var payment_date = $('#payment_date').val();
            $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
            if(data !== 'valid'){
              error_msg_alert("The Payment date does not match between selected Financial year.");
              return false;
            }
            else{
              $('#btn_save_expense').button('loading');
              $.ajax({
                type:'post',
                url: base_url+'controller/other_expense/expense_booking_save.php',
                data:{ expense_type : expense_type, supplier_type : supplier_type, sub_total : sub_total, ledger_ids : ledger_ids, service_tax_subtotal : service_tax_subtotal, tds : tds, net_total : net_total, due_date : due_date, booking_date : booking_date, invoice_no : invoice_no,id_upload_url : id_upload_url, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id,branch_admin_id : branch_admin_id, payment_evidence_url : payment_evidence_url, emp_id : emp_id},
                success:function(result){
                  $('#btn_save_expense').button('reset');
                  msg_alert(result);	                
                  $('#expense_save_modal').modal('hide');
                  reset_form('frm_vendor_expense_save');
                  $('#expense_save_modal').on('hidden.bs.modal', function(){
                      expense_dashboard_content_reflect();
                  });
                }
              });
            }
          });
        }
      });
 
		}
	});
});
</script>