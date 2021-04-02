<?php
include_once('../../model/model.php');
header("Content-type: text/css");

global $theme_color, $theme_color_dark, $theme_color_2, $topbar_color, $sidebar_color;

$success = "#449d44";
$info = "#33b5e5";
$danger = "#ff5b5b";
$primary = "#5d93e4";
$yellow = "#FFC107";
?>
html, body{
	margin:0;
	padding:0;
	background: #ffffff;
	font-family: 'Roboto', sans-serif;
}
.theme_col{ color:<?= $theme_color ?>; }
.theme_col_dark{ color:<?= $theme_color ?>; }
.theme_col_2{ color:<?= $theme_color_2 ?>; }
.theme_feild{ border-color:<?= $theme_color ?> !important; color:<?= $theme_color ?>;}

.bg_light{ background: #f5f5f5 }
.bg_white{ background: #fff }

.success-col{ color:<?= $success ?>; }
.info-col{ color:<?= $info ?>; }
.danger-col{ color:<?= $danger ?>; }
.primary-col{ color:<?= $primary ?>; }

.success_bg{ background:<?= $success ?>; }
.info_bg{ background:<?= $info ?>; }
.danger_bg{ background:<?= $danger ?>; }
.primary_bg{ background:<?= $primary ?>; }

::placeholder {
  text-transform : none;
}
.main_block{
	float: left;
	width:100%;
}
.no-pad{
	padding:0 !important;
}
.no-marg{
	margin:0 !important;
}
.xs_show{
    display:none;
}
small {
    font-size: 11px;
}
.text_caps{
    text-transform: uppercase;
}
a{
    text-decoration : none !important;
}
/***App Fonts start***/
table {
    font-family: 'Noto Sans', sans-serif;
    margin-top: 20px !important;
}
.btn, button{
	font-family: 'Raleway', sans-serif;
}
table input[type="text"]{
	min-width:60px;
}
table select{
	min-width:70px;
	width:1em;
}
table input[maxlength="15"]{
	width: 50px;
}
/***App Fonts end***/

.table {
    border-bottom: 1px solid #ddd;
    font-family: 'Roboto', sans-serif;
}
table tr.table-heading-row,  table tfoot tr{
    background: #f7f7f7;
}
table th, .modal table.dataTable th{
    font-size: 13px;
	padding-left: 28px !important;
    text-transform: uppercase;
    font-weight: 500;
    border: 0 !important;
    border-bottom: 1px solid #ddd !important;
    border-top: 1px solid #ddd !important;
}
table tr.table-heading-row td{
    font-size: 14px;
    padding-left: 5px !important;
    text-transform: uppercase;
    font-weight: 500;
    border: 0 !important;
    border-bottom: 1px solid #ddd !important;
    border-top: 1px solid #ddd !important;
}
table th:after {
    left: 8px;
    width: 20px;
}
tr.even {
    background-color: rgba(0, 0, 0, 0.02);
}
.table-hover>tbody>tr:hover {
    background-color: #e5ffe773;
}
.table td, .modal table.dataTable td {
    border: 0 !important;
    font-size: 13px;
    font-weight: 400;
    color: #22262E;
    padding: 15px 8px 10px 28px !important;
}
.table .btn-info{
    background: transparent !important;
    color: <?= $theme_color ?>;
    padding: 0;
    padding-left: 5px;
    font-size: 16px;
}
.table .btn-info:hover, .table .btn-danger:hover, .table .btn-warning:hover{
    box-shadow: none;
}
.table .btn-info a i{
    color: <?= $theme_color ?>;
    font-size: 16px;
}
.table button i, .table .btn-info i, .table .btn-danger i, .table .btn-warning i{
    padding: 8px;
    border-radius: 50%;
    transition: 0.5s;
}
.table .btn-danger i {
    padding: 8px 9.7px;
}
.table button:hover i, .table .btn-info:hover i {
    background: <?= $theme_color ?>;
    color: #ffffff;
}

.table .btn-danger {
    background: transparent !important;
    padding: 0;
    padding-left: 5px;
    font-size: 16px;
    color: #CC0000;
}
.table .btn-danger:hover i {
    background: #CC0000 !important;
    color: #ffffff;
}


.table .btn-warning {
    background: transparent !important;
    padding: 0;
    padding-left: 5px;
    font-size: 16px;
    color: #FF8800;
}
.table .btn-warning:hover i {
    background: #FF8800 !important;
    color: #ffffff;
}

table .table-danger-btn {
    font-size: 12px !important;
    padding: 6px 12px 6px 34px !important;
    margin-top: 0 !important;
}
.table .btn-danger.table-danger-btn:hover i {
    background: transparent !important;
}

/* Table Scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 12px;
    width: 10px;
    cursor: pointer;
}
.table-responsive::-webkit-scrollbar-track {
      background-color: #eeeeee;
} /* the new scrollbar will have a flat appearance with the set background color */
 
.table-responsive::-webkit-scrollbar-thumb {
      background-color: #7b7b7b; 
      cursor: pointer;
} /* this will style the thumb, ignoring the track */
 
.table-responsive::-webkit-scrollbar-button {
      background-color: #7b7b7b;
      width:5px;
      cursor: pointer;
} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */
 
.table-responsive::-webkit-scrollbar-corner {
      background-color: black;
      border-radius:25px;
}

/* Modal table scrollbar */
.modal-content .table-responsive::-webkit-scrollbar {
    height: 12px;
    width: 10px;
    cursor: pointer;
}
.modal-content .table-responsive::-webkit-scrollbar-thumb {
      background-color: #7b7b7b; 
      cursor: pointer;
} /* this will style the thumb, ignoring the track */
 
.modal-content .table-responsive::-webkit-scrollbar-button {
      background-color: #7b7b7b;
      width:5px;
      cursor: pointer;
} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */
 




#cssmenu > ul > li > a {
    background: <?= $theme_color ?>;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}


/*******App Alrts********/
.vi_alert_parent .item {
    padding: 10px 20px 10px 60px;
    color: rgba(0,0,0,.87);
    box-shadow: 0 8px 10px -5px rgba(0,0,0,.2), 0 16px 24px 2px rgba(0,0,0,.14), 0 6px 30px 5px rgba(0,0,0,.12);
}
.vi_alert_parent .item:before {
    position: absolute;
    content: '';
    height: 25px;
    width: 25px;
    background-size: contain;
    background-repeat: no-repeat;
    left: 20px;
    top: 15px;
}
.vi_alert_parent .item.success:before {
    background-image: url(../../images/alert_success.png);
}
.vi_alert_parent .item.error:before {
    background-image: url(../../images/alert_error.png);
}
.vi_alert_parent .item.success, .vi_alert_parent .item.error {
    background: #ffffff;
}

/*******App Button start********/
.app_btn{
    background: <?= $theme_color ?>;
    border: 1px solid <?= $theme_color ?>;
    color: #fff;
    font-size: 15px;
    padding: 5px 18px;
    position:relative;
    transition:0.4s;
}
.app_btn.ico_left{
	padding-left:34px;
}
.app_btn.ico_left i{
	position:absolute;
	left:0;
	top:0;
	height:100%;
	padding:7px 10px;
	background:#3897ca;
}
.app_btn:active, .app_btn:hover, .app_btn:focus{
	outline:none;
}
.app_btn:hover{
	opacity:0.9;
	transition:0.4s;
}
.app_btn:after {
    content: "";
    position:absolute;
    background:#ddd;
    opacity:0.3;
    top:50%;
    left:50%;
    width:0;
    height:0;
    transition: all 0.1s
}
.app_btn:active:after {
	top:0;
	left:0;
    width:100%;	
    height:100%;	
    transition: 0.1s;
}

.app_btn_out{
	background:#fff;
	border:1px solid <?= $theme_color ?>;
	color:<?= $theme_color ?>;
	transition:0.4s;
	box-shadow:none;
}
.app_btn_out:hover, .app_btn_out:focus{
	background:<?= $theme_color ?>;
	border:1px solid <?= $theme_color ?>;
	color:#fff;
	transition:0.4s;
}
.app_btn_out:hover i{
	color:#fff !important;
	transition:0.4s;
}

.btn-success {
    transition: .2s ease-out;
    color: #fff;
    box-shadow: none;
    padding-left: 35px;
    position: relative;
    background: #58a653 !important;
    border: 1px solid #58a653;
    border-radius: 25px !important;
    line-height: 22px;
}
.btn-success:hover {
    color: #58a653 !important;
    background-color: #fff !important;
    border-color: #58a653;
}
.btn-success i {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    padding: 10px;
}
.btn-success i:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 20px;
    right: 0;
    top: 6px;
    background: #fff;
    opacity: 0.5;
}
.btn-success:hover i:after {
    background-color: #58a653 !important;
}
table .btn-success:hover i {
    background: transparent !important;
    color: #58a653;
}

