<?php

include_once("../../../model/model.php");

?>

<form id="frm_save">



<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Destination</h4>

      </div>

      <div class="modal-body">

        <div class="row mg_bt_10"> <div class="col-md-12 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_destination_master')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_destination_master')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div> </div>



        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
          <table id="tbl_destination_master" name="tbl_destination_master" class="table border_0 table-hover no-marg">
              <tr>
                  <td><input id="chk_dest1" type="checkbox" checked></td>
                  <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td><input type="text" id="destination_name1" onchange="fname_validate(this.id);" name="destination_name1" placeholder="*Destination Name" title="Destination Name"></td>
                  <td><select name="active_flag1" id="active_flag1" title="Status" style="width:100%" class="hidden">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                  </td>
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

$('#city_id1').select2();

$('#frm_save').validate({

    submitHandler:function(form){



        var destination_name_arr = new Array();

        var status_arr = new Array();



        var error_msg = "";

        var table = document.getElementById("tbl_destination_master");

        var rowCount = table.rows.length;

        for(var i=0; i<rowCount; i++)

        {

          var row = table.rows[i];

          if(rowCount == '1'){
            if(!row.cells[0].childNodes[0].checked)
            { 
              error_msg_alert('Atleast enter one Destination'); return false;
            }
          }

          if(row.cells[0].childNodes[0].checked)

          {  

              var destination_name = row.cells[2].childNodes[0].value;

              var status = row.cells[3].childNodes[0].value;

              if(destination_name==""){ error_msg +="Destination name is required in row : "+(i+1)+"<br>"; }



              destination_name_arr.push(destination_name);

              status_arr.push(status);

          }
          

         }

        if(error_msg!=""){

          error_msg_alert(error_msg);

          return false;

        }



        $('#btn_save').button('loading');



        $.ajax({

          type:'post',

          url:base_url()+'controller/other_masters/destination/destination_master.php',

          data:{  destination_name_arr : destination_name_arr, status_arr : status_arr},

          success:function(result){

              $('#btn_save').button('reset');

              var msg = result.split('--');

              msg_alert(result);

              if(msg[0]!="error"){

                $('#save_modal').modal('hide');

                list_reflect();

              }

          }

        });







    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>