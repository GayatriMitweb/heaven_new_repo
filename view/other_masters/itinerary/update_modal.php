<?php
include "../../../model/model.php";
$dest_id = $_POST['dest_id'];
?>

<form id="itinerary_frm_update">

<div class="modal fade" id="itinerary_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Itinerary</h4>

      </div>

      <div class="modal-body">
        <div class="row">
          <div class="text-left col-md-3 col-sm-6">
            <select id="dest_ids1"  name="dest_names1" title="Select Destination" class="form-control" onchange="check_dest_validation(this.id)" style="width:100%" disabled> 
              <?php
              $row_dest = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id = '$dest_id'"));
              ?>
              <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
            </select>
          </div>
          <div class="col-xs-9 text-right text_center_xs">
              <button type="button" class="btn btn-excel btn-sm" title="Add row" onClick="addRow('default_program_list')"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="row mg_tp_10">
          <div class="col-sm-12">  
            <span style="color: red;" class="note" data-original-title="" title="">Note : Character limit for Special attraction is 85 characters, for Day-wise program is 500 characters and for Overnight stay is 30 characters.</span>
          </div>
          <div class="col-sm-12 mg_tp_10"> 
          <span style="color: red;" class="note" data-original-title="" title="">For saving daywise program keep checkbox selected!</span>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-6 col-xs-12 mg_bt_10">
            <table style="width:100%" id="default_program_list" name="default_program_list" class="table mg_bt_0 table-bordered">
                <tbody>
                  <?php
                  $count = 0;
                  $sq_itinerary = mysql_query("select * from itinerary_master where dest_id='$dest_id'");
                  while($row_itinerary = mysql_fetch_assoc($sq_itinerary)){
                    $count++;
                    ?>
                    <tr>
                      <td width="27px;" style="padding-right: 10px !important;"><input class="css-checkbox labelauty" id="chk_programd<?=$count?>" type="checkbox" checked style="display: none;"><label for="chk_programd1<?=$count?>"><span class="labelauty-unchecked-image"></span><span class="labelauty-checked-image"></span></label></td>
                      <td width="20px;"><input maxlength="15" value="<?=$count?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled=""></td>
                      <td class="col-md-3 no-pad" style="padding-left: 5px !important;"><input type="text" id="special_attaraction<?=$count?>-u" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control" placeholder="*Special Attraction" title="Special Attraction" value="<?=$row_itinerary['special_attraction']?>"></td>
                      <td class="col-md-5 no-pad" style="padding-left: 5px !important;"><textarea id="day_program<?=$count?>-u" name="day_program" class="form-control" title="" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" title="Day-wise Program"><?=$row_itinerary['daywise_program']?></textarea></td>
                      <td class="col-md-2 no-pad" style="padding-left: 5px !important;"><input type="text" id="overnight_stay<?=$count?>-u" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control" placeholder="*Overnight Stay" title="Overnight Stay" value="<?=$row_itinerary['overnight_stay']?>"></td>
                      <td class="hidden"><input type="text" id="entry_id" name="entry_id" class="form-control" value="<?=$row_itinerary['entry_id']?>"></td>
                    </tr>
                    <?php 
                  } ?>
                </tbody>
            </table>
            </div>
        </div>
          <div class="row mg_tp_10">
            <div class="col-xs-12 text-center">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>



      </div>      

    </div>

  </div>

</div>

</form>

<script>
$('#dest_ids1').select2();
$('#itinerary_update_modal').modal('show');

$('#itinerary_frm_update').validate({
    rules:{
           dest_names1 : { required : true }
    },
    submitHandler:function(form){

      var dest_id = $('#dest_ids1').val();
      var table = document.getElementById("default_program_list");
      var rowCount = table.rows.length;
      //Atleast one row validation
      var count = 0;
      for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
              count++;
          }
      }
      if(parseInt(count) == 0){
          error_msg_alert("Please select atleast one day itinerary!");
          return false;
      }
			var checked_arr = new Array();
      var sp_arr = new Array();
      var dwp_arr = new Array();
      var os_arr = new Array();
			var entry_id_arr = new Array();
      for(var i=0; i<rowCount; i++){
        
        var row = table.rows[i];

        var status = row.cells[0].childNodes[0].checked;
        var sp = row.cells[2].childNodes[0].value;
        var dwp = row.cells[3].childNodes[0].value;
        var os = row.cells[4].childNodes[0].value;
				if(row.cells[5]){
					var entry_id = row.cells[5].childNodes[0].value;	
				}
				else{
					var entry_id = "";
				}
        if(row.cells[0].childNodes[0].checked){

          if(sp==""){
              error_msg_alert('Special attraction is mandatory in row'+(i+1));
              return false;
          }
          if(dwp==""){
              error_msg_alert('Daywise program is mandatory in row'+(i+1));
              return false;
          }
          if(os==""){
              error_msg_alert('Overnight stay is mandatory in row'+(i+1));
              return false;
          }
          var flag1 = validate_spattration(row.cells[2].childNodes[0].id);
          var flag2 = validate_dayprogram(row.cells[3].childNodes[0].id);
          var flag3 = validate_onstay(row.cells[4].childNodes[0].id);         
          if(!flag1 || !flag2 || !flag3){
              return false;
          }
        }
        checked_arr.push(status);
        sp_arr.push(sp);
        dwp_arr.push(dwp);
        os_arr.push(os);
        entry_id_arr.push(entry_id);
      }

      $('#btn_update').button('loading');
      $.ajax({
      type:'post',
      url:base_url()+'controller/other_masters/itinerary/itinerary_update.php',
      data:{ dest_id : dest_id, sp_arr : sp_arr, dwp_arr : dwp_arr, os_arr : os_arr,checked_arr:checked_arr,entry_id_arr:entry_id_arr},
      success:function(result){

          $('#btn_update').button('reset');
          var msg = result.split('--');
          if(msg[0]!="error"){
            $('#itinerary_update_modal').modal('hide');
            msg_alert(result);
            list_reflect();
          }
          else{
            error_msg_alert(msg[1]);
            $('#btn_update').button('reset');
          }
      }
      });
    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>