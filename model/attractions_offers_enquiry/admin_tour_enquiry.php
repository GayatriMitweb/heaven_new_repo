<?php 
include_once('../model.php');

$name=$_POST['name']; 
$mobile_no=$_POST['mobile_no']; 
$landline_no=$_POST['landline_no']; 
$email_id=$_POST['email_id']; 
$tour_name=$_POST['tour_name']; 
$travel_from_date=$_POST['travel_from_date']; 
$travel_to_date=$_POST['travel_to_date']; 
$budget=$_POST['budget']; 
$total_adult=$_POST['total_adult']; 
$total_infant=$_POST['total_infant']; 
$reference_id=$_POST['reference_id']; 
$enquiry_spec=$_POST['enquiry_spec']; 
$hotel_type=$_POST['hotel_type']; 

global $app_name,$app_email_id;
global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

$content = '



<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr>
				<td colspan=2 style="text-align:center;border: 1px solid #888888;"><b>Refer new enquiry details.</b></td> 
			</tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Customer Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Mobile Number</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$mobile_no.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$travel_from_date.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Total Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$total_adult.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Total Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$total_infant.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Preferred Hotels</td>   <td style="text-align:left;border: 1px solid #888888;">'.$hotel_type.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Reference</td>   <td style="text-align:left;border: 1px solid #888888;">'.$reference_id.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_spec.'</td></tr>
            </table>
          </tr>
			
';
 

$subject = "New enquiry information received! : ".$name;
$model->app_email_master($app_email_id, $content, $subject,'1');
echo "Thank you for your interest. Our team will get back to you soon.";
?>