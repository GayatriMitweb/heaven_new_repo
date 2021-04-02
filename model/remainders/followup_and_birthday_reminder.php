<?php 

 include_once('../model.php');



	$today = date('Y-m-d');

	$sq_reminder_count = mysql_num_rows(mysql_query("select * from followup_and_birthday_reminder where reminder_date='$today'"));	
	
	if($sq_reminder_count==0){
		begin_t();

		$sq_max = mysql_fetch_assoc(mysql_query("select max(reminder_id) as max from followup_and_birthday_reminder"));

		$reminder_id = $sq_max['max'] + 1;

		$sq_reminder = mysql_query("insert into followup_and_birthday_reminder (reminder_id, reminder_date) values ('$reminder_id', '$today')");

		if(!$sq_reminder){

			rollback_t();

		}

		else{

			commit_t();

			 mail_send();



		}



	}



  function mail_send()

  {

	$today = date('Y-m-d');

	$month = date('m');

	$day = date('d');



	$enquirty_count = mysql_num_rows(mysql_query("select * from enquiry_master"));

	$followup_count = 0;

	$content1 = '';

	$sq_enquiry = mysql_query("select * from enquiry_master where status!='Disabled'");

	while($row_enq = mysql_fetch_assoc($sq_enquiry)){

		$sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select * from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));

		if($sq_enquiry_entry['followup_status']=="Active" && date('Y-m-d', strtotime($sq_enquiry_entry['followup_date']))==$today){
			$followup_count++;
		}
	}

	if($followup_count>0){

		$content1 .= '
		<tr>
			<td>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr>
					<td style="text-align:left;border: 1px solid #888888;">Todays Followups</td>
					</tr>
					<tr>
						<td style="text-align:left;border: 1px solid #888888;">Sr. No</td>
						
						<td style="text-align:left;border: 1px solid #888888;">Customer Name</td>
						
						<td style="text-align:left;border: 1px solid #888888;">Tour Name</td>
			
						<td style="text-align:left;border: 1px solid #888888;">Mobile No</td>

						<td style="text-align:left;border: 1px solid #888888;">Date Time</td>

						<td style="text-align:left;border: 1px solid #888888;">Followup Type</td>
					</tr>';



					$count = 0;
					$sq_enquiry = mysql_query("select * from enquiry_master where status!='Disabled'");

					while($row_enq = mysql_fetch_assoc($sq_enquiry)){

						$sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select * from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));

						$enquiry_content = $row_enq['enquiry_content'];

						$enquiry_content_arr1 = json_decode($enquiry_content, true);
// print_r($enquiry_content_arr1[0]['name']);

						if($enquiry_content_arr1[$count]['name']=="tour_name")
							{
								$tour_name = $enquiry_content_arr1[$count]['value']; 
							}

						

						$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_enq[assigned_emp_id]'"));

						

						if($sq_enquiry_entry['followup_status']=="Active" && date('Y-m-d', strtotime($sq_enquiry_entry['followup_date']))==$today){

							$count++;

							$content1 .= '

								<tr>
									<td style="text-align:left;border: 1px solid #888888;">'.$count.'</td>
									
									<td style="text-align:left;border: 1px solid #888888;">'.$row_enq['name'].'</td>
									
									<td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td>								
								
									<td style="text-align:left;border: 1px solid #888888;">'.$row_enq['mobile_no'].'</td>									
									<td style="text-align:left;border: 1px solid #888888;">'.$sq_enquiry_entry['followup_date'].'</td>

									<td style="text-align:left;border: 1px solid #888888;">'.$sq_enquiry_entry['followup_type'].'</td>

								</tr>

							';					

						}



					}

		$content1 .= '

				</table>

			</td>

		</tr>

		';
	}



	$content2 = '';



	$sq_birthday_count = mysql_num_rows(mysql_query("select birth_date from customer_master where DAYOFMONTH(birth_date)='$day' and MONTH(birth_date)='$month' "));

	if($sq_birthday_count>0){



		$content2 .= '

		<tr>

			<td>

				<table style="background: #fff; color: #22262e; font-size: 13px;width:100%; margin-bottom:20px;">

					<tr>

						<th colspan="4"  style="'.$td_style.'">Todays Birthdays</th>

					</tr>

					<tr>

						<th style=" padding-left: 10px;border: 1px solid #c1c1c1;text-align: left;font-weight: 500;background: #ddd;font-size: 14px;color: #22262E">Sr. No</th>

						<th style=" padding-left: 10px;border: 1px solid #c1c1c1;text-align: left;font-weight: 500;background: #ddd;font-size: 14px;color: #22262E">Customer</th>

						<th style=" padding-left: 10px;border: 1px solid #c1c1c1;text-align: left;font-weight: 500;background: #ddd;font-size: 14px;color: #22262E">Birth Date</th>

						<th style=" padding-left: 10px;border: 1px solid #c1c1c1;text-align: left;font-weight: 500;background: #ddd;font-size: 14px;color: #22262E">Mobile No</th>

					</tr>

		';



		$count = 0;

		$sq_customer = mysql_query("select * from customer_master where DAYOFMONTH(birth_date)='$day' and MONTH(birth_date)='$month' ");

		while($row_customer = mysql_fetch_assoc($sq_customer)){

			$count++;

			$content2 .='

				<tr>

					<td style="color: #777;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.$count.'</td>

					<td style="color: #777;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.$row_customer['first_name'].' '.$row_customer['last_name'].'</td>

					<td style="color: #777;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.get_date_user($row_customer['birth_date']).'</td>

					<td style="color: #777;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.$row_customer['contact_no'].'</td>

				</tr>

			';



		}



		$content2 .= '

					</table>

				</td>

			</tr>

		';



	}





	$content = '
	<tr>
		<td>
			<table style="padding:0 30px; width:100%">
				'.$content1.$content2.'
			</table>
		</td>
	</tr>

	';





	if($followup_count>0 || $sq_birthday_count>0){

	$subject = 'Todays_ followup';

		global $model, $app_email_id;
		$model->app_email_send('69',"Team",$app_email_id, $content,$subject,'1');
	}

	



}

 

?>