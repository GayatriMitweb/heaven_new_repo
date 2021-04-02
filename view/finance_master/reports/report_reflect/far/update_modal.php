<?php
include "../../../../../model/model.php";
$entry_id = $_POST['id'];
$sq_asset = mysql_fetch_assoc(mysql_query("select * from fixed_asset_entries where entry_id='$entry_id'"));
?>
<form id="asset_frm_update">

<input type="text" name="old_sold_amount" id="old_sold_amount" placeholder="Asset Sold Amount" value="<?= $sq_asset['sold_amount'] ?>" title="Asset Sold Amount">
<div class="modal fade" id="asset_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asset</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <select id="asset_type" name="asset_type" onchange="get_assets(this.id,'2')" style="width: 100%" disabled>
                <?php 
                $sq_query = mysql_fetch_assoc(mysql_query("select * from fixed_asset_master where entry_id='$sq_asset[asset_id]'"));
                ?>
                  <option value="<?= $sq_query['asset_type'] ?>"><?= $sq_query['asset_type'] ?></option>
              </select>
            </div>
            <div class="col-md-4">
              <select id="asset_name2" name="asset_name2" style="width: 100%" disabled>
                  <option value="<?= $sq_query['entry_id'] ?>"><?= $sq_query['asset_name'] ?></option>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" name="asset_ledger_name1" id="asset_ledger_name1" placeholder="Asset Ledger Name" value="<?= $sq_asset['asset_ledger'] ?>">
            </div>            
          </div>   
          <div class="row mg_tp_20">
            <div class="col-md-4">
              <input type="text" name="purchase_date1" id="purchase_date1" placeholder="Purchase Date" value="<?= get_date_user($sq_asset['purchase_date']) ?>" readonly>
            </div>
            <div class="col-md-4">
              <input type="text" name="purchase_amount1" id="purchase_amount1" placeholder="Purchase Amount"  value="<?= $sq_asset['purchase_amount'] ?>" onchange="calculate_depreciation_amount('purchase_amount1','depr_type2','rate_of_depr1','depr_interval1','purchase_date1','asset_name2','asset_ledger_name1','1')" readonly>
            </div>
            <div class="col-md-4">
              <select id="depr_type2" name="depr_type2" style="width: 100%" onchange="calculate_depreciation_amount('purchase_amount1','depr_type2','rate_of_depr1','depr_interval1','purchase_date1','asset_name2','asset_ledger_name1','1')">
                <option value="<?= $sq_asset['depr_type'] ?>"><?= $sq_asset['depr_type'] ?></option>
                <option value="">Depreciation Type</option>
                <option value="Written Down Value">Written Down Value</option>
                <option value="Straight Line">Straight Line</option>
              </select>
            </div>     
          </div>      
          <div class="row mg_tp_20">       
            <div class="col-md-4">
              <input type="text" name="rate_of_depr1" id="rate_of_depr1" placeholder="Rate of Depreciation" onchange="calculate_depreciation_amount('purchase_amount1','depr_type2','rate_of_depr1','depr_interval1','purchase_date1','asset_name2','asset_ledger_name1','1')" value="<?= $sq_asset['rate_of_depr'] ?>">
            </div>
            <div class="col-md-4">
              <select name="depr_interval1" id="depr_interval1" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Depreciation Intervals" onchange="calculate_depreciation_amount('purchase_amount1','depr_type2','rate_of_depr1','depr_interval1','purchase_date1','asset_name2','asset_ledger_name1','1');get_depr_validation(this.id);">
              <?php 
              $sq_finacial_year1 = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id ='$sq_asset[depr_interval]'"));
              $financial_year1 = get_date_user($sq_finacial_year1['from_date']).'&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;'.get_date_user($sq_finacial_year1['to_date']);
              ?>
                <option value="<?= $sq_finacial_year1['financial_year_id'] ?>"><?= $financial_year1 ?></option>
                <option>Depreciation Interval</option>
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
              <input type="text" name="depr_amount1" id="depr_amount1" placeholder="Depreciation Till Date" title="Depreciation Till Date" value="<?= $sq_asset['depr_till_date'] ?>">
            </div>
          </div>   
          <div class="row mg_tp_20">
            <div class="col-md-4">
              <input type="text" name="carrying_amount1" id="carrying_amount1" placeholder="Carrying Amount as on Date" title="Carrying Amount as on Date" value="<?= $sq_asset['carrying_amount'] ?>" readonly>
            </div>
            <div class="col-md-4">
              <input type="text" name="sold_amount1" id="sold_amount1" onchange="calculate_profit_loss('1')" placeholder="Asset Sold Amount" value="<?= $sq_asset['sold_amount'] ?>" title="Asset Sold Amount">
            </div>
            <div class="col-md-4">
              <input type="text" name="profit_loss1" id="profit_loss1" placeholder="Profit/Loss On sale" title="Profit/Loss On sale" value="<?= $sq_asset['profit_loss'] ?>" readonly>
            </div>
          </div> 
          <div class="row mg_tp_20">
            <div class="col-md-12">
              <TEXTAREA name="remark" id="remark" placeholder="Remark"><?= $sq_asset['remark'] ?></TEXTAREA> 
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-md-12">
              <div class="div-upload">
                  <div id="photo_upload_btn_p" class="upload-button1"><span>Evidence</span></div>
                  <span id="photo_status" ></span>
                  <ul id="files" ></ul>
                  <input type="hidden" id="evidence_url" name="evidence_url" value="<?= $sq_asset['evidence_url'] ?>">
                </div>
            </div>
          </div>    
          <div class="row text-center mg_bt_10">
            <div class="col-md-12">
              <button id="btn_update" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </div>   
    </div>
  </div>
