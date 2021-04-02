<?php

include_once("../../../model/model.php");

?>

<form id="frm_save">



<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Airline</h4>

      </div>

      <div class="modal-body">

        

          

        <div class="row mg_bt_10"> <div class="col-md-12 text-right">

            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_airline_master')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>

            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_airline_master')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>

        </div> </div>



        <div class="row"> <div class="col-md-12"> <div class="table-responsive">

        

          <table id="tbl_airline_master" name="tbl_airline_master" class="table border_0 table-hover no-marg">

              <tr>

                  <td><input id="chk_airport1" type="checkbox" checked></td>

                  <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>

                  <td><input type="text" id="airline_name1" name="airline_name" placeholder="*Airline Name" title="Airline Name"></td>

                  <td><input type="text" id="airline_code1" name="airline_code" onchange="validate_alphanumeric(this.id)" style="text-transform: uppercase;" placeholder="*Airline Code" title="Airline Code"></td>

                  <td><select name="active_flag" id="active_flag" title="Status" style="width:100%" class="hidden">

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



        var airline_name_arr = new Array();

        var airline_code_arr = new Array();

        var airline_status_arr = new Array();



        var error_msg = "";

        var table = document.getElementById("tbl_airline_master");

        var rowCount = table.rows.length;

        for(var i=0; i<rowCount; i++)

        {

          var row = table.rows[i];

          if(row.cells[0].childNodes[0].checked)

          {  

              var airline_name = row.cells[2].childNodes[0].value;

              var airline_code = row.cells[3].childNodes[0].value;

              var airline_status = row.cells[4].childNodes[0].value;



              if(airline_name==""){ error_msg +="Airline name is required in row : "+(i+1)+"<br>"; }
              if(airline_code==""){ error_msg +="Airline code is required in row : "+(i+1)+"<br>"; }


              airline_name_arr.push(airline_name);

              airline_code_arr.push(airline_code);

              airline_status_arr.push(airline_status);

          }
          else{
            if(rowCount == '1'){
              error_msg_alert('Atleast enter one Airline details'); return false;
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

          url:base_url()+'controller/other_masters/airlines/save_airline.php',

          data:{  airline_name_arr : airline_name_arr, airline_code_arr : airline_code_arr, airline_status_arr : airline_status_arr },

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