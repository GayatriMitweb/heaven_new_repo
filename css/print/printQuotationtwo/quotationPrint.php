<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
?>

.landingPageTop {
    position: relative;
    border-bottom: 5px solid <?= $theme_color ?>;
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
    right: 30px;
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

.detailBlock {
    display: inline-block;
    width:120px;
}
.detailBlockIcon {
    background-color: rgba(0, 165, 129, 0.79) !important;
    -webkit-print-color-adjust: exact;
    font-size: 28px;
    width: 100px;
    height: 100px;
    line-height: 100px;
    text-align: center;
    transform: rotate(45deg);
    margin: 30px auto;
    position: relative;
}
.detailBlockIcon i{
    font-size : 24px;
    transform: rotate(-45deg);
}
.detailBlockIcon i:before{
    color: #fff !important;
    font-size : 24px;
    transform: rotate(-45deg);
}
.detailBlockIcon img {
    width : 30px;
    transform: rotate(-45deg);
    position: absolute;
    left: calc(50% - 15px);
    top: calc(50% - 12.5px);
}
.detailBlockBlue{
    background-color: rgba(0, 165, 129, 0.79) !important;
    -webkit-print-color-adjust: exact;
}
.detailBlockGreen{
    background-color: rgba(126, 194, 0, 0.8) !important;
    -webkit-print-color-adjust: exact;
}
.detailBlockYellow{
    background-color: rgba(240, 137, 0, 0.8) !important;
    -webkit-print-color-adjust: exact;
}
.detailBlockRed{
    background-color: rgba(196, 15, 0, 0.8) !important;
    -webkit-print-color-adjust: exact;
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


li.singleItinenrary {
    position: relative;
    list-style-type: none;
}
li.singleItinenrary:before {
    position: absolute;
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    left: calc(50% - 5px);
    top: calc(50% - 5px);
    border: 5px solid #f00;
}
li.singleItinenrary:after {
    position: absolute;
    content: '';
    height: 100%;
    border: 1px solid #dddddd;
    left: calc(50% - 0.5px);
    bottom: 0;
    z-index: -1;
}
li.singleItinenrary:first-child:after {
    height: 50%;
}
li.singleItinenrary:last-child:after {
    height: 50%;
    bottom: auto;
    top:0;
}
h5.specialAttraction {
    font-size: 16px;
    line-height: 30px;
    text-transform : capitalize;
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
}
.leftItinerary .itneraryImg img {
    border-radius: 25%;
    padding:0 20px 0 10px;
}
.rightItinerary .itneraryImg img {
    border-radius: 25%;
    padding:0 10px 0 20px;
}
.leftItinerary .itineraryDetail {
    position: absolute;
    left: 60%;
    top: calc(50% - 30px);
}
.rightItinerary .itineraryDetail {
    position: absolute;
    left: 20%;
    top: calc(50% - 30px);
}
.itineraryDetail ul li {
    list-style-type: none;
    line-height: 30px;
}
.itineraryDetail ul li i {
    min-width: 25px;
}
.leftItinerary .dayCount {
    position: absolute;
    left: calc(50% + 20px);
    top: calc(50% - 10px);
}
.rightItinerary .dayCount {
    position: absolute;
    right: calc(50% + 20px);
    top: calc(50% - 10px);
}
.dayCount:before {
    position: absolute;
    content: '\f104';
    color: #f00 !important;
    font-family: fontawesome;
    font-size: 18px;
    top: -2px;
}
.leftItinerary .dayCount:before{left: -35px;}
.rightItinerary .dayCount:before{left: -20px;}
.dayCount:after {
    position: absolute;
    content: '\f105';
    color: #f00 !important;
    font-family: fontawesome;
    font-size: 18px;
    top: -2px;
}
.leftItinerary .dayCount:after{right: -20px;}
.rightItinerary .dayCount:after{right: -35px;}
.dayCount span {
    font-weight: 500;
    color: #f00 !important;
    -webkit-print-color-adjust: exact;
}
.itneraryText p {
    max-height: 700px;
    overflow: hidden;
    font-size: 13px !important; 
    padding: 0 !important;
    color: #5a5a5a !important;
}

.incluExclu {
    position: relative;
    margin-bottom:20px;
}
.imgPanel {
    position: absolute;
}
.imgPanel img {
    height: 450px;
    width: 100%;
}
.imgPanel .imgPanelOvelay {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    background-color: rgba(17, 71, 145, 0.8) !important;
    -webkit-print-color-adjust: exact;
}
h3.lgTitle {
    color: #fff !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 18px;
    margin: 0 0 15px 0;
    padding-bottom: 5px;
    border-bottom: 1px solid #fff;
}
.contenPanel.main_block.side_pad.mg_tp_30 {
    min-height: 400px;
    max-height: 450px;
    overflow: hidden;
}
.contenPanel pre.real_text, .contenPanel pre.real_text ul li, .contenPanel pre.real_text p, .contenPanel pre.real_text span {
    color: #ffffff !important;
    -webkit-print-color-adjust: exact;
}
.incluExclu .contenPanel pre.real_text {
    max-height: 375px;
    overflow: hidden;
}

h3.nrmTitle {
    text-transform: uppercase;
    color: #114791 !important;
    -webkit-print-color-adjust: exact;
    margin: 0 0 15px 0;
    font-weight: 500;
    font-size: 18px;
}


.guestDetail{
    position:relative;
}
.guestDetail h3 {
    position: absolute;
    left: 30px;
    top: 0;
}
.guestDetail img {
    width: 400px;
    margin: 0 auto;
}
.guestDetail .guestCount {
    color: #646368 !important;
    -webkit-print-color-adjust: exact;
    font-size: 16px;
    text-transform: uppercase;
    width: 100px;
    display: inline-block;
}
span.guestCount.childCount {
    position: absolute;
    bottom: 45px;
    left: calc(50% - 50px);
}
span.guestCount.adultCount, span.guestCount.infantCount {
    margin: 0 45px;
}

.costBankSec{
    background-color: #b7c7de !important;
    -webkit-print-color-adjust: exact;
}
h3.costBankTitle {
    color: #114791 !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 16px;
    margin: 0px 0 20px;
    font-size: 23px;
    font-weight: 400;
    letter-spacing: -1px;
}
.costBankSec .col-md-6{
    padding-left : 60px;
}
.costBankSec .icon img {
    width : 30px;
    margin : 0 auto 5px;
}
.costBankSec h4 {
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
    font-size: 16px;
    line-height: 24px;
}
.costBankSec p {
    color: #2c3642 !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    font-size: 10px;
    line-height: 16px;
}



.contactTitlePanel img{
    width: 250px;
    margin: 10px auto 0;
}
.contactTitlePanel p{
    color: #222a35 !important;
    -webkit-print-color-adjust: exact;
    font-size:10px;
    position: absolute;
    width: 98%;
    top: 60%;
    padding: 0 15px;
    text-align: center;
}

.contactsec .col-md-5 {
    position:relation;
    background-color: #222a35 !important;
    -webkit-print-color-adjust: exact;
    min-height: 270px;
}
.cBlockIcon {
    float: left;
    width: 10%;
}
.cBlockContent {
    float: left;
    width: 90%;
}
.cBlockIcon i {
    background-color: #fff !important;
    -webkit-print-color-adjust: exact;
    font-size: 18px;
    height: 30px;
    width: 30px;
    text-align: center;
    line-height: 30px;
    border-radius: 50%;
}
h5.cTitle{
    margin: 0 0 8px;
    color: #ffffff !important;
    -webkit-print-color-adjust: exact;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 16px;
}
.cBlockData{
    color: #ffffff !important;
    font-size: 13px;
    -webkit-print-color-adjust: exact;
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