</div>



</form>



<script>

$('#asset_update_modal').modal('show');
$('#asset_type, #asset_name2').select2();
$('#purchase_date1').datetimepicker({ timepicker:false, format:'d-m-Y' }); 


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

function get_depr_validation(depr_interval1){

        var depr_interval1 = $('#'+depr_interval1).val();

        $.ajax({
          type: 'post',
          url: 'report_reflect/far/depr_date_validation.php',
          data:{ depr_interval1 : depr_interval1},
          success: function(result){
          $('#val_result').val(result);
          }
        });
}

$('#asset_frm_update').validate({
    rules:{
            system_cash : { required : true },
    },

    submitHandler:function(){
        var branch_admin_id = $('#branch_admin_id1').val();
        var asset_id = $('#asset_name2').val();
        var asset_ledger = $('#asset_ledger_name1').val();
        var purchase_date1 = $('#purchase_date1').val();
        var purchase_amount1 = $('#purchase_amount1').val();
        var depr_type2 = $('#depr_type2').val();
        var rate_of_depr1 = $('#rate_of_depr1').val();
        var depr_interval1 = $('#depr_interval1').val();
        var depr_till_date1 = $('#depr_amount1').val();
        var carrying_amount1 = $('#carrying_amount1').val();
        var sold_amount1 = $('#sold_amount1').val();
        var profit_loss = $('#profit_loss1').val();
        var remark = $('#remark').val();
        var evidence_url = $('#evidence_url').val();
        var old_sold_amount = $('#old_sold_amount').val();

 
        $('#btn_update').button('loading');

        $.ajax({

          type: 'post',

          url: base_url()+'controller/finance_master/reports/far/far_master_save.php',

          data:{ branch_admin_id : branch_admin_id, asset_id : asset_id,  asset_ledger : asset_ledger, purchase_date : purchase_date1, purchase_amount : purchase_amount1, depr_type : depr_type2 , rate_of_depr : rate_of_depr1 ,  depr_interval : depr_interval1 , depr_till_date : depr_till_date1, carrying_amount : carrying_amount1,sold_amount : sold_amount1,profit_loss : profit_loss,remark : remark,evidence_url : evidence_url,old_sold_amount : old_sold_amount },

          success: function(result){
            $('#btn_update').button('reset');
            msg_alert(result);
            $('#asset_update_modal').modal('hide');
            report_reflect();
          }

        });



    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>