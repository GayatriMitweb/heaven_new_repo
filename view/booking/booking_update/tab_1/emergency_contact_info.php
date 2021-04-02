<h5 class="booking-section-heading main_block">Emergency Contact</h5>
<div class="row mg_bt_10">
    <div class="col-sm-1 col-xs-2 mg_bt_10_xs">
        <select class="form-control pull-left" id="cmb_r_honorific" title="Honorific" name="cmb_r_honorific">
            <option value="<?php echo $tourwise_details['relative_honorofic'] ?>"><?php echo $tourwise_details['relative_honorofic'] ?></option>
            <option value="Mr."> Mr. </option>
            <option value="Mrs"> Mrs </option>
            <option value="Mas"> Mas </option>
            <option value="Miss"> Miss </option>
            <option value="Smt"> Smt </option>
        </select>
    </div>
    <div class="col-md-3 col-sm-7 col-xs-10 mg_bt_10_xs">
        <input class="form-control" type="text" id="txt_r_name" name="txt_r_name"  onchange="fname_validate(this.id)" placeholder="Enter Full Name" title="Full Name" value="<?php echo $tourwise_details['relative_name'] ?>"/>
    </div>

    <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_xs">
        <select class="form-control" id="cmb_relation" title="Relation" name="cmb_relation" > 
        <?php 
            if($tourwise_details['relative_relation']!=''){
        ?>
            <option  value="<?php echo $tourwise_details['relative_relation'] ?>"> <?php echo $tourwise_details['relative_relation'] ?> </option>
        <?php } ?>
            <?php get_relation_dropdown() ?>
        </select>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <input class="form-control" type="text" id="txt_r_mobile" onchange="mobile_validate(this.id)" name="txt_r_mobile" title="Mobile Number" placeholder="Enter Mobile Number" value="<?php echo $tourwise_details['relative_mobile_no'] ?>"/>
    </div>

</div>



<script>
$(document).ready(function() {
    $("#txt_r_city, #txt_r_state").select2();   
});
</script>