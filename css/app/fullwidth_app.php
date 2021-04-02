<?php
include_once('../../model/model.php');
header("Content-type: text/css");

global $theme_color, $theme_color_dark, $theme_color_2, $topbar_color, $sidebar_color;
?>
small {
    font-size: 11px;
}
.app_wrap{
	background: #fff;
	position: relative;
	min-height: 300px;
}

.legend_pan{
	position: relative;
    padding-top: 13px;
}
.legend_text{
	position: absolute;
    top: -22px;
    z-index: 1;
    background: #fff;
}

@media screen and (max-width:768px){
	.app_container{
		padding:0;
	}
	.app_logo {
	    height: 70px;
	    width: 70px;
	    border-radius: 0%;
	    top: 11px;
	    left: 21px;
	}
	.app_wrap {
		margin-top:0;
	}
}

/*****************Booking form css start******************/
.bk_tab_head{
	padding: 20px;
	text-align: center;
	float: left;
	width: 100%;
	background: <?= $theme_color ?>;
}
.bk_tab_head ul, .bk_tab_head li{
	margin: 0;
	padding:0;
	display: inline;
}
.bk_tab_head li{
	margin-left: 10px;
	margin-right: 10px;
    width: 184px;
    display: inline-block;
}
.bk_tab_head li a{
	display: inline-block;
	text-decoration: none;
	color: #777;
}
.bk_tab_head li a:hover{
	text-decoration: none;
}
.bk_tab_head li .num{
	height: 40px;
    width: 40px;
    border: 4px solid #0000004a;
    color: #fff;
    border-radius: 50%;
    display: inline-block;
    font-size: 17px;
    line-height: 32px;
    margin-right: 8px;
    position: relative;
}
.bk_tab_head li .num i{
    display: none;
    color: #fff;
    position: absolute;
    left: 8px;
    top: 7px;
}
.bk_tab_head li:not(:last-child) .num:after{
    content: "";
    position: absolute;
    top: 14px;
    left: 33px;
    height: 4px;
    width: 87px;
    background: #0000004a;
}
.bk_tab_head li:not(:first-child) .num:before{
    content: "";
    position: absolute;
    top: 14px;
    right: 33px;
    height: 4px;
    width: 87px;
    background: #0000004a;
}

.bk_tab_head li .text{
	font-size: 14px;
	margin-top: 6px;
    display: inline-block;
    color:#fff;
}
.bk_tab_head li a.active .num{
	border-color: #fff;
}
.bk_tab_head li a.done .num{
	background-color:<?= $theme_color ?>;
	color:<?= $theme_color ?>;
}
.bk_tab_head li a.done .num i{
	display:initial;
	color:#fff;
}
.bk_tab_head li a.active .num:after{
	background:#fff;
}
.bk_tab_head li a.active .num:before{
	background:#fff;
}
.bk_tab_head li a.active .text{

}

.bk_tabs .bk_tab{
	display: none;
}
.bk_tabs .bk_tab.active{
	display: block;
}
@media screen and (max-width:992px){
	.bk_tab_head li{
	    width: 54px;
	}
	.bk_tab_head li:not(:last-child) .num:after{
		display:none;		
	}
	.bk_tab_head li:not(:first-child) .num:before{
		display:none;
	}
	.bk_tab_head li a .text{
		display:none;		
	}	
}

#div_seats_availability{
	display:inline-block;
	padding:0 15px;
}
.seat_availability{
	color: #fff;
    padding: 7px 25px;
    display:inline-block;
    margin-right:-4px;
}
.bk_payment_wrap .row{
	padding-left:10px;
}
.bk_payment_wrap .chk_wrap{
    position: absolute;
    top: 20px;
    left: -9px;
}
#ul_site_seeing_list {
	height:300px; 
	overflow-y:scroll;
	resize: vertical;
}
#tbl_package_tour_schedule_wrap {
	height:300px; 
	overflow-y:scroll;
	resize: vertical;
}
#ul_site_seeing_list li{
	z-index:9;
 	padding:5px;
 	font-size:13px;
 	cursor: move;
 	width:100%;
}
#tbl_package_tour_schedule textarea{
	font-size: 14px;
}
/*****************Booking form css end******************/

