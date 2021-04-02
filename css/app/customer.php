<?php
include_once('../../model/model.php');
header("Content-type: text/css");

global $theme_color, $theme_color_dark, $theme_color_2, $topbar_color, $sidebar_color;
?>
.dashboard_dual_stat{
	background: #fff;
	width: 100%;
	float: left;
	position: relative;
	z-index: 1;
	min-height: 98px;
	display: table;
	border-top:2px solid <?= $theme_color ?>;
	box-shadow: 2px 3px 2px #D7D7D7;
}
.dashboard_dual_stat .wrap1, .dashboard_dual_stat .wrap2{
	padding:5px;
	width: 50%;
	text-align: center;
	display: table-cell;
	vertical-align: middle;
}
.dashboard_dual_stat .wrap1{
	background: #fff;
}
.dashboard_dual_stat .wrap2{
	background: #efefef;
}
.dashboard_dual_stat .sub-text{
	font-size: 15px;
}
.dashboard_dual_stat .title{
	color: #656565;
}
.dashboard_dual_stat i{
	position: absolute;
	bottom:10px;
	right: 10px;
	font-size: 35px;
	color: #ffe6e6;
	z-index: -1;
}


.customer_tabs ul, .customer_tabs li{
	margin: 0;
	padding:0;
}
.customer_tabs a, .customer_tabs a:hover, .customer_tabs a:active{
	text-decoration: none;
}
.customer_tabs .tabs li{
	display: inline;
	padding:8px 15px;
	background: #4e5d65;
	margin-right: 15px;
	border: 1px solid #4e5d65;
	cursor: pointer;
}
.customer_tabs .tabs li a{
	color: #fff;
	font-size: 14px;
	font-weight: 600;
}
.customer_tabs .tabs li.active{
	background: #fff;
	border-bottom: 1px solid #fff;
}
.customer_tabs .tabs li.active a{
	color: #333;
}
.customer_tabs .tab-content .tab{
	display: none;
}
.customer_tabs .tab-content .tab.active{
	display: block;
}
.customer_tabs .tab-content{
	border: 1px solid #4e5d65;
	padding: 20px;
	margin-top: 6px;
	margin-bottom: 20px; 
	background: #fff;
}

.customer_tabs .customer_pan{
	padding-top: 35px;
	position: relative;
}
.customer_tabs .customer_badge{
	position: absolute;
	top: 0;
	left: 0;
	padding: 3px 10px;
	background: #ddd;
	color: #333;
	font-weight: 600;
}
.customer_tabs .customer_badge_right{
	position: absolute;
	top: 0;
	right: 0;
	padding: 3px 10px;
	background: #ddd;
	color: #333;
	font-weight: 600;
}



.sing_fourth_coming{
	border: 1px solid #f5e9e9;
}
.fourth_cmg_att_content .head{
    padding: 5px;
    font-size: 18px;
    font-weight: 400;
    text-transform: capitalize;
    color: #424242;
}
.fourth_cmg_att_content .body {
    padding: 15px;
    background: #fff;
    color: #484848;
}
.fourth_cmg_att_content .footer {
    padding: 5px;
    color: #a2a2a2;
}

.cust_dash_stat{
	width: 100%;
    float: left;
    text-align: center;
    border-right: 1px solid #f1f1f1;
    background: #fff;
    padding: 10px;
    border-top: 2px solid #36aae7;
    box-shadow: 1px 1px 6px #ddd;
    margin-bottom: 10px;
}
.cust_dash_stat:last-child{
	border-right: 0;
}

.feedback td{
	    line-height: 26px;
}

.feedback th{
	    line-height: 30px;
}
 
.feedback_option_lable{
	padding: 0 25px 0 5px;
}