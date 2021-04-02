<?php
include "../model/encrypt_decrypt.php";
global $encrypt_decrypt;
$tempString = $_POST['tempString'];
$secret_key = $_POST['secret_key'];
$result = $encrypt_decrypt->fnDecrypt($tempString,$secret_key);
echo $result;
?>