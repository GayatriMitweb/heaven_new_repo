<?php 
include "../../../model/model.php";
$entity_id = $_POST['entity_id'];

$query = "select * from checklist_entities where entity_id = '$entity_id'";

$sq_checklist = mysql_fetch_assoc(mysql_query($query));
$sq_tour_group =mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id='$sq_checklist[tour_id]' and group_id='$sq_checklist[tour_group_id]'"));
$tour_group = ($sq_checklist['tour_group_id']=="") ? "NA" : get_date_user($sq_tour_group['from_date']).' To '.get_date_user($sq_tour_group['to_date']);
$booking_id1 = ($sq_checklist['booking_id'] == '') ? "NA" : get_package_booking_id($sq_checklist['booking_id']);
$sq_tour =mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_checklist[tour_id]'"));
$tour_name = ($sq_tour['tour_name']=="")? "NA" : $sq_tour['tour_name'];
?>
<div class="modal fade" id="entity_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Checklist</h4>
      </div>
      <div class="modal-body">
        
        <form id="frm_entity_update">
        <div class="row">
          <input type="hidden" name="entity_id" id="entity_id1" value="<?php echo $sq_checklist['entity_id'];?>">
              
          <div class="col-sm-4 mg_bt_30">
            <select name="entity_for" class="form-control" id="entity_for1" data-toggle="tooltip" title="Select Service" disabled="" >
              <option value="<?php echo $sq_checklist['entity_for'];?>"><?php echo $sq_checklist['entity_for'];?></option>
              <option value="">Select Service</option>
              <option value="Group Tour">Group Tour</option>
              <option value="Package Tour">Package Tour</option>
              <option value="Visa Booking">Visa Booking</option>
              <option value="Flight Booking">Flight Booking</option>
              <option value="Train Booking">Train Booking</option>
              <option value="Hotel Booking">Hotel Booking</option>
              <option value="Bus Booking">Bus Booking</option>
              <option value="Car Rental Booking">Car Rental Booking</option>
              <option value="Passport Booking">Passport Booking</option>
              <option value="Excursion Booking">Excursion Booking</option>
            </select>
          </div>
          <?php if($sq_checklist['destination_name']!=''){ 
                  $class = '';
                }else{
                  $class = 'hidden';
                }  
          ?>
           <div class="col-sm-4 mg_bt_30 <?= $class ?>">
            <?php if($sq_checklist['destination_name']!=''){  ?>
           
              <select id="dest_name_s"  name="dest_name_s" title="Select Destination" class="form-control"  style="width:100%" readonly> 
                  <?php
                    $sq_query1 = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id != '$sq_checklist[destination_name]'"));
                    ?>

                    <option value="<?= $sq_checklist['destination_name'] ?>"><?= $sq_query1['dest_name']; ?></option>
                      <option value="">*Destination</option>
                      <?php 
                      $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                      while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                          <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                  <?php } ?>
                </select>
            <?php } ?>
          </div>
          <div class="col-sm-4 mg_bt_30"></div>
          <?php if($sq_checklist['tour_id']!=""){?>
            <div class="col-sm-4 mg_bt_30">
            <input type="text" name="tour_id" id="tour_id" class="form-control" value="<?= $tour_name ?>" disabled >
          </div>
          <?php } ?>
          <?php if($sq_checklist['tour_group_id']!=""){?>
            <div class="col-sm-4 mg_bt_30">
            <input type="text" name="tour_group_id" id="tour_group_id" class="form-control" value="<?= $tour_group ?>" disabled >
          </div>
          <?php } ?>
          <?php if($sq_checklist['booking_id']!=""){?>
            <div class="col-sm-4 mg_bt_30">
            <input type="text" name="booking_id" id="booking_id" class="form-control" value="<?= $booking_id1  ?>" disabled >
          </div>
          <?php } ?>
         
        </div>
        
        <div class="row mg_bt_10">
        <div class="col-md-4 text-right"></div>
          <div class="col-md-4 text-center"><h4>Checklist Entries<h4></div>
          <div class="col-md-4 text-right">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_tour_name_update')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
          </div> </div>

          <div class="row"> <div class="col-md-12"> 
            <table id="tbl_dynamic_tour_name_update" name="tbl_dynamic_tour_name_update" class="table table-bordered table-hover no-marg"  cellspacing="0">
              <?php
              $count=0;
              $sql_query=mysql_query("select * from to_do_entries where entity_id = '$entity_id'");
              while($row_query=mysql_fetch_assoc($sql_query)){
                   $count++;
              ?>
              <tr>
                  <td class="col-md-1"><input id="chk_tour_group1<?= $count ?>" type="checkbox" class="form-control" checked ></td>
                  <td class="col-md-1"><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td class="col-md-10"><input type="text" placeholder="*Checklist Name" onchange="validate_specialChar(this.id)" id="entity_name<?= $count ?>"  name="entity_name" title="Checklist Name" class="form-control" value="<?php echo $row_query['entity_name'];?>" /></td>
                  <td><input type="hidden" id="entry_id<?= $count ?>"  name="entry_id" class="form-control" value="<?php echo $row_query['id'];?>" /></td>
              </tr> 
              <?php } ?>                               
            </table>  

          </div> </div>
          <div class="row text-center mg_tp_20">
          <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="update_button"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
          </div>
        </div>
        </form>

      </div>      
    </div>
  </div>
</div>

<script>
$('#entity_update_modal').modal('show');

 function feild_reflect(){
    var entity_for = $('#entity_for').val();
    var base_url = $('#base_url').val();
    $.post(base_url+'view/checklist/entities/tour_load.php', { entity_for : entity_for }, function(data){
   $('#div_reflect_tour').html(data);
     });
    }


$(function(){
  $('#frm_entity_update').validate({
    rules:{
      
    },
    submitHandler:function(form){
      var entity_id = $('#entity_id1').val();
      var base_url =$('#base_url').val();
      var checked_arr = new Array();
      var entity_name_arr = new Array();
      var entry_id_arr = new Array();

      var table = document.getElementById("tbl_dynamic_tour_name_update");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];
      
          var checked = row.cells[0].childNodes[0].checked;
          var entity_name = row.cells[2].childNodes[0].value;
          var entry_id = row.cells[3].childNodes[0].value;

          if(entity_name == ''){ error_msg_alert("Entity name required in row"+(i+1)); return false; }
          entity_name_arr.push(entity_name);
          entry_id_arr.push(entry_id);
          checked_arr.push(checked);
       
      }
      
      $('#update_button').button('loading');
      $.ajax({
        type:'post',
        url:base_url+'controller/checklist/entities/entity_update.php',
        data:{entity_name_arr : entity_name_arr,entity_id : entity_id,entry_id_arr : entry_id_arr,checked_arr:checked_arr},
        success:function(result){
          msg_alert(result);
          $('#update_button').button('reset');
          $('#entity_update_modal').modal('hide');
          entities_list_reflect();
        }
      });
    }
  });
});
</script><script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>