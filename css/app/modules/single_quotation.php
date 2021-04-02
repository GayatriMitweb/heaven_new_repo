<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
global $theme_color;
?>
#mainheader {display:block;}
#printheader {display:none;}

body{
    margin:0;
    padding:0;
    background: #ffffff;
    font-family: 'Roboto', sans-serif;
}
.navbar-default {
    background-color: #ffffff !important;
    border-color: #f0f0f0;
    margin-bottom: 0;
}
span.highlight {
    font-weight: 600 !important;
}

    
.nav.goToTop {
  position: fixed;
  top: 0;
  height: 38px;
  z-index: 1;
  transition:0.5s;
  width: 100%;
}


.Header_Top {
    background: #f5f5f5;
    padding: 5px 0;
    border-bottom: 1px solid #dadada;
}
ul.company_contact {
    padding: 0;
    text-align: right;
    margin: 0;
}
ul.company_contact li {
    list-style-type: none;
    display: inline-block;
    margin: 0 10px;
    line-height: 30px;
    font-size: 14px;
}
ul.company_contact li a {
    text-decoration: none !important;
    color: #22262e;
}
ul.company_contact li i {
    color: <?= $theme_color ?>;
    font-size: 18px;
    margin-right: 3px;
}


.navbar-header {
    float: left;
    width: 100%;
}
a.navbar-brand {
    height: 85px;
    padding: 0px;
    font-size: 38px;
    line-height: 70px;
    font-weight: 600;
    margin-top: 5px;
}
.logo_right_part h1 {
    text-align: right;
    margin: 0;
    padding: 31px 0;
    color: <?= $theme_color ?>;
    font-weight: 500;
    font-size: 26px;
}


.collapse.navbar-collapse{
    float: left;
    width: 100%;
    background: <?= $theme_color ?>; 
    position: relative;
}
.collapse.navbar-collapse:before {
    position: absolute;
    content: '';
    height: 40px;
    width: 100%;
    background: <?= $theme_color ?>;
    left: -98%;
}
.collapse.navbar-collapse:after {
    position: absolute;
    content: '';
    height: 40px;
    width: 100%;
    background: <?= $theme_color ?>;
    right: -98%;
}
ul.nav.navbar-nav li a {
    line-height: 40px;
    transition: 0.5s;
    color: #ffffff;
    padding: 0 18px;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
}
ul.nav.navbar-nav li.active a, ul.nav.navbar-nav li:hover a {
    background: rgba(0, 0, 0, 0.16) !important;
    color: #fff !important;
}
ul.nav.navbar-nav li.active a {
    position: relative;
}
ul.nav.navbar-nav li.active a:before {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 10px 10px 0 10px;
    border-color: <?= $theme_color ?> transparent transparent transparent;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
}
ul.nav.navbar-nav li.active a:after {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 10px 10px 0 10px;
    border-color: rgba(0, 0, 0, 0.16) transparent transparent transparent;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
}



.link_page_section {
    padding: 30px 0;
}
.sec_heding h2 {
    margin: 0;
    color: <?= $theme_color ?>;
    padding: 10px 15px;
    font-size: 24px;
    font-weight: 400;
    text-transform: uppercase;
    text-align: center;
    position: relative;
    padding-bottom: 50px;
}
.sec_heding h2:after {
    position: absolute;
    content: '';
    width: 400px;
    height: 30px;
    left: 50%;
    margin-left: -200px;
    bottom: 10px;
    background-image: url(../../../images/heading_border.png);
    background-size: contain;
    background-repeat: no-repeat;
}



