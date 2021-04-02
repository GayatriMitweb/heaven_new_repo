<?php 
include_once('../../../model/model.php');
header("Content-type: text/css");
global $theme_color;
?>


.report_menu .navbar-default {
    border: 0;
}
.report_menu .collapse.navbar-collapse {
    background: transparent;
    padding: 0;
}
.report_menu .collapse.navbar-collapse:before, .report_menu .collapse.navbar-collapse:after{
    display: none;
}
.report_menu ul.nav.navbar-nav{
    background: <?= $theme_color ?>;
    border-radius:5px;
}
.report_menu ul.nav.navbar-nav li {
    border-right: 1px solid #85b1b1;
}
.report_menu ul.nav.navbar-nav li:last-child {
    border-right: 0;
}
.report_menu ul.nav.navbar-nav li a {
    color: #ffffff;
    padding: 2px 25px;
    text-align: center;
    transition: 0.5s;
}
.report_menu ul.nav.navbar-nav li:hover a {
    background: rgba(0, 0, 0, 0.25) !important;
}
.report_menu ul.dropdown_menu {
    position: absolute;
    left: 0;
    top: 60px;
    min-width: 230px;
    width: max-content;
    overflow: hidden;
    background: #424852;
    text-align: left;
    height: auto;
    display : none;
    transition: 0.5s;
    z-index : 99;
}
.report_menu li.dropdown:hover .dropdown_menu, .report_menu li.active .dropdown_menu{
    display : block;
    top: 44px;
}
.report_menu li.dropdown:hover .dropdown_menu{
    z-index : 999;
}
.report_menu .dropdown_menu_two, .report_menu .dropdown_menu_three{
   display: none; 
}
.report_menu ul.dropdown_menu span{
        display: block;
    color: #fff;
    padding: 10px;
}

.report_menu ul.dropdown_menu span {
  cursor: pointer;
  border-bottom: 1px solid #32373e;
  border-left: 1px solid #32373e;
  border-right: 1px solid #32373e;
  padding: 10px 20px;
  z-index: 1;
  text-decoration: none;
  font-size: 13px;
  color: #eeeeee;
  background: #424852;
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
  padding-left: 35px;
  line-height: 16px;
}
.report_menu ul ul.dropdown_menu li:hover > span {
  background: #49505a;
  color: #ffffff;
}
.report_menu ul ul.dropdown_menu li:first-child > span {
  box-shadow: none;
}
.report_menu ul ul.dropdown_menu ul{
    padding-left :0 ;
}
.report_menu ul ul.dropdown_menu ul li span {
    padding-left: 55px;
    list-style-type: none;
    position: relative;
}
.report_menu ul ul.dropdown_menu ul li ul li span {
    padding-left: 85px;
    position: relative;
}
.report_menu li.dropdown_two, .report_menu li.dropdown_three{
    position: relative;
}
.report_menu li.dropdown_two:after, li.dropdown_three:after{
    position: absolute;
    content: "\f107";
    font-family:fontawesome;
    right: 10px;
    top: 12px;
    color: #ffffff;
    z-index: 1;
}
li.dropdown_two ul li span:before {
    content: '\f105';
    font-family: fontawesome;
    left: 35px;
    top: 12px;
    position: absolute;
}
.report_menu ul ul.dropdown_menu ul li ul li span:before{
    content: '\f105';
    font-family: fontawesome;
    left: 61px;
    top: 12px;
    position: absolute;
}




