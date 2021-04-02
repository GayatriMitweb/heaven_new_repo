<?php 
include_once('../model.php');
$theme_color = "#36aae7"; $theme_color_dark = "#239ede"; $theme_color_2 = "#1d4372"; $topbar_color = "#ffffff"; $sidebar_color = "#36aae7"; 
?>
<?php 
$week_start_date = date('Y-m-d', strtotime('-5 days'));
$converted_count = 0;
$closed_count = 0;
$followup_count = 0;

//************************************Enquiy summary ***********************************************//
$cur_date = date('Y-m-d');
$day = date("D", strtotime($cur_date));
$sq_enquiry = mysql_query("select * from enquiry_master where status!='Disabled' and enquiry_date between '$week_start_date' and '$cur_date'");

while($row_enq = mysql_fetch_assoc($sq_enquiry)){

    $sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
    if($sq_enquiry_entry['followup_status']=="Dropped"){
        $closed_count++;
    }

    if($sq_enquiry_entry['followup_status']=="Converted"){
        $converted_count++;
    }
    if($sq_enquiry_entry['followup_status']=="Active"){
        $followup_count++;
    }
}

//************************************Task summary ***********************************************//
$sq_task =mysql_num_rows(mysql_query("select * from tasks_master where remind_due_date between '$week_start_date' and '$cur_date' "));

$sq_task_complete =mysql_num_rows(mysql_query("select * from tasks_master where remind_due_date between '$week_start_date' and '$cur_date' and task_status=='Completed' "));

$sq_task_active =mysql_num_rows(mysql_query("select * from tasks_master where remind_due_date between '$week_start_date' and '$cur_date' and task_status=='Created' "));

//************************************Sale summary ***********************************************//
//Group booking
$sq_group_booking =mysql_num_rows(mysql_query("select * from  tourwise_traveler_details where form_date between '$week_start_date' and '$cur_date'"));
$group_amount = 0;
$tourwise_details = mysql_query("select * from tourwise_traveler_details where form_date between '$week_start_date' and '$cur_date'");
while($row_group = mysql_fetch_assoc($tourwise_details)){
    $total_amount= $row_group['total_tour_fee'] + $row_group['total_travel_expense'];
    $group_amount = $group_amount + $total_amount;
}

// Package booking
$sq_package_booking =mysql_num_rows(mysql_query("select * from package_tour_booking_master where booking_date between '$week_start_date' and '$cur_date'"));
$package_amount = 0; $total_amount = 0;
$sq_package = mysql_query("select * from package_tour_booking_master where booking_date between '$week_start_date' and '$cur_date'");
while($row_package = mysql_fetch_assoc($sq_package)){
    //Tour TOtal
    $tour_amount= ($row_package['actual_tour_expense']!="") ? $row_package['actual_tour_expense']: 0;
    //Travel Total 
    $travel_amount= ($row_package['total_travel_expense']!="") ? $row_package['total_travel_expense']: 0;

    $total_amount = $tour_amount + $travel_amount ;

    $package_amount = $package_amount + $total_amount;
}

// Visa booking
$sq_visa_booking =mysql_num_rows(mysql_query("select * from visa_master where created_at between '$week_start_date' and '$cur_date'"));        
$visa_amount = 0;
$sq_visa = mysql_query("select * from visa_master where created_at between '$week_start_date' and '$cur_date'");
while($row_visa = mysql_fetch_assoc($sq_visa)){
    $visa_amount = $visa_amount + $row_visa['visa_total_cost'];
}

//Passport booking
$sq_passport_booking =mysql_num_rows(mysql_query("select * from passport_master where created_at between '$week_start_date' and '$cur_date'"));
$passport_amount = 0;
$sq_pass = mysql_query("select * from passport_master where created_at between '$week_start_date' and '$cur_date'");
while($row_pass = mysql_fetch_assoc($sq_pass)){
    $passport_amount = $passport_amount + $row_pass['passport_total_cost'];
}

// Air ticket booking
$sq_air_booking =mysql_num_rows(mysql_query("select * from ticket_master where created_at between '$week_start_date' and '$cur_date'"));
$air_amount = 0;
$sq_air = mysql_query("select * from ticket_master where created_at between '$week_start_date' and '$cur_date'");
while($row_air = mysql_fetch_assoc($sq_air)){
    $air_amount = $air_amount + $row_air['ticket_total_cost'];
}

//Train booking
$sq_train_booking =mysql_num_rows(mysql_query("select * from train_ticket_master where created_at between '$week_start_date' and '$cur_date'"));
$train_amount = 0;
$sq_train = mysql_query("select * from train_ticket_master where created_at between '$week_start_date' and '$cur_date'");
while($row_train = mysql_fetch_assoc($sq_train)){
    $train_amount = $train_amount + $row_train['net_total'];
}

