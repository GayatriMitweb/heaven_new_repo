<?php include_once("../../../model/model.php"); ?>

<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document" style='width:50%;'>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ROE</h4>
      </div>
      <div class="modal-body">

        <div class="row mg_bt_10"> <div class="col-md-12 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_roe_master')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_roe_master')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div> </div>

        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
          <table id="tbl_roe_master" name="tbl_roe_master" class="table border_0 table-hover no-marg">
              <tr>
                  <td><input id="chk_currency" type="checkbox" checked></td>
                  <td style="width: 100px;"><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td style="width: 150px;"><select name="currency_code" id="currency_code" class="app_select2" style="width:150px">
                        <option value="">Select Currency</option>
                        <?php 
                          $sq_currency = mysql_query("select * from currency_name_master order by default_currency desc");
                          while($row_currency = mysql_fetch_assoc($sq_currency)){
                        ?>
                            <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                        <?php } ?>
                        </select></td>
                  <td><input type="number" id="currency_rate" name="currency_rate" placeholder="*Currency Rate" title="Currency Rate"></td>
              </tr>
          </table>  
        </div> </div> </div>

        <div class="row mg_tp_10">
          <div class="col-md-12 text-center">
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
$('#currency_code').select2();

$('#frm_save').validate({
    submitHandler:function(form){

        var currency_name_arr = new Array();
        var currency_rate_arr = new Array();

        var error_msg = "";
        var table = document.getElementById("tbl_roe_master");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){

          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){  

              var currency_name = row.cells[2].childNodes[0].value;
              var currency_rate = row.cells[3].childNodes[0].value;

              if(currency_name==""){ error_msg +="Select Currency in row : "+(i+1)+"<br>"; }
              if(currency_rate==""){ error_msg +="Enter Currency Rate in row : "+(i+1)+"<br>"; }

              currency_name_arr.push(currency_name);
              currency_rate_arr.push(currency_rate);
          }
          else{
            if(rowCount == '1'){
              error_msg_alert('Atleast enter one ROE details'); return false;
            }
          }
         }

        if(error_msg!=""){
          error_msg_alert(error_msg);
          return false;
        }

        $('#btn_save').button('loading');
        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/roe/save_roe.php',
          data:{  currency_name_arr : currency_name_arr, currency_rate_arr : currency_rate_arr },
          success:function(result){
              $('#btn_save').button('reset');
              var msg = result.split('--');
              if(msg[0]!="error"){
                $('#save_modal').modal('hide');
                msg_alert(result);
                list_reflect();
              }
              else{
                error_msg_alert(msg[1]);
                $('#btn_save').button('reset');
              }
          }
        });
    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>