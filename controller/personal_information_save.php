<?php include "../model/model.php"; ?>
<?php

$honorific=$_POST['honorific'];
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$mail=$_POST['mail'];
$gender=$_POST['gender'];
$birth_date=$_POST['birth_date'];
$age=$_POST['age'];
$mobile_no=$_POST['mobile_no'];
$land_line_no=$_POST['land_line_no'];
$address1=$_POST['address1'];
$address2=$_POST['address2'];
$pincode=$_POST['pincode'];
$ltc=$_POST['ltc'];
$city=$_POST['city'];
$state=$_POST['state'];
$docs=$_POST['docs'];
$gaurdian_honorific=$_POST['gaurdian_honorific'];
$gaurdian_first_name=$_POST['gaurdian_first_name'];
$gaurdian_last_name=$_POST['gaurdian_last_name'];
$gaurdian_relation=$_POST['gaurdian_relation'];
$gaurdian_address=$_POST['gaurdian_address'];
$gaurdian_pin_code=$_POST['gaurdian_pin_code'];
$gaurdian_contact_no=$_POST['gaurdian_contact_no'];
$reference_type=$_POST['reference_type'];
$reference=$_POST['reference'];
 
$model->personal_information_save($honorific,$first_name,$last_name, $mail, $gender,$birth_date,$age,$mobile_no,$land_line_no,$address1,$address2, $pincode, $ltc,$city, $state, $docs,$gaurdian_honorific,$gaurdian_first_name,$gaurdian_last_name,$gaurdian_relation,$gaurdian_address,$gaurdian_pin_code, $gaurdian_contact_no, $reference_type, $reference  );

?>