//Bus booking
$sq_bus_booking =mysql_num_rows(mysql_query("select * from bus_booking_master where created_at between '$week_start_date' and '$cur_date'"));
$bus_amount = 0;
$sq_bus = mysql_query("select * from bus_booking_master where created_at between '$week_start_date' and '$cur_date'");
while($row_bus = mysql_fetch_assoc($sq_bus)){
    $bus_amount = $bus_amount + $row_bus['net_total'];
}

// Car rental booking
$sq_car_booking =mysql_num_rows(mysql_query("select * from car_rental_booking where traveling_date between '$week_start_date' and '$cur_date'"));
$car_amount = 0;
$sq_car = mysql_query("select * from car_rental_booking where traveling_date between '$week_start_date' and '$cur_date'");
while($row_car = mysql_fetch_assoc($sq_car)){
    $car_amount = $car_amount + $row_car['total_fees'];
}

//forex booking 
$sq_forex_booking =mysql_num_rows(mysql_query("select * from forex_booking_master where created_at between '$week_start_date' and '$cur_date'"));
$forex_amount = 0;
$sq_forex = mysql_query("select * from forex_booking_master where created_at between '$week_start_date' and '$cur_date'");
while($row_forex = mysql_fetch_assoc($sq_forex)){
    $forex_amount = $forex_amount + $row_forex['net_total'];
}

// Hotel booking
$sq_hotel_booking =mysql_num_rows(mysql_query("select * from hotel_booking_master where created_at between '$week_start_date' and '$cur_date'"));        
$hotel_amount = 0;
$sq_hotel = mysql_query("select * from hotel_booking_master where created_at between '$week_start_date' and '$cur_date'");
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
    $hotel_amount = $hotel_amount + $row_hotel['total_fee'];
}

// Excursion booking
$sq_exc_booking =mysql_num_rows(mysql_query("select * from excursion_master where created_at between '$week_start_date' and '$cur_date'"));        
$exc_amount = 0;
$sq_exc = mysql_query("select * from excursion_master where created_at between '$week_start_date' and '$cur_date'");
while($row_exc = mysql_fetch_assoc($sq_exc)){
    $exc_amount = $exc_amount + $row_exc['exc_total_cost'];
}

$total_sale_amount = $group_amount + $package_amount + $visa_amount + $passport_amount + $air_amount + $train_amount + $bus_amount + $car_amount + $forex_amount + $hotel_amount + $exc_amount;

//****************************** Purchase Report ********************************//

//Hotel vendor
$sq_hotel_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Hotel Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_hotel = 0;
$sq_hotel = mysql_query("select * from vendor_estimate where vendor_type='Hotel Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
    $p_hotel = $p_hotel + $row_hotel['net_total'];
}

//DMc vendor
$sq_dmc_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='DMC Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_dmc = 0;
$sq_dmc = mysql_query("select * from vendor_estimate where vendor_type='DMC Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_dmc = mysql_fetch_assoc($sq_dmc)){
    $p_dmc = $p_dmc + $row_dmc['net_total'];
}

//Tranport vendor
$sq_transport_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Transport Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_transport = 0;
$sq_trans = mysql_query("select * from vendor_estimate where vendor_type='Transport Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_trans)){
    $p_transport = $p_transport + $row_tr['net_total'];
}

//Car Rental vendor
$sq_car_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Car Rental Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_car = 0;
$sq_trans = mysql_query("select * from vendor_estimate where vendor_type='Car Rental Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_trans)){
    $p_car = $p_car + $row_tr['net_total'];
}

//Visa Vendor
$sq_visa_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Visa Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_visa = 0;
$sq_visa = mysql_query("select * from vendor_estimate where vendor_type='Visa Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_visa = mysql_fetch_assoc($sq_visa)){
    $p_visa = $p_visa + $row_visa['net_total'];
}

//Passport Vendor
$sq_passport_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Passport Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_passport = 0;
$sq_trans = mysql_query("select * from vendor_estimate where vendor_type='Passport Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_trans)){
    $p_passport = $p_passport + $row_tr['net_total'];
}

//Ticket Vendor
$sq_ticket_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Ticket Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_ticket = 0;
$sq_trans = mysql_query("select * from vendor_estimate where vendor_type='Ticket Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_trans)){
    $p_ticket = $p_ticket + $row_tr['net_total'];
}

