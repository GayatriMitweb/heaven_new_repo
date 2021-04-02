<?php  
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>

  <div class="row mg_bt_20">
    <div class="col-sm-12 text-right text_left_sm_xs">
    <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Status</button>
    </div>
  </div>
<div class="app_panel_content Filter-panel">
    <div class="row"> 
        <div class="col-sm-4 col-sm-offset-4">
          <select name="visa_id_filter1" id="visa_id_filter1" style="width:100%" title="Booking ID" onchange="load_visa_report(this.id,'visa_booking','visa_status_div')">
            <option value="">Booking ID</option>
            <?php 
            $query = "select * from visa_master where 1";
            if($branch_status=='yes' && $role!='Admin'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
            }
            elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
              $query .= " and emp_id='$emp_id'";
            }
            $query .= " order by visa_id desc";
            $sq_visa = mysql_query($query);
            while($row_visa = mysql_fetch_assoc($sq_visa)){
              $booking_date = $row_visa['created_at'];
              $yr = explode("-", $booking_date);
              $year =$yr[0];
              $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));
              ?>
              <option value="<?= $row_visa['visa_id'] ?>"><?= get_visa_booking_id($row_visa['visa_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
              <?php
            }
            ?>
          </select>
        </div>
    </div>
</div>

<div id="save_div"></div>
<div id="visa_status_div" class="main_block"></div>


<script>
$('#visa_id_filter1').select2();
function save_modal()
{
  var branch_status = $('#branch_status').val();
  $.post( '../../visa_status/visa/save_modal.php' , {branch_status : branch_status} , function ( data ) {
        $("#save_div").html(data);
   });
}
function load_passenger(booking_id)
{
	var booking_id = $('#'+booking_id).val();
	$.post( base_url()+"view/visa_status/inc/load_visa_passenger.php" , {booking_id : booking_id} , function ( data ) {
        $("#cmb_traveler_id2").html(data);
   });
}

function load_visa_status(traveler_id,offset)
{
   var booking_type = $('#booking_type').val();
   var traveler_id = $('#'+traveler_id).val();
   $.post( base_url()+"view/visa_status/visa_tracking_report.php" , {booking_type : booking_type, traveler_id : traveler_id } , function ( data ) {
        $ ("#doc_status"+offset).html(data) ;
   });
}
function load_visa_report(booking_id,booking_type,result_div)
{
    var booking_id = $('#'+booking_id).val();

    $.post( base_url()+"view/visa_status/inc/get_visa_status_report.php" , {booking_id : booking_id, booking_type : booking_type } , function ( data ) {
        $ ("#"+result_div).html(data) ;
    });
}
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>