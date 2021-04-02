<?php
include_once('../../model/model.php');
header("Content-type: text/css");

global $theme_color, $theme_color_dark, $theme_color_2, $topbar_color, $sidebar_color;
?>
html,body{
	margin:0;
	padding:0;
}
.login_screen{
	background: url(../../images/login_bg.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
    height: 100vh;
}
.login_screen:before {
    position: absolute;
    content: '';
    width: 25%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    left: 0;
    top: 0;
}
.login_wrap{
	background: #fff;
    width: 600px;
    left: 25%;
    top: 50%;
    margin: 0 auto;
    margin-top: -175px;
    margin-left: -225px;
    position: absolute;
    padding-top: 70px;
    box-shadow: 2px 0px 5px 2px rgba(0, 0, 0, 0.28);
}
.login_wrap h3{
    margin: 0;
    position: absolute;
    top: 35px;
    left: 45px;
    font-size: 21px;
    color: #444;
    font-weight: 300 !important;
}
.logo-wrap{
	height: 140px;
	width: 140px;
	border-radius: 50%;
	right:50px;
	top:-70px;
	background: #fff;
	position: absolute;
	display:flex;
	box-shadow: 2px 3px 2px #D7D7D7;
    z-index: 1
}
.logo-wrap img{
	max-width: 100%;
	height: auto;
	margin:auto;
}
.login_wrap_inner{
    padding: 20px 50px;
    background: #fff;
    z-index: 1;
    position: relative;
    margin-top: 3px;
}
.div_version{
	padding:9px 10px;
    background: <?= $theme_color ?>;
    color: #fff;
    text-align: center;
    font-size: 19px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}
.btn, .form-control{
	border-radius:0;
}

label.error{
    color: #a94442;
    width: 100%;
    line-height: 34px;
    margin-left: 8px;
    position: relative;
}

.login_wrap button {
    width: 100%;
    height: 42px;
}
input, select{height: 42px !important;}


@media screen and (max-width:992px){
    .login_wrap{
        margin-left: -125px;
    }   
}

@media screen and (max-width:768px){
    .login_wrap{
        padding-top: 102px;
        min-width: 84%;
        width: auto;
        margin-top: 0;
        margin-left: 0;
        top: 120px;
        left: 8%;
    }  
    .login_wrap_inner {
        padding: 20px 25px;
    }
    .login_wrap h3 {
    top: 80px;
}
}


