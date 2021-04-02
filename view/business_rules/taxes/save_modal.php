<?php
include_once("../../../model/model.php");
?>
<input type="hidden" id="modal_type" name="modal_type">
<div class="modal fade" id="taxes_save_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Tax</h4>
      </div>
      <div class="modal-body">
        
        <div class="row mg_bt_10"> <div class="col-md-12 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_taxes')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_taxes')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div></div>

        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
        
          <table id="tbl_taxes" name="tbl_taxes" class="table border_0 table-hover no-marg"  cellspacing="0">
              <tr>
                  <td><input id="chk_tax1" type="checkbox" checked></td>
                  <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td><input type="text" placeholder="*Code" title="Code" id="code"  class="form-control" /></td>
                  <td><input type="text" placeholder="*Name" title="Name" id="name"  class="form-control" /></td>
                  <td><select name="rate_in" id="rate_in" data-toggle="tooltip" class="form-control"  title="*Rate In">
                        <option value="Percentage">Percentage</option>
                        <option value="Flat">Flat</option>
                      </select>
                  </td>
                  <td><input type="number" placeholder="*Rate" min="0" title="Rate" id="rate" class="form-control" onchange="toggle_rate_validation(this.id)" /></td>
              </tr>                                
          </table>  

        </div> </div> </div>
      
        <div class="row mg_tp_20">
          <div class="col-md-12 text-center">
            <button class="btn btn-sm btn-success" onclick="taxes_master_save()" id="btn_taxes_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>


      </div>      
    </div>
  </div>
</div>

<script>
$('#taxes_save_modal').modal('show');

function taxes_master_save()
{
  var base_url = $('#base_url').val();
  var code_array = new Array();
  var name_array = new Array();
  var rate_in_array = new Array();
  var rate_array = new Array();

  var table = document.getElementById("tbl_taxes");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++){

    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked){

      var code = row.cells[2].childNodes[0].value;
      var name = row.cells[3].childNodes[0].value;
      var rate_in = row.cells[4].childNodes[0].value;
      var rate = row.cells[5].childNodes[0].value;
      
      if(code==""){
        error_msg_alert("Enter Code in row"+(i+1));
        return false;
      }
      if(name==""){
        error_msg_alert("Enter Name in row"+(i+1));
        return false;
      }
      if(rate==""){
        error_msg_alert("Enter Rate in row"+(i+1));
        return false;
      }
      if(parseFloat(rate) < 0){
        error_msg_alert("Rate should not be less than 0 in row"+(i+1));
        return false;
      }

      for(var j=0; j<code_array.length; j++){
        if(code_array[j]==code){

          error_msg_alert(code+" is repeated in row"+(j+1)+" and row"+(i+1));
          return false;
        }  
      }
      code_array.push(code);
      name_array.push(name);
      rate_in_array.push(rate_in);
      rate_array.push(rate);
    }
  }

  if(code_array.length==0){
    error_msg_alert("Select rows to save taxes!");
    return false;
  }  

  $('#btn_taxes_save').button('loading');
  $.post( 
        base_url+"controller/business_rules/taxes/save.php",
        { code_array : code_array, name_array : name_array,rate_in_array:rate_in_array,rate_array:rate_array },
        function(data) {
          var msg = data.split('--');
          if(msg[0].replace(/\s/g, '') === "error"){
            error_msg_alert(msg[1]);
            $('#btn_taxes_save').button('reset');
            return false;
          }
          else{
              success_msg_alert(data);
              $('#btn_taxes_save').button('reset');
              $('#taxes_save_modal').modal('hide');
              update_cache();
              list_reflect();
          }
  });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>