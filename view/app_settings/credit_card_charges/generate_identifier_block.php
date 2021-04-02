<?php
include '../../../model/model.php';
$identifier_count = $_POST['identifier_count'];
$membership_no = $_POST['membership_no'];

for($i = 1; $i <= $identifier_count; $i++){
?>
    <div class="col-md-4 mg_bt_10">
        <input type="number" id="identifier<?= $membership_no.$i ?>" name="identifier<?= $i ?>" class="form-control" placeholder="*Identifier No <?= $i ?>" title="Identifier No">
    </div>
<?php } ?>