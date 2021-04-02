<?php 
include_once('../../model/model.php');
header("Content-type: text/css");
?>


/*******Generic********/

body{
    margin:0;
    padding:0;
    background: #ffffff;
    font-family: 'Roboto', sans-serif;
}
body p{
    line-height: 20px;
}
.print_header_logo{
  max-width: 210px; 
}
.print_header span.title {
    margin: 0;
    padding: 0;
    color: <?= $theme_color ?>;
    font-weight: 500;
    font-size: 21px;
}
section.print_sec {
    padding: 15px 0;
}
.print_sec_tp_s{padding: 15px 0 0 0;}
.print_sec_bt_s{padding: 0 0 15px 0;}
.section_heding h2 {
    margin: 0;
    color: <?= $theme_color ?>;
    padding: 10px 15px;
    font-size: 24px;
    font-weight: 400;
    text-transform: uppercase;
    text-align: center;
    position: relative;
    padding-bottom: 10px !important;
}
.section_heding_img {
	display:block;
	width: 400px;
	margin: 0 auto 20px;
}






/*******List-Points********/
ul.print_info_list {
    margin: 0;
}
ul.print_info_list li {
    margin-bottom: 3px;
    position: relative;
    padding-left: 20px;
}
ul.print_info_list li:before {
    content: '\f0da';
    position: absolute;
    font-family: fontawesome;
    left: 0;
    color: <?= $theme_color ?>;
}
ul.print_info_list li span {
    display: inline-block;
    font-weight: 500;
}

/*******info_block********/
.print_info_block{
    margin: 0;
    border: 1px solid <?= $theme_color ?>;
    padding: 10px;
    border-radius: 5px;
    display: inline-block;
    width: 100%;
}
.print_info_block ul{
    margin: 0;
}
.print_info_block ul li {
    
    display: inline-block;
    border-left: 1px solid <?= $theme_color ?>;
}
.print_info_block ul li span {
    font-weight: 500;
    margin-right: 5px;
}

/*******print_text_bolck********/
.print_text_bolck{
    border: 1px solid <?= $theme_color ?>;
    padding: 10px;
    border-radius: 5px;
}

.print_text_bolck span ul li{
    list-style-type: disc;
}
.print_text_bolck span ol li{
    list-style-type: decimal;
}

/*******Signature_block********/
.signature_block_receiver.text-right {
    padding-top: 60px;
    padding-right: 10px;
}
section.print_signature .signature_block_authorized.text-right {
    position: absolute;
    right: 30px;
    bottom: 15px;
}


/*******amount_block********/
.print_amount_block{
    margin: 0;
    border: 1px solid <?= $theme_color ?>;
    padding: 10px;
    border-radius: 5px;
    display: inline-block;
    width: 100%;
}
.print_amount_block ul{
    margin: 0;
}
.print_amount_block ul li {
    
    display: inline-block;
    border-left: 1px solid <?= $theme_color ?>;
    position : relative;
}
.print_amount_block ul li span {
    font-weight: 500;
    margin-right: 5px;
    position:absolute;
    left:15px;
}



@media print {
div.section_heding{
   page-break-after: avoid;
}
}



/*******per print********/


/*******Quotation********/

.print_single_accomodation_hotel {
    background: #f3f3f3;
    border-radius: 5px;
    padding: 20px;
    border: 1px solid #e8e8e8
}
.print_acco_hotel_image {
    box-shadow: 0px 0px 2px 1px #c5c5c5;
    padding: 2px;
    background: #fff;
    margin-bottom: 20px;
}
.print_acco_hotel_image img {
    height: 100px;
    margin: 0 auto;
}
.print_acco_hotel_detail ul {
    padding: 0;
    margin: 0;
}
.print_acco_hotel_detail ul li {
    
    margin-bottom: 5px;
}
li.print_acco_hotel_name {
    font-weight: 500;
    font-size: 16px;
    text-transform: uppercase;
    height: 23px;
    overflow: hidden;
}
li.print_acco_hotel_star {
    font-weight: 500;
    color: #f76600;
    font-size: 14px;
    margin-top: -5px;
    margin-bottom: 10px !important;
}
.print_acco_hotel_detail ul li span {
    font-weight: 500;
}
.acco_hotel_btn button {
    background: <?= $theme_color ?>;
    color: #fff;
    padding: 7px 10px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 3px !important;
    transition: 0.5s;
}
.acco_hotel_btn button:hover {
    background: #fff;
    color: <?= $theme_color ?>;
}


li.print_single_itinenary {
    
    position: relative;
    margin: 42px 0 0 45px;
    padding: 30px 0 35px 58px;
    border-left: 1px solid <?= $theme_color ?>;
}
li.print_single_itinenary:before {
    position: absolute;
    content: '';
    height: 15px;
    width: 15px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50%;
    left: 0px;
    top: 50%;
    margin-top: -8px;
}
li.print_single_itinenary:last-child:after {
    position: absolute;
    content: '';
    height: 15px;
    width: 15px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50%;
    left: -8px;
    bottom: -14px;
}
li.print_single_itinenary .print_itinenary_count {
    position: absolute;
    left: -45px;
    top: -43px;
    height : 44px;
    width: 90px;
    text-align: center;
}
.print_itinenary_desciption {
    width: 61.7%;
    position: relative;
}
.print_itinenary_desciption:before {
    position: absolute;
    content: '';
    width: 43px;
    height: 1px;
    border-top: 1px solid <?= $theme_color ?>;
    left: -44px;
    top: 50%;
    margin-top: 1px;
}
.print_itinenary_desciption p {
    text-align: justify;
}
.print_itinenary_attraction{
    margin-bottom: 5px;
}
span.print_itinenary_attraction_icon {
    float: left;
    width: 30px;
    height: 30px;
    text-align: center;
    border: 1px solid <?= $theme_color ?>;
    line-height: 30px;
    border-radius: 50%;
}
samp.print_itinenary_attraction_location {
    line-height: 30px;
    margin-left: 10px;
    font-weight: 500 !important;
    font-family: 'Roboto', sans-serif !important;
}
.print_itinenary_details {
    position: absolute;
    left: 67.5%;
    top: 50%;
    width: 200px;
    margin-top: -54px;
}
.print_itinenary_details:before {
    position: absolute;
    content: '';
    width: 23px;
    height: 1px;
    border-top: 1px solid <?= $theme_color ?>;
    left: -23px;
    top: 50%;
    margin-top: 1px;    
}
.print_itinenary_details .print_info_block ul li span {
    float: left;
    height: 25px;
}
.print_quotation_creator {
    margin-top: 30px;
}
.print_quotation_creator span {
    font-weight: 500;
}
.print_sigthseing .print_sigthseing_images img{
    max-height:150px;
}


table.salary_table td{
    padding: 8px 8px 5px 28px !important;
}