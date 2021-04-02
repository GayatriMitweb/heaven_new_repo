<?php  
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<div class="app_panel_content Filter-panel">
  <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
          <select id="cmb_traveler_id" name="cmb_traveler_id" title="Passenger Name" style="width:100%;" onchange="traveler_id_proof_info_reflect()" class="form-control" title="Passenger">
              <option value="">Passenger Name</option>
              <?php 
                  $query = "select * from tourwise_traveler_details where 1 ";

                  include "../../../model/app_settings/branchwise_filteration.php";

                  $query .=" and tour_group_status != 'Cancel'";

                  $query .=" order by traveler_group_id desc";
                  $sq_tourwise_traveler_det = mysql_query($query);
                  while($row_tourwise_traveler_details = mysql_fetch_assoc( $sq_tourwise_traveler_det ))
                  {
                    $booking_date = $row_tourwise_traveler_details['form_date'];
                    $yr = explode("-", $booking_date);
                    $year =$yr[0];
                     $sq_travelers_details = mysql_query("select traveler_id, m_honorific, first_name, last_name from travelers_details where traveler_group_id='$row_tourwise_traveler_details[traveler_group_id]' and status='Active' "); 
                     while($row_travelers_details = mysql_fetch_assoc( $sq_travelers_details ))
                     {
                      ?>
                      <option value="<?php echo $row_travelers_details['traveler_id'] ?>"><?php echo get_group_booking_id($row_tourwise_traveler_details['id'],$year).' : '.$row_travelers_details['m_honorific'].' '.$row_travelers_details['first_name'].' '.$row_travelers_details['last_name']; ?></option>
                      <?php
                     } 
                   ?>
                   <?php      
                  }    
              ?>
          </select>
      </div>
  </div>
</div>

<div id="div_traveler_id_proof_info" class="main_block mg_tp_20"></div>


<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#cmb_traveler_id').select2();
function traveler_id_proof_info_reflect()
{
    var traveler_id = $('#cmb_traveler_id').val();
    if(traveler_id == ''){
      error_msg_alert("Select Passenger first!");
      $('#div_traveler_id_proof_info').addClass('hidden'); 
      return false;
    }else{
      $('#div_traveler_id_proof_info').removeClass('hidden'); }

    $.post('group_tour/traveler_id_proof_info_reflect.php', { traveler_id : traveler_id }, function(data){
        $('#div_traveler_id_proof_info').html(data);
    });
}

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>