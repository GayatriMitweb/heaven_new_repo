<?php include_once('app_functions.php');
$sq_settings = mysql_fetch_assoc(mysql_query("SELECT credit_card_charges,b2c_flag FROM app_settings where setting_id ='1'"));
$credit_card_charges = $sq_settings['credit_card_charges'];?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= ($app_name == '') ? 'iTours App' : $app_name ?></title>

	<?php fullwidth_header_scripts(); ?>
  
</head>
<body>
<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">
<input type="hidden" id='credit_card_charges' name='credit_card_charges' value="<?= $credit_card_charges ?>"/>
<input type="hidden" id='b2c_flag' name='b2c_flag' value="<?= $sq_settings['b2c_flag'] ?>"/>

<div class="app_container">
<div class="app_wrap main_block">


<div class="fullwidth_header main_block">
	<div class="col-sm-4 col-xs-6">
     <a class="btn btn-info btn-sm ico_left mg_tp_10" data-toggle="tooltip" data-placement="bottom" title="Dashboard" href="<?php echo BASE_URL ?>view/dashboard/dashboard_main.php"><i class="fa fa-tachometer"></i><span class="">&nbsp;&nbsp;Dashboard</span></a>
	</div>
	<div class="col-sm-8 col-xs-6 mg_tp_10_sm_xs">
		<div class="app_ico_wrap main_block text-right">
			<ul class="hidden-xs">
				<?php topbar_icon_list() ?>
				
			</ul>

                <?php $new_array = get_cache_data(); ?>
			<input type="hidden" id="cache_data" name="cache_data" value='<?= $new_array ?>'>
			<div class="dropdown pull-right visible-xs">
			  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			    <i class="fa fa-cog" aria-hidden="true"></i>
			    <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    <?php topbar_icon_list() ?>
			  </ul>
			</div>
		</div>
	</div>
</div>

<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">