.btn-info.ico_right{
    transition: .2s ease-out;
    color: #ffffff;
    box-shadow: none;
    padding-right: 34px;
    position: relative;
    line-height: 24px;
    border-radius: 25px;
    background: #58a653 !important;
    border: 1px solid #58a653;	
}
.btn-info.ico_right:hover {
    color: #58a653;
    background: #fff !important;
}
.btn-info.ico_right i {
    position: absolute;
    right: 7px;
    top: 11px;
    height: 100%;
}
.btn-info.ico_right i:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 20px;
    right: 20px;
    top: -4px;
    background: #ffffff;
    opacity: 0.5;
}
.btn-info.ico_right:hover i:after {
    background: #58a653 !important;
}

.btn-info.ico_left{
    transition: .2s ease-out;
    color: <?= $theme_color ?>;
    box-shadow: none;
    padding-left: 34px;
    position: relative;
    line-height: 22px;
    border-radius: 25px;
    border: 1px solid <?= $theme_color ?> !important;
    font-weight: bold;	
    background: #fff;
}
.btn-info.ico_left:hover, .btn-info.ico_left:focus {
    color: #fff;
    background: <?= $theme_color ?> !important;
}
.btn-info.ico_left i{
    position: absolute;
    left: 2px;
    top: 2px;
    height: 100%;
    padding: 9px;
}
.btn-info.ico_left i:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 20px;
    right: 0;
    top: 5px;
    background: #0079a6;
    opacity: 0.5;
}
.btn-info.ico_left:hover i:after{
	background: #fff;
    opacity: 1;
}

.btn-danger.ico_left{
    transition: .2s ease-out;
    color: #CC0000;
    box-shadow: none;
    padding: 5px 10px;
    padding-left: 35px;
    position: relative;
    line-height: 24px;
    border-radius: 25px;
    border: 1px solid #CC0000 !important;
    font-weight: bold;
    background: #fff;
    font-size: 12px;
}
.btn-danger.ico_left:hover, .btn-danger.ico_left:focus {
    color: #fff;
    background: #CC0000 !important;
}
.btn-danger.ico_left i{
    position: absolute;
    left: 2px;
    top: 2px;
    height: 100%;
}
.btn-danger.ico_left i:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 20px;
    right: 0;
    top: 5px;
    background: #CC0000;
    opacity: 0.5;
}
.btn-danger.ico_left:hover i:after {
    background: #fff;
    opacity: 1;
}
.btn-danger.btn-sm.ico_left i, .btn-info.btn-sm.ico_left i, .btn-danger.ico_left i{
  padding:9px;
}

