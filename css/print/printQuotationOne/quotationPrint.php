<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
?>

    
.print_header span.title {
    margin: 0;
    padding: 0;
    color: <?= $theme_color ?> !important;
    font-weight: 500;
    font-size: 18px;
}
.print_header span.title i:before{
    color: <?= $theme_color ?> !important;
}
.section_heding h2 {
    margin: 0;
    color: <?= $theme_color ?>;
    padding: 10px 15px;
    font-size: 18px;
    font-weight: 400;
    text-transform: uppercase;
    text-align: center;
    position: relative;
    padding-bottom: 10px !important;
}
.section_heding_img {
	display:block;
	width: 300px;
	margin: 0 auto 20px;
}
.headerImage img {
    height: 300px;
}
.subTitle h3 {
    margin: 8px 0;
    font-size: 16px;
    text-transform: uppercase;
}


/*******List-Points********/
ul.print_info_list {
    margin: 0;
}
ul.print_info_list li {
    list-style-type: none;
    margin-bottom: 3px;
    position: relative;
    padding-left: 20px;
    border-left: 0 !important;

}
ul.print_info_list li:before {
    content: '\f0da';
    position: absolute;
    font-family: fontawesome;
    left: 0;
    color: <?= $theme_color ?> !important;
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
    list-style-type: none;
    display: inline-block;
    position: relative;
}
.print_info_block li:before {
    content: '\f101';
    position: absolute;
    font-family: fontawesome;
    left: -0px;
    color: <?= $theme_color ?> !important;
}
.print_info_block ul li span {
    font-weight: 500;
    margin-right: 5px;
}
.print_info_block .print_quo_detail_block i:before{
    color: <?= $theme_color ?> !important;
}

/*******print_text_bolck********/
.print_text_bolck{
    border: 1px solid <?= $theme_color ?>;
    padding: 10px;
    border-radius: 5px;
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
    list-style-type: none;
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
    list-style-type: none;
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


section.print_single_itinenary {
    list-style-type: none;
    position: relative;
    margin: 45px 0 0px 30px;
    padding: 10px 0 0px 58px;
    border-left: 1px solid <?= $theme_color ?>;
}
section.print_single_itinenary:before {
    position: absolute;
    content: '';
    height: 15px;
    width: 15px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50%;
    left: 0px;
    top: 50%;
    margin-top: 0px;
}
section.print_single_itinenary.last-child:after {
    position: absolute;
    content: '';
    height: 15px;
    width: 15px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50%;
    left: -8px;
    bottom: -14px;
}
section.print_single_itinenary .print_itinenary_count {
    position: absolute;
    left: -45px;
    top: -43px;
    height : 44px;
    width: 90px;
    text-align: center;
    font-weight : 500;
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
    margin-top: -50px;
}
.print_itinenary_details:before {
    position: absolute;
    content: '';
    width: 21px;
    height: 1px;
    border-top: 1px solid <?= $theme_color ?>;
    left: -20px;
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

.headerImage {
    position: absolute;
}
.headerImageOverLay {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    background-color: rgba(255, 255, 255, 0.9) !important;
}



@media print {
    table tr.table-heading-row th, table tfoot tr td, .headerImageOverLay{
        -webkit-print-color-adjust: exact; 
    }
}