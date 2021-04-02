<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];

$query = mysql_fetch_assoc(mysql_query("select max(id) as booking_id from tourwise_traveler_details where financial_year_id='$financial_year_id' and branch_admin_id='$branch_admin_id'"));

$sq_traveler = "select * from traveler_personal_info where 1 ";

$query_package = "select * from package_tour_booking_master where financial_year_id='$financial_year_id'";

if($booking_id != ''){
  $sq_entry = mysql_query("select * from tourwise_traveler_details where id='$booking_id'");
}
else{
   $sq_entry = mysql_query("select * from tourwise_traveler_details where id='$query[booking_id]'");
}
$row_entry = mysql_fetch_assoc($sq_entry);
 $sq_tour_name = mysql_fetch_assoc(mysql_query("select  * from tour_master where tour_id = '$row_entry[tour_id]'"));
 $sq_traveler_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$query[booking_id]'"));
?>
<div class="col-md-7 col-sm-8 col-md-pull-3">
  <span class="tour_concern" style="margin-right: 30px;"><label>TOUR NAME  </label><em>:</em><?php echo $sq_tour_name['tour_name']; ?></span>
  <span class="tour_concern"><label>Mobile No </label><em>:</em><?php echo $sq_traveler_personal_info['mobile_no']; ?></span>
</div><div class="col-md-12 mg_tp_10">
      <div class="dashboard_table_body main_block">
        <div class="col-sm-9 no-pad table_verflow table_verflow_two"> 
          <div class="table-responsive no-marg-sm">
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
              $traveler_group_id = $row_entry['traveler_group_id'];
              $sq_entry = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'");
             while($row_entry1 = mysql_fetch_assoc($sq_entry)){
           			if($row_entry1['status']=="Cancel" || $row_entry['tour_group_status']=="Cancel"){
           				$bg="danger";    			}
           			else {
           				$bg="#fff";      			}

                //payment details
                $actual_tour_expense = $row_entry['total_tour_fee'] + $row_entry['total_travel_expense'];
                 if($actual_tour_expense==""){  $actual_tour_expense = 0 ;  }
                 
                 $sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$row_entry[id]'"));
                 $cancel_tour_amount=$sq_tour_refund['total_refund'] - $cancel_amount;
                 $cancel_tour_amount = number_format($cancel_tour_amount, 2);
                 if($cancel_tour_amount==""){ $cancel_tour_amount = 0; }
                 
                 $total_group_tour_amount=$actual_tour_expense - $cancel_tour_amount;
                  
                 
                 $query1 = "SELECT * from payment_master where tourwise_traveler_id='$row_entry[id]'";
                  
                 $sq_tour_paid_amount=0;
                 $tour_pending_cancel = 0;
                    
                $sq_group_tour_payment = mysql_query($query1);  
                while($row_group_tour_payment = mysql_fetch_assoc($sq_group_tour_payment)){

                  if($row_group_tour_payment['clearance_status']=="Pending" || $row_group_tour_payment['clearance_status']=="Cancelled"){ 
                    $tour_pending_cancel = $tour_pending_cancel + $row_group_tour_payment['amount'];
                  }
                    
                  $sq_tour_paid_amount = $sq_tour_paid_amount + $row_group_tour_payment['amount'];
                }
   
           		 $paid_amt = $sq_tour_paid_amount - $tour_pending_cancel;	
               $balance_amt = $total_group_tour_amount - $paid_amt;
               $count++;
               $age = $row_entry1['age'];
               $exp = explode(":" , $age); //explode marks data

                $mark1 = $exp[0];  
              ?>
                <tr class="<?= $bg ?>">
                    <td><?php echo $count ?></td>
                    <td><?php echo $row_entry1['m_honorific'].' '.$row_entry1['first_name']." ".$row_entry1['last_name']; ?></td>
                    <td><?php echo get_date_user($row_entry1['birth_date']); ?></td>
                    <td><?php echo $mark1; ?></td>
                    <td>
                      <button class="btn btn-info btn-sm" title="ID Proof"><i class="fa fa-id-card-o" onclick="display_group_id_proof('<?php echo $row_entry1[id_proof_url]; ?>')"></i></button>
                    </td>
                </tr>
                  <?php } ?>
              </tbody>
            </table>

          </div> 
        </div>
        <div class="col-sm-3 no-pad">
          <div class="table_side_widget_panel main_block">
            <div class="table_side_widget_content main_block">
              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount"><?php echo number_format($total_group_tour_amount,2); ?></div>
                  <div class="table_side_widget_text widget_blue_text">Total Amount</div>
                </div>
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount"><?php echo number_format($paid_amt,2); ?></div>
                  <div class="table_side_widget_text widget_green_text">Total Paid</div>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount"><?php echo number_format($balance_amt,2); ?></div>
                  <div class="table_side_widget_text widget_red_text">Total Balance</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="id_proof"></div>
</div>

<script type="text/javascript">
  function display_group_id_proof(id_proof_url)
  {
      $.post('admin/id_proof/group_booking_id.php', { id_proof_url : id_proof_url }, function(data){
      $('#id_proof').html(data);
     });
  }
</script>