.cust_table button, .cust_table .btn{
    border: 0 !important;
}

/*******App Button end********/

input.labelauty + label, input.labelauty:checked:not([disabled]) + label:hover{
    background-color:<?= $theme_color ?>;
}

.form-control{
  border-color:#e2e2e2;
	border-radius:0;
	box-shadow:none;
}

.form-control:focus{
	box-shadow:none;

	border-color:#a8a8a8;;

}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {

    background-color: #f5f5f5;

}
.form-control-visible {
    background-color: #fff !important;
}

label{ 
	color: #656565; 	
	font-weight: 400; 
	margin-bottom:0; 
}

strong{ 
	color: #656565; 
}

.dataTables_filter label {
    position: relative;
}
.dataTables_filter label:before {
    position: absolute;
    content: '';
    right: 30px;
    top: 4px;
    opacity: 0.5;
    width: 1px;
    height: 22px;
    background: #a2a2a2;
}
.dataTables_filter label:after {
    position: absolute;
    content: '\f002';
    font-family: fontawesome;
    right: 10px;
    top: 5px;
    opacity: 0.5;
}
.dataTables_filter input {
    border-radius: 25px;
}

.dataTables_length, .dataTables_info {
    padding-left: 15px;
}
.dataTables_filter, .dataTables_paginate {
    padding-right: 15px;
}
.dataTables_paginate ul.pagination li a {
    color: <?= $theme_color ?>;
}
.dataTables_paginate ul.pagination li.active a {
    background: <?= $theme_color ?>;
    border-color: <?= $theme_color ?>;
    color: #fff;
}
.app_panel {
    float: left;
    width: 100%;
}

.app_panel .app_panel_head{

	float: left;
    width: 100%;
	background: <?= $topbar_color ?>;
	padding: 0px 10px;
    font-size: 17px;
    text-transform: uppercase;
    border: 1px solid #dddddd8f;

}
.app_panel_head h2 {
    color: #282323;
    text-transform: capitalize;
    font-size: 22px;
    padding-left: 5px;
    margin: 20px 0;
    width: 90%;
    font-weight: 300;
    font-family: 'Roboto', sans-serif;
}
.app_panel h4{
    margin: 0px !important;
    margin-bottom: 15px;
    font-size: 17px;
    color: #22262E;
    font-weight: 400;
    font-family: 'Roboto', sans-serif !important;
}
.header_btn {
    /*** width: 5%; ***/
    text-align: center !important;
}
.header_btn button {
    background: transparent;
    border: 0;
    padding: 13px 5px;
}
.header_btn button a {
    font-family: Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;
    text-decoration: none;
}
.header_btn button a i {
    color: #606060;
    background: #ffffff;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    line-height: 36px;
    text-align: center;
    border: 1px solid #d8d5d5;
    font-size: 17px;
}
.header_bottom {
    float: left;
    width: 100%;
    background: <?= $topbar_color ?>;
    border-left: 0;
    border-right: 0;
    padding: 9px 15px;
    border-bottom: 0;
}

.app_panel .app_panel_content{

	float: left;
    width: 100%;
    padding: 15px;
    background: #fff;
    margin: 0;
    border-top: 0;

}

.Filter-panel {
    background-color: #fdfdfd !important;
    border: 1px solid #ddd;
    border-top: 1px solid <?= $theme_color ?> !important;
    margin: 0 10px !important;
    width: 98% !important;
}
.app_panel_content .Filter-panel {
    width: 100% !important;
    margin: 0 !important;
}
.customer_filter_panel{
    margin: 0 15px !important;
    width: 97% !important;
}


.app_panel_content legend{
    font-size: 17px;
    color: #22262E;
    font-weight: 400;
    font-family: 'Roboto', sans-serif !important;
}


