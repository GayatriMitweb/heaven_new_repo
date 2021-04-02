<?php
include_once("../../../model/model.php");
 
?>
<div class="modal fade" id="state_save_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">State</h4>
      </div>
      <div class="modal-body">
        

        <div class="row mg_bt_10"> 
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_state_name')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_state_name')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
          </div> 
        </div>

        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
        
          <table id="tbl_dynamic_state_name" name="tbl_dynamic_state_name" class="table border_0 table-hover no-marg"  cellspacing="0">
              <tr>
                  <td><input id="chk_tour_group1" type="checkbox" checked></td>
                  <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td><input type="text" id="cmb_state1" name="cmb_state" onchange="validate_state(this.id)"  placeholder="*State Name" title="State Name" class="form-control" /></td>
                  <td><select name="active_flag1" id="active_flag1" class="form-control hidden" title="Status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                  </td>
              </tr>                                
          </table>  

        </div> </div> </div>
      
        <div class="row mg_tp_10">
          <div class="col-md-12 text-center">
            <button class="btn btn-sm btn-success" onclick="state_master_save()" id="btn_state_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>


      </div>      
    </div>
  </div>
</div>

<!--  Restrict Modal Close -->
<script type="text/javascript">
$('#state_save_modal').modal('show');
</script>

<script>
$('#state_save_modal').modal('show');

///////////////////////*** City master save start*********//////////////

function state_master_save()
{

  var base_url = $('#base_url').val();
  var state_name = new Array();
  var active_flag_arr = new Array();

  var table = document.getElementById("tbl_dynamic_state_name");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked)
    {  
      var state_name1 = row.cells[2].childNodes[0].value;
      var active_flag = row.cells[3].childNodes[0].value;
 
      if(state_name1=="")
      {
        error_msg_alert("Enter State name in row"+(i+1));
        return false;
      }  

      for(var j=0; j<state_name.length; j++)
      {
        if(state_name[j]==state_name1)
        {
          error_msg_alert(state_name+" is repeated in row"+(j+1)+" and row"+(i+1));
          return false;
        }  
      }  

      state_name.push(state_name1);
      active_flag_arr.push(active_flag);
    }
    
  }

  if(state_name.length==0)
  {
    error_msg_alert("Select rows to save State names!");
    return false;
  }  

  $('#btn_state_save').button('loading');

  $.post( 
               base_url+"controller/other_masters/states/save_states.php",
               { state_name : state_name, active_flag_arr : active_flag_arr },
               function(data) {   
                var msg = data.split('--');
                if(msg[0]=="error"){
                  error_msg_alert(msg[1]); 
                  $('#btn_state_save').button('reset');
                }
                else{
                    msg_alert(data);
                    $('#btn_state_save').button('reset');
                     
                    $('#state_save_modal').modal('hide');
                    list_reflect();
                    
                  } 
               });



}

///////////////////////***City master save end*********//////////////
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>