<?php 
include_once('../../model/model.php');
header("Content-type: text/css");
?>


/*******style_class********/
body{
    margin:0;
    padding:0;
    background: #ffffff;
    font-family: 'Roboto', sans-serif;
    font-size: 13px;
}
table.table{
    padding: 0 !important;
}
table th, .table td {
    padding-left: 8px !important;
}


.font_5{font-weight: 500;}
.font_s_21{font-size:21px;line-height: 24px;}
.font_s_16{font-size:16px;line-height: 21px;}
.font_s_14{font-size:14px;line-height: 18px;}
.font_s_13{font-size:13px;line-height: 18px;}
.font_s_12{font-size:12px;line-height: 18px;}
.caps_text{text-transform:uppercase;}

li{line-height:24px;}
hr{float:left;width: 100%;}

.border_block{
	border: 1px solid <?= $theme_color ?>;
    padding: 10px;
    border-radius: 5px;
}
.border_rt{border-right: 1px solid <?= $theme_color ?>;}
.border_lt{border-left: 1px solid <?= $theme_color ?>; padding-left:10px;}

.less_opact{opacity:0.7;}

.float_r{float: right;}



/*******page_style********/
.inv_rece_header_logo {
    max-width: 210px;
}
.inv_rece_header_bottom ul li h3.title {
    margin-bottom: 5px !important;
}
.inv_rece_header_bottom .inv_rece_header_right ul li span {
    min-width: 130px;
    float: left;
}
section.print_sec.inv_rece_mainbody table tr th, section.print_sec.inv_rece_mainbody table tr td {
    padding-left: 5 !important;
}
.inv_rece_footer_signature {
    position: relative;
}
.signature_block {
    padding-top: 60px;
}
.signature_block_r{
    position: absolute;
    right: 10px;
    bottom: 10px;
}

.header_seprator{position:relative;}
.header_seprator:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 100%;
    top: 0;
    border-left: 1px solid #ddd;
}
.header_seprator_4:after{left: 33.33333333%;}
.header_seprator_6:after{left: 50%;}
.last_h_sep_border_lt{border-left: 1px solid #ddd;}

.inv_border{
    border: 1px solid #dddddd;
    border-collapse: collapse;
    line-height: 25px;
}
#inv_tbl_emp_list{
    border: 1px solid #dddddd;
    border-collapse: collapse;
}

#inv_tbl_emp_list th{
    border: 1px solid #dddddd !important;
    border-collapse: collapse;
}

#inv_tbl_emp_list td {
    border-right: 1px solid #dddddd !important;
    height:30px;
    padding:10px;
    text-align:left;
}
.red_txt{
    color: red !important;
}

.blue_txt{
    color:#33b5e5 !important;
}
.border_rt{
    border-right : 1px solid #dddddd;
}

<!-- GST invoice -->
table.gst_invoice{
    border-collapse: collapse !important;
}
table.gst_invoice tr td {
    padding: 2px 5px 2px !important;
    border-top: 1px solid #ddd !important;
    font-size: 9px !important;
}
.border_lt{
    border-left : 1px solid #dddddd !important;
}
table.table-bordered{
    border-collapse: collapse !important;
}
table.table-bordered tr td{
    border: 1px solid #ddd !important;
}