.app_panel_content ul.nav.nav-tabs {
    display: inline-block;
    border-bottom: 1px solid #eaeaea;
    border: 1px solid <?= $theme_color ?>;
    background: #fff;
    margin-bottom: 0px;
    cursor: pointer;
    border-radius: 20px;
    overflow: hidden;
}
.app_panel_content ul.nav.nav-tabs li{
        margin-bottom: -2px;
}
.app_panel_content ul.nav.nav-tabs li a {
    font-size: 16px;
    font-weight: 300;
    color: <?= $theme_color ?>;
    padding: 6px 12px 6px 35px;
    position: relative;
    border-radius: 0;
    margin: -2px 0px 2px -1px;
    border: 1px solid transparent;
    border-right: 1px solid <?= $theme_color ?>;
}
.app_panel_content ul.nav.nav-tabs li:first-child a{
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.app_panel_content ul.nav.nav-tabs li:last-child a{
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    border-right: 0;
}
.app_panel_content ul.nav.nav-tabs li.active a {
    background: <?= $theme_color ?>;
    color: #fff;
}
.app_panel_content ul.nav.nav-tabs li a:before {
    position: absolute;
    content: '\f00c';
    font-family: fontawesome;
    left: 10px;
    font-size: 11px;
    border: 2px solid <?= $theme_color ?>;
    background:#fff;
    color:#fff;
    border-radius: 50%;
    width: 17px;
    height: 17px;
    line-height: 15px;
    text-align: center;
    top: 8px;
}
.app_panel_content ul.nav.nav-tabs li.active a:before {
    border: 2px solid #006d6d;
    background:#006d6d;    
    border-radius: 50%;
}
.app_panel_content ul.nav.nav-tabs li a:hover {
    background: <?= $theme_color ?>;
    color: #fff;
    border: 1px solid <?= $theme_color ?>;
}
.panel-group.responsive .panel-heading {
    padding: 0;
}
.panel-group.responsive .panel-heading h4.panel-title a {
    padding: 10px 15px;
    display: block;
    text-decoration:none;
}

input { outline: none !important; }

.panel{ border-radius:0; }

.btn{ border-radius:0; }

.btn:active, .btn:hover, .btn:focus{ outline:none; }

label.error { color: #f90a0a !important; }

a{ text-decoration: none; }



.div-upload {
    padding: 4px 13px 4px 40px;
    background: #fff;
    color: <?= $theme_color ?>;
    display: inline-block;
    position: relative;
    font-size: 12px;
    line-height: 24px;
    border-radius: 25px;
    border: 1px solid <?= $theme_color ?>;
    cursor: pointer;
    box-shadow: none;
    transition: 0.5s;
    font-weight: 500;
}
.div-upload:hover {
    background: <?= $theme_color ?>;
    color: #fff;
}
.div-upload:before {
    content: "\f093";
    font-family: FontAwesome;
    font-weight: normal;
    font-style: normal;
    display: inline-block;
    text-decoration: inherit;
    position: absolute;
    left: 10px;
}
.div-upload:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 20px;
    left: 30px;
    top: 5px;
    background: <?= $theme_color ?>;
    opacity: 0.5;
}
.div-upload:hover:after {
    background: #fff;
}

.div-upload ul {
    margin: 0 !important;
}
.div-upload span.btn-text {
    padding: 0px 15px 0px 40px;
}

textarea{
    resize: vertical;
    min-height:34px;
    max-height: 100px;
}

.no_pad{ padding:0; }

.pd_tp_5{ padding-top:5px; }

.pd_bt_0{ padding-bottom:0px; }

.pd_bt_5{ padding-bottom:5px; }

.pd_bt_51{padding-bottom: 51px !important;}

.col_pad{padding: 0 15px}



.mg_tp_0{ margin-top:0px; }

.mg_tp_10{ margin-top:10px; }

.mg_tp_20{ margin-top:20px; }

.mg_tp_25{ margin-top: 25px;}

.mg_tp_30{ margin-top: 30px;}

.mg_bt_0{ margin-bottom:0px; }

.mg_bt_-1{ margin-bottom:-1px; }

.mg_bt_10{ margin-bottom:10px; }

.mg_bt_20{ margin-bottom:20px; }

.mg_bt_25{ margin-bottom: 25px;}

.mg_bt_30{ margin-bottom: 30px;}
.mg_bt_150{ margin-bottom: 150px;}

.pad_0{ padding:0px; }

.pad_5{ padding:5px; }

.pad_8{ padding:8px; }

.pad_15{ padding:15px; }

.border_0, .border_0 td, .border_0 tr, .border_0 th{ border:0 !important; }




/**App Generic Widget start***/

.widget_parent-bg-img{
    float: left;
    width: 100%;
    background-repeat: repeat;
    background-size: 260px 126px;
    border-radius: 10px;
}

.widget_parent-bg-img.bg-img-red{
    background-image: url(../../images/widgets/statistic-box-red.png);
}
.widget_parent-bg-img.bg-img-purp{
    background-image: url(../../images/widgets/statistic-box-purple.png);
}
.widget_parent-bg-img.bg-img-green{
    background-image: url(../../images/widgets/statistic-box-green.png);
}
.bg-green {background: #41cac0;}
.bg-red{background: #ff4a4a;}
.bg-purple{background: #995dea;}


.widget_parent{
    width: 100%;
    float: left;
    padding: 15px 25px 20px;
    background-image: url(../../images/widgets/statistic-box-grid.png);
    background-repeat: repeat;
    background-size: 21px 20px;
}

.widget_head{
	background: #39b1a8;
    padding: 8px;
    font-size: 18px;
    color: #fff;
    float: left;
    width:100%;
    text-align: center;
    box-shadow: 0 0px 24px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);
}

.widget_parent .widget {
	padding:0 10px;
}

.widget_parent .title{
	font-size: 18px;
	color:#fff;
}

.widget_parent .content{
	font-size: 18px;
	margin-top:6px;
	color:#007970;
}



.widget_parent .progress{
	height:8px;
	margin-top:10px;
}

.widget_parent label{

	font-size:13px;

	color: #fff;

}

.widget_parent .title.success-col {
    text-align: right;
    font-size: 14px;
}
.widget_parent .title.success-col span.succes_count {
    font-size: 28px;
    font-weight: 600;
}
.widget_parent .widget-badge {
    text-align: right;
}
.widget_parent .widget-badge .label.label-warning {
    float: left;
    margin-top: 1px;
    background-color: #ff9600;
    font-size: 12px;
}
.widget-badge label {
    font-size: 12px !important;
    color: #fff !important;
    width: auto !important;
}
.widget_parent .progress-bar-danger {
    background-color: #ff9600;
}

.widget_parent .stat_content{
        line-height: 34px;
}
.widget_parent .stat_content .stat_content-tilte{
    font-size: 14px;
    color:#fff;
    line-height: 21px;
}
.widget_parent .stat_content .stat_content-amount{
    color: #efff00;
    font-size: 21px;
}
}

/**App Generic Widget end***/



/***Generic panel-legend start***/

.app_panel_style{

    position: relative;
    margin-bottom: 40px;

}

.app_panel_style legend{

    border: 0;
    position: absolute;
    top: -15px;
    font-size: 18px;
    background: #fff;
    width: auto;
    padding: 0 5px;
    color: #22262E;
    font-weight: 300;
    font-family: 'Roboto', sans-serif !important;

}

.panel-default {
    border-color: #22262e14 !important;
    box-shadow: none;
}
.panel-default .panel-default-inner{
    border: 1px solid #ddd;
    padding: 15px 0;
}
.panel-default.feildset-panel{
        position: relative;
}
.panel_height_limit {
    max-height: 172px;
    overflow-y: scroll;
}
.panel_height_limit::-webkit-scrollbar {
    height: 1px;
    width: 2px;
}
.panel_height_limit::-webkit-scrollbar-track {
      background-color: #b3b3b3;
} /* the new scrollbar will have a flat appearance with the set background color */
 
.panel_height_limit::-webkit-scrollbar-thumb {
      background-color: #ececec; 
} /* this will style the thumb, ignoring the track */
 
.panel_height_limit::-webkit-scrollbar-button {
      background-color: #000;
      width:5px;
      height: 0px;
} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */
 
.panel_height_limit::-webkit-scrollbar-corner {
      background-color: black;
      border-radius:25px;
}

/***Generic panel-legend end***/



/***Autocomplete name start***/

.ui-widget.ui-widget-content.ui-autocomplete {

    z-index: 2000 !important;

    border: 1px solid #c5c5c5;

}

/***Autocomplete name end***/

small{ color: #717171;}

div.wysiwyg, div.wysiwyg iframe{
  width:100% !important;
}
.gmail_default {
    color: #000 !important;
}





/***Cancel estimate css***/

.cancel_fieldset{

  border:1px solid #ddd;

  float: left;

  width: 100%;

  padding: 10px 20px;

  margin-bottom: 20px;

}

.cancel_fieldset legend{

  border:0;

  font-size: 16px;

  width: auto;

  margin-bottom: 0;

}

.simple_multiple_stat{
  width:100%;
  float:left;
  background: #41cac0;
  padding:10px;
  color:#fff;
}
.simple_multiple_stat span{
  font-size:18px;
}

.col5{ 
width:20%; 
float:left; 
padding:0 15px;
}

.simple_multiple_stat .col4{ width:25%; float:left; }
.simple_multiple_stat .col2{ width:50%; float:left; }
.simple_multiple_stat .col3{ width:33.33%; float:left; }

.profile_stat_wrap-bg-img {
    background-repeat: repeat;
    background-size: 260px 108px;
    border-radius: 5px;
    float: left;
    width: 100%;
}
.profile_stat_wrap-bg-img.bg-img-red{
    background-image: url(../../images/widgets/statistic-box-red.png);
        border: 1px solid #ef474a;
}
.profile_stat_wrap-bg-img.bg-img-purp{
    background-image: url(../../images/widgets/statistic-box-purple.png);
    border: 1px solid #995dea;
}
.profile_stat_wrap-bg-img.bg-img-green{
    background-image: url(../../images/widgets/statistic-box-green.png);
    border: 1px solid #8dc327;
}
.profile_stat_wrap {
    background-image: url(../../images/widgets/statistic-box-grid.png);
    background-repeat: repeat;
    background-size: 21px 19px;
    border-radius: 5px;
    overflow: hidden;
}
.profile_stat_wrap .stat_content {
    padding: 10px 12px;
    color: #fff;
    font-size: 15px;
    padding-bottom: 0;
}
.profile_stat_wrap .stat_content span.content_span{
  margin-bottom:10px;
}
.profile_stat_wrap .stat_footer{
    padding: 7px 12px;
    font-size: 16px;
    font-weight: 500;
    color: #ffffff;
}
.profile_stat_wrap .stat_footer .contant_total {
    color: #efff00;
}

/***Modal***/
.modal-open .modal{
    width: 100%;
    height: 100vh;
    overflow-y: scroll;
}
.modal-xl {
    width: 96%;
}
.modal-open .modal::-webkit-scrollbar {
    height: 1px;
    width: 2px;
}
.modal-open .modal::-webkit-scrollbar-track {
      background-color: #b3b3b3;
} /* the new scrollbar will have a flat appearance with the set background color */
 
.modal-open .modal::-webkit-scrollbar-thumb {
      background-color: #ececec; 
} /* this will style the thumb, ignoring the track */
 
.modal-open .modal::-webkit-scrollbar-button {
      background-color: #000;
      width:5px;
      height: 0px;
} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */
 
.modal-open .modal::-webkit-scrollbar-corner {
      background-color: black;
      border-radius:25px;
}

.modal-body {
    position: relative;
    padding: 25px 15px 15px 15px;
}
#view_log_modal .modal-body {
    padding: 0px 15px 15px 15px;
}
.modal-content {
    border-top: 4px solid <?= $theme_color ?>;
}
.modal-header {
    padding: 10px 15px;
}
h4.modal-title {
    margin: 0;
    line-height: 1.42857143;
    color: #282323;
    text-transform: capitalize;
    font-size: 22px;
    padding-left: 5px;
    font-weight: 300;
    font-family: 'Roboto', sans-serif;
}
.modal-body ul.nav.nav-tabs{
    display: block;
    border: 0;
    border-bottom: 1px solid #eaeaea;    
    border-radius: 0;
}
.modal-body ul.nav.nav-tabs li a {
    margin: 0;
    padding: 10px 6px;
    border: 0;
    color: #555;
    font-size: 18px;
    font-weight: 300;
    transition: 0.5s;
    border: 1px solid transparent;
}
.modal-body ul.nav.nav-tabs li a:before{
    display:none;
}
.modal-body ul.nav.nav-tabs li.active a, .modal-body ul.nav.nav-tabs li.active a:focus, .modal-body ul.nav.nav-tabs li.active a:hover {
    border: 1px solid #eaeaea;
    border-top-color: <?= $theme_color ?>;
    color: #22262e;
    border-bottom-color: transparent;
    background: #fff;
}
.modal-body table th{
    padding-left: 10px !important; */
}
.modal-body table td {
    padding-left: 10px !important;
}
.modal-body h4{
    margin: 0px;
    margin-bottom: 15px;
    font-size: 17px;
    color: #22262E;
    font-weight: 400;
    font-family: 'Roboto', sans-serif !important;
}

.note{
    color: #ff0000;
    background: rgba(241, 48, 48, 0.07);
    padding: 5px;
    font-size: 13px;
}

.editor_title{
    font-size: 14px;
    font-weight: 500;
    margin: 0px !important;
    color: #212320;
    background: #eaeaea;
    padding: 10px 8px;  
    text-transform: uppercase;
}

.seat_availability {
    color: #fff;
    padding: 7px 25px;
    display: inline-block;
    margin-right: -4px;
}

/* Guidlines Section*/

.guidlines_modal .modal-content{
  border-top: 4px solid <?php echo $danger;  ?>
}
.guidlines_modal h5{
    font-size: 26px;
    margin-top: 0;
    margin-bottom: 20px;
}
.guidlines_modal ul{
  margin:0 !important;
  padding:0 !important;
}
.app_guidline {
    list-style-type: none;
    border-bottom: 1px solid #eee;
    border-radius: 5px;
    margin-left: 0;
    margin-bottom: 10px;
    overflow: hidden;
    float: left;
    width: 100%;
}
.app_guidline span {
    padding: 0px 15px 10px;
    font-size: 13px;
}
.app_guidline .guidline_left{
     width: 25%;
    color: #22262e;
    font-weight: 500;
}
.app_guidline .guidline_right {
    color: #675e5e;
    width: 75%;
}

/**Excel button**/
button.btn-excel {
    padding: 0;
    background: transparent;
}
button.btn-excel:hover {
    box-shadow: none;
}
button.btn-excel i {
    background: transparent;
    color: <?= $theme_color ?>;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-size: 16px;
    line-height: 34px;
    text-align: center;
}
button.btn-excel i:hover{
    background: <?= $theme_color ?>;
    color: #ffffff;
}
<!-- Itinerary button -->
/**Excel button**/
button.btn-iti {
    padding: 0;
    background: transparent;
}
button.btn-iti:hover {
    box-shadow: none;
}
button.btn-iti i {
    background: transparent;
    color: <?= $theme_color ?>;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-size: 16px;
    line-height: 20px;
    text-align: center;
}
button.btn-iti i:hover{
    background: <?= $theme_color ?>;
    color: #ffffff;
}

/**PDf button**/
button.btn-pdf {
    padding: 0;
    background: transparent;
}
button.btn-pdf:hover {
    box-shadow: none;
}
button.btn-pdf i {
    background: transparent;
    color: #c00;
    border: 1px solid #c00;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    line-height: 36px;
    text-align: center;
    font-size: 16px;
}
button.btn-pdf i:hover{
    background: #c00;
    color: #fff;
}
}


/**Table dropdown**/
.tbl_dropdown{
    min-width: 105px;
    height: 28px;
    border: 1px solid #ddd;
    font-size: 12px;
    float: left;
    width: auto;
    padding: 0px 2px;
}

/**pverlapping tooltip**/
ul.select2-results__options li {
    border-bottom: 1px solid #f1f1f1;
}
ul.select2-results__options li[aria-selected="true"], ul.select2-results__options li:first-child {
    font-weight: 500;
}
.select2-selection .tooltip.fade.bottom.in {
    opacity:0 !important;
}
.table{
    border-collapse: initial !important
}

select option {
    background:#f3f1f1;
}
select option:first-child {
    font-weight: 500;
}


/***Image-gallery***/

.gallary-single-image, .table-single-image{
    box-shadow: 0px 0px 2px 1px #c5c5c5;
    padding: 2px;
    background: #fff;
    position: relative;
}
span.img-check-btn {
    position: absolute;
    top: 1px;
    right: 2px;
    z-index: 5;
}
.table-image-btns {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.64);
    transition: 0.2s;
    display:none;
}
.table-image-btns ul {
    padding: 0;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -36px;
    margin-top: -15px;
}
.table-single-image:hover .table-image-btns, .gallary-single-image:hover .table-image-btns{
    display:block;
}
.table-image-btns ul li {
    list-style-type: none;
    display: inline-block;
}
.table-image-btns ul li button.btn.btn-sm {
    background: transparent;
    border: 1px solid;
}
.table-image-btns ul li button.btn.btn-sm i {
    font-size: 13px;
}
.img_description p {
        font-size: 16px;
    color: #22262e;
    line-height: 23px;
    background: #f5f5f5;
    padding: 10px;
}
span.img-check-btn button.btn.btn-danger.btn-sm {
    border: 1px solid #c00;
    width: 15px;
    height: 15px;
    line-height: 15px;
    font-size: 9px;
    padding: 0;
}
span.img-check-btn button.btn.btn-danger.btn-sm:hover {
    color: #c00;
    background: transparent;
}

