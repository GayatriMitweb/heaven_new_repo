<?php 
include_once('../../../model/model.php');
include_once('../../../model/promotional_email/email_send.php');

$template_id = $_POST['template_type'];
$group_id = $_POST['group_name'];

$sq_email_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id='$template_id'"));

if($sq_email_template['template_type'] == "Diwali"){
	$email_send = new email_send;
	$email_send->diwali_send_mail($template_id,$group_id);
}	
elseif($sq_email_template['template_type'] == "Ganesha Chaturthi")
{
	$email_send = new email_send;
	$email_send->chaturthi_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Eid")
{
	$email_send = new email_send;
	$email_send->eid_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Gudi Padwa")
{
	$email_send = new email_send;
	$email_send->padwa_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Raksha Bandhan")
{
	$email_send = new email_send;
	$email_send->raksha_bandhan_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Christmas")
{
	$email_send = new email_send;
	$email_send->christmas_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "New Year")
{
	$email_send = new email_send;
	$email_send->new_year_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Father's Day")
{
	$email_send = new email_send;
	$email_send->father_day_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Mother's Day")
{
	$email_send = new email_send;
	$email_send->mother_day_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Valentine Day")
{
	$email_send = new email_send;
	$email_send->valentine_day_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Thanks Giving")
{
	$email_send = new email_send;
	$email_send->thanks_giving_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Monthly Offers")
{
	$email_send = new email_send;
	$email_send->monthly_offer_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Full Payment")
{
	$email_send = new email_send;
	$email_send->full_payment_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Repeater")
{
	$email_send = new email_send;
	$email_send->repeater_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Senior Citizens")
{
	$email_send = new email_send;
	$email_send->senior_citizen_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Womens Special")
{
	$email_send = new email_send;
	$email_send->women_special_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Halloween")
{
	$email_send = new email_send;
	$email_send->halloween_send_mail($template_id,$group_id);
}
elseif($sq_email_template['template_type'] == "Easter")
{
	$email_send = new email_send;
	$email_send->easter_send_mail($template_id,$group_id);
}
/*
elseif($sq_email_template['template_type'] == "Children's Day")
{
	$email_send = new email_send;
	$email_send->children_send_mail($template_id,$group_id);
}*/
else
{

}
?>