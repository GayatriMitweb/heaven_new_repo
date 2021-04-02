<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Transport Agency Information Save') ?>

<form id="frm_transport_agency_save">

  
  <div class="row mg_bt_10">
    <div class="col-md-3 col-sm-6  mg_bt_10_sm_xs">
      <select id="cmb_city_id" name="cmb_city_id" style="width:100%" class="form-control">
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
      <input type="text" class="form-control"  id="txt_transport_agency_name" name="txt_transport_agency_name" placeholder="Transport Agency Name">                               
    </div>
    <div class="col-md-2 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_mobile_no" name="txt_mobile_no" onchange="mobile_validate(this.id)" placeholder="Mobile Number">
    </div>
    <div class="col-md-2 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_email_id" name="txt_email_id" onchange="validate_email(this.id)" placeholder="Email Address">
    </div>
    <div class="col-md-2 col-sm-6  mg_bt_10_sm_xs">
      <input type="text" class="form-control"  id="txt_contact_person_name" name="txt_contact_person_name" placeholder="Contact Person">
    </div>    
  </div>

  <div class="row mg_bt_10">
    <div class="col-md-12">
      <textarea id="txt_transport_agency_address" name="txt_transport_agency_address" class="form-control" placeholder="Transport Agency Address"></textarea>
    </div>
  </div>

<div class="row col-md-12 text-center mg_tp_20">
    <button class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Transport Agency</button>
</div>              
 
</form>
                           
 
                            
                              
<?= end_panel() ?>

<script>
$('#cmb_city_id').select2();
</script>
<script src="../js/transport_agency.js"></script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>