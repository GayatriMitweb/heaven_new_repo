<?php 
include "../../../model/model.php";
include_once('../../layouts/fullwidth_app_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$tourwise_id = $_POST['booking_id'];
$branch_status = $_POST['branch_status'];

$sq_tourwise_id = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id' "));

$tour_id = $sq_tourwise_id['tour_id'];
$tour_group_id = $sq_tourwise_id['tour_group_id'];
$traveler_group_id = $sq_tourwise_id['traveler_group_id'];
$reflections = json_decode($sq_tourwise_id['reflections']);
$tour_name_sq = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$tour_id'"));
$tour_name = $tour_name_sq['tour_name'];
$tour_group_sq = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'"));
$tour_group_name = date("d-m-Y", strtotime($tour_group_sq['from_date']))." to ".date("d-m-Y", strtotime($tour_group_sq['to_date']));

$tourwise_details = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
$date = $tourwise_details['form_date'];
$yr = explode("-", $date);
$year =$yr[0];
?>
<input type="hidden" id="cmb_tour_name" name="cmb_tour_name" value="<?php echo $tour_id; ?>">
<input type="hidden" id="txt_tourwise_id" name="txt_tourwise_id" value="<?php echo $tourwise_id; ?>">
<input type="hidden" id="hotel_markup" name="hotel_markup" value="<?php echo $reflections[0]->hotel_markup ?>">
<input type="hidden" id="hotel_taxes" name="hotel_taxes" value="<?php echo $reflections[0]->hotel_taxes ?>">
<input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes" value="<?php echo $reflections[0]->hotel_markup_taxes ?>">
<input type="hidden" id="hotel_tds" name="hotel_tds" value="<?php echo $reflections[0]->hotel_tds ?>">
<div class="bk_tab_head bg_light">
    <ul>
        <li>
            <a href="javascript:void(0)" id="tab_1_head" class="active">
                <span class="num">1<i class="fa fa-check"></i></span><br>
                <span class="text">Tour Details</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_2_head">
                <span class="num">2<i class="fa fa-check"></i></span><br>
                <span class="text">Travelling</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_3_head">
                <span class="num">3<i class="fa fa-check"></i></span><br>
                <span class="text">Receipt</span>
            </a>
        </li>
    </ul>
</div>

<div class="bk_tabs">
    <div id="tab_1" class="bk_tab active">
        <?php include_once('tab_1/tab_1.php') ?>
    </div>
    <div id="tab_2" class="bk_tab">
        <?php include_once('tab_2/tab_2.php') ?>
    </div>
    <div id="tab_3" class="bk_tab">
        <?php include_once('tab_3/tab_3.php') ?>
    </div>
</div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script src="../js/calculations.js"></script>
<script src="../js/business_rule.js"></script>
<?php 
include_once('../../layouts/fullwidth_app_footer.php');
?>