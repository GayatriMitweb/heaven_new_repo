<?php
include_once('../model.php');
global $model ;

$sq_settings = mysql_fetch_assoc(mysql_query("select * from app_settings"));
$tax_type= $sq_settings['tax_type'];
$tax_pay_date = $sq_settings['tax_pay_date'];
$tax_pay_day = date_parse_from_format('Y-m-d', $tax_pay_date)['day'];
 
$today=date('Y-m-d');
$tax_date = date('Y-m-d', strtotime('+7 days', strtotime($today)));

$tax_day = date_parse_from_format('Y-m-d', $tax_date)['day'];
$quart_date = date('Y-m-d', strtotime("+3 months", strtotime($tax_pay_date)));
$quart_date1 = date('Y-m-d',strtotime("+6 months", strtotime($tax_pay_date)));
$quart_date2 =  date('Y-m-d',strtotime("+9 months", strtotime($tax_pay_date)));
$year_date  = date("d-m", strtotime($tax_pay_date));
$tax_year_date  = date("d-m", strtotime($tax_date));

	if($tax_type=='Monthly' && $tax_pay_day==$tax_day){
	 $sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'tax_pay_raminder' and date='$today' and status='Done'"));
		if($sq_count==0){
			email($tax_pay_date,$tax_type);
		}	
		$row=mysql_query("SELECT max(id) as max from remainder_status");
	 	$value=mysql_fetch_assoc($row);
	 	$max=$value['max']+1;
		$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','tax_pay_raminder','$today','Done')");
	}
	 
	if($tax_type=='Quarterly' && ($tax_date==$tax_pay_date ||  $tax_date==$quart_date || $tax_date==$quart_date1 || $tax_date==$quart_date2)){
	 
	 $sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'tax_pay_raminder' and date='$today' and status='Done'"));
		if($sq_count==0){
			email($tax_date,$tax_type);
		}
		$row=mysql_query("SELECT max(id) as max from remainder_status");
	 	$value=mysql_fetch_assoc($row);
	 	$max=$value['max']+1;
		$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','tax_pay_raminder','$today','Done')");
	}
 
    if($tax_type=='Yearly' && $year_date==$tax_year_date){
	 
	 $sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'tax_pay_raminder' and date='$today' and status='Done'"));
	 
		if($sq_count==0){
				email($tax_date,$tax_type);
		}	
		$row=mysql_query("SELECT max(id) as max from remainder_status");
	 	$value=mysql_fetch_assoc($row);
	 	$max=$value['max']+1;
		$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','tax_pay_raminder','$today','Done')");
 	}
 
	function email($tax_pay_date,$tax_type)
	{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;


		$content = '
		<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Tax pay date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($tax_pay_date).'</td></tr>
              
            </table>
          </tr>';
	    global $model;
	 	$subject = 'Tax Pay Reminder';
		$model->app_email_send('90',"Admin",$app_email_id, $content, $subject);
	 
	}

?>