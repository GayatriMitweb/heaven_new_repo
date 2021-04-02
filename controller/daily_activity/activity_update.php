<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/transport_agency/transport_agency_bus.php"; 

$bus_id = $_POST["bus_id"];
$bus_name = $_POST["bus_name"];
$bus_capacity = $_POST["bus_capacity"];
$per_day_cost = $_POST["per_day_cost"];
$status = $_POST["status"];

$transport_agency_bus = new transport_agency_bus();
$transport_agency_bus->transport_agency_bus_master_update($bus_id, $bus_name, $bus_capacity,$per_day_cost, $status);
?>