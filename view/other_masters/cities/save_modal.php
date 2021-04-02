<?php
include_once("../../../model/model.php");

$modal_type = $_POST['modal_type'];
?>
<input type="hidden" id="modal_type" name="modal_type" value="<?= $modal_type ?>">
<div class="modal fade" id="tour_cities_save_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add City</h4>
      </div>
      <div class="modal-body">
        

        <div class="row mg_bt_10"> <div class="col-md-12 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_city_name')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_city_name')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div> </div>

        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
        
          <table id="tbl_dynamic_city_name" name="tbl_dynamic_city_name" class="table border_0 table-hover no-marg"  cellspacing="0">
              <tr>
                  <td><input id="chk_tour_group1" type="checkbox" checked></td>
                  <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td><input placeholder="*City Name" title="City Name" id="other_city"  class="form-control" onchange="validate_city(this.id)"/></td>
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
            <button class="btn btn-sm btn-success" onclick="city_master_save()" id="btn_city_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>


      </div>      
    </div>
  </div>
</div>

<script>
$('#tour_cities_save_modal').modal('show');


///////////////////////*** City master save start*********//////////////

function city_master_save()
{

  var base_url = $('#base_url').val();
  var city_name = new Array();
  var active_flag_arr = new Array();

  var table = document.getElementById("tbl_dynamic_city_name");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked)
    {  
      var city_name1 = row.cells[2].childNodes[0].value;
      var active_flag = row.cells[3].childNodes[0].value;
      
      if(city_name1=="")
      {
        error_msg_alert("Enter city name in row"+(i+1));
        return false;
      }  

      for(var j=0; j<city_name.length; j++)
      {
        if(city_name[j]==city_name1)
        {
          error_msg_alert(city_name+" is repeated in row"+(j+1)+" and row"+(i+1));
          return false;
        }  
      }  

      city_name.push(city_name1);
      active_flag_arr.push(active_flag);
    }
    
  }

  if(city_name.length==0)
  {
    error_msg_alert("Select rows to save city names!");
    return false;
  }  

  $('#btn_city_save').button('loading');

  $.post( 
               base_url+"controller/group_tour/tour_cities/city_master_save_c.php",
               { city_name : city_name, active_flag_arr : active_flag_arr },
               function(data) {
                var msg = data.split('--');
								
								if(msg[0]=='error'){
									error_msg_alert(msg[1]);
                  $('#btn_city_save').button('reset');
                  return false;
								}
								else{
                    msg_alert(data);
                    $('#btn_city_save').button('reset');
                    
                    var modal_type = $('#modal_type').val();
                    $('#tour_cities_save_modal').modal('hide');
                    $('#tour_cities_save_modal').on('hidden.bs.modal', function(){
                        if(modal_type=="master"){
                          //window.location.reload();
                          list_reflect();
                        }
                        else{
                          city_master_dropdown_reload();
                        }
                    });
                }
                    
               });



}

///////////////////////***City master save end*********//////////////
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>