<?php
include "../../model/model.php";
$dest_id = $_POST['dest_id'];
$spa = $_POST['spa'];
$dwp = $_POST['dwp'];
$ovs = $_POST['ovs'];
$dayp = $_POST['dayp'];
$sq_itinerary_c = mysql_num_rows(mysql_query("select * from itinerary_master where dest_id='$dest_id'"));
?>
        
<form id="itinerary_detail_frm">

<div class="modal fade" id="itinerary_detail_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Add Itinerary for <?= $dayp ?></h4>

      </div>

      <div class="modal-body">
      <input type="hidden" id="spa" value='<?=$spa ?>'/>
      <input type="hidden" id="dwp" value='<?=$dwp ?>'/>
      <input type="hidden" id="ovs" value='<?=$ovs ?>'/>
        <div class="row">
          <div class="text-left col-md-3 col-sm-6">
            <select id="dest_ids1"  name="dest_names1" title="Select Destination" class="form-control" style="width:100%" onchange="get_dest_itinerary(this.id)" required> 
              <?php
              if($dest_id !='' && $dest_id !='0'){
              $row_dest = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id = '$dest_id'"));
              ?>
              <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
              <?php } ?>
              <option value="">*Destination</option>
              <?php 
              $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
              while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                  <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                  <?php } ?>
            </select>
          </div>
        </div>
          <h5></h5>
        <div class="row" id="itinerary_data">
        <?php
        if($sq_itinerary_c >0){
        ?>
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
                    <td width="27px;" style="padding-right: 10px !important;"><input class="css-checkbox labelauty" id="chk_programd<?=$count?>" type="checkbox" style="display: none;"><label for="chk_programd1<?=$count?>"><span class="labelauty-unchecked-image"></span><span class="labelauty-checked-image"></span></label></td>
                    <td width="20px;"><input maxlength="15" value="<?=$count?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled=""></td>
                    <td class="col-md-3 no-pad" style="padding-left: 5px !important;"><input type="text" id="special_attaraction" onchange="validate_spaces(this.id);validate_spattration(this.id);" name="special_attaraction" class="form-control" placeholder="*Special Attraction" title="Special Attraction" value="<?=$row_itinerary['special_attraction']?>"></td>
                    <td class="col-md-5 no-pad" style="padding-left: 5px !important;"><textarea id="day_program" name="day_program" class="form-control" title="" rows="3" placeholder="*Day-wise Program" onchange="validate_spaces(this.id);validate_dayprogram(this.id);" title="Day-wise Program"><?=$row_itinerary['daywise_program']?></textarea></td>
                    <td class="col-md-2 no-pad" style="padding-left: 5px !important;"><input type="text" id="overnight_stay" name="overnight_stay" onchange="validate_spaces(this.id);validate_onstay(this.id);" class="form-control" placeholder="*Overnight Stay" title="Overnight Stay" value="<?=$row_itinerary['overnight_stay']?>"></td>
                    <td class="hidden"><input type="text" id="entry_id" name="entry_id" class="form-control" value="<?=$row_itinerary['entry_id']?>"></td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
            </div>
        <?php }
        else{
          if($dest_id != '' || $dest_id != 0){ ?>
            <div class="col-md-12 col-sm-6 col-xs-12 mg_tp_10">
            <?php echo '<h4 class="no-pad">Itinerary not added for this destination! <a href="'.BASE_URL.'view/other_masters/index.php" target="_blank" title="Add Itinerary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Itinerary</a></h4> '; ?>
            </div>
        <?php }?>
          <div class="col-md-12 col-sm-6 col-xs-12 mg_tp_10"></div>
        <?php }?>
        </div>
          <div class="row mg_tp_10">
            <div class="col-xs-12 text-center">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            </div>
          </div>



      </div>      

    </div>

  </div>

</div>

</form>

<script>
$('#itinerary_detail_modal').modal('show');
$('#dest_ids1').select2();
$('#itinerary_detail_frm').validate({
    rules:{
      dest_names1 : {required:true}
    },
    submitHandler:function(form){
      
        var sq_itinerary_c = $('#sq_itinerary_c1').val();
        if(sq_itinerary_c != 0){
          var dest_id = $('#dest_ids1').val();
          var spa = $('#spa').val();
          var dwp = $('#dwp').val();
          var ovs = $('#ovs').val();

          if(dest_id == '' || dest_id == 0){
            error_msg_alert("Please select destination!");
            return false;
          }
          var table = document.getElementById("default_program_list");
          var rowCount = table.rows.length;
          var count = 0;
          for(var i=0; i<rowCount; i++){
              var row = table.rows[i];
              if(row.cells[0].childNodes[0].checked){
                  count++;
              }
          }
          if(parseInt(count) != 1){
              error_msg_alert("Please select one day program!");
              return false;
          }
          for(var i=0; i<rowCount; i++){
              var row = table.rows[i];
              if(row.cells[0].childNodes[0].checked){

                  var sp = row.cells[2].childNodes[0].value;
                  var dwp1 = row.cells[3].childNodes[0].value;
                  var os1 = row.cells[4].childNodes[0].value;
                  $('#'+spa).val(sp);
                  $('#'+dwp).val(dwp1);
                  $('#'+ovs).val(os1);
              }
          }
          $('#itinerary_detail_modal').modal('hide');
        }
        else{
          error_msg_alert("You need to add itinerary for this destination first!");
          return false;
        }
        
    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>