<?php
include_once('../model.php');
$start_date = date('Y-m-d');
$end_date = date('Y-m-d', strtotime('+5 days', strtotime($start_date)));


$group_tour_arr = array();
$group_tour_pending_arr = array();

$package_tour_arr = array();
$package_tour_pending_arr = array();
$package_tour_booking_arr = array();

$group_tour_contnet = '';
$package_tour_contnet = '';

//Group Booking Checklist
$sq_tour_count = mysql_num_rows(mysql_query("SELECT * from tour_groups where from_date between '$start_date' and '$end_date' and status!='Cancel'"));
if($sq_tour_count > 0){
$group_tour_contnet = '<p style="line-height: 24px;">
							<span style="color:#3434f5; font-weight : 600;">Group Tour:</span>
						</p>';
}
$sq_tour_groups = mysql_query("SELECT * from tour_groups where from_date between '$start_date' and '$end_date' and status!='Cancel'");
while($row_booking = mysql_fetch_assoc($sq_tour_groups)){

		$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$row_booking[tour_id]'"));
		$tour_name = $sq_tour['tour_name'].'('.date('d-m-Y', strtotime($row_booking['from_date'])).' to '.date('d-m-Y', strtotime($row_booking['to_date'])).')';

		// $group_tour_contnet .='<p style="line-height: 24px;">
		// 								&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3434f5; font-weight : 600;">'.$tour_name.'<br></span></p>';
		$group_tour_contnet .='<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>';
		
				$sq_check_count = mysql_num_rows(mysql_query("select * from checklist_entities where entity_for='Group Tour' and (tour_group_id='$row_booking[group_id]' and tour_id='$row_booking[tour_id]')"));
				if($sq_check_count!=0)
				{
					$sq_group_entity = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Group Tour' and (tour_group_id='$row_booking[group_id]' and tour_id='$row_booking[tour_id]')"));

					$sq_checklist_count = mysql_num_rows(mysql_query("select * from checklist_group_tour where (tour_group_id='$sq_group_entity[tour_group_id]' and tour_id='$sq_group_entity[tour_id]')"));
					if($sq_checklist_count!=0)
					{
						$group_tour_contnet .='<p style="line-height: 18px;">
									&nbsp;&nbsp;&nbsp;&nbsp;Pending Points:&nbsp;&nbsp; <br></p>';
						$sq_entities = mysql_query("select * from checklist_group_tour where (tour_group_id='$sq_group_entity[tour_group_id]' and tour_id='$sq_group_entity[tour_id]')");
						
								$count = 1;
						$group_tour_contnet_c ='';
						while($row_entity = mysql_fetch_assoc($sq_entities))
						{
							$sq_checklist_1 = mysql_fetch_assoc(mysql_query("select * from to_do_entries where id='$row_entity[entity_id]'"));
							$group_tour_contnet_c .='<p style="line-height: 12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$count++.'.'.''.$sq_checklist_1['entity_name'].'<br> </p>';					
						}
						$group_tour_contnet .= $group_tour_contnet_c;
					}
				}
}


//Package Booking Checklist
$sq_booking_count = mysql_num_rows(mysql_query("SELECT * from package_tour_booking_master where tour_from_date between '$start_date' and '$end_date'"));
if($sq_booking_count > 0){
$package_tour_contnet = '<p style="line-height: 24px;">
							<span style="color:#3434f5; font-weight : 600;">Package Tour:</span>
						</p>';
}
$sq_booking = mysql_query("SELECT * from package_tour_booking_master where tour_from_date between '$start_date' and '$end_date'");
while($row_booking = mysql_fetch_assoc($sq_booking)){

		$tour_name = $row_booking['tour_name'].'('.date('d-m-Y', strtotime($row_booking['tour_from_date'])).' to '.date('d-m-Y', strtotime($row_booking['tour_to_date'])).')';
		// $package_tour_contnet .='<p style="line-height: 24px;">
		// 								&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3434f5; font-weight : 600;">'.$tour_name.'<br></span>
		// 								&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3434f5; font-weight : 600;">Booking ID :&nbsp;&nbsp;'.get_package_booking_id($row_booking['booking_id']).'<br></span></p>';
		$package_tour_contnet .='<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
		<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>
		<tr><td style="text-align:left;border: 1px solid #888888;"> Booking ID </td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_package_booking_id($row_booking['booking_id']).'</td></tr>
				
			</table>
			</tr>';
				$sq_check_count = mysql_num_rows(mysql_query("select * from checklist_entities where entity_for='Package Tour' and booking_id='$row_booking[booking_id]'"));
				if($sq_check_count!=0)
				{
					$sq_package_entity = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Package Tour' and booking_id='$row_booking[booking_id]'"));

					$sq_checklist_count = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$sq_package_entity[booking_id]'"));

					if($sq_checklist_count!=0)
					{
						$sq_entities = mysql_query("select * from checklist_package_tour where booking_id='$sq_package_entity[booking_id]'");
						$package_tour_contnet .='<p style="line-height: 18px;">
									&nbsp;&nbsp;&nbsp;&nbsp;Pending Points:&nbsp;&nbsp; <br></p>';
								$count = 1;
						$package_tour_contnet_c ='';
						while($row_entity = mysql_fetch_assoc($sq_entities))
						{
							$sq_checklist_1 = mysql_fetch_assoc(mysql_query("select * from to_do_entries where id='$row_entity[entity_id]'"));
							$package_tour_contnet_c .='<p style="line-height: 12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$count++.'.'.''.$sq_checklist_1['entity_name'].' <br></p>';					
						}
						$package_tour_contnet .= $package_tour_contnet_c;
					}
				}
}

if(sizeof($group_tour_pending_arr) > 0){
	$group_tour_contnet = '<p style="line-height: 24px;">
								<span style="color:#3434f5; font-weight : 600;">Group Tour:</span>
							</p>';

	for($i=0; $i<sizeof($group_tour_pending_arr); $i++){
		if($group_tour_pending_arr[$i]!=""){
			$group_tour_contnet .='<p style="line-height: 24px;">
										&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3434f5; font-weight : 600;">'.$group_tour_arr[$i].'<br></span>											
										&nbsp;&nbsp;&nbsp;&nbsp;Pending Points:&nbsp;&nbsp;'.$group_tour_pending_arr[$i].' <br>
									</p>';
		}
	}
}

$content = '
<tr>
	<td>
		<table style="width:100;">
			<tr>
				<td>
					'.$group_tour_contnet.' '.$package_tour_contnet.'
				</td>
			</tr>
		</table>
	</td>
</tr>
'; 

global $model, $app_email_id,$secret_key,$encrypt_decrypt;
$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'checklist_remainder' and date='$start_date' and status='Done'"));

if($sq_count==0)
{
	if($group_tour_contnet != '' || $package_tour_contnet != ''){
		$subject = 'Checklist remainder ( Tour Name : '.$tour_name.' ,Tour dates : '.date('d-m-Y', strtotime($row_booking['tour_from_date'])).' to '.date('d-m-Y', strtotime($row_booking['tour_to_date'])).' )';
		$model->app_email_send('68',"Admin",$app_email_id, $content,$subject);	
		$row=mysql_query("SELECT max(id) as max from remainder_status");
		$value=mysql_fetch_assoc($row);
		$max=$value['max']+1;
		$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','checklist_remainder','$start_date','Done')");
	}
}

 
?>