.app_panel .app-btn-group button{
	font-size: 14px;
    border: 0;
    background: #2982b1;
}


h5.booking-section-heading {
    font-size: 21px;
    color: <?= $theme_color ?>;
    font-weight: 400;
    border-bottom: 1px solid #f0f0f0;
    margin-top: 25px;
    padding-bottom: 10px;
    text-transform: capitalize;
}

.panel.bg_light legend {
    text-transform: capitalize;
}


/*****************Header******************/

.fullwidth_header {
    background: #ffffff;
    height: 60px;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 6;
    border-bottom: 2px solid #eaeaea;
}
.fullwidth_header .logo_wrap {
    float: left;
    height: 100%;
    width: 240px;
}
.fullwidth_header .logo_wrap img {
    height: 100%;
    max-width: 100%;
}

.app_ico_wrap ul li a{
    border:1px solid <?= $theme_color ?>;
}
.app_ico_wrap ul li{
    display: inline;
    margin: 0 5px;
}
.app_ico_wrap ul li a.btn{
    border-radius: 4px;
    border:1px solid <?= $theme_color ?>;
    width: 35px;
    height: 35px;
    text-align: center;
    padding: 10px;
}

.app_ico_wrap  ul li.financial_yr a {
    width: auto !important;
    line-height: 15px;
}


.logged_user {
    display: inline-block;
    color: <?= $theme_color ?>;
    padding: 10px 0px;
    line-height: 40px;
}
.logged_user span {
    display: inline-block;
}
.logged_user span.logged_user_id {
    margin-bottom: -15px;
}   
.logged_user span img {
    width: 40px;
    height: 40px;
    margin: 0 auto;
    border-radius: 5px;
    border: 2px solid rgba(0, 0, 0, 0.25);
}

li.logged_user_body {
    position: relative;
}
li.logged_user_body .profile_pic_block {
    position: absolute;
    width: 230px;
    background: #009898;
    color: #fff;
    padding: 3px;
    left: -25px;
    top: 38px;
    display: none;
    transition: 0.5s;
}
.profile_pic_block:before {
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 5px 10px 5px;
    border-color: transparent transparent <?= $theme_color ?> transparent;
    position: absolute;
    top: -10px;
    left: 40px;
}
.profile_pic_block .upload {
    position: absolute;
    bottom: 0px;
    width: 100%;
    text-align: center;
    background: rgba(0, 0, 0, 0.73);
    left: 0;
    padding: 5px;
}
.profile_pic_block .upload i {
    margin-right: 5px;
    color: #fff !important;
}
.profile_pic_block .close_profile_pic {
    position: absolute;
    top: 0px;
    right: 0px;
    font-size: 18px;
    color: #fff !important;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.2);
    padding: 4px;
}
.profile_pic_block .close_profile_pic i {
    color: #fff !important;
}
.profile_pic_block_display{
    display : inline-block !important; 
}



input.labelauty + label, input.labelauty:checked + label, input.labelauty:checked:not([disabled]) + label:hover{
    background-color:<?= $theme_color ?>;
}
input.labelauty + label, input.labelauty:checked:not([disabled]) + label:hover{
    background-color:<?= $theme_color ?>;
}


@media screen and (max-width: 767px){
.fullwidth_header ul.dropdown-menu {
    padding: 0;
}
.fullwidth_header ul.dropdown-menu li {
    display: block;
    margin: 0;
}
.fullwidth_header ul.dropdown-menu pre.xs_show {
    padding: 0 0 0 8px;
    margin: 0;
    background: transparent;
    border: 0;
}
.fullwidth_header ul.dropdown-menu li a.btn {
    width:100%;
    border-radius: 0;
}
.fullwidth_header ul.dropdown-menu li a.btn i{
    float:left;
}
.bk_tab_head li {
    width: 40px;
}
}
