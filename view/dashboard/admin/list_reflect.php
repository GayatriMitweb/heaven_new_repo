<?php
include "../../../model/model.php";
$query = mysql_fetch_assoc(mysql_query("select max(booking_id) as booking_id from package_tour_booking_master"));

$booking_id = $_POST['booking_id'];
if($booking_id != ''){
	$sq_package = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
}
else{
	$sq_package = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$query[booking_id]'"));
}
?>

<div class="col-md-12">
      <div class="dashboard_table_body main_block">
        <div class="col-md-9 no-pad table_verflow"> 
          <div class="table-responsive">
            <table class="table table-hover" style="margin: 0 !important;border: 0;padding: 0 !important;">
              <thead>
                <tr class="table-heading-row">
                  <th>S_No.</th>
                  <th>Passenger_Name</th>
                  <th>BIRTH_DATE</th>
                  <th>AGE</th>
                  <th>ID_Proof</th>
                </tr>
              </thead>
              <tbody>
              <?php 
             while($row_entry = mysql_fetch_assoc($sq_entry)){
           			if($row_entry['status']=="Cancel")
           			{
           				$bg="danger";
           			}
           			else
           			{
           				$bg="#fff";
           			}
           			$count++;
              ?>
                <tr class="<?= $bg ?>">
                    <td><?php echo $count ?></td>
                    <td><?php echo $row_entry['m_honorific'].''.$row_entry['first_name']." ".$row_entry['last_name']; ?></td>
                    <td><?php echo get_date_user($row_entry['birth_date']); ?></td>
                    <td><?php echo $row_entry['age']; ?></td>
                    <td>
                      <button class="btn btn-info btn-sm" title="ID Proof" data-target="#ModalIDProof" data-toggle="modal"><i class="fa fa-id-card-o"></i></button>
                    </td>
                </tr>
                  <?php } ?>
              </tbody>
            </table>

          </div> 
        </div>
        <div class="col-md-3 no-pad">
          <div class="table_side_widget_panel main_block">
            <div class="table_side_widget_content main_block">
              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount">2350</div>
                  <div class="table_side_widget_text widget_blue_text">Total Amount</div>
                </div>
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount">2350</div>
                  <div class="table_side_widget_text widget_green_text">Total Paid</div>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount">2350</div>
                  <div class="table_side_widget_text widget_red_text">Total Balance</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