//Excursion Vendor
$sq_exc_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Excursion Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$exc_ticket = 0;
$sq_exc = mysql_query("select * from vendor_estimate where vendor_type='Excursion Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_exc = mysql_fetch_assoc($sq_exc)){
    $exc_ticket = $exc_ticket + $row_exc['net_total'];
}
//Train Vendor
$sq_train_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Train Ticket Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_train = 0;
$sq_train = mysql_query("select * from vendor_estimate where vendor_type='Train Ticket Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_train)){
    $p_train = $p_train + $row_tr['net_total'];
}

//Insurance Vendor
$sq_insurance_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Insurance Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_ins = 0;
$sq_trans = mysql_query("select * from vendor_estimate where vendor_type='Insurance Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_trans)){
    $p_ins = $p_ins + $row_tr['net_total'];
}

// Other Vendor
$sq_other_vendor =mysql_num_rows(mysql_query("select * from vendor_estimate where vendor_type='Other Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_other = 0;
$sq_trans = mysql_query("select * from vendor_estimate where vendor_type='Other Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysql_fetch_assoc($sq_trans)){
    $p_other = $p_other + $row_tr['net_total'];
}

$total_purchase_amount = $p_hotel + $p_transport + $p_train + $p_ticket + $p_ins + $p_car + $p_other + $p_visa+ $p_dmc + $p_passport + $exc_ticket;

//*************** Office Expense *****************//
$row_exp = mysql_fetch_assoc(mysql_query("select sum(total_fee) as exp_paid from other_expense_master where expense_date between '$week_start_date' and '$cur_date'"));

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.theme.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
   <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/modules/single_quotation.php">   


  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
  
</head>

<body>
  <!-- Header -->

  <nav class="navbar navbar-default">

      <!-- Header-Top -->
      <div class="Header_Top">
        <div class="container">
          <div class="row">
            <div class="col-md-offset-6 col-md-6">
              <ul class="company_contact">
                <li><a href="mailto:email@company_name.com"><i class="fa fa-envelope"></i>  <?= $app_email_id; ?></a></li>
                <li><i class="fa fa-mobile"></i> <?= $app_contact_no; ?></li>
                <li><i class="fa fa-phone"></i> <?= $app_landline_no; ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>


    <div class="container">

      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><img src="<?php echo BASE_URL ?>images/Admin-Area-Logo.png" class="img-responsive"></a>
        <div class="logo_right_part">
          <h1>
            <i class="fa fa-pencil-square-o"></i> Weekly Summary Report<br>
            <SPAN style="font-size: 15px;color: #000;">(<?php echo date('d-m-Y', strtotime($week_start_date)).' To '.date('d-m-Y', strtotime($cur_date)); ?>)</SPAN>
          </h1>
        </div>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="nav">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul id="menu-center" class="nav navbar-nav">
            <li class="active"><a href="#0">SALE SUMMARY</a></li>
            <li><a href="#1">PURCHASE SUMMARY</a></li>
            <li><a href="#2">ABSTRACT REPORT</a></li>
            <li><a href="#3">ENQUIRY</a></li>	
          </ul>
        </div><!-- /.navbar-collapse -->
      </div>
    </div><!-- /.container-fluid -->
  </nav>

  <!-- Header-End -->

<!-- Sale -->
  <section id="0" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>Sale Summary</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list"  style="padding-bottom: 0 !important;">
            <thead>
              <tr class="table-heading-row">
                <th>SERVICES</th>
                <th>Group</th>
                <th>Package</th>
                <th>Flight</th>
                <th>Visa</th>
                <th>Passport</th>
                <th>Hotel</th>
                <th>Train</th>
                <th>Bus</th>
                <th>Car_Rental</th>
                <th>Forex</th>
                <th>Excursion</th>
              </tr>
            </thead>
            <tbody>   
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_SALE</td>
                <td><?= $sq_group_booking ?></td>
                <td><?= $sq_package_booking ?></td>
                <td><?= $sq_air_booking ?></td>
                <td><?= $sq_visa_booking ?></td>
                <td><?= $sq_passport_booking ?></td>
                <td><?= $sq_hotel_booking ?></td>
                <td><?= $sq_train_booking ?></td>
                <td><?= $sq_bus_booking ?></td>
                <td><?= $sq_car_booking ?></td>
                <td><?= $sq_forex_booking ?></td>
                <td><?= $sq_exc_booking ?></td>
              </tr>
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_AMOUNT</td>
                <td><?= number_format($group_amount,2) ?></td>
                <td><?= number_format($package_amount,2) ?></td>
                <td><?= number_format($air_amount,2) ?></td>
                <td><?= number_format($visa_amount,2) ?></td>
                <td><?= number_format($passport_amount,2) ?></td>
                <td><?= number_format($hotel_amount,2) ?></td>
                <td><?= number_format($train_amount,2) ?></td>
                <td><?= number_format($bus_amount,2) ?></td>
                <td><?= number_format($car_amount,2) ?></td>
                <td><?= number_format($forex_amount,2) ?></td>
                <td><?= number_format($exc_amount,2) ?></td>
              </tr>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </div>
  </section>

<!-- Purchase -->
  <section id="1" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>Purchase Summary</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding-bottom: 0 !important;">
            <thead>
              <tr class="table-heading-row">
                <th>SERVICES</th>
                <th>Hotel</th>
                <th>DMC</th>
                <th>Transport</th>
                <th>Visa</th>
                <th>Passport</th>
                <th>FLIGHT</th>
                <th>Excursion</th>
                <th>Train</th>
                <th>Insurance</th>
                <th>Car_Rental</th>
                <th>Other</th>
              </tr>
            </thead>
            <tbody>   
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_PURCHASE</td>
                <td><?= $sq_hotel_vendor ?></td>
                <td><?= $sq_dmc_vendor ?></td>
                <td><?= $sq_transport_vendor ?></td>
                <td><?= $sq_visa_vendor ?></td>
                <td><?= $sq_passport_vendor ?></td>
                <td><?= $sq_ticket_vendor ?></td>
                <td><?= $sq_exc_vendor ?></td>
                <td><?= $sq_train_vendor ?></td>
                <td><?= $sq_insurance_vendor ?></td>
                <td><?= $sq_car_vendor ?></td>
                <td><?= $sq_other_vendor ?></td>
              </tr>
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_AMOUNT</td>                
                <td><?= number_format($p_hotel,2) ?></td>
                <td><?= number_format($p_dmc,2) ?></td>
                <td><?= number_format($p_transport,2) ?></td>
                <td><?= number_format($p_visa,2) ?></td>
                <td><?= number_format($p_passport,2) ?></td>
                <td><?= number_format($p_ticket,2) ?></td>
                <td><?= number_format($exc_ticket,2) ?></td>
                <td><?= number_format($p_train,2) ?></td>
                <td><?= number_format($p_ins,2) ?></td>
                <td><?= number_format($p_car,2) ?></td>
                <td><?= number_format($p_other,2) ?></td>
              </tr>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </div>
  </section>

<!-- Summary Report -->
  <section id="2" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>ABSTRACT REPORT</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="adolence_info">
            <ul class="main_block">
              <li class="col-md-4"><span>Total Sale : </span><?php echo number_format($total_sale_amount,2); ?></li>
              <li class="col-md-4"><span>Total Purchase : </span><?php echo number_format($total_purchase_amount,2); ?></li>
              <li class="col-md-4"><span>Other Expense : </span><?php echo number_format($row_exp['exp_paid'],2); ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- Enquiry Summary Report -->
  <section id="3" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>Enquiry</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="adolence_info">
            <ul class="main_block">
              <li class="col-md-4"><span>Active : </span><?php echo $followup_count; ?></li>
              <li class="col-md-4 highlight" style="font-weight: 600; color: #016d01;"><span class="highlight">Converted : </span><?php echo $converted_count; ?></li>
              <li class="col-md-4 highlight" style="font-weight: 600; color: red;"><span class="highlight">Dropped : </span><?php echo $closed_count; ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>



<!-- Footer -->

  <footer class="main_block">
    <div class="footer_part">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="footer_company_cont">
              <p><i class="fa fa-map-marker"></i> <?php echo $app_address; ?></p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="footer_company_cont text-right">
              <p><i class="fa fa-phone"></i> <?php echo $app_contact_no; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

<!-- Footer-End-->




<!-- sticky-header -->
    <script type="text/javascript">
      $(document).ready(function(){

        $(window).bind('scroll', function() {
      
          var navHeight = 159; // custom nav height
      
          ($(window).scrollTop() > navHeight) ? $('div.nav').addClass('goToTop') : $('div.nav').removeClass('goToTop');
      
        });
      
      });
    </script>

<!-- Smooth-scroll -->
<script type="text/javascript">
       $(document).on('click', '#menu-center a', function(event){
          event.preventDefault();

          $('html, body').animate({
              scrollTop: $( $.attr(this, 'href') ).offset().top
          }, 500);
      });
</script>

<!-- Active-menu -->
<script type="text/javascript">
  $("#menu-center a").click(function(){
      $(this).parent().siblings().removeClass('active');
      $(this).parent().addClass('active');
  });
</script>

<!-- Accordion -->
<script type="text/javascript">
  $('#myCollapsible').collapse({
    toggle: false
  })
</script>

<!-- Slider -->
<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        pagination:false,
        autoPlay:true,
        singleItem:true,
        navigation:true,
        navigationText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
</script>

</body>
</html>