/***Image-gallery Modal***/
.modal button.close {
    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 28px;
    z-index: 99;    
}

div#display_modal .close {
    position: absolute;
    right: 5px;
    top: -2px;
    font-size: 28px;
}


/***Balance_sheet***/

.panel-default .panel-heading {
    background-color: #f7f7f7;
}
.panel-heading strong {
    font-weight: 500;
    font-size: 14px;
    text-transform: uppercase;
    color: #007777;
}
.panel-body ul {
    margin-bottom: 25px;
}
.panel-body ul li strong {
    font-weight: 500;
    font-size: 14px;
    color: #007575;
}
.panel-body ul ul {
    padding-top: 10px;
    margin-bottom: 0 !important;
}
.panel-body ul ul li {
    margin-bottom: 10px;
    font-weight: 400;
    font-size: 13px;
}
.panel-footer strong {
    font-weight: 500;
    color: #007777;
}



/***Amount Feild***/

.amount_feild_highlight{
    background: #96d1b6 !important;
    color: #30825c;
    font-weight: 500;
}
.amount_feild_highlight::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #30825c;
}
.amount_feild_highlight::-moz-placeholder { /* Firefox 19+ */
  color: #30825c;
}
.amount_feild_highlight:-ms-input-placeholder { /* IE 10+ */
  color: #30825c;
}
.amount_feild_highlight:-moz-placeholder { /* Firefox 18- */
  color: #30825c;
}

