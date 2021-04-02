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
        <select id="cmb_traveler_id" name="cmb_traveler_id" title="Passenger Name" style="width:100%;" onchange="traveler_id_proof_info_reflect()" title="Passenger">
            <option value="">Passenger Name</option>
            <?php 
                  $query = "select * from ticket_master_entries where 1";
                  if($branch_status=='yes' && $role!='Admin'){
                      $query .= " and ticket_id in (select ticket_id from ticket_master where branch_admin_id = '$branch_admin_id')";
                  }
                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                    $query .= " and ticket_id in (select ticket_id from ticket_master where emp_id ='$emp_id')";
                  }
                  // if($branch_status=='yes'){
                  //   if($role=='Branch Admin'){
                  //   $query .= " and ticket_id in (select ticket_id from ticket_master where branch_admin_id = '$branch_admin_id')";
                  //   } 
                  //   elseif($role!='Admin' && $role!='Branch Admin'){
                  //     $query .= " and ticket_id in (select ticket_id from ticket_master where emp_id ='$emp_id')";
                  //     }
                  //   }
                    $query .= " and status != 'Cancel'";
                    $query .= " order by ticket_id desc";  

                    $sq_travelers_details = mysql_query($query);   
                   while($row_travelers_details = mysql_fetch_assoc( $sq_travelers_details ))
                   {
                    $sql_booking = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id = '$row_travelers_details[ticket_id]'"));
                    $booking_date = $sql_booking['created_at'];
                    $yr = explode("-", $booking_date);
                    $year =$yr[0];
                    
                    ?>
                    <option value="<?php echo $row_travelers_details['entry_id'] ?>"><?php echo get_ticket_booking_id($row_travelers_details['ticket_id'],$year).' : '.$row_travelers_details['first_name'].' '.$row_travelers_details['last_name']; ?></option>
                    <?php
                   }  
            ?>
          </select>  
    </div>
</div>
</div>
<div id="div_traveler_id_proof_info1" class="main_block mg_tp_20"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#cmb_traveler_id').select2();
function traveler_id_proof_info_reflect()
{
    var traveler_id = $('#cmb_traveler_id').val();
    if(traveler_id == ''){
      error_msg_alert("Select Passenger first!");
      $('#div_traveler_id_proof_info1').addClass('hidden'); 
      return false;
    }else{
      $('#div_traveler_id_proof_info1').removeClass('hidden'); }

    $.post('air_ticket/traveler_id_proof_info_reflect.php', { entry_id : traveler_id }, function(data){
        $('#div_traveler_id_proof_info1').html(data);
    });
}

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>