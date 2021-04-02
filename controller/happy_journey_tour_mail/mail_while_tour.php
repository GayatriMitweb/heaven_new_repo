<?php
include('../../model/model.php');
include ('../../model/mail_while_tour.php');

$jurney_mail = new jurney_mail;
$jurney_mail->mail_send();
?>