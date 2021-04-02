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


.side_pad {padding: 0 30px;}
.col_pad {padding: 0 15px;}
.col_tp_pad{padding: 15px 0 0 0;}
.col_bt_pad{padding: 0 0 15px 0;}


table tr.table-heading-row th, table tfoot tr td{
    background-color: #f7f7f7 !important;
}
table.table-bordered{
    border-collapse: collapse !important;
}
table.table-bordered tr td{
    border: 1px solid #ddd !important;
}

.fullHeightLand{
    min-height: 803px;
}
.themeColor {
    color: #009898 !important;
    -webkit-print-color-adjust: exact;
}

.pageSection {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    position: relative;
}
.pageSectionInner {
    position: absolute;
    top: 0;
    left: 0;
}
section.pageSection img.pageBGImg{
    max-height: 1142px;
}

table.tableTrnasp {
    border-bottom: 0 !important;
}
table.tableTrnasp tr.table-heading-row th {
    border-bottom: 0 !important;
    border-top: 0 !important;
    font-size: 8px !important;
    padding: 5px !important;
}
table.tableTrnasp tr td {
    font-size: 10px;
    padding: 5px !important;
}
table.table.no-marg.tableTrnasp td {
    background-color: transparent !important;
    -webkit-print-color-adjust: exact;
}



