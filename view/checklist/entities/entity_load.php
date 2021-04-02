<?php
include "../../../model/model.php";

$entity_for=$_POST['entity_for'];
$emp_id=$_POST['emp_id'];
$branch_status=$_POST['branch_status'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$check_list_array = Array();

if($entity_for=="Group Tour"){
    $check_list_array = ['Visa Document Collect','Visa Document Processing','Visa Approve','Flight/Train Ticket Purchase','Hotels Purchase & Confirmation','Excursion Purchase & Confirmation','Transport Purchase & Confirmation','Service Vouchers handover','Travel Ticket Handover','Excursion Ticket Handover','Happy Journey Wishes','Driver Assigned'];
}
else if($entity_for=="Visa Booking"){
    $check_list_array=['Document Confirm','Document Received','Document Process','Visa Confirm','Visa Handover'];
}else if($entity_for=="Flight Booking"){
    $check_list_array = ['Flight Ticket Purchase','Train Ticket Handover'];
}
else if($entity_for=="Train Booking"){
    $check_list_array = ['Train Ticket Purchase','Ticket Confirm','Train Ticket Handover'];
}

else if($entity_for=="Hotel Booking"){
    $check_list_array = ['Hotels Purchase & Confirmation','Service Vouchers handover'];
}

else if($entity_for=="Bus Booking"){
    $check_list_array = ['Bus Booking & Confirmation','Ticket Handover'];

}
else if($entity_for=="Car Rental Booking"){
   
    $check_list_array = ['Vehicle Purchase Confirm','Driver Assigned','Driver Contact Details shared'];
}
else if($entity_for=="Passport Booking"){
   
    $check_list_array = ['Passport Date shared with customer','Passport Consultancy Done'];
}
else if($entity_for=="Excursion Booking"){
   
    $check_list_array = ['Excursion Purchase & Confirmation','Excursion Ticket Handover'];
}
else{
    $check_list_array = ['Visa Document Collect','Visa Document Processing','Visa Approve','Flight/Train Ticket Purchase','Hotels Purchase & Confirmation','Excursion Purchase & Confirmation','Transport Purchase & Confirmation','Service Vouchers handover','Travel Ticket Handover','Excursion Ticket Handover','Happy Journey Wishes','Driver Assigned','Driver Contact Details shared'];
    }
    echo json_encode($check_list_array);
?>