<?php
include_once('../../model/model.php');
include_once('../../model/b2b_excursion/b2b_exc_save.php');

$b2b_exc_save = new b2b_exc_save_master;
$b2b_exc_save->service_update();
?>