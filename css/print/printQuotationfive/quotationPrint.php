<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
?>

section.landingSec {
    position: relative;
    background-color: #e3e0d1 !important;
    -webkit-print-color-adjust: exact;

}
section.landingSec img {
    width: 535px;
    height: 1144px;
    border-right: 5px solid <?= $theme_color ?>;
}
span.landingPageId {
    position: absolute;
    left: 30px;
    top: 30px;
    color: #2c3642 !important;
    background-color: rgba(255, 255, 255, 0.6) !important;
    -webkit-print-color-adjust: exact;
    padding: 10px 15px;
    font-weight: 500;
    font-size: 13px;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 8px;
}
h1.landingpageTitle {
    position: absolute;
    margin: 0;
    width: auto;
    top: 80px;
    right: 0;
    font-size: 30px;
    line-height: 32px;
    color: #ffffff !important;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    text-align: center;
    font-weight: 400;
    padding: 25px;
    min-width:350px;
}
.packageDeatailPanel {
    position: absolute;
    width: 273px;
    right: 0;
    bottom: 0;
    padding-bottom: 30px;
}
.detailBlock {
    display: block;
    width: 100%;
    height: 100px;
    padding-left: 40px;
}
.detailBlockIcon {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    font-size: 21px;
    width: 45px;
    height: 45px;
    line-height: 45px;
    text-align: center;
    transform: rotate(45deg);
    border-radius: 10px;
    position: absolute;
    left: -25px;
}
.detailBlockIcon i {
    font-size: 24px;
    transform: rotate(-45deg);
}
.detailBlockIcon i:before {
    color: #fff !important;
    -webkit-print-color-adjust: exact;
}
.detailBlockContent h3.contentValue {
    margin: 0 0 10px 0;
    font-size: 16px;
}
h3.customerFrom {
    font-size: 14px;
    margin-top: 0px;
    margin-bottom: 50px;
    line-height: 30px;
    background-color: <?= $theme_color ?> !important;
    text-transform: capitalize;
    color: #fff !important;
    -webkit-print-color-adjust: exact;
    font-weight: 400;
    padding: 0 15px;
}
.landigPageCustomer span {
    padding-left: 40px;
    position: relative;
    display: block;
    margin: 0;
}
.landigPageCustomer span em {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    font-size: 13px;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    transform: rotate(45deg);
    margin: 0 30px 0 -33px;
    position: absolute;
    top: 0;
    left: 15.5px;
}
.landigPageCustomer span i {
    transform: rotate(-45deg);
}
.landigPageCustomer span em i:before {
    color: #fff !important;
}

.travsportInfoBlock {
    border: 1px solid <?= $theme_color ?>;
    position: relative;
    width: 100%;
}
.transportIcon {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    position: absolute;
    width: 160px;
    height: 100%;
    top: 0;
}
.transportDetailsleft .transportIcon{
    left: 0;
}
.transportDetailsright .transportIcon{
    right: 0;
}
.transportIcon img {
    width: 100px;
    position: absolute;
    top: calc(50% - 50px);
    left: calc(50% - 50px);
}
.transportDetails {
    width: 80%;
    position: relative;
    min-height: 150px;
    display : inline-block;
}
.transportDetailsleft .transportDetails {
    margin-left: 20%;
}
.transportDetails .transportDetailsHalf {
    display: table;
    position: absolute;
    top: 0;
    min-height: 130px;
    width: 50%;
    text-align: center;
}
.transportDetailsHalf.leftHalf {
    left: 0;
}
.transportDetailsHalf.rightHlf {
    right: 0;
}
.transportDetailsHalf .transportDetailText{
  display: table-cell;
  vertical-align: middle;
}
.transportDetailsHalf .transportDetailText p{
    margin-bottom: 5px;
}



section.print_single_itinenary {
    list-style-type: none;
    width: 95%;
    border: 1px solid <?= $theme_color ?>;
    margin: 30px 0;
}
section.print_single_itinenary.leftItinerary{
    float: right;
    border-right: 0;
}
section.print_single_itinenary.rightItinerary{
    float: left;
    border-left: 0;
}
.itneraryImg {
    width: 40%;
    padding: 0 25px 0 15px;
}
.leftItinerary .itneraryImg{ float: left; }
.rightItinerary .itneraryImg{ float: right; }
.itneraryImgblock {
    position: relative;
    z-index: 0;
}
.itneraryImgblock:after {
    position: absolute;
    content: '';
    width: 100%;
    height: 100%;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    left: 10px;
    top: 10px;
}
.itneraryImg img {
    margin-top: -30px;
    position: relative;
    margin-bottom: 30px;
    z-index: 1;
}
.itneraryDayAccomodation {
    margin-bottom: 20px;
}
.itneraryDayAccomodation span {
    display: block;
    margin: 10px 0;
}
.itneraryDayAccomodation span i:before {
    color: <?= $theme_color ?> !important;
    font-size: 18px;
    margin-right: 10px;
    width: 16px;
    display: inline-block;
}
.itneraryText {
    padding: 15px;
}
.itneraryDayInfo {
    margin-bottom: 10px;
}
.itneraryDayInfo i:before {
    font-size: 26px;
    color: <?= $theme_color ?> !important;
    margin-right: 10px;
}
.itneraryDayInfo span {
    font-weight: 500;
}
.itneraryDayPlan p {
    font-size: 12px;
    max-height: 200px;
    overflow: hidden;
}

.incluExcluTermsTabPanel {
    width: 90%;
    border: 1px solid <?= $theme_color ?>;
    padding: 15px;
    position: relative;
}
.inclusions{ 
    float: right; 
    border-right: 0;
}
.exclusions{ 
    float: left; 
    border-left: 0;
    background-color: #f7f7f7 !important;
    -webkit-print-color-adjust: exact;
}
h3.incexTitle {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    color: #fff !important;
    width: auto;
    position: absolute;
    top: -33px;
    left: 50px;
    font-size: 18px;
    padding: 0 15px;
    line-height: 30px;
}
.termsPanel {
    width: 80%;
    margin: 0 auto;
}
h3.incexTitleTwo {
    font-size: 18px;
    color: <?= $theme_color ?> !important;
}

h3.endingPageTitle {
    margin-bottom: 30px;
    color: <?= $theme_color ?> !important;
}
.iconPassengerBlock {
    position: relative;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
}
.iconPassengerBlock:before {
    position: absolute;
    content: '';
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    height: 41px;
    width: 15px;
    left: -15px;
    top: calc(50% - 21px);
}
.iconPassengerBlock:after {
    position: absolute;
    content: '';
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    height: 41px;
    width: 15px;
    right: -15px;
    top: calc(50% - 21px);
}
.iconPassengerSide {
    position: absolute;
    width: 25%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.25) !important;
    -webkit-print-color-adjust: exact;
}
.iconPassengerSide.leftSide {
    left: 0;
    top: 0;
}
.iconPassengerSide.leftSide:before {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 60px 60px 0 0;
    border-color: #ffffff transparent transparent transparent;
    left: -1px;
    top: -1px;
}
.iconPassengerSide.leftSide:after {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 60px 0 0 60px;
    border-color: transparent transparent transparent #ffffff;
    left: -1px;
    bottom: -1px;
}
.iconPassengerSide.rightSide {
    right: 0;
    top: 0;
}
.iconPassengerSide.rightSide:before {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 60px 60px 0;
    border-color: transparent #ffffff transparent transparent;
    right: -1px;
    top: -1px;
}
.iconPassengerSide.rightSide:after {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 0 60px 60px;
    border-color: transparent transparent #ffffff transparent;
    right: -1px;
    bottom: -1px;
}
.passengerPanel .iconPassenger {
    width: 50%;
    margin: 0 auto;
    padding: 15px 15px 60px 15px;
}
.passengerPanel h4 {
    position: absolute;
    width: 100%;
    text-align: center;
    bottom: 15px;
    left: 0;
    color: #fff !important;
}
.iconPassengerBlock i {
    position: absolute;
    left: -20px;
    top: calc(50% - 7px);
}
.iconPassengerBlock i:before {
    color: #fff !important;
}


.constingBankingPanelRow{
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    min-height: 819px;

}
.constingBankingPanel.constingPanel {
    position: relative;
}
.constingBankingPanel.constingPanel:after {
    position: absolute;
    content: '';
    width: 100%;
    height: 4px;
    background-color: #fff !important;
    -webkit-print-color-adjust: exact;
    bottom: -30px;
    left: 0;
    border-radius: 25px;
}
h3.costBankTitle.text-center {
    color: #fff !important;
    margin: 30px 0;
    text-transform: capitalize;
}
.constingBankingPanel .icon img {
    width: 50px;
    margin: 0 auto 10px;
}
.constingBankingPanel h4 {
    color: #fff !important;
    line-height: 30px;
}
.constingBankingPanel p {
    font-size: 14px;
    color: #fff !important;
}
.constingBankingPanel .icon {
    padding: 10px 0;
}
.constingBankingPanel p {
    padding-bottom: 10px;
}
.constingBankingwhite {
    background-color: #fff !important;
    -webkit-print-color-adjust: exact;
}
.constingBankingwhite .icon img{
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
}
.constingBankingwhite h4 {
    color: <?= $theme_color ?> !important;
}
.constingBankingwhite p {
    color: <?= $theme_color ?> !important;
}

.companyLogo {
    height: 175px;
    max-height: 175px;
}
.companyLogo img {
    margin: 20px 0 0 0;
    max-height: 175px;
}
.companyContactDetail h3 {
    color: <?= $theme_color ?> !important;
    margin-bottom: 50px;
    text-transform: uppercase;
}
.contactBlock {
    width: 50%;
    margin: 0 auto 40px;
}
.contactBlock i {
    margin-bottom: 10px;
}
.contactBlock i:before {
    color: <?= $theme_color ?> !important;
    font-size: 36px;
}



@media print {
    table tr.table-heading-row th, table tfoot tr td{
        -webkit-print-color-adjust: exact; 
    }
}