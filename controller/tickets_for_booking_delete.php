<?php include "../model/model.php"; ?>
<?php

$ticket_id = $_POST['ticket_id'];

$model->ticket_for_traveler_delete($ticket_id);


?>