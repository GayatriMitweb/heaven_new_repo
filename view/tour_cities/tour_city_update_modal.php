<?php
include "../../model/model.php"; 
$tour_city_id = $_POST['city_id'];  
$tour_id = $_POST['tour_id'];  
$sq = mysql_fetch_assoc(mysql_query("select * from tour_city_names where id='$tour_city_id'"));
?>

<form id="frm_tour_city_update">
<input type="hidden" id="tour_city_id" name="tour_city_id" value="<?php echo $tour_city_id ?>">
<input type="hidden" id="txt_tour_id" name="txt_tour_id" value="<?php echo $tour_id ?>">

<div class="modal fade" id="tour_city_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Tour City</h4>
      </div>
      <div class="modal-body text-center">

        <div class="row mg_bt_10">
          <div class="col-md-12">
            <label for="txt_city_name">City Name</label> 
            <select id="txt_city_name" name="txt_city_name" class="form-control" required>
            <?php $sq_city_info = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq[city_id]'")); ?>
              <option value="<?php echo $sq_city_info['city_id'] ?>"><?php echo $sq_city_info['city_name'] ?></option>
              <?php 
              $sq1 = mysql_query("select * from city_master");
              while($row1 = mysql_fetch_assoc($sq1))
              {
                ?>
                <option value="<?php echo $row1['city_id'] ?>"><?php echo $row1['city_name'] ?></option>
                <?php  
              }    
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-success"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update Tour City</button>
          </div>
        </div>
        
      </div>      
    </div>
  </div>
</div>
</form>

<script>
  $('#tour_city_update_modal').modal('show');
  $(function(){
    $('#frm_tour_city_update').validate({
        submitHandler:function(form){
            var base_url = $('#base_url').val();  
            var tour_city_id = $("#tour_city_id").val();
            var city_name = $("#txt_city_name").val();
            var tour_id = $("#txt_tour_id").val();
            $.post( 
                         base_url+"controller/group_tour/tour_cities/tour_city_update_c.php",
                         { tour_city_id : tour_city_id, city_name : city_name, tour_id : tour_id },
                         function(data) {  
                                $('#tour_city_update_modal').modal('hide');
                                msg_alert(data);
                                $('#div_city_list').load('tour_cities_list_load.php', { tour_id : tour_id }).hide().fadeIn(500);
                         });
        }
    });
  });
</script>
