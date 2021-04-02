<div class="app_panel"> 

 <!--=======Header panel======-->
            <div class="app_panel_head">
              <div class="container">
                <h2 class="pull-left"></h2>
                <div class="pull-right header_btn">
                  <button>
                      <a>
                          <i class="fa fa-arrow-right"></i>
                      </a>
                  </button>
                </div>
                <div class="pull-right header_btn">
                  <button>
                    <a></a>
                  </button>
                </div>
              </div>
            </div> 

  <!--=======Header panel end======-->

    <div class="">
      <div class="container">
          <h5 class="booking-section-heading main_block">Tour Details</h5>
          <div class="app_panel_content Filter-panel">
              <div class="row">
              
                  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                      <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" title="Tour Name" onchange="payment_details_reflected_data('tbl_member_dynamic_row'); seats_availability_reflect();tour_group_reflect(this.id);" disabled> 
                          <option value="<?php echo $tour_id ?>"><?php echo $tour_name ?></option>   
                          <?php
                              $sq=mysql_query("select tour_id,tour_name from tour_master where active_flag = 'Active' order by tour_name asc");
                              while($row=mysql_fetch_assoc($sq))
                              {
                                echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                              }    
                          ?>
                      </select>               
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                      <select class="form-control" id="cmb_tour_group" name="cmb_tour_group" title="Tour Date" onchange="seats_availability_reflect(); seats_availability_check(); due_date_reflect()"> 
                          <option value="<?php echo $tour_group_id ?>"> <?php echo $tour_group_name ?> </option>        
                      </select>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                      <select id="cmb_traveler_group_id" name="cmb_traveler_group_id" title="Tour Group Id" onchange="select_color(this.id);"> 
                          <option value="<?php echo $tourwise_id ?>"> <?php echo get_group_booking_id($tourwise_id,$year) ?> </option>        
                      </select>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12 hidden">
                    <select name="taxation_type" id="taxation_type" title="Taxation Type">
                      <option value="<?= $tourwise_details['taxation_type'] ?>"><?= $tourwise_details['taxation_type'] ?></option>
                     
                    </select>
                  </div>    
                  
                  <div id="div_seats_availability" class="reflect-seats" style=""></div>   

              </div>
          </div>

        <input type="hidden" id="txt_available_seats" name="txt_available_seats">   
<input type="hidden" id="txt_total_seats1" name="txt_total_seats">
<input type="hidden" id="seats_booked" name="seats_booked">    
</div>
<?= end_panel() ?>

<script src="../js/tab_1_tour_info_sec.js"></script> 
 <script>

$(document).ready(function() {
    //$("#cmb_tour_name").select2();
});
    tour_type_reflect('cmb_tour_name',1);
    seats_availability_reflect();
    seats_availability_check();
</script>