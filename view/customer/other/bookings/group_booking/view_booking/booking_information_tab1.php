<!--*********Section-1 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Tour Information</div>
	<div class="row">
		<div class="col-md-4">
			<label>Tour Name :</label> <?php echo $tour_name ?>	
		</div>
		<div class="col-md-4">
			<label>Tour Group :</label> <?php echo $tour_group ?>	
		</div>
	</div>
</div>


<!--*********Section-2 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Member Information</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10">
            <thead>
                <tr class="active">
                    <td>Sr. No.</td>
                    <td>Name of The passengers</td>
                    <td>Gender</td>
                    <td>Birth Date</td>
                    <td>Age</td>
                    <td>Adolescence</td>
                    <td>Passport No</td>
                    <td>Passport Issue Date</td>
                    <td>Passport Expiry Date</td>
                </tr>
            </thead>    
            <tbody>
            <?php 
            $count=0;
            $bg;
            $sq_traveler_info = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'");
            while($row_traveler_info = mysql_fetch_assoc($sq_traveler_info))
            {
                $count++;

                if($row_traveler_info['passport_no']==""){
                    $passport_no='N/A';
                    $passport_date='N/A';
                    $expiry_date='N/A';
                }else
                {
                   $passport_no= $row_traveler_info['passport_no'];
                   $passport_date = date('d-m-Y', strtotime($row_traveler_info['passport_issue_date']));
                   $expiry_date = date('d-m-Y', strtotime($row_traveler_info['passport_expiry_date']));
                }

                if($row_traveler_info['birth_date']==""){ $m_birth_date = ""; }
			    else { $m_birth_date = date("d-m-Y", strtotime($row_traveler_info['birth_date'])); }   

             ($row_traveler_info['status']=='Cancel')?$bg='-webkit-text-fill-color: hsl(4, 100%, 51%);':$bg='';

                ?>
                <tr style="<?= $bg;?>">
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row_traveler_info['m_honorific']." ".$row_traveler_info['first_name']." ".$row_traveler_info['middle_name']." ".$row_traveler_info['last_name'] ?></td>
                    <td><?php echo $row_traveler_info['gender']; ?></td>
                    <td><?php echo $m_birth_date; ?></td>
                    <td><?php echo $row_traveler_info['age']; ?></td>
                    <td><?php echo $row_traveler_info['adolescence']; ?></td>
                    <td><?php echo $passport_no; ?></td>
                    <td><?= $passport_date;?></td>
                    <td><?= $expiry_date;?></td>
                </tr>    
                <?php 

            }
            ?>    
            </tbody>
        </table> 
	</div> </div> </div>
</div>


<?php 
$traveler_personal_details = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));

?>

<!--*********Section-3 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Personal Information</div>
	<div class="row">
		<div class="col-md-4"><label>Mobile No1:</label>&nbsp;&nbsp;<?php echo $traveler_personal_details['mobile_no'] ?></div>
		<div class="col-md-4"><label>Email Id:</label>&nbsp;&nbsp;<?php echo $traveler_personal_details['email_id'] ?></div>	
		<div class="col-md-4"><label>Address:</label>&nbsp;&nbsp;<?php echo $traveler_personal_details['address'] ?></div>		
	</div>
</div>



<!--*********Section-4 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Emergency Contact</div>
	<div class="row">
		<div class="col-md-4"><label>Relative Name:</label>&nbsp;&nbsp;<?php echo $sq_tourwise_det['relative_name']." ".$sq_tourwise_det['relative_last_name'] ?></div>
		<div class="col-md-4"><label>Realation:</label>&nbsp;&nbsp;<?php echo $sq_tourwise_det['relative_relation'] ?></div>	
		<div class="col-md-4"><label>Mobile No:</label>&nbsp;&nbsp;<?php echo $sq_tourwise_det['relative_mobile_no'] ?></div>
		
	</div>
</div>


<?php 

$hotel_stmt = ""; 
if($sq_tourwise_det['s_double_bed_room']!=0) {  $hotel_stmt = $hotel_stmt." ".$sq_tourwise_det['s_double_bed_room']."  Double Bed Rooms"; }
if($sq_tourwise_det['s_extra_bed']!=0) { $hotel_stmt = $hotel_stmt." And ".$sq_tourwise_det['s_extra_bed']." Extra Bed "; }
if($sq_tourwise_det['s_on_floor']!=0) { $hotel_stmt = $hotel_stmt."And ".$sq_tourwise_det['s_on_floor']." Extra Person With No Bed "; }
if($sq_tourwise_det['s_adjusted_with']!="") { $hotel_stmt = $hotel_stmt."And  Adjust with File No-".$sq_tourwise_det['s_adjusted_with']; }
if($sq_tourwise_det['s_seperate_room']!=0) { $hotel_stmt = $hotel_stmt."And  ".$sq_tourwise_det['s_seperate_room']." Seperate Room"; }

?>

<!--*********Section-5 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Hoteling Information</div>
	<div class="row">
		<div class="col-md-12"><?php echo $hotel_stmt ?></div>
	</div>
</div>


<!--*********Extra Section start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Special Requirement</div>
	<div class="row">
		<div class="col-md-12"><?php echo $sq_tourwise_det['special_request'] ?></div>
	</div>
</div>