ul.pack_info {
    margin: 0;
}
ul.pack_info li {
    list-style-type: none;
    font-weight: 500;
    margin-bottom: 10px;
    position: relative;
    padding-left: 20px;
}
ul.pack_info li:before {
    content: '\f0da';
    position: absolute;
    font-family: fontawesome;
    left: 0;
    color: <?= $theme_color ?>;
}
ul.pack_info li span {
    display: inline-block;
    width: 120px;
    font-weight: 600;
}
.adolence_info ul {
    margin: 0;
    border: 1px solid <?= $theme_color ?>98;
    padding: 10px;
    border-radius: 5px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.adolence_info ul li {
    list-style-type: none;
    display: inline-block;
    border-right: 1px solid <?= $theme_color ?>;
}
.adolence_info ul li:last-child {
    border-right: 0;
}
.adolence_info ul li span {
    font-weight: 500;
    margin-right: 5px;
}



.app_accordion .panel-group .panel{
    margin-bottom:2px;
}
.app_accordion div.panel-heading {
    color: #333;
    background-color: #f3f3f3;
    border-radius: 0;
    font-weight: 500;
    padding: 0;
    line-height: 40px;
}
.app_accordion div.panel-heading span em{
    font-style: normal;
}
.app_accordion .Normal {
    position: relative;
}
.app_accordion .Normal:after {
    position: absolute;
    content: '\f106';
    font-family: fontawesome;
    right: 15px;
    top: 6px;
    font-size: 24px;
    height: 27px;
    width: 27px;
    text-align: center;
    line-height: 23px;
    border-radius: 50%;
    color: #fff;
    background: <?= $theme_color ?> -webkit-radial-gradient(center 75%, ellipse contain, #ffffff, rgba(255, 255, 255, 0.29) 60%);
    box-shadow: inset 0 0px 6px rgba(0, 0, 0, 0.4), inset 0 -1px 6px rgba(0, 0, 0, 0.4), inset 0 8px 3px rgba(0, 0, 0, 0.13), inset 0 10px 3px rgba(255,255,255,.1), 0 0px 0px rgba(0, 0, 0, 0.45); 
}
.app_accordion .Normal.collapsed:after {
    position: absolute;
    content: '\f106';
    font-family: fontawesome;
    right: 15px;
    top: 6px;
    font-size: 24px;
    height: 27px;
    width: 27px;
    text-align: center;
    line-height: 18px;
    border-radius: 50%;
    color: #fff;
    background: <?= $theme_color ?> -webkit-radial-gradient(center 75%, ellipse contain, #ffffff, rgba(255, 255, 255, 0.29) 60%);
    box-shadow: inset 0 0px 6px rgba(0, 0, 0, 0.4), inset 0 -1px 6px rgba(0, 0, 0, 0.4), inset 0 8px 3px rgba(0, 0, 0, 0.13), inset 0 10px 3px rgba(255,255,255,.1), 0 0px 0px rgba(0, 0, 0, 0.45); 
    top: 6px;
    transform: rotate(180deg);
}





.single_accomodation_hotel {
    background: #f3f3f3;
    border-radius: 5px;
    padding: 20px;
    border: 1px solid #e8e8e8
}
.acco_hotel_image {
    box-shadow: 0px 0px 2px 1px #c5c5c5;
    padding: 2px;
    background: #fff;
    margin-bottom: 20px;
}
.acco_hotel_detail ul {
    padding: 0;
    margin: 0;
}
.acco_hotel_detail ul li {
    list-style-type: none;
    margin-bottom: 5px;
}
li.acco-_hotel_name {
    font-weight: 500;
    font-size: 15px;
    text-transform: uppercase;
    max-height: 25px;
    overflow: hidden;
}
li.acco-_hotel_star {
    font-weight: 500;
    color: #f76600;
    font-size: 14px;
    margin-top: -5px;
    margin-bottom: 10px !important;
}
.acco_hotel_detail ul li span {
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


.in_ex_tab ul.nav.nav-tabs {
    border: 0;
}
.in_ex_tab ul.nav.nav-tabs li a {
    margin: 0;
    padding: 10px;
    border: 0;
    font-size: 18px;
    font-weight: 300;
    transition: 0.5s;
    min-width: 135px;
    text-align: center;
    font-family: 'Roboto', sans-serif;
    text-transform: uppercase;
    color:#555;
    border: 1px solid transparent;
}
.in_ex_tab ul.nav.nav-tabs li.active a {
    border-bottom: 0;
    color: #fff;
}
.in_ex_tab ul.nav.nav-tabs li.active a[href="#home"], .in_ex_tab ul.nav.nav-tabs li.active a[href="#terms"] {
    background: green;
    border: 1px solid green;
}
.in_ex_tab ul.nav.nav-tabs li.active a[href="#profile"] {
    background: red;
    border: 1px solid red;
}
.in_ex_tab .tab-content div[id="home"], .in_ex_tab .tab-content div[id="terms"] {
    padding: 20px;
    border: 1px solid green;
}
.in_ex_tab .tab-content div[id="profile"] {
    padding: 20px;
    border: 1px solid red;
}
.in_ex_tab .tab-content pre {
    background: transparent;
    border: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
}


.feedback_btn button {
    padding: 10px;
    width: 190px;
    border-radius: 3px;
    color: #fff;
    transition: 0.5s;
    background: <?= $theme_color ?>;
    border: 1px solid <?= $theme_color ?>;
}
.feedback_btn.succes button:hover{
    background: green;
    border: 1px solid green;
   
}
.feedback_btn.danger button:hover{
    background: red;
    border: 1px solid red;
    
}
.feedback_btn.info button:hover{
    background: #fff;
    color:<?= $theme_color ?>;   
}






footer.main_block {
    background: <?= $theme_color ?>;
}
.footer_part {
    background: rgba(0, 0, 0, 0.4);
    padding: 10px 0;
    color: #fff;
}
.footer_company_cont p {
    margin-bottom: 0;
    line-height: 21px;
}
.footer_company_cont p i {
    font-size: 16px;
    margin-right: 5px;
}




.acco_hotel_slider_moal .modal-content {
    border: 4px solid <?= $theme_color ?>;
    background: <?= $theme_color ?>;
}
.acco_hotel_slider_moal .modal-body {
    position: relative;
    padding: 3px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 5px;
}
.acco_hotel_slider_moal .owl-controls.clickable {
    margin: 0;
}
.acco_hotel_slider_moal button.close {
    position: absolute;
    top: -15px;
    right: -15px;
    background: <?= $theme_color ?>;
    z-index: 999;
    opacity: 1;
    color: #fff;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    border-radius: 50%;
}
.acco_hotel_slider_moal  .owl-buttons .owl-prev:before, .acco_hotel_slider_moal .owl-buttons .owl-next:before{
    display:none;
}
.acco_hotel_slider_moal .owl-prev, .acco_hotel_slider_moal .owl-next {
    background: #fff !important;
    color: #606060 !important;
    opacity: 0.6 !important;
    border-radius: 5px !important;
    font-size: 21px !important;
    padding: 0px 14px !important;
    border: 1px solid #a09d9d;
    line-height: 26px !important;
    margin-top: -14px !important;
    position: absolute;
    top: 50%;
}
.acco_hotel_slider_moal .owl-prev {
    left: -28px;
}
.acco_hotel_slider_moal .owl-next {
    right: -28px !important;
}



#single_img_modal button.close {
    position: absolute;
    top: -15px;
    right: -15px;
    background: <?= $theme_color ?>;
    z-index: 999;
    opacity: 1;
    color: #fff;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    border-radius: 50%;
}
.Sightseeing_img_block.main_block {
    position: relative;
    border: 1px solid <?= $theme_color ?>;
    width: 100%;
    max-height: 190px;
    overflow: hidden;
    cursor: pointer;
}
.Sightseeing_img_block.main_block img {
    transition: 0.5s;
    width: 100%;
    height: auto;
}
.Sightseeing_img_block.main_block:hover img {
    transform: scale(1.5);
}
.Sightseeing_img_block.main_block:after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.65);
    left: 0;
    top: 0;
    opacity: 0;
    transition: 0.5s;
}
.Sightseeing_img_block.main_block:hover:after{
    opacity: 1;
}
.Sightseeing_img_block.main_block:before {
    content: '+';
    position: absolute;
    font-size: 40px;
    top: 50%;
    margin-top: -30px;
    left: 20%;
    margin-left: -11px;
    color: #fff;
    opacity: 0;
    transition: 0.5s;
}
.Sightseeing_img_block.main_block:hover:before {
    z-index: 1;
    left: 50%;
    opacity: 1;
    transform: rotate(360deg);
}



/**Pkg Quotation acordian***/
.package_selector {
    float: left;
    padding: 10px 10px 0 0;
}
.package_content {
    float: left;
    width: 97%;
}



/***Quotation Responsive***/

@media screen and (max-width:1200px){
ul.nav.navbar-nav li a {
    padding: 0 9px;
}
}
@media screen and (max-width:992px){
.sm_r_brd_r8 {
    border-right: 0 !important;
}

ul.nav.navbar-nav li a {
    display: none;
}
ul.nav.navbar-nav{
    width:100%;
    height:1px;
}
.collapse.navbar-collapse:before, .collapse.navbar-collapse:after {
    display:none;
}
}
@media screen and (max-width:767px){
.adolence_info ul li {
    border-right: 0;
}
.Sightseeing_img_block.main_block {
    max-height: 244px;
}
}
@media screen and (max-width:520px){
ul.company_contact {
    text-align: left;
}
.single_quotation_head a.navbar-brand {
    width: 100%;
}
.single_quotation_head a.navbar-brand img {
    width: 200px;
    margin: 0 auto;
}
.logo_right_part {
    float: left;
    width: 100%;
}
.logo_right_part h1 {
    text-align: center;
    font-size: 21px;
    padding: 0 0 9px 0;
}
.sec_heding h2 {
    font-size: 18px;
}
ul.pack_info {
    padding: 0;
}
}