.highlighted_cost, .highlighted_cost label {
    color: <?= $theme_color ?>;
    font-weight: 500;
}


/***B2B Package elements***/

.single_b2b_package .b2b_pkg_img img {
    box-shadow: 0px 0px 2px 1px #c5c5c5;
    padding: 2px;
    background: #fff;
}
.single_b2b_package .b2b_pkg_btns ul li {
    display: inline-block;
    margin-right: 15px;
}
.single_b2b_package h3.b2b_pkg_title {
    color: #22262E;
    margin: 0;
    letter-spacing: 0;
    font-size: 21px;
    margin-bottom: 15px;
    max-height: 23px;
    overflow: hidden;
}
.single_b2b_package span.b2b_pkg_cost {
    font-size: 21px;
    font-weight: 600;
    color: #e73636;
}
.single_b2b_package p.b2b_pkg_cost_text {
    margin: 0;
    font-size: 12px;
}
.single_b2b_package p.b2b_pkg_code {
    font-weight: 500;
    color: #22262E;
}
.single_b2b_package p.b2b_pkg_duration i {
    font-weight: 600;
    color: <?= $theme_color ?>;
    font-size: 16px;
    margin-right: 3px;
}
.single_b2b_package span.duration_seprator {
    margin: 0 10px;
}
.single_b2b_package .b2b_pkg_text_detail {
    margin-top: 20px;
}
.single_b2b_package .b2b_pkg_text_detail p {
    margin-bottom: 15px;
    float: left;
    width: 100%;
}
.single_b2b_package .b2b_pkg_text_detail p strong {
    color: #22262E;
    font-size: 14px;
    margin-right: 10px;
    float: left;
    width: 100px;
    height: 35px;
    font-weight: 500;
}
.single_b2b_package em.b2b_hotel_category {
    font-style: normal;
    color: #e73636;
    font-weight: 600;
}
.single_b2b_package em.sightseeing_content {
    float: left;
    width: 82%;
    font-style: normal;
}
label.tbl_radio_btn_body{
    position:relative;
    cursor: pointer;
}
label.tbl_radio_btn_body > input {
    opacity: 0;
    position: absolute;
    top: -15px;
    left: 5px;
}
label.tbl_radio_btn_body span.tbl_radio_btn{ 
  background: #fff;
  border: 2px solid <?= $theme_color ?>;
  color: #fff;
  border-radius: 50%;
  width: 17px;
  height: 17px;
  display: inline-block;
}
label.tbl_radio_btn_body.tbl_span_check span.tbl_radio_btn{ 
  background: <?= $theme_color ?>;
}


