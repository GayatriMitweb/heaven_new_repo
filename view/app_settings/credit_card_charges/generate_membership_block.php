<?php
include '../../../model/model.php';
$dynamic_div_count = $_POST['dynamic_div_count'];
?>
<div id="block<?= $dynamic_div_count ?>">
<?php
if($dynamic_div_count!=0){
    ?>
    <div class="col-sm-2 col-xs-12 pull-right text-right mg_tp_10">

        <button type="button" class="btn btn-danger btn-sm" onclick="close_block('block<?= $dynamic_div_count ?>')"><i class="fa fa-times"></i></button>
    </div>
    <?php	
}
?>
    <div class="row mg_tp_10">
        <div class="col-md-4">
            <input type="text" id="membership_no<?=$dynamic_div_count?>" name="membership_no<?=$dynamic_div_count?>" class="form-control" placeholder="*Membership Establishment No<?=($dynamic_div_count+1)?>" title="Membership Establishment No" required>
        </div>
        <div class="col-md-4">
            <input type="number" id="identifier_count<?=$dynamic_div_count?>" name="identifier_count<?=$dynamic_div_count?>" onchange="generate_identifier_block(this.id,<?=$dynamic_div_count?>)" title="Identifier No Count" placeholder="*Identifier No Count" class="form-control" min='0' maxlength="9"/>
        </div>
    </div>
    <div class="row mg_tp_10">
        <div id="credit_identifier_block<?=$dynamic_div_count?>"></div>
    </div>
</div>
<hr/>