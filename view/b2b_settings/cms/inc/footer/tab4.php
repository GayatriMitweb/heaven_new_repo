<?php
$terms_cond = $query1['terms_cond'];
$privacy_policy = $query1['privacy_policy'];
$cancellation_policy = $query1['cancellation_policy'];
$refund_policy = $query1['refund_policy'];
$careers_policy = $query1['careers_policy'];
?>
<div class="row mg_bt_20">
    <div class="col-md-6 mg_bt_10">
        <h3 class="editor_title">Terms & Conditions</h3>
        <textarea class="feature_editor" id="terms_cond" style="width:100%" name="terms_cond" title="Terms & Conditions"><?= $terms_cond ?></textarea>
    </div>  
    <div class="col-md-6 mg_bt_10">
        <h3 class="editor_title">Privacy Policy</h3>
        <textarea class="feature_editor" id="privacy" style="width:100%" name="privacy" title="Privacy Policy"><?= $privacy_policy ?></textarea>
    </div>  
    <div class="col-md-6 mg_bt_10">
        <h3 class="editor_title">Cancellation Policy</h3>
        <textarea class="feature_editor" id="cancellation" style="width:100%" name="cancellation" title="Cancellation Policy"><?= $cancellation_policy ?></textarea>
    </div>  
    <div class="col-md-6 mg_bt_10">
        <h3 class="editor_title">Refund Policy</h3>
        <textarea class="feature_editor" id="refund" style="width:100%" name="refund" title="Refund Policy"><?= $refund_policy ?></textarea>
    </div>  
    <div class="col-md-6">
        <h3 class="editor_title">Careers</h3>
        <textarea class="feature_editor" id="careers" style="width:100%" name="careers" title="Careers"><?= $careers_policy ?></textarea>
    </div>    
    <div class="col-md-6 mg_tp_10">
        <h3 class="editor_title">Copyright Text</h3>
        <input type="text" id="copyright_text" data-toggle="tooltip" placeholder="Copyright Text" title="Copyright Text" value="<?= $query1['footer_strip'] ?>" onchange="validate_char_size(this.id,40);"/>
    </div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>