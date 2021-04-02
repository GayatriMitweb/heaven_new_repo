<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
?>

.landingPageTop {
    position: relative;
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
h1.landingpageTitle {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    margin: 0;
    text-align: right;
    padding: 15px 30px;
    font-size: 24px;
    color: #fff !important;
    position: absolute;
    width: 100%;
    top: 0;
}
h1.landingpageTitle:before {
    position: absolute;
    content: '';
    width: 50px;
    height: 120%;
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    left: calc(7% + 12px);
    top: 0;
}
.packageDeatailPanel {
    position: absolute;
    bottom: 19px;
    left: 7%;
}
.landigPageCustomer {
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    width: 90%;
    margin: 0 auto -20px;
    z-index: 1;
    position: relative;
    padding: 10px;
    font-size: 10px;
}
.landigPageCustomer:before {
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    position: absolute;
    content: '';
    width: 60px;
    height: 10px;
    left: 0px;
    top: -10px;
}
h3.customerFrom {
    color: #fff !important;
    font-size: 13px;
    margin: 0 0 10px 0;
    padding-left: 13px;
}
.landigPageCustomer span {
    line-height: 30px;
    padding-left: 45px;
    position: relative;
    color: #fff !important;
}
.landigPageCustomer span em {
    position: absolute;
    left: 10px;
}
.landigPageCustomer span i:before {
    color: #fff !important;
}
.landingPageBlocks {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    padding: 20px 15px 15px 90px;
}
.landingPageBlocks:after {
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    position: absolute;
    content: '';
    width: 60px;
    height: 36px;
    left: 13px;
    bottom: -20px;
}
.detailBlock {
    position: relative;
    line-height: 60px;
}
.detailBlockIcon {
    position: absolute;
    left: -77px;
    top: 0;
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    width: 60px;
    height: 60px;
    line-height: 60px;
    text-align: center;
}
.detailBlockIcon i:before {
    font-size: 21px;
    color: #fff !important;
}
.detailBlock p {
    margin: 0;
    color: #fff !important;
    font-size: 12px;
    line-height: 60px;
}

.travsportInfoBlock {
    border: 1px dashed #000;
    border-top: 0;
    position: relative;
    width: 80%;
    margin: 0 auto;
    min-height: 200px;
}
.transportDetailsLeftPanel .travsportInfoBlock{
    border-right: 0;
}
.transportDetailsRightPanel .travsportInfoBlock{
    border-left: 0;
}
.transportDetailsLastPanel .travsportInfoBlock{
    border-bottom: 0;
}
.transportIcon {
    position: absolute;
    width: 150px;
    height: 150px;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    padding: 20px;
    top: calc(50% - 75px);
}
.transportDetailsLeftPanel .transportIcon{
    left: -75px;
}
.transportDetailsRightPanel .transportIcon{
    right: -75px;
}
.transportIcon:after {
    position: absolute;
    content: '';
    height: 14px;
    width: 20px;
    background-color: #fff !important;
    -webkit-print-color-adjust: exact;
    top: calc(50% - 7px);
}
.transportDetailsLeftPanel .transportIcon:after{
    right: -10px;
}
.transportDetailsRightPanel .transportIcon:after{
    left: -10px;
}
.transportDetails {
    width: 80%;
    padding-top: 20px;
}
.transportDetailsLeftPanel .transportDetails{
    margin-left: 15%;
}
.transportDetailsPanel table tr.table-heading-row th {
    background-color: #c8d4e2 !important;
    -webkit-print-color-adjust: exact;
    border: 0 !important;
}

ul.print_itinenary li {
    list-style-type: none;
    display: inline-block;
    width: 33.33%;
    border: 1px dashed #51514f;
    position: relative;
    min-height: 450px;
    margin: 50px -2px 0;
    padding: 15px;
}
ul.print_itinenary li.topItinerary{
    border-bottom: 0;
}
ul.print_itinenary li.bottomItinerary{
    border-top: 0;
}
li .itineraryContent {
    position: absolute;
    width: 100%;
    left: 0;
}
li.topItinerary .itineraryContent {
    top: -70px;
}
li.bottomItinerary .itineraryContent {
    bottom: -70px;
}
.itneraryImg {
    width: 250px;
    margin: 0 auto;
    position: relative;
}
.itneraryImg:before {
    position: absolute;
    content: '';
    width: 100%;
    height: 100%;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    z-index: 0;
    left: -5px;
    bottom: -5px;
}
.itneraryImg img {
    border: 3px solid <?= $theme_color ?>;
    z-index: 1;
    position: relative;
}
li.topItinerary .itneraryText {
    padding: 30px 10px 10px 10px;
}
li.bottomItinerary .itneraryText {
    padding: 10px 10px 30px 10px;
}
.itneraryText i:before {
    color: #51514f !important;
    font-size: 16px;
    margin-right: 10px;
}
.itneraryDayInfo span {
    font-weight: 500;
    color: #51514f !important;
    font-size: 13px;
}
.itneraryDayPlan p {
    color: #51514f !important;
    font-size: 12px;
    line-height: 18px;
    max-height: 310px;
    overflow: hidden;
}
.itneraryDayAccomodation span {
    color: #51514f !important;
    font-size: 12px;
    display: block;
    margin: 10px 0;
}

.incluExcluTermsTabPanel {
    margin-top: auto;
    padding: 15px;
    position: relative;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
}
h3.incexTitle {
    color: #ffffff !important;
    font-size: 16px;
    margin: 0;
}
.incluExcluTermsTabPanel.inclusions {
    margin-bottom: 30px;
    padding-top: 25px;
}
.incluExcluTermsTabPanel.inclusions:before {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 20px 40px 20px;
    border-color: transparent transparent #51514f transparent;
    top: -25px;
}
.incluExcluTermsTabPanel.exclusions  {
    padding-bottom: 25px;
}
.incluExcluTermsTabPanel.exclusions:before {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 40px 20px 0 20px;
    border-color: #51514f transparent transparent transparent;
    bottom: -25px;
}
h3.termsConditionsTitle {
    margin: 0;
    font-size: 16px;
    color: #51514f !important;
}
.tabContent pre.real_text, .tabContent pre.real_text ul li, .tabContent pre.real_text span, .tabContent pre.real_text div, .tabContent pre.real_text p {
    color: #fff !important;
    font-size:12px;
    line-height:18px;
}
.termsConditions pre.real_text, .termsConditions pre.real_text ul li, .termsConditions pre.real_text span, .termsConditions pre.real_text div, .termsConditions pre.real_text p {
    color: #51514f !important;
    font-size:12px;
    line-height:18px;
}


h3.endingPageTitle {
    margin-bottom: 30px;
    color: <?= $theme_color ?> !important;
    font-size: 18px;
}
.passengerPanel .icon {
    width: 200px;
    margin: 20px auto;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    padding: 60px;
    position: relative;
}
.passengerPanel h4 {
    position: absolute;
    width: 100%;
    text-align: center;
    bottom: 20px;
    left: 0;
    color: #fff !important;
}
.passengerPanel .icon i {
    position: absolute;
    bottom: -22.5px;
    left: calc(50% - 9px);
}
.passengerPanel .icon i:before {
    font-size: 24px;
    color: #51514f !important;
}



.constingBankingPanel {
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    margin: 10px 0;
    min-height: 300px;
}
h3.costBankTitle {
    color: #fff !important;
    margin: 30px 0;
    text-transform: capitalize;
    font-size: 18px;
}
.constingBankingPanel .icon img {
    width: 30px;
    margin: 0 auto 10px;
}
.constingBankingPanel h4 {
    color: #fff !important;
    line-height: 30px;
}
.constingBankingPanel p {
    font-size: 12px;
    color: #fff !important;
}

.contactPanel {
    width: 48%;
    margin: 50px auto 0;
    position: relative;
}
.contactPanel:before{
    position:absolute;
    content:'';
    width:70px;
    height:120%;
    left:20px;
    bottom:-10%;
    background-color: #51514f !important;
    -webkit-print-color-adjust: exact;
    z-index: 1;
}
.companyLogo {
    height: 175px;
    max-height: 175px;
    width: 300px;
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    margin-left: 50px;
    position: relative;
    z-index: 9;
    padding: 15px;
    display: inline-block;
}
.companyLogo img {
    max-height: 175px;
    position: absolute;
    left: calc(50% - 111px);
    top: calc(50% - 41px);
}
.companyContactDetail .contactBlock {
    background-color: <?= $theme_color ?> !important;
    -webkit-print-color-adjust: exact;
    padding: 15px 15px 15px 100px;
    margin: 20px 0;
    position: relative;
}
.contactBlock i {
    position: absolute;
    left: 50px;
}
.contactBlock i:before {
    color: #fff !important;
    font-size: 21px;
    z-index: 9;
    position: relative;
}
.contactBlock p {
    margin: 0;
    color: #fff !important;
}



@media print {
    table tr.table-heading-row th, table tfoot tr td{
        -webkit-print-color-adjust: exact; 
    }
}