<?php 
include "../../../model/model.php";
include "../../../model/group_tour/bus/bus_master_save.php";

$bus_name = $_POST["bus_name"];
$bus_capacity = $_POST["bus_capacity"];

$bus_master_save = new bus_master_save();
$bus_master_save->bus_master_save_c($bus_name, $bus_capacity);
?>