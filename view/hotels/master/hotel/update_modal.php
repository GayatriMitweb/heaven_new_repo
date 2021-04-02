<?php
include "../../../../model/model.php";
global $encrypt_decrypt, $secret_key;

$hotel_id = $_POST['hotel_id'];
$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
$sq_vendor_login = mysql_fetch_assoc(mysql_query("select * from vendor_login where username='$sq_hotel[hotel_name]' and password='$sq_hotel[mobile_no]' and vendor_type='Hotel Vendor'"));

$role = $_SESSION['role'];
$value = '';
$images_url = '';
if($role!='Admin' && $role!="Branch Admin"){ $value="readonly"; }

$sq_hotel_img = mysql_query("select * from hotel_vendor_images_entries where hotel_id='$hotel_id'");
while($row_hotel_img = mysql_fetch_assoc($sq_hotel_img)){
  $images_url .= $row_hotel_img['hotel_pic_url'].',';  
}
$amenities = $sq_hotel['amenities'];
$amenities_arr = explode(',', $amenities);
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_hotel['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);
$email_id1 = $encrypt_decrypt->fnDecrypt($sq_hotel['alternative_email_1'], $secret_key);
$email_id2 = $encrypt_decrypt->fnDecrypt($sq_hotel['alternative_email_2'], $secret_key);
?>

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style='width:80%'>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Hotel Supplier Details</h4>
      </div>

      <div class="modal-body">
		<form id="frm_hotel_update">

    <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <legend>Basic Information</legend>
		    <input type="hidden" id="txt_hotel_id" name="txt_hotel_id" value="<?php echo $hotel_id ?>">
		    <input type="hidden" id="vendor_login_id" name="vendor_login_id" value="<?= $sq_vendor_login['login_id'] ?>">			
		    <div class="row">
		    	<div class="col-md-2 col-sm-6 mg_bt_10">
		            <select id="cmb_city_id" name="cmb_city_id" style="width:100%" title="City Name" required>
		                <?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'")); ?>
		                <option value="<?php echo $sq_hotel['city_id'] ?>" selected="selected"><?php echo $sq_city['city_name'] ?></option>
		            </select>
                <input type="hidden" id="selected_city" value="<?php echo $sq_hotel['city_id'] ?>">
		        </div>

		        <div class="col-md-2 col-sm-6 mg_bt_10">
		            <input type="text" value="<?= $sq_hotel['hotel_name'] ?>" onchange="validate_spaces(this.id);" onkeypress="return blockSpecialChar(event);"  class="form-control" id="txt_hotel_name" name="txt_hotel_name" placeholder="Hotel Name" title="Hotel Name" required>        
		        </div>

		        <div class="col-md-2 col-sm-6 mg_bt_10">
		            <input type="text" value="<?= $mobile_no ?>" onchange="mobile_validate(this.id);" class="form-control" id="txt_mobile_no" name="txt_mobile_no" placeholder="Mobile Number" title="Mobile Number">
		        </div>  
            <div class="col-md-2 col-sm-6 mg_bt_10">
                <input type="text" value="<?= $sq_hotel['landline_no'] ?>" id="txt_landline_no" name="txt_landline_no"placeholder="Landline Number" title="Landline Number">
            </div>
		        <div class="col-md-2 col-sm-6 mg_bt_10">
		            <input type="text" value='<?= $email_id ?>'  class="form-control" id="txt_email_id" name="txt_email_id"  placeholder="Email ID" title="Email ID" onchange="validate_email(this.id)">
		        </div>
            <div class="col-md-2 col-sm-6 ">
                <input type="text" value='<?= $email_id1 ?>' class="form-control" id="txt_email_id_1" name="txt_email_id"  placeholder="Alternative Email ID 1" title="Alternative Email ID 1" onchange="validate_email(this.id)">
            </div>
		        
		    </div>

		    <div class="row">
            <div class="col-md-2 col-sm-6 ">
                  <input type="text" value='<?= $email_id2 ?>' class="form-control" id="txt_email_id_2" name="txt_email_id"  placeholder="Alternative Email ID 2" title="Alternative Email ID 2" onchange="validate_email(this.id)">
            </div>
            <div class="col-md-2 col-sm-6 mg_bt_10">
		            <input type="text" value="<?= $sq_hotel['contact_person_name'] ?>"  class="form-control" id="txt_contact_person_name" name="txt_contact_person_name" placeholder="Contact Person Name" title="Contact Person Name">
		        </div>
            <div class="col-md-2 col-sm-6 mg_bt_10">
                <input type="text" value="<?= $sq_hotel['immergency_contact_no'] ?>"  class="form-control" id="immergency_contact_no" name="immergency_contact_no"  onchange="mobile_validate(this.id);" placeholder="Emergency Contact No" title="Emergency Contact No">
            </div>
            <div class="col-sm-2 col-xs-6 mg_bt_10">
                <select name="cust_state1" id="cust_state1" title="Select State" style="width:100%" required>
                <?php if($sq_hotel['state_id'] != '0'){ ?>
                  <?php $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_hotel[state_id]'"));
                  ?>
                  <option value="<?= $sq_hotel['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
                  <?php } ?>
                  <?php get_states_dropdown() ?>
                </select>
              </div>
              <div class="col-md-2 col-sm-6 mg_bt_10">
                  <textarea id="country" name="country" placeholder="Country" title="Country" class="form-control" rows="1"><?= $sq_hotel['country'] ?></textarea>
              </div>
              <div class="col-md-2 col-sm-6 mg_bt_10">
                  <input type="text" id="website" name="website" placeholder="Website" title="Website" class="form-control" value="<?= $sq_hotel['website'] ?>">
              </div>
             
		    </div>

		    <div class="row">
              <div class="col-md-2 col-sm-6 mg_bt_10">
                <select name="rating_star" id="rating_star" title="Hotel Category" required>
                <?php if($sq_hotel['rating_star']!=''){?>
                  <option value="<?= $sq_hotel['rating_star'] ?>"><?= $sq_hotel['rating_star'] ?></option>
                <?php } ?>
                <option value=''>Hotel Category</option>
                <option value="1 Star">1 Star</option>
                <option value="2 Star">2 Star</option>
                <option value="3 Star">3 Star</option>
                <option value="4 Star">4 Star</option>
                <option value="5 Star">5 Star</option>
                <option value="7 Star">7 Star</option>
                  <option value="Other">Other</option>
                </select>
              </div> 
              <div class="col-md-2 col-sm-6 mg_bt_10">
                <select name="hotel_type1" id="hotel_type1" title="Hotel Type" class='form-control' style='width:100%;'>
                <?php if($sq_hotel['hotel_type']!=''){?>
                  <option value="<?= $sq_hotel['hotel_type'] ?>"><?= $sq_hotel['hotel_type'] ?></option>
                <?php } ?>
                <?php get_hotel_type_dropdown(); ?>
                </select>
              </div>
            <div class="col-md-2 col-sm-6 mg_bt_10">
              <select name="meal_plan1" id="meal_plan1" title="Meal Plan">
                <?php if($sq_hotel['meal_plan']!=''){?>
                  <option value="<?= $sq_hotel['meal_plan'] ?>"><?= $sq_hotel['meal_plan'] ?></option>
                <?php } ?>
              <?php get_mealplan_dropdown(); ?>
              </select>
            </div>
            <div class="col-md-6 col-sm-6 mg_bt_10">
                <textarea id="txt_hotel_address" name="txt_hotel_address"  onchange="validate_address(this.id);" placeholder="Hotel Address" title="Hotel Address" class="form-control" rows="1"><?= $sq_hotel['hotel_address'] ?></textarea>
            </div> 
            <div class="col-md-2 col-sm-6 mg_bt_10">
              <select name="active_flag" id="active_flag" title="Status">
                <option value="<?= $sq_hotel['active_flag'] ?>"><?= $sq_hotel['active_flag'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
        </div>
      </div>

      <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
          <legend>Bank Information</legend>
          <div class="row"> 
            <div class="col-md-2 col-sm-6 mg_bt_10">
                  <input type="text" value="<?= $sq_hotel['bank_name'] ?>" id="bank_name" name="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest" >
            </div>  
            <div class="col-md-2 col-sm-6 mg_bt_10">
                  <input type="text" value="<?= $sq_hotel['account_name'] ?>" class="form-control" id="account_name1" name="account_name1" placeholder="A/c Name" title="A/c Name">
            </div>
            <div class="col-md-2 col-sm-6 mg_bt_10">
                  <input type="text" value="<?= $sq_hotel['account_no'] ?>" onchange="validate_accountNo(this.id);" class="form-control" id="account_no" name="account_no" placeholder="A/c No" title="A/c No">
            </div>   
            <div class="col-md-2 col-sm-6 mg_bt_10">
                <input type="text" value="<?= $sq_hotel['branch'] ?>" onchange="validate_branch(this.id);" class="form-control" id="branch" name="branch" placeholder="Branch" title="Branch">
            </div>
            <div class="col-md-2 col-sm-6 mg_bt_10">
              <input type="text" value="<?= strtoupper($sq_hotel['ifsc_code']) ?>" onchange="validate_IFSC(this.id);" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
            </div>
            <div class="col-md-2 col-sm-6 mg_bt_10">
                <input type="text" name="service_tax_no" id="service_tax_no"  onchange="validate_alphanumeric(this.id);" placeholder="Tax No" title="Tax No" value="<?= strtoupper($sq_hotel['service_tax_no'])?>" style="text-transform: uppercase;">
                  <input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" title="Opening Balance" value="<?= $sq_hotel['opening_balance'] ?>" <?= $value ?>  onchange="validate_balance(this.id)">
            </div>
          </div>
		    	<div class="row"> 
          <div class="col-md-2 mg_bt_10">
             <input type="text" id="supp_pan" name="supp_pan" value="<?= $sq_hotel['pan_no']?>" onchange="validate_alphanumeric(this.id)" placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
            <input type="hidden" id="as_of_date1" name="as_of_date1" placeholder="*As of Date" title="As of Date" value="<?= get_date_user($sq_hotel['as_of_date']) ?>" required>
          </div>
          <div class="col-md-2 mg_bt_10">
            <select class="hidden" name="side" id="side1" title="Select side" disabled required>
            <?php if($sq_hotel['side']!=''){?>
              <option value="<?= $sq_hotel['side'] ?>"><?= $sq_hotel['side'] ?></option>
            <?php } ?>
              <option value="">*Select Side</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>
          </div>
        </div>
      

		<div class="row">
		<div class="col-md-12 app_accordion">
		<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="accordion_content package_content">
      <div class="panel panel-default main_block">
        <div class="panel-heading main_block" role="tab" id="heading1">
          <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1" id="collapsed1">                  
            <div class="col-md-12"><span><em style="margin-left: 15px;"><?php echo "Hotel Amenities and Policies"; ?></em></span></div>
          </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading1">
          <div class="panel-body">
          <div class="row mg_tp_20">
            <div class="col-md-12 col-sm-6 mg_bt_10">
              <textarea id="description" name="description" placeholder="Hotel Description" class="form-control" title="Hotel Description" rows="2"><?= $sq_hotel['description'] ?></textarea>
            </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">   
          <legend>Hotel Amenities</legend>  
          <div class="row">
              <div class="col-md-12 col-sm-4 col-xs-12 mg_bt_10">
                <div class="row">
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("WIFI", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="wifi" name="amenities" value="WIFI" <?= $chk ?>>
                      <label for="wifi">WIFI</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Swimming Pool", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="swm" name="amenities" value="Swimming Pool" <?= $chk ?>>
                      <label for="swm">Swimming Pool</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Television", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="tele" name="amenities" value="Television" <?= $chk ?>>
                      <label for="tele">Television</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Coffee", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="coffee" name="amenities" value="Coffee" <?= $chk ?>>
                      <label for="coffee">Coffee</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Air Conditioner", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="air" name="amenities" value="Air Conditioner"  <?= $chk ?>>
                    <label for="air">Air Conditioner</label>
                  </div>
                  </div>
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Fitness Facility", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="fit" name="amenities" value="Fitness Facility" <?= $chk ?>>
                    <label for="fit">Fitness Facility</label>
                  </div>
                  </div>
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Fridge", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="fridge" name="amenities" value="Fridge" <?= $chk ?>>
                    <label for="fridge">Fridge</label>
                  </div>
                  </div>
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Wine Bar", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="wine" name="amenities" value="Wine Bar" <?= $chk ?>>
                    <label for="wine">Wine Bar</label>
                  </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Smoking Allowed", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="smoke" name="amenities" value="Smoking Allowed" <?= $chk ?>>
                      <label for="smoke">Smoking Allowed</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Entertainment", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="enter" name="amenities" value="Entertainment" <?= $chk ?>>
                    <label for="enter">Entertainment</label>
                  </div>
                  </div>
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Secure Vault", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="secure" name="amenities" value="Secure Vault" <?= $chk ?>>
                    <label for="secure">Secure Vault</label>
                  </div>
                  </div>
                  <div class="col-md-3">
                  <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                  <?php $chk = (in_array("Pick & Drop", $amenities_arr)) ? "checked" : ""; ?>
                    <input type="checkbox" id="pick" name="amenities" value="Pick & Drop" <?= $chk ?>>
                    <label for="pick">Pick & Drop</label>
                  </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Room Service", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="room" name="amenities" value="Room Service" <?= $chk ?>>
                      <label for="room">Room Service</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Pets Allowed", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="pets" name="amenities" value="Pets Allowed" <?= $chk ?>>
                      <label for="pets">Pets Allowed</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Play Place", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="play" name="amenities" value="Play Place" <?= $chk ?>>
                      <label for="play">Play Place</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Complimentary Breakfast", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="comp" name="amenities" value="Complimentary Breakfast" <?= $chk ?>>
                      <label for="comp">Complimentary Breakfast</label> 
                    </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Free Parking", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="free" name="amenities" value="Free Parking" <?= $chk ?>>
                      <label for="free">Free Parking</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Conference Room", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="conf" name="amenities" value="Conference Room" <?= $chk ?>>
                      <label for="conf">Conference Room</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Fire Place", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="fire" name="amenities" value="Fire Place" <?= $chk ?>>
                      <label for="fire">Fire Place</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Handicap Accessible", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="handi" name="amenities" value="Handicap Accessible" <?= $chk ?>>
                      <label for="handi">Handicap Accessible</label>
                    </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Doorman", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="doorman" name="amenities" value="Doorman" <?= $chk ?>>
                      <label for="doorman">Doorman</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Hot Tub", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="hot" name="amenities" value="Hot Tub" <?= $chk ?>>
                      <label for="hot">Hot Tub</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <?php $chk = (in_array("Elevator", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="elev" name="amenities" value="Elevator" <?= $chk ?>>
                      <label for="elev">Elevator</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <?php $chk = (in_array("Suitable For Events", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="suita" name="amenities" value="Suitable For Events" <?= $chk ?>>
                      <label for="suita">Suitable For Events</label>
                    </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Laundry Service", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="laundry" name="amenities" value="Laundry Service" <?= $chk ?>>
                      <label for="laundry">Laundry Service</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                    <?php $chk = (in_array("Doctor On Call", $amenities_arr)) ? "checked" : ""; ?>
                      <input type="checkbox" id="doctor" name="amenities" value="Doctor On Call" <?= $chk ?>>
                      <label for="doctor">Doctor On Call</label>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          </div>
          <div class='row'>
                <div class="col-md-6 col-sm-3 mg_bt_10"> 
                  <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
                    <legend>Child Without Bed</legend>
                    <div class="col-md-3 col-sm-3 mg_bt_10">
                        <select name="cwob_from1" id="cwob_from1" title="Child Without Bed From Age">
                            <?php if($sq_hotel['cwob_from'] != '0'){?><option value='<?= $sq_hotel['cwob_from'] ?>'><?= $sq_hotel['cwob_from'] ?></option><?php } ?>
                            <option value=''>*From Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3 mg_bt_10">
                        <select name="cwob_to1" id="cwob_to1" title="Child Without Bed To Age" class='form-control'>
                            <?php if($sq_hotel['cwob_to'] != '0'){?><option value='<?= $sq_hotel['cwob_to'] ?>'><?= $sq_hotel['cwob_to'] ?></option><?php } ?>
                            <option value=''>*To Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                  </div>
                </div>
              <div class="col-md-6 col-sm-3 mg_bt_10">
                  <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
                    <legend>Child With Bed</legend>         
                    <div class="col-md-3 col-sm-3 mg_bt_10">
                        <select name="cwb_from1" id="cwb_from1" title="Child With Bed From Age">
                            <?php if($sq_hotel['cwb_from'] != '0'){?><option value='<?= $sq_hotel['cwb_from'] ?>'><?= $sq_hotel['cwb_from'] ?></option><?php } ?>
                            <option value=''>*From Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3 mg_bt_10">
                        <select name="cwb_to1" id="cwb_to1" title="Child With Bed To Age" class='form-control'>
                            <?php if($sq_hotel['cwb_to'] != '0'){?><option value='<?= $sq_hotel['cwb_to'] ?>'><?= $sq_hotel['cwb_to'] ?></option><?php } ?>
                            <option value=''>*To Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                  </div>
                </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">   
            <legend>Hotel Policies</legend>
            <div class="row">
              <div class="col-md-12 col-sm-6 mg_bt_10">
                <textarea class="feature_editor" name="policies" id="policies" style="width:100% !important" rows="8"><?= $sq_hotel['policies'] ?></textarea>
              </div>
            </div>
          </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
        <div class="row mg_tp_10">
          <div class="col-md-12">
              <div class="div-upload">
                <div id="hotel_upload_btn" class="upload-button1"><span>Upload Images</span></div>
                <span id="id_proof_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="hotel_upload_url" name="hotel_upload_url" value='<?= $images_url ?>'>
            </div>  (Upload Maximum 10 images)
          </div>
            <div class="col-sm-6 mg_tp_10">  
              <span style="color: red;" class="note">Note : Image size should be less than 100KB, resolution : 900X450.</span>
            </div>
        </div>
      <div class="row mg_tp_20 mg_bt_20" id="images_list"></div>

      <div class="row text-center mg_tp_20">
        <div class="col-md-12">
          <button class="btn btn-sm btn-success" id="updte_btn"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button> 
        </div>    
      </div>
		</form>

      </div>
    </div>
  </div>

</div>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#update_modal').modal('show');
$('#as_of_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

$(document).ready(function(){
    $("#cust_state1,#hotel_type1").select2();   
    city_lzloading('#cmb_city_id');
});
function load_images(hotel_id){
    var base_url = $("#base_url").val();
    $.ajax({
          type:'post',
          url: base_url+'view/custom_packages/master/package/get_hotel_img.php',
          data:{hotel_name : hotel_id },
          success:function(result){
           $('#images_list').html(result);
          }
  });
}
load_images(<?= $hotel_id ?>);

function delete_image(image_id,hotel_name){
    var base_url = $("#base_url").val();
    $("#vi_confirm_box").vi_confirm_box({
          callback: function(result){
            if(result=="yes"){
              $.ajax({
                    type:'post',
                    url: base_url+'controller/custom_packages/delete_hotel_image.php',
                    data:{ image_id : image_id },
                    success:function(result)
                    {
                      msg_alert(result);
                      load_images(hotel_name);
                    }
              });    
            } }
    });
}

upload_hotel_pic_attch();
function upload_hotel_pic_attch(){
    var img_array = new Array(); 

    var btnUpload=$('#hotel_upload_btn');
    $(btnUpload).find('span').text('Upload Images');
    $("#hotel_upload_url").val('');

    new AjaxUpload(btnUpload, {
      action: 'hotel/upload_hotel_images.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload Images');
        }else
        {
          if(response=="error1"){
            $(btnUpload).find('span').text('Upload Images');
            error_msg_alert('Maximum size exceeds');
            return false;
          }
          else{
              $(btnUpload).find('span').text('Uploaded'); 
              $("#hotel_upload_url").val(response);
               upload_pic();            
          }
          // img_array.push(response); 
        }
        // $("#hotel_image_path").val(img_array); 
      }
    });
}

function upload_pic(){
  var base_url = $("#base_url").val();
  var hotel_upload_url = $('#hotel_upload_url').val();
  var hotel_names = $('#txt_hotel_id').val();
  $.ajax({
          type:'post',
          url: base_url+'controller/hotel/hotel_img_save_c.php',
          data:{ hotel_upload_url : hotel_upload_url,hotel_names : hotel_names },
          success:function(result)
          {
            msg_alert(result);
            load_images(hotel_names);
          }
  });
}
///////////////////////***Hotel Master Update start*********//////////////

$(function(){

    $('#frm_hotel_update').validate({
    rules:{
            cwb_from1 : { required : true },
            cwb_to1 : { required : true },
            cwob_from1 : { required : true },
            cwob_to1 : { required : true },
    },
    submitHandler:function(form){
      var hotel_id = $("#txt_hotel_id").val();
      var vendor_login_id = $('#vendor_login_id').val();
      var base_url = $("#base_url").val();
      var city_id = $("#cmb_city_id").val();
      var hotel_name = $("#txt_hotel_name").val();
      var mobile_no = $("#txt_mobile_no").val();
      var landline_no = $('#txt_landline_no').val();
      var email_id = $("#txt_email_id").val();
      var email_id_1 = $("#txt_email_id_1").val();
      var email_id_2 = $("#txt_email_id_2").val();
      var contact_person_name = $("#txt_contact_person_name").val();
      var immergency_contact_no =$("#immergency_contact_no").val();
      var hotel_address = $("#txt_hotel_address").val();
      var country = $("#country").val();
      var website = $("#website").val();
      var bank_name = $("#bank_name").val();
      var branch = $("#branch").val();
      var ifsc_code = $("#ifsc_code").val();
      var account_no = $("#account_no").val();
      var account_name = $("#account_name1").val();
      var opening_balance = $('#opening_balance').val();
      var rating_star = $('#rating_star').val();
      var hotel_type = $('#hotel_type1').val();
      var meal_plan = $('#meal_plan1').val();
      var active_flag = $('#active_flag').val();
      var service_tax_no = $('#service_tax_no').val();
      var state = $('#cust_state1').val();
      var side1 = $('#side1').val();
      var supp_pan = $('#supp_pan').val();
      var as_of_date = $('#as_of_date1').val();
      var cwb_from = $('#cwb_from1').val();
      var cwb_to = $('#cwb_to1').val();
      var cwob_from = $('#cwob_from1').val();
      var cwob_to = $('#cwob_to1').val();

      var add = validate_address('txt_hotel_address');
      
      var description = $('#description').val();
      var policies = $('#policies').val();
      var amenities = (function() {  var a = ''; $("input[name='amenities']:checked").each(function() { a += this.value+','; });  return a; })();
      amenities = amenities.slice(0,-1);

      if(!add){
        error_msg_alert('More than 155 characters are not allowed.');
        return false;
      }
      
      if(parseFloat(cwb_from) == 0 || cwb_from == ''){
        error_msg_alert('Enter Child With Bed From Age in Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwb_to) == 0 || cwb_to == ''){
        error_msg_alert('Enter Child With Bed To Age in Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwob_from) == 0 || cwob_from == ''||parseInt(cwob_to) == parseInt(cwb_from)){
        error_msg_alert('Enter Child Without Bed From Age in Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwob_to) == 0 || cwob_to == ''){
        error_msg_alert('Enter Child Without Bed To Age in Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwb_from) > parseFloat(cwb_to)){
        error_msg_alert('Invalid Child With Bed From-To Age in Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwob_from) > parseFloat(cwob_to)){
        error_msg_alert('Invalid Child Without Bed From-To Age in Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwob_to)>parseFloat(cwb_from)){
        error_msg_alert('Invalid Child Without-Bed and With-Bed Ages'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      $('#updte_btn').button('loading');
      
      $.post(
            base_url+"controller/hotel/hotel_master_update_c.php",
            { hotel_id : hotel_id, vendor_login_id : vendor_login_id, city_id : city_id, hotel_name : hotel_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, hotel_address : hotel_address, country : country, website :website,  opening_balance : opening_balance,rating_star : rating_star,hotel_type:hotel_type,meal_plan:meal_plan, active_flag : active_flag, bank_name : bank_name, account_no: account_no, branch : branch, ifsc_code :ifsc_code, service_tax_no : service_tax_no, state : state,side1 : side1,account_name : account_name,supp_pan : supp_pan,as_of_date : as_of_date,description:description,policies:policies,amenities:amenities,cwb_from:cwb_from,cwb_to:cwb_to,cwob_from:cwob_from,cwob_to:cwob_to,email_id_1:email_id_1,email_id_2:email_id_2 },

            function(data) {  
                msg_alert(data);
                $('#updte_btn').button('reset');
                $('#update_modal').modal('hide');
                update_b2c_cache();
                list_reflect();
            });
    }
  });
});
$('select').on('change', function(){
	$(this).valid()
});
///////////////////////***Hotel Master Update end*********//////////////

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>