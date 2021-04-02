<?php 
include "../../../../../../model/model.php";
 
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$financial_year_id = $_SESSION['financial_year_id'];
$pre_financial_year_id = $financial_year_id -1;

$sq_finacial_year = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$financial_year_id'")); 
$current_finance_yr = get_date_user($sq_finacial_year['from_date']).' - '.get_date_user($sq_finacial_year['to_date']);
$sq_finacial_year = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$pre_financial_year_id'")); 
$prev_finance_yr = get_date_user($sq_finacial_year['from_date']).' - '.get_date_user($sq_finacial_year['to_date']);
$current_date = date("Y-m-d");
$month = date('F', strtotime($current_date));


?>
<!-- <div class="row mg_bt_10">
	<div class="col-md-12 text-right">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div> -->
<div class="row mg_tp_20">
<form id="frm_save">
    <div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
    <table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
            <thead >
                <tr class="table-heading-row ">
                    <th></th>
                    <th colspan="2" class="text-center"><?= date('F') ?></th>
                    <th colspan="2" class="text-center">For The Year</th>
                </tr>
                <tr class="table-heading-row">
                    <th>Particular</th>
                    <th><?= $prev_finance_yr ?></th>
                    <th><?= $current_finance_yr ?></th>
                    <th><?= $prev_finance_yr ?></th>
                    <th><?= $current_finance_yr ?></th>
                </tr>
            </thead>
            <tbody>
            <!-- Group Booking -->
        <?php
        $sq_group_count = mysql_num_rows(mysql_query("select * from tourwise_traveler_details where financial_year_id='$financial_year_id'"));
        $sq_group_pre_count = mysql_num_rows(mysql_query("select * from tourwise_traveler_details where financial_year_id='$pre_financial_year_id'"));

        $sq_group = mysql_fetch_assoc(mysql_query("select sum(total_tour_fee) as total_tour_fee, sum(total_travel_expense) as total_travel_expense from tourwise_traveler_details where financial_year_id='$financial_year_id'"));
        $sq_group_pre = mysql_fetch_assoc(mysql_query("select sum(total_tour_fee) as total_tour_fee, sum(total_travel_expense) as total_travel_expense from tourwise_traveler_details where financial_year_id='$pre_financial_year_id'"));

        $current_group_sale = $sq_group['total_travel_expense'] + $sq_group['total_tour_fee'];
        $previous_group_sale = $sq_group_pre['total_travel_expense'] + $sq_group_pre['total_tour_fee'];

        $sq_group_month = mysql_fetch_assoc(mysql_query("SELECT sum(total_tour_fee) as total_tour_fee, sum(total_travel_expense) as total_travel_expense
        FROM  tourwise_traveler_details WHERE MONTH(form_date) = MONTH(form_date)
        AND YEAR(form_date) = YEAR(form_date) AND financial_year_id='$financial_year_id'"));
        $sq_group_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(total_tour_fee) as total_tour_fee, sum(total_travel_expense) as total_travel_expense
        FROM  tourwise_traveler_details WHERE MONTH(form_date) = MONTH(form_date)
        AND YEAR(form_date) = YEAR(form_date) AND financial_year_id='$pre_financial_year_id'"));
 $current_group_sale_m = $sq_group_month['total_tour_fee'] + $sq_group_month['total_travel_expense'];
 $previous_group_sale_m = $sq_group_month_pre['total_tour_fee'] + $sq_group_month_pre['total_travel_expense'];
            if($sq_group_count!="0" || $sq_group_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Group Booking</td>
                        <td><?= number_format($previous_group_sale_m,2) ?></td>
                        <td><?= number_format($current_group_sale_m,2) ?> </td>
                        <td><?= number_format($previous_group_sale,2) ?></td>
                        <td><?= number_format($current_group_sale,2) ?></td>
                    </tr>
            <?php } ?>
<!-- Package Booking -->
        <?php
        $sq_package_count = mysql_num_rows(mysql_query("select * from package_tour_booking_master where financial_year_id='$financial_year_id'"));
        $sq_package_pre_count = mysql_num_rows(mysql_query("select * from package_tour_booking_master where financial_year_id='$pre_financial_year_id'"));

        $sq_package = mysql_fetch_assoc(mysql_query("select sum(actual_tour_expense) as actual_tour_expense, sum(total_travel_expense) as total_travel_expense from package_tour_booking_master where financial_year_id='$financial_year_id'"));
        $sq_package_pre = mysql_fetch_assoc(mysql_query("select sum(actual_tour_expense) as actual_tour_expense, sum(total_travel_expense) as total_travel_expense from package_tour_booking_master where financial_year_id='$pre_financial_year_id'"));

        $current_package_sale = $sq_package['actual_tour_expense'] + $sq_package['total_travel_expense'];
        $previous_package_sale = $sq_package_pre['actual_tour_expense'] + $sq_package_pre['total_travel_expense'];

        $sq_package_month = mysql_fetch_assoc(mysql_query("SELECT sum(actual_tour_expense) as actual_tour_expense, sum(total_travel_expense) as total_travel_expense
        FROM package_tour_booking_master WHERE MONTH(booking_date) = MONTH(booking_date)
        AND YEAR(booking_date) = YEAR(booking_date) AND financial_year_id='$financial_year_id'"));
        $sq_package_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(actual_tour_expense) as actual_tour_expense, sum(total_travel_expense) as total_travel_expense
        FROM package_tour_booking_master WHERE MONTH(booking_date) = MONTH(booking_date)
        AND YEAR(booking_date) = YEAR(booking_date) AND financial_year_id='$pre_financial_year_id'"));
        $current_package_sale_m = $sq_package_month['actual_tour_expense'] + $sq_package_month['total_travel_expense'];
        $previous_package_sale_m = $sq_package_month_pre['actual_tour_expense'] + $sq_package_month_pre['total_travel_expense'];
            if($sq_package_count!="0" || $sq_package_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Package Booking</td>
                        <td><?= number_format($previous_package_sale_m,2) ?></td>
                        <td><?= number_format($current_package_sale_m,2) ?> </td>
                        <td><?= number_format($previous_package_sale,2) ?></td>
                        <td><?= number_format($current_package_sale,2) ?></td>
                    </tr>
            <?php } ?>
 <!-- Hotel Booking -->
        <?php
        $sq_hotel_count = mysql_num_rows(mysql_query("select * from hotel_booking_master where financial_year_id='$financial_year_id'"));
        $sq_hotel_pre_count = mysql_num_rows(mysql_query("select * from hotel_booking_master where financial_year_id='$pre_financial_year_id'"));

        $sq_hotel = mysql_fetch_assoc(mysql_query("select sum(total_fee) as hotel_total from hotel_booking_master where financial_year_id='$financial_year_id'"));
        $sq_hotel_pre = mysql_fetch_assoc(mysql_query("select sum(total_fee) as hotel_total from hotel_booking_master where financial_year_id='$pre_financial_year_id'"));
        $current_hotel_sale = $sq_hotel['hotel_total'];
        $previous_hotel_sale = $sq_hotel_pre['hotel_total'];
        $sq_hotel_month = mysql_fetch_assoc(mysql_query("SELECT sum(total_fee) as hotel_total
        FROM hotel_booking_master WHERE MONTH(created_at) = MONTH(created_at)
        AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));
        $sq_hotel_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(total_fee) as hotel_total
        FROM hotel_booking_master WHERE MONTH(created_at) = MONTH(created_at)
        AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
        $pre_month_hotel = $sq_hotel_month_pre['hotel_total'];
        $current_month_hotel = $sq_hotel_month['hotel_total'];
            if($sq_hotel_count!="0" || $sq_hotel_pre_count!='0'){
                // if($pre_month_hotel>$current_month_hotel){
                //   $icon =   '<span class="glyphicon glyphicon-arrow-up"></span>';
                // }else{
                //     $icon =   '<span class="glyphicon glyphicon-arrow-down"></span>';
                // }
                
            ?>
                    <tr>
                        <td>Hotel Booking</td> 
                        <td><?= $pre_month_hotel ?></td>
                        <td><?= $current_month_hotel ?> </td>
                        <td><?= $previous_hotel_sale ?></td>
                        <td><?= $current_hotel_sale ?></td>
                    </tr>
            <?php } ?>
            <?php
// Bus Booking
$sq_bus_count = mysql_num_rows(mysql_query("select * from bus_booking_master where financial_year_id='$financial_year_id'"));
$sq_bus_pre_count = mysql_num_rows(mysql_query("select * from bus_booking_master where financial_year_id='$pre_financial_year_id'"));

$sq_bus = mysql_fetch_assoc(mysql_query("select sum(net_total) as bus_total from bus_booking_master where financial_year_id='$financial_year_id'"));
$sq_bus_pre = mysql_fetch_assoc(mysql_query("select sum(net_total) as bus_total from bus_booking_master where financial_year_id='$pre_financial_year_id'"));
$current_bus_sale = $sq_bus['bus_total'];
$previous_bus_sale = $sq_bus_pre['bus_total'];
$sq_bus_month = mysql_fetch_assoc(mysql_query("SELECT sum(net_total) as bus_total
FROM bus_booking_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_bus_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(net_total) as bus_total
FROM bus_booking_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_bus = $sq_bus_month_pre['bus_total'];
$current_month_bus = $sq_bus_month['bus_total'];
            if($sq_bus_count!="0" || $sq_bus_pre_count!='0'){
            ?>
                    <tr>
                        <td>Bus Booking</td>
                        <td><?= $pre_month_bus ?></td>
                        <td><?= $current_month_bus ?> </td>
                        <td><?= $previous_bus_sale ?></td> 
                        <td><?= $current_bus_sale ?></td>
                    </tr>
            <?php } 
// Flight Booking
$sq_flight_count = mysql_num_rows(mysql_query("select * from ticket_master where financial_year_id='$financial_year_id'"));
$sq_flight_pre_count = mysql_num_rows(mysql_query("select * from ticket_master where financial_year_id='$pre_financial_year_id'"));

$sq_flight = mysql_fetch_assoc(mysql_query("select sum(ticket_total_cost) as flight_total from ticket_master where financial_year_id='$financial_year_id'"));
$sq_flight_pre = mysql_fetch_assoc(mysql_query("select sum(ticket_total_cost) as flight_total from ticket_master where financial_year_id='$pre_financial_year_id'"));
$current_flight_sale = $sq_flight['flight_total'];
$previous_flight_sale = $sq_flight_pre['flight_total'];
$sq_flight_month = mysql_fetch_assoc(mysql_query("SELECT sum(ticket_total_cost) as flight_total
FROM ticket_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_flight_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(ticket_total_cost) as flight_total
FROM ticket_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));

$pre_month_flight = $sq_flight_month_pre['flight_total'];
$current_month_flight = $sq_flight_month['flight_total'];
            if($sq_flight_count!="0" || $sq_flight_pre_count!='0'){
            ?>
                    <tr>
                        <td>Flight Booking</td> 
                        <td><?= $pre_month_flight ?></td>
                        <td><?= $current_month_flight ?> </td>
                        <td><?= $previous_flight_sale ?></td>
                        <td><?= $current_flight_sale ?></td>
                    </tr>
            <?php } 
// <!-- Train Booking -->
$sq_train_count = mysql_num_rows(mysql_query("select * from  train_ticket_master where financial_year_id='$financial_year_id'"));
$sq_train_pre_count = mysql_num_rows(mysql_query("select * from train_ticket_master where financial_year_id='$pre_financial_year_id'"));

$sq_train = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total from train_ticket_master where financial_year_id='$financial_year_id'"));
$sq_train_pre = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total from train_ticket_master where financial_year_id='$pre_financial_year_id'"));
$current_train_sale = $sq_train['net_total'];
$previous_train_sale = $sq_train_pre['net_total'];
$sq_train_month = mysql_fetch_assoc(mysql_query("SELECT sum(net_total) as net_total
FROM train_ticket_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_train_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(net_total) as net_total
FROM train_ticket_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_train = $sq_train_month_pre['net_total'];
$current_month_train = $sq_train_month['net_total'];
            if($sq_train_count!="0" || $sq_train_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Train Booking</td>
                        <td><?= $pre_month_train ?></td>
                        <td><?= $current_month_train ?> </td>
                        <td><?= $previous_train_sale ?></td>
                        <td><?= $current_train_sale ?></td>
                    </tr>
            <?php } 
 // <!-- Visa Booking -->
$sq_visa_count = mysql_num_rows(mysql_query("select * from visa_master where financial_year_id='$financial_year_id'"));
$sq_visa_pre_count = mysql_num_rows(mysql_query("select * from visa_master where financial_year_id='$pre_financial_year_id'"));

$sq_visa = mysql_fetch_assoc(mysql_query("select sum(visa_total_cost) as net_total from visa_master where financial_year_id='$financial_year_id'"));
$sq_visa_pre = mysql_fetch_assoc(mysql_query("select sum(visa_total_cost) as net_total from visa_master where financial_year_id='$pre_financial_year_id'"));
$current_visa_sale = $sq_visa['net_total'];
$previous_visa_sale = $sq_visa_pre['net_total'];
$sq_visa_month = mysql_fetch_assoc(mysql_query("SELECT sum(visa_total_cost) as net_total
FROM visa_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_visa_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(visa_total_cost) as net_total
FROM visa_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_visa = $sq_visa_month_pre['net_total'];
$current_month_visa = $sq_visa_month['net_total'];
            if($sq_visa_count!="0" || $sq_visa_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Visa Booking</td>
                        <td><?= $pre_month_visa ?></td>
                        <td><?= $current_month_visa ?> </td>
                        <td><?= $previous_visa_sale ?></td>
                        <td><?= $current_visa_sale ?></td>
                    </tr>
            <?php }
// <!-- Car Rental Booking -->
$sq_car_count = mysql_num_rows(mysql_query("select * from car_rental_booking where financial_year_id='$financial_year_id'"));
$sq_car_pre_count = mysql_num_rows(mysql_query("select * from car_rental_booking where financial_year_id='$pre_financial_year_id'"));

$sq_car = mysql_fetch_assoc(mysql_query("select sum(total_fees) as net_total from car_rental_booking where financial_year_id='$financial_year_id'"));
$sq_car_pre = mysql_fetch_assoc(mysql_query("select sum(total_fees) as net_total from car_rental_booking where financial_year_id='$pre_financial_year_id'"));
$current_car_sale = $sq_car['net_total'];
$previous_car_sale = $sq_car_pre['net_total'];
$sq_car_month = mysql_fetch_assoc(mysql_query("SELECT sum(total_fees) as net_total
FROM car_rental_booking WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_car_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(total_fees) as net_total
FROM car_rental_booking WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_car = $sq_car_month_pre['net_total'];
$current_month_car = $sq_car_month['net_total'];
            if($sq_car_count!="0" || $sq_car_pre_count!='0'){
            ?>
                    <tr>
                        <td>Car rental Booking</td> 
                        <td><?= $pre_month_car ?></td>
                        <td><?= $current_month_car ?> </td>
                        <td><?= $previous_car_sale ?></td>
                        <td><?= $current_car_sale ?></td>
                    </tr>
            <?php } 
// <!-- Activity Booking -->
$sq_exc_count = mysql_num_rows(mysql_query("select * from excursion_master where financial_year_id='$financial_year_id'"));
$sq_exc_pre_count = mysql_num_rows(mysql_query("select * from excursion_master where financial_year_id='$pre_financial_year_id'"));

$sq_exc = mysql_fetch_assoc(mysql_query("select sum(exc_total_cost) as net_total from excursion_master where financial_year_id='$financial_year_id'"));
$sq_exc_pre = mysql_fetch_assoc(mysql_query("select sum(exc_total_cost) as net_total from excursion_master where financial_year_id='$pre_financial_year_id'"));
$current_exc_sale = $sq_exc['net_total'];
$previous_exc_sale = $sq_exc_pre['net_total'];
$sq_exc_month = mysql_fetch_assoc(mysql_query("SELECT sum(exc_total_cost) as net_total
FROM excursion_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_exc_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(exc_total_cost) as net_total
FROM excursion_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_act = $sq_exc_month_pre['net_total'];
$current_month_act = $sq_exc_month['net_total'];
            if($sq_exc_count!="0" || $sq_exc_pre_count!='0'){
            ?>
                    <tr>
                        <td>Activity Booking</td> 
                        <td><?= $pre_month_act ?></td>
                        <td><?= $current_month_act ?> </td>
                        <td><?= $previous_exc_sale ?></td>
                        <td><?= $current_exc_sale ?></td>
                    </tr>
            <?php } 
// <!-- misc Booking -->
$sq_misc_count = mysql_num_rows(mysql_query("select * from miscellaneous_master where financial_year_id='$financial_year_id'"));
$sq_misc_pre_count = mysql_num_rows(mysql_query("select * from miscellaneous_master where financial_year_id='$pre_financial_year_id'"));

$sq_misc = mysql_fetch_assoc(mysql_query("select sum(misc_total_cost) as net_total from miscellaneous_master where financial_year_id='$financial_year_id'"));
$sq_misc_pre = mysql_fetch_assoc(mysql_query("select sum(misc_total_cost) as net_total from miscellaneous_master where financial_year_id='$pre_financial_year_id'"));
$current_misc_sale = $sq_misc['net_total'];
$previous_misc_sale = $sq_misc_pre['net_total'];
$sq_misc_month = mysql_fetch_assoc(mysql_query("SELECT sum(misc_total_cost) as net_total
FROM miscellaneous_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_misc_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(misc_total_cost) as net_total
FROM miscellaneous_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_misc = $sq_misc_month_pre['net_total'];
$current_month_misc = $sq_misc_month['net_total'];
            if($sq_misc_count!="0" || $sq_misc_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Miscellaneous Booking</td>
                        <td><?= $pre_month_misc ?></td>
                        <td><?= $current_month_misc ?> </td>
                        <td><?= $previous_misc_sale ?></td>
                        <td><?= $current_misc_sale ?></td>
                    </tr>
            <?php }
 // <!-- Forex Booking -->
$sq_forex_count = mysql_num_rows(mysql_query("select * from forex_booking_master where financial_year_id='$financial_year_id'"));
$sq_forex_pre_count = mysql_num_rows(mysql_query("select * from forex_booking_master where financial_year_id='$pre_financial_year_id'"));

$sq_forex = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total from forex_booking_master where financial_year_id='$financial_year_id'"));
$sq_forex_pre = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total from forex_booking_master where financial_year_id='$pre_financial_year_id'"));
$current_forex_sale = $sq_forex['net_total'];
$previous_forex_sale = $sq_forex_pre['net_total'];
$sq_forex_month = mysql_fetch_assoc(mysql_query("SELECT sum(net_total) as net_total
FROM forex_booking_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_forex_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(net_total) as net_total
FROM forex_booking_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_forex = $sq_forex_month_pre['net_total'];
$current_month_forex = $sq_forex_month['net_total'];
            if($sq_forex_count!="0" || $sq_forex_pre_count!='0'){
            ?>
                    <tr>
                        <td>Forex Booking</td> 
                        <td><?= $pre_month_forex ?></td>
                        <td><?= $current_month_forex ?> </td>
                        <td><?= $previous_forex_sale ?></td>
                        <td><?= $current_forex_sale ?></td>
                    </tr>
            <?php } 
// <!-- Passport Booking -->
$sq_passport_count = mysql_num_rows(mysql_query("select * from passport_master where financial_year_id='$financial_year_id'"));
$sq_passport_pre_count = mysql_num_rows(mysql_query("select * from passport_master where financial_year_id='$pre_financial_year_id'"));

$sq_passport = mysql_fetch_assoc(mysql_query("select sum(passport_total_cost) as net_total from passport_master where financial_year_id='$financial_year_id'"));
$sq_passport_pre = mysql_fetch_assoc(mysql_query("select sum(passport_total_cost) as net_total from passport_master where financial_year_id='$pre_financial_year_id'"));
$current_passport_sale = $sq_passport['net_total'];
$previous_passport_sale = $sq_passport_pre['net_total'];
$sq_passport_month = mysql_fetch_assoc(mysql_query("SELECT sum(passport_total_cost) as net_total
FROM passport_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$financial_year_id'"));

$sq_passport_month_pre = mysql_fetch_assoc(mysql_query("SELECT sum(passport_total_cost) as net_total
FROM passport_master WHERE MONTH(created_at) = MONTH(created_at)
AND YEAR(created_at) = YEAR(created_at) AND financial_year_id='$pre_financial_year_id'"));
$pre_month_passport = $sq_passport_month_pre['net_total'];
$current_month_passport = $sq_passport_month['net_total'];
            if($sq_passport_count!=0 || $sq_passport_pre_count!=0){
            ?>
                    <tr>
                        <td>Passport Booking</td>
                        <td><?= $pre_month_passport ?></td>
                        <td><?= $current_month_passport ?> </td>
                        <td><?= $previous_passport_sale ?></td> 
                        <td><?= $current_passport_sale ?></td>
                    </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <?php
// curent year sale
$total_current_yr_sale = $current_group_sale+$current_package_sale+$current_hotel_sale+$current_visa_sale+$current_flight_sale+$current_train_sale+$current_bus_sale+$current_car_sale+$current_forex_sale+$current_exc_sale+$current_passport_sale+$current_misc_sale;
// previous year sale
$total_pre_yr_sale = $previous_group_sale+$previous_package_sale+$previous_hotel_sale+$previous_visa_sale+$previous_flight_sale+$previous_train_sale+$previous_bus_sale+$previous_car_sale+$previous_forex_sale+$previous_exc_sale+$previous_passport_sale+$previous_misc_sale;
// previous year month sale
$total_pre_month_sale = $previous_group_sale_m+$previous_package_sale_m+$pre_month_hotel+$pre_month_bus+$pre_month_car+$pre_month_flight+$pre_month_train+$pre_month_visa+$pre_month_forex+$pre_month_misc+$pre_month_act+$pre_month_passport;
// current year month sale
$total_current_month_sale = $current_group_sale_m+$current_package_sale_m+$current_month_hotel+$current_month_bus+$current_month_car+$current_month_flight+$current_month_train+$current_month_visa+$current_month_forex+$current_month_misc+$current_month_act+$current_month_passport;



            ?>
                <tr class="active">
                    <th colspan="" class="" style="font-weight: bold;">Total : </th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_pre_month_sale, 2) ?></th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_current_month_sale, 2) ?></th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_pre_yr_sale, 2) ?></th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_current_yr_sale, 2) ?></th>
                </tr>
            </tfoot>
        </table>
    </div> </div> </div>
</form>
</div>
<script>
function excel_report()
{
	
	
	var branch_id = $('#branch_id_filter').val();
	var base_url = $('#base_url').val();
	var branch_status = $('#branch_status').val();
	window.location = base_url+'view/reports/business_reports/report_reflect/gross_sale/gross_sale_summary/excel_report.php?branch_id='+branch_id+'&branch_status='+branch_status;
}
</script>