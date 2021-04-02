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



/****Notification Blocks****/

span.entry_count {

    position: absolute;
    top: -15px;
    background: #ff4c6b;
    height: 20px;
    width: 20px;
    text-align: center;
    line-height: 18px;
    color: #fff;
    border-radius: 50%;
    right: -6px;
    font-weight: 600;
    font-size: 13px;

}

li.notifications_body {

    position:relative;

}

body .notification_bg {
    display: none;
    position: absolute;
    left: 0;
    top: 0;
    background: rgba(0, 0, 0, 0.3);
    width: 100%;
    height: 100vh;
    z-index: 6;
}

body .notifications_body_block{
    display: none;
    position: absolute;
    width: 380px;
    background: #fff;
    border: 1px solid <?= $theme_color ?>;
    border-radius: 5px;
    box-shadow: 0px 0px 15px #909090;
    color: #fff;
    right: 150px;
    top: 75px;
    z-index: 7;
}

body .notifications_body_block:before {

    content: '';

    width: 0;

    height: 0;

    border-style: solid;

    border-width: 0 5px 10px 5px;

    border-color: transparent transparent <?= $theme_color ?> transparent;

    position: absolute;

    top: -10px;

    right: 14px;

}

.close_notification_panel {
    display: inline-block;
    text-align: right;
    position: absolute;
    right: -1px;
    top: 1px;
}

.close_notification_panel i {

    color: #c7c7c7 !important;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    line-height: 28px;
    text-align: center;
    font-size: 14px;
    cursor: pointer;

}

.notification_panel_content ul.nav.nav-tabs {

    display: inline-block;
    border-bottom: 1px solid #eaeaea;
    border: 0;
    background: #fff;
    margin-bottom: 0px;
    cursor: pointer;
    border-radius: 6px;

}

.notification_panel_content ul.nav.nav-tabs li{

    margin: 0 0 -2px 0;

}

.app_header .ico_wrap .notification_panel_content ul.nav.nav-tabs li:last-child{

    margin-right: 0 !important;

}

.notification_panel_content ul.nav.nav-tabs li a {

    font-size: 16px;
    font-weight: 300;
    color: #009898;
    padding: 6px 12px 6px 35px;
    position: relative;
    border-radius: 0;
    margin: -2px 5px 10px 4px;
    border-right: 0;

}

.notification_panel_content ul.nav.nav-tabs li.active a {

    background: <?= $theme_color ?>;
    color: #fff;

}

.notification_panel_content ul.nav.nav-tabs li a:before {

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

.notification_panel_content ul.nav.nav-tabs li.active a:before {

    border: 2px solid #006d6d;

    background:#006d6d;    

    border-radius: 50%;

}

.notification_panel_content .tab-content.responsive {

    color: #333;

    margin-top: 10px;

}

.notification_scroller {

    max-height: 60vh;

    overflow-y: scroll;

}

.notification_scroller::-webkit-scrollbar {

    height: 1px;

    width: 1px;

}

.notification_scroller::-webkit-scrollbar-track {

      background-color: #b3b3b3;

} /* the new scrollbar will have a flat appearance with the set background color */

 

.notification_scroller::-webkit-scrollbar-thumb {

      background-color: #ececec; 

} /* this will style the thumb, ignoring the track */

 

.notification_scroller::-webkit-scrollbar-button {

      background-color: #000;

      width:5px;

      height: 0px;

} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */

 

.notification_scroller::-webkit-scrollbar-corner {

      background-color: black;

      border-radius:25px;

}

.notification_scroller .all_notification a{

    color: #fff;

    text-decoration: none;

    font-size: 15px;

    display: block;

    padding: 5px 0;

    background: #009898;

    padding: 5px 0;

}

.notification_scroller li {

    display: block !important;

    position: relative;

    text-align: left;

    padding: 8px 0 8px 60px;

    margin: 0 !important;

    width: 100%;

    border-bottom: 1px solid #dddddd8f;

    cursor: pointer;

}

.notification_scroller li:before {

    content: '\f098';

    font-family: fontawesome;

    position: absolute;

    left: 23px;

    top: 11px;

    font-size: 18px;

    color: <?= $theme_color ?>;

}

.notification_scroller.notification_scroller_task li:before{

    content: '\f08d';

}

.notification_scroller li:last-child{

    border-bottom: 0;

}

.notification_scroller .single_notification h5.single_notification_text{

    color: #333;
    font-weight: 400;
    line-height: 25px;
    max-height: 25px;
    max-width: 95%;
    overflow: hidden;

}

.notification_scroller .single_notification p.single_notification_date_time{

    color: #929292;

}