/**********APP accordion**********/
.app_accordion .accordion_content .Normal.collapsed:after, .app_accordion .accordion_content .Normal:after {
    content: '\f044';
    font-size: 18px;
    line-height: 28px;
    background: transparent;
    box-shadow: none;
    transform: rotate(0deg);
    color: #333333;
}
.indicator{
    border: 1px solid rgba(255, 0, 0, 0.59);
}




/***Generic Responsive***/

@media screen and (max-width:992px){
.mg_bt_10_xs{ 
    margin-bottom: 10px; 
}
.mg_bt_20_xs{ 
    margin-bottom: 20px; 
}
.text_center_xs{ 
    text-align: center; 
}
.text_left_xs{ 
    text-align: left; 
}
.right_border_none_sm{
    border-right: 0 !important;
}
.no-pad-sm-xs{
    padding:0 !important;
}
.no-marg-sm-xs{
    margin:0 !important;
}
}

@media screen and (max-width:768px){
.mg_bt_10_sm_xs{ 
    margin-bottom: 10px; 
} 
.mg_bt_20_sm_xs{ 
    margin-bottom: 20px; 
} 
.mg_rgt_10_sm_xs{
    margin-right: 10px;
}
.mg_tp_10_sm_xs{ 
    margin-top: 10px; 
}
.text_center_sm_xs{ 
    text-align: center; 
}
.text_left_sm_xs{ 
    text-align: left !important; 
}
.text_right_sm_xs{ 
    text-align: right; 
}
.no-pad-sm{
    padding:0 !important;
}
.no-marg-sm{
    margin:0 !important;
}
.xs_show {
    display: block;
}
.right_border_none_sm_xs{
    border-right: 0 !important;
}
.main_block_xs{
    float:left;
    width:100%
}
}




/***Responsive***/

@media screen and (max-width:992px){

.app_content_wrap.toggle {
    padding-left: 0px !important;
}





.panel-group.responsive h4.panel-title a {
    border: 1px solid <?= $theme_color ?>;
    color: <?= $theme_color ?>;
    position: relative;
}
.panel-group.responsive .panel.panel-default {
    margin-bottom: 20px;
}
.panel-group.responsive .panel-collapse {
    border: 1px solid <?= $theme_color ?>;
    border-top: 0;
}
.panel-group.responsive .panel-heading h4.panel-title a.accordion-toggle:after {
    content: '\f106';
    position: absolute;
    font-family: fontawesome;
    right: 15px;
    color: #fff;
    font-size: 14px;
    top: 11px;
}
.panel-group.responsive .panel-heading h4.panel-title a.accordion-toggle:before {
    content: '';
    position: absolute;
    right: 10px;
    top: 8px;
    width: 20px;
    height: 20px;
    border: 1px solid <?= $theme_color ?>;
    background: <?= $theme_color ?>;
    border-radius: 50%;
}
}

@media screen and (max-width:768px){


.app_panel .app_panel_head {
    padding: 0px 0px !important;
}
.app_panel_head h2 {
    font-size: 18px;
    width: 80%;
}
.header_btn {
    width: 10%;
}
.header_btn button {
    padding: 13px 0px;
}
.header_btn button a i {
    width: 30px;
    height: 30px;
    line-height: 30px;
    font-size: 14px;
}

.dataTables_length {
    text-align: left !important;
    margin: 10px 0;
}
.dataTables_filter {
    text-align: left !important;
}
.dataTables_info {
    text-align: left !important;
    margin: 0 0 10px 0;
}
.dataTables_paginate {
    text-align: left !important;
}
.table {
    padding-bottom: 0px !important;
}

.app_guidline span {
    padding: 0px 15px 5px;
}
.app_guidline .guidline_left {
    width: 100%;
}
.app_guidline .guidline_right {
    width: 100%;
}


.app_dual_button {
    padding: 5px 5px;
}

.img_description p {
    font-size: 14px;
}

h4.modal-title {
    font-size: 18px;
}



.seat_availability {
    padding: 7px 9px;
}


}


.feedback td{
        line-height: 26px;
}

.feedback th{
        line-height: 30px;
} 
.loader_parent{
    position : relative;
    min-height : 45vh;
}
.loader
{
    position: absolute;
    left: 50%;
    margin-left: -45px;
    top: 50%;
    margin-top: -45px;
    height: 90px;
    width: 90px;
    z-index: 2;
    background-color: transparent !important;
    background: url(<?= BASE_URL ?>images/loader.gif) no-repeat;
    background-size: contain;
}

/*******pre tag********/
pre.real_text {
    font-family: 'Roboto', sans-serif;
    overflow: initial;
    background: transparent;
    border: 0;
    white-space: pre-wrap;
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;
    white-space: -o-pre-wrap;
    word-break: keep-all;
}

<!-- Video URL -->
.vid_block {
    position: relative;
}
.btnHidder{
    background-color: transparent;
    height: 60px;
    position: absolute;
    right: 17px;
    top: 2px;
    width: 60px;
    z-index: 2147483647;
}
input[type=button].btnType {
    background: transparent;
    color: <?= $theme_color ?>;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50px;
    font-size: 14px;
    text-align: center;
    position: relative;
}
input[type=button].btnType:hover {
    background: #fff !important;
    color: <?= $theme_color ?>!important;
}
<!--  -->
.st-custBtn {
    background: transparent;
    color: <?= $theme_color ?>!important;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    position: relative;
    padding: 8px 20px 7px 40px;
    line-height: 17px;
}
.st-custBtn:hover {
    background: <?= $theme_color ?>!important;
    color: #fff!important;
}
.st-custBtn .icon{
    border-right: 1px solid <?= $theme_color ?>;
    position: absolute;
    top: 8px;
    left: 0;
    height: 15px;
    width: 30px;
    line-height: 15px;
    font-size: 12px;
}
.st-custBtn:hover .icon{border-color: #fff;}

<!--  -->
ul.noType li{
    list-style-type : none;
}
.fontw_bold span{
    font-weight: 500 !important;
}

.div_left{
    width: 150px;
    float: left;
    display:block;
}
.div_left.type-02,.div_left.type-02 .nav-pills>li{
    width:200px!important;
    position : relative;
}
.div_left.type-02 .nav-pills>li{padding-right: 35px;}
.div_left.type-02 .dropdown.active a{background-color : #eee!important; color:<?= $theme_color ?>;
}
.div_left.type-02 .nav-pills>li>a{font-size: 12px; line-height: 16px; font-weight: 500;}
.div_left.type-02 .nav-pills>li>a i{
    position: absolute;
    top: 15px;
    right: 8px;
}
.div_right{
    width: calc(100% - 150px);
    float: left;
    display:block;
    <!-- border: solid <?= $theme_color ?>; -->
}
.div_right.type-02{
    width: calc(100% - 200px);
    float: left;
    display:block;
    <!-- border: solid <?= $theme_color ?>; -->
}
.nav-pills>li {
    width: 150px !important;
    float: none !important;
}
.nav-pills>li>a{
    color:<?= $theme_color ?>;
}

.nav-pills>li>a i {
  border: solid <?= $theme_color ?>;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
}
.right {
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}
.open>.dropdown-menu{
    top: 0;
    left: 155px;
    width: 250px;
    cursor: pointer;
}
.dropdown-menu li{
    padding: 6px 3px;
    font-size: 12px;
    font-weight: 500;
    border-bottom: 1px solid #d6d5d5;
}
.dropdown-menu li:hover{
    background-color: #eee;
}
.servingTime .saveProfile,
.servingTime .st-cancleEdit{
    display:none;
}
.servingTime.st-editable .saveProfile,
.servingTime.st-editable .st-cancleEdit{
    display: inline-block;
}
.servingTime.st-editable .st-editProfile{
    display:none;
}
.servingTime .saveProfile,
.servingTime .st-editProfile{
    background : <?= $theme_color ?> !important;
}
.input-sm{
    padding: 0 25px 0 3px !important;
}

.itinerary-link{text-decoration:underline!important;color:blue!important;}
.itinerary-img{height:25px;width:25px;display: inline-block;}
