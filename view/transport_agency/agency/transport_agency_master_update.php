<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');

$transport_agency_id = $_POST['cmb_transport_agency_id'];
$sq_transport_agency = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
?>
<?= begin_panel('Transport Agency Information Save') ?>

<form id="frm_transport_agency_update">

<input type="hidden" id="txt_transport_agency_id" name="txt_transport_agency_id" value="<?php echo $transport_agency_id ?>">

  
  <div class="row mg_bt_10">
    <div class="col-md-3 col-sm-6  mg_bt_10_sm_xs">
      <select id="cmb_city_id" name="cmb_city_id" style="width:100%" onchange="tour_city_list_load(this.id)" class="form-control">
          <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_transport_agency[city_id]'")); ?>
          <option value="<?php echo $sq_transport_agency['city_id'] ?>"><?php echo $sq_city['city_name'] ?></option>
          <option value="">Select City Name</option>
          <?php 
           $sq_tour_info = mysql_query("select * from city_master");
           while($row = mysql_fetch_assoc($sq_tour_info))
           {
           ?>
           <option value="<?php echo $row['city_id'] ?>"><?php echo $row['city_name'] ?></option>
           <?php   
           }    
          ?>
      </select>
    </div>
    <div class="col-md-3 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_transport_agency_name" name="txt_transport_agency_name" placeholder="Transport Agency Name" value="<?php echo $sq_transport_agency['transport_agency_name'] ?>">                               
    </div>
    <div class="col-md-2 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_mobile_no" name="txt_mobile_no" onchange="mobile_validate(this.id)" placeholder="Mobile Number" value="<?php echo $sq_transport_agency['mobile_no'] ?>">
    </div>
    <div class="col-md-2 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_email_id" name="txt_email_id" onchange="validate_email(this.id)" placeholder="Email Address" value="<?php echo $sq_transport_agency['email_id'] ?>">
    </div>
    <div class="col-md-2 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_contact_person_name" name="txt_contact_person_name" placeholder="Contact Person Name" value="<?php echo $sq_transport_agency['contact_person_name'] ?>">
    </div>
   
  </div>

  <div class="row mg_bt_10">
    <div class="col-md-12 col-sm-12  mg_bt_10_sm_xs">
      <textarea id="txt_transport_agency_address" name="txt_transport_agency_address" class="form-control" placeholder="Transport Agency Address"><?php echo $sq_transport_agency['transport_agency_address'] ?></textarea>
    </div>
  </div>

<div class="row col-md-12 text-center mg_tp_20">
    <button class="btn btn-success"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update Transport Agency</button>
</div>              
 
</form>
                           
 
<?= end_panel() ?>

<script src="../js/transport_agency.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>