<?php 
 include_once('../model.php');
	$today = date('Y-m-d');

	$date = strtotime("+1 day", strtotime($today));
	$tommorow = date("Y-m-d", $date);

	$group_tour_arr = array();
	$group_tour_pending_arr = array();
	
	$package_tour_arr = array();
	$package_tour_pending_arr = array();

	$group_tour_contnet = '';
	$package_tour_contnet = '';

	$sq_tour_groups = mysql_query("select * from tour_groups where from_date>'$today'");
	while($row_tour_groups = mysql_fetch_assoc($sq_tour_groups)){

		if($tommorow==$row_tour_groups['from_date']){

			$sq_tour = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$row_tour_groups[tour_id]'"));
			$tour_name = $sq_tour['tour_name'].'('.date('d-m-Y', strtotime($row_tour_groups['from_date'])).' to '.date('d-m-Y', strtotime($row_tour_groups['to_date'])).')';

			array_push($group_tour_arr, $tour_name);

			$entity_list = "";

			$sq_entities = mysql_query("select * from checklist_entities where entity_for!='Package Tour'");
			while($row_entity = mysql_fetch_assoc($sq_entities)){

				$sq_checklist_count = mysql_num_rows(mysql_query("select * from to_do_entries where tour_group_id='$row_tour_groups[group_id]' and entity_id='$row_entity[entity_id]'"));

				if($sq_checklist_count==0){
					$entity_list .= $row_entity['entity_name'].", ";		
				}
			}

			$entity_list = trim($entity_list, ', ');
			array_push($group_tour_pending_arr, $entity_list);
		}
	}


	$sq_booking = mysql_query("select * from package_tour_booking_master where tour_from_date>'$today'");
	while($row_booking = mysql_fetch_assoc($sq_booking)){

		if($tommorow==$row_booking['tour_from_date']){

			$tour_name = $row_booking['tour_name'].'('.date('d-m-Y', strtotime($row_booking['tour_from_date'])).' to '.date('d-m-Y', strtotime($row_booking['tour_to_date'])).')';
			array_push($package_tour_arr, $tour_name);
			$entity_list = "";

			$sq_entities = mysql_query("select * from checklist_entities where entity_for!='Group Tour'");
			while($row_entity = mysql_fetch_assoc($sq_entities)){

				$sq_checklist_count = mysql_num_rows(mysql_query("select * from to_do_entries where booking_id='$row_booking[booking_id]' and entity_id='$row_entity[entity_id]'"));

				if($sq_checklist_count==0){
					$entity_list .= $row_entity['entity_name'].", ";		
				}

			}

			$entity_list = trim($entity_list, ', ');
			array_push($package_tour_pending_arr, $entity_list);

		}

	}

	if(sizeof($group_tour_pending_arr) >0){
		$group_tour_contnet = '<p style="line-height: 24px;">
								<span style="color:#3434f5; font-weight : 600;">Group Tour:</span>
							</p>';
	}

	for($i=0; $i<sizeof($group_tour_pending_arr); $i++){
		if($group_tour_pending_arr[$i]!=""){
			$group_tour_contnet .='<p style="line-height: 24px;">
										&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3434f5; font-weight : 600;">'.$group_tour_arr[$i].'<br></span>
										&nbsp;&nbsp;&nbsp;&nbsp;Pending Points:&nbsp;&nbsp;'.$group_tour_pending_arr[$i].' <br>
									</p>';
		}
	}

	if(sizeof($package_tour_pending_arr) >0){
		$package_tour_contnet = '<p style="line-height: 24px;">
								<span style="color:#3434f5; font-weight : 600;">Package Tour:</span>
							</p>';
	}

	for($i=0; $i<sizeof($package_tour_pending_arr); $i++){
		if($package_tour_pending_arr[$i]!=""){
			$package_tour_contnet .='<p style="line-height: 24px;">
										&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3434f5; font-weight : 600;">'.$package_tour_arr[$i].'<br></span>
										&nbsp;&nbsp;&nbsp;&nbsp;Pending Points:&nbsp;&nbsp;'.$package_tour_pending_arr[$i].' <br>
									</p>';
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

	global $model, $app_email_id;
	$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'checklist_remainder' and date='$today' and status='Done'"));
 
	if($sq_count==0){
		if($group_tour_contnet != '' || $package_tour_contnet != ''){
			$model->app_email_send('68',"Admin",$app_email_id, $content);	
			$row=mysql_query("SELECT max(id) as max from remainder_status");
			$value=mysql_fetch_assoc($row);
			$max=$value['max']+1;
			$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','checklist_remainder','$today','Done')");
		}
	}

 
?>