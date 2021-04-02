<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
?>

.landingPageTop {
    position: relative;
}
.landingPageTop h1.landingpageTitle {
    position: absolute;
    margin: 0;
    top: 30px;
    left: 30px;
    font-size: 24px;
    border-bottom: 3px solid <?= $theme_color ?>;
    line-height: 32px;
    color: White !important;
    -webkit-print-color-adjust: exact;
}
.landingPageTop h1.landingpageTitle em {
    font-size: 18px;
    font-style: normal;
    color: #ffffff !important;
    -webkit-print-color-adjust: exact;
}
span.landingPageId {
    position: absolute;
    left: 30px;
    bottom: 30px;
    color: #2c3642 !important;
    background-color: rgba(255, 255, 255, 0.6) !important;
    -webkit-print-color-adjust: exact;
    padding: 10px 15px;
    font-weight: 500;
    font-size: 13px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 8px;
}
.landingdetailBlock {
    position: absolute;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.62) !important;
    -webkit-print-color-adjust: exact;
    top: 0;
    right: 0;
    border-left: 3px solid <?= $theme_color ?>;
}
.detailBlock {
    display: block;
    padding: 20px 15px;
    margin: 0 15px;
    border-top: 1px solid rgba(0, 0, 0, 0.15);
}
.detailBlockIcon i{
    font-size : 24px;
    margin: 15px auto;
}
.detailBlockIcon i:before{
    font-size : 24px;
    margin: 15px auto;
    color:#fff !important;
}
.detailBlockIcon img {
    width: 30px;
    margin: 15px auto;
    transform: rotate(0deg);
}
.print_header_logo {
    float: right;
    width: 100%;
}
.print_header_logo img{
    float: right;
    width: auto;
    height: 70px;
    margin: 15px 0 0 0;
}
.print_header_contact span.title {
    margin: 0;
    padding: 0;
    font-weight: 500;
    font-size: 21px;
}
.print_header_contact p.address{
    line-height: 18px;
    height: 36px;
    overflow: hidden;
}
.print_header_contact p{
    font-size : 12px;
}

.landigPageCustomer {
    margin-bottom : 6px;
}
h3.customerFrom {
    font-size: 16px;
    margin-top: 0px;
    margin-bottom: 20px;
    line-height: 36px;
    border-bottom: 1px solid <?= $theme_color ?>;
    text-transform : uppercase;
}
.landigPageCustomer span{
    line-height: 28px;
}
.landigPageCustomer i{
    min-width : 30px;
}
span.generatorName {
    font-size: 14px;
    font-weight: 500;
    line-height: 26px;
    display: block;
    margin-top: 20px;
}

h3.contentValue {
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
    margin: 0;
    font-size: 16px;
    line-height: 24px;
}
span.contentLabel {
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    font-size: 10px;
    line-height: 16px;
}


.singleItinenrary {
    position: relative;
    list-style-type: none;
}
.itneraryImg {
    position: relative;
}
.itneraryImg:before {
    position: absolute;
    font-family: fontawesome;
    font-size: 18px;
    top: 42%;
}
.leftItinerary .itneraryImg:before{
    content: '\f101';
    right: -20px;
}
.rightItinerary .itneraryImg:before{
    content: '\f100';
    left:-20px;
}
.itneraryImg h5 {
    position: absolute;
    font-size: 45px;
    font-weight: 600;
    text-transform: uppercase;
    top: 50%;
    width: 100%;
    text-align: center;
    color: rgba(255, 255, 255, 0.8) !important;
    margin: -25px 0 0 0;
}
.itineraryDetail {
    position: absolute;
    margin-top: -20px;
    left: 0;
    bottom: 0;
    width: 100%;
}
.itineraryDetail ul {
    background-color: rgba(255, 255, 255, 0.6) !important;
    -webkit-print-color-adjust: exact;
    padding: 5px 15px !important;
    width: 100%;
    margin: 0;
}
.itineraryDetail ul li {
    list-style-type: none;
    line-height: 30px;
    display: inline-block;
}
.itineraryDetail ul li:first-child {
    width: 59%;
}
.itineraryDetail ul li:last-child {
    width: 39%;
    text-align : right;
}
.itneraryText {
    border: 1px solid<?= $theme_color ?>;
    border-radius: 5px;
    min-height: 255px;
}
.dayCount {
    background-color:<?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    padding: 10px;
    text-transform: uppercase;
}
.dayCount span{
    color: #fff !important;
    font-weight: 500;
}
.dayCount span i {
    background-color: #ffffff !important;
    -webkit-print-color-adjust: exact;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    text-align: center;
    line-height: 25px;
    margin-right: 5px;
}
.dayWiseProgramDetail{
    padding : 10px;
}
.dayWiseProgramDetail p {
    font-size: 13px !important; 
    padding: 0 !important;
    margin: 0 !important;
    color: #5a5a5a !important;
    max-height: 642px;
    overflow: hidden;
}

.incluExcluTerms {
    position: relative;
}
.incluExcluTerms:before {
    position: absolute;
    content: '';
    background-color: #efdeb3 !important;
    -webkit-print-color-adjust: exact;
    border-right: 3px solid #d0c098;
    width: 100px;
    height: 100%;
    left: 0;
    top: 0;
}
h3.incexTitle {
    color: #5c2318 !important;
    font-size: 24px;
    font-weight: 600;
    margin: 0;
    padding-bottom: 5px;
    border-bottom: 1px solid #5c2318;
    margin-bottom: 10px;
}
h3.tncTitle {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    font-size: 18px;
    color: #fff !important;
    padding: 20px 50px;
    border-top: 3px solid #30656e;
    border-bottom: 3px solid #30656e;
    margin: 0;
}
.tncContent {
    padding: 20px 0 0 120px;
}


.constingBankingPanel {
    background-color: #b7c7de !important;
    -webkit-print-color-adjust: exact;
}
h3.costBankTitle {
    color: #114791 !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    padding: 30px 15px 30px;
    font-size: 23px;
    font-weight: 400;
    letter-spacing: -1px;
}
.constingBankingPanel .icon img {
    width: 35px;
    margin-bottom: 5px;
}
.constingBankingPanel.endPageLeft .icon img {
    float: right;
}
.passengerPanel {
    background-color: #efdeb3 !important;
    -webkit-print-color-adjust: exact;
}
.passengerPanel .col-md-12 {
    margin-top: 50px;
}
.passengerPanel .icon img {
    width: 60px;
    margin: 0 auto 10px;
}
.endPageSection h4 {
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
    font-size: 16px;
    line-height: 24px;
}
.endPageSection p {
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    font-size: 10px;
    line-height: 16px;
}

.print_info_block{
    margin: 0;
    border: 1px solid <?= $theme_color ?>;
    padding: 10px;
    border-radius: 5px;
    display: inline-block;
    width: 100%;
}
.print_info_block .print_quo_detail_block i:before{
    color: <?= $theme_color ?> !important;
}


@media print {
    table tr.table-heading-row th, table tfoot tr td{
        -webkit-print-color-adjust: exact; 
    }
}