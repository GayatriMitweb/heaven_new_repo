<?php
include_once('app_functions.php');
$sq_curr = mysql_fetch_assoc(mysql_query("select currency_code from currency_name_master where id='$currency'"));
$sq_settings = mysql_fetch_assoc(mysql_query("SELECT credit_card_charges,b2c_flag FROM app_settings where setting_id ='1'"));
$credit_card_charges = $sq_settings['credit_card_charges'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	  <title><?= ($app_name == '') ? 'iTours App' : $app_name ?></title>
	  <?php admin_header_scripts(); ?>
    <?php $new_array = get_cache_data(); ?>
</head>
<body>
<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">
<input type="hidden" id="currency_code" name="currency_code" value="<?= $sq_curr['currency_code'] ?>">
<input type="hidden" id='credit_card_charges' name='credit_card_charges' value="<?= $credit_card_charges ?>"/>
<input type="hidden" id="cache_data" name="cache_data" value='<?= $new_array ?>'>
<input type="hidden" id='b2c_flag' name='b2c_flag' value="<?= $sq_settings['b2c_flag'] ?>"/>


<div class="app_header main_block">
   <!--========*****Topbar*****========-->
   <?php include "admin_topbar.php"; ?>
</div>

<script type="text/javascript">
  $('#calendar').datetimepicker({ timepicker:false, format:'d-m-Y' });
</script>
<div class="sidebar_wrap">
  <!--========*****sidebar*****========-->
  <?php include "admin_sidebar.php"; ?>
</div>

<div class="app_content_wrap">