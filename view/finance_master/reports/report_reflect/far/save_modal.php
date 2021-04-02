<?php
include "../../../../../model/model.php";
$branch_admin_id = $_POST['branch_admin_id'];
?>
<form id="asset_frm_save">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="asset_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Asset</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <select id="asset_type" name="asset_type" onchange="get_assets(this.id)" style="width: 100%">
                <option value="">Type of Asset</option>
                <?php 
                $sq_query = mysql_query("select distinct(asset_type) from fixed_asset_master");
                while($row_query = mysql_fetch_assoc($sq_query)){ ?>
                  <option value="<?= $row_query['asset_type'] ?>"><?= $row_query['asset_type'] ?></option>
                <?php } ?>

              </select>
            </div>
            <div class="col-md-4">
              <select id="asset_name" name="asset_name" style="width: 100%">
                  <option value="">Select Asset</option>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" name="asset_ledger_name" id="asset_ledger_name" placeholder="Asset Ledger Name">
            </div>            
          </div>   
          <div class="row mg_tp_20">
            <div class="col-md-4">
              <input type="text" name="purchase_date" id="purchase_date" placeholder="Purchase Date">
            </div>
            <div class="col-md-4">
              <input type="text" name="purchase_amount" id="purchase_amount" placeholder="Purchase Amount" onchange="calculate_depreciation_amount('purchase_amount','depr_type','rate_of_depr','depr_interval','purchase_date','asset_name','asset_ledger_name')">
            </div>
            <div class="col-md-4">
              <select id="depr_type" name="depr_type" style="width: 100%" onchange="calculate_depreciation_amount('purchase_amount','depr_type','rate_of_depr','depr_interval','purchase_date','asset_name','asset_ledger_name')">
                <option value="">Depreciation Type</option>
                <option value="Written Down Value">Written Down Value</option>
                <option value="Straight Line">Straight Line</option>
              </select>
            </div>     
          </div>      
          <div class="row mg_tp_20">       
            <div class="col-md-4">
              <input type="text" name="rate_of_depr" id="rate_of_depr" placeholder="Rate of Depreciation" onchange="calculate_depreciation_amount('purchase_amount','depr_type','rate_of_depr','depr_interval','purchase_date','asset_name','asset_ledger_name')">
            </div>
            <div class="col-md-4">
              <select name="depr_interval" id="depr_interval" class="form-control"  title="Depreciation Intervals" onchange="get_depr_validation(this.id);calculate_depreciation_amount('purchase_amount','depr_type','rate_of_depr','depr_interval','purchase_date','asset_name','asset_ledger_name')">
                <option value="">Depreciation Interval</option>
              <?php 
              $sq_finacial_year = mysql_query("select * from financial_year order by financial_year_id desc");

                while($row_financial_year = mysql_fetch_assoc($sq_finacial_year)){
                  $financial_year = get_date_user($row_financial_year['from_date']).'&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;'.get_date_user($row_financial_year['to_date']);
                  ?>

                  <option value="<?= $row_financial_year['financial_year_id'] ?>"><?= $financial_year  ?></option>

                  <?php

                }
                 ?>
            </select>
            </div>
            <div class="col-md-4">
              <input type="text" name="depr_amount" id="depr_amount" placeholder="Depreciation Till Date" title="Depreciation Till Date">
            </div>
          </div>   
          <div class="row mg_tp_20">
            <div class="col-md-4">
              <input type="text" name="carrying_amount" id="carrying_amount" placeholder="Carrying Amount as on Date" title="Carrying Amount as on Date" readonly>
            </div>
            <div class="col-md-4">
              <input type="text" name="sold_amount" id="sold_amount" onchange="calculate_profit_loss()" placeholder="Asset Sold Amount" title="Asset Sold Amount">
            </div>
            <div class="col-md-4">
              <input type="text" name="profit_loss" id="profit_loss" placeholder="Profit/Loss On sale" title="Profit/Loss On sale" readonly>
            </div>
          </div> 
          <div class="row mg_tp_20">
            <div class="col-md-12">
              <TEXTAREA name="remark" id="remark" placeholder="Remark"></TEXTAREA> 
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-md-12">
              <div class="div-upload">
                  <div id="photo_upload_btn_p" class="upload-button1"><span>Evidence</span></div>
                  <span id="photo_status" ></span>
                  <ul id="files" ></ul>
                  <input type="hidden" id="evidence_url" name="evidence_url">
                </div>
            </div>
            <input type="hidden" name="val_result" id="val_result">
          </div>    
          <div class="row text-center mg_bt_10">
            <div class="col-md-12">
              <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </div>   
    </div>
  </div>
</div>



</form>



<script>

$('#asset_save_modal').modal('show');
$('#asset_type, #asset_name').select2();
$('#purchase_date').datetimepicker({ timepicker:false, format:'d-m-Y' }); 


upload_user_pic_attch();

function upload_user_pic_attch()

{

    var btnUpload=$('#photo_upload_btn_p');

    $(btnUpload).find('span').text('Evidence');


    new AjaxUpload(btnUpload, {

      action: 'report_reflect/far/upload_proof.php',

      name: 'uploadfile',

      onSubmit: function(file, ext)

      {  

        if (! (ext && /^(jpg|png|jpeg|docx|pdf|xlsx)$/.test(ext))){ 

         error_msg_alert('Only JPG, PNG, GIF, Excel, Word, PDF files are allowed');

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

          $("#evidence_url").val(response);

        }

      }

    });

}

function get_depr_validation(depr_interval){

        var depr_interval = $('#'+depr_interval).val();

        $.ajax({
          type: 'post',
          url: 'report_reflect/far/depr_date_validation.php',
          data:{ depr_interval : depr_interval},
          success: function(result){
          $('#val_result').val(result);
          }
        });
}

$('#asset_frm_save').validate({
    rules:{
            asset_type : { required : true },
            asset_name : { required : true },
            asset_ledger_name : { required : true },
            purchase_date : { required : true },
            purchase_amount : { required : true },
            depr_type : { required : true },
            rate_of_depr : { required : true },
            depr_interval : { required : true },
    },

    submitHandler:function(){
        var branch_admin_id = $('#branch_admin_id1').val();
        var asset_id = $('#asset_name').val();
        var asset_ledger = $('#asset_ledger_name').val();
        var purchase_date = $('#purchase_date').val();
        var purchase_amount = $('#purchase_amount').val();
        var depr_type = $('#depr_type').val();
        var rate_of_depr = $('#rate_of_depr').val();
        var depr_interval = $('#depr_interval').val();
        var depr_till_date = $('#depr_amount').val();
        var carrying_amount = $('#carrying_amount').val();
        var sold_amount = $('#sold_amount').val();
        var profit_loss = $('#profit_loss').val();
        var remark = $('#remark').val();
        var evidence_url = $('#evidence_url').val();

        if($('#val_result').val() == 0) { error_msg_alert("Depreciation can not be done!"); return false; }        

        $('#btn_save').button('loading');

        $.ajax({

          type: 'post',

          url: base_url()+'controller/finance_master/reports/far/far_master_save.php',

          data:{ branch_admin_id : branch_admin_id, asset_id : asset_id,  asset_ledger : asset_ledger, purchase_date : purchase_date, purchase_amount : purchase_amount, depr_type : depr_type , rate_of_depr : rate_of_depr ,  depr_interval : depr_interval , depr_till_date : depr_till_date, carrying_amount : carrying_amount,sold_amount : sold_amount,profit_loss : profit_loss,remark : remark,evidence_url : evidence_url },

          success: function(result){
            $('#btn_save').button('reset');
            msg_alert(result);
            $('#asset_save_modal').modal('hide');
            report_reflect();
          }

        });



    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>