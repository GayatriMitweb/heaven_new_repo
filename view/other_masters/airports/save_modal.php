<?php
include_once("../../../model/model.php");
?>

<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Airport</h4>

      </div>

      <div class="modal-body">

        

          

        <div class="row mg_bt_10"> <div class="col-md-12 text-right">

            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_airport_master')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>

            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_airport_master')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>

        </div> </div>



        <div class="row"> <div class="col-md-12"> <div class="table-responsive">

        

          <table id="tbl_airport_master" name="tbl_airport_master" class="table border_0 table-hover no-marg pd_bt_51">

              <tr>

                  <td><input id="chk_airport1" type="checkbox" checked></td>

                  <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>

                  <td><select name="city_id" id="city_id1" title="Select City" class="app_select2" style="width:150px">
                  </select></td>

                  <td><input type="text" id="airport_name1" name="airport_name" placeholder="*Airport Name" title="Airport Name"></td>

                  <td><input type="text" id="airport_code1" name="airport_code" onchange="validate_alphanumeric(this.id)" placeholder="*Airport Code" title="Airport Code" style="text-transform: uppercase;"></td>

                  <td><select name="active_flag" id="active_flag" title="Status" style="width:100px" class="hidden">

                        <option value="Active">Active</option>

                        <option value="Inactive">Inactive</option>

                      </select></td>

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

city_lzloading('#city_id1');

$('#frm_save').validate({

    submitHandler:function(form){



        var city_id_arr = new Array();

        var airport_name_arr = new Array();

        var airport_code_arr = new Array();

        var airport_status_arr = new Array();



        var error_msg = "";

        var table = document.getElementById("tbl_airport_master");

        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++)
        {

          var row = table.rows[i];

          if(row.cells[0].childNodes[0].checked)
          {  

              var city_id = row.cells[2].childNodes[0].value;

              var airport_name = row.cells[3].childNodes[0].value;

              var airport_code = row.cells[4].childNodes[0].value;

              var airport_status = row.cells[5].childNodes[0].value;



              if(city_id==""){ error_msg +="Select city in row : "+(i+1)+"<br>"; }

              if(airport_name==""){ error_msg +="Airport name is required in row : "+(i+1)+"<br>"; }
              if(airport_code==""){ error_msg +="Airport code is required in row : "+(i+1)+"<br>"; }

              city_id_arr.push(city_id);

              airport_name_arr.push(airport_name);

              airport_code_arr.push(airport_code);

              airport_status_arr.push(airport_status);
          }
          else{
            if(rowCount == '1'){
              error_msg_alert('Atleast enter one Airport details'); return false;
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

          url:base_url()+'controller/other_masters/airports/save_airport.php',

          data:{ city_id_arr : city_id_arr, airport_name_arr : airport_name_arr, airport_code_arr : airport_code_arr ,airport_status_arr : airport_status_arr},

          success:function(result){

              $('#btn_save').button('reset');

              var msg = result.split('--');


              if(msg[0]!="error"){
                $('#save_modal').modal('hide');
                msg_alert(result);
                // SearchData();
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