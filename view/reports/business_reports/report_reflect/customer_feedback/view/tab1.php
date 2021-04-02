<div class="profile_box">

    <div class="row">

        <div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd; min-height: 15px;">

            <span class="main_block">

                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                  <?php echo "<label>Booking Type <em>:</em></label> ".$sq_feed['booking_type']; ?>

            </span>
            <?php
            $booking_type = $sq_feed['booking_type'];
            if($booking_type=="Group Booking"){ 
                $query = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$sq_feed[booking_id]'"));  
                    $sq_tour_group_name = mysql_query("select from_date,to_date from tour_groups where group_id='$query[tour_group_id]'");
                    $row_tour_group_name = mysql_fetch_assoc($sq_tour_group_name);
                    $tour_date = date("d-m-Y", strtotime($row_tour_group_name['from_date'])).' To '.date("d-m-Y", strtotime($row_tour_group_name['to_date'])); 
                    } 
                   
                elseif($booking_type=="Package Booking"){
                $query =mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$sq_feed[booking_id]'"));
                    $tour_date = date('d-m-Y', strtotime($query['tour_from_date'])).' To '. date('d-m-Y', strtotime($query['tour_to_date'])); 
                     
                } ?>
            
        </div>

        <div class="col-md-6">
            <span class="main_block">

                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                  <?php echo "<label>Travel Date <em>:</em></label> ".$tour_date; ?>

            </span>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">

        <div class="profile_box main_block">
            <div class="row bg_light">
              <div class="col-md-8 col-xs-12"><h5>Review for</h5></div>
              <div class="col-md-4 col-xs-12"><h5>Review</h5></div>
            </div>

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-md-8 col-xs-12"><h5>1. Why did you choose us over other travel agencies?</h5></div>
              <div class="col-md-4 col-xs-12"><h5><?= $sq_feed['travel_agencies'] ?></h5></div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-md-8 col-xs-12"><h5>2. How was our sales team to you?</h5></div>
              <div class="col-md-4 col-xs-12"><h5><?= $sq_feed['sales_team'] ?></h5></div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-xs-12">
                <h5>3. Quality of Travel Services</h5>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>a) Were the vehicles exactly as requested ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['travel_agencies'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>b) Were Pickups usually on time?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['pickup_time'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>c) Were the vehicles in clean, neat & good condition ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['vehicles_condition'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>d) Was the driver safe, polite, courteous and informative ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['driver_info'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>e) Were the tickets, service vouchers issued in a timely manner ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['ticket_info'] ?></h5>
                  </div>
                </div>
              </div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-xs-12">
                <h5>4. Quality of Accomodation Services?</h5>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>a) Were the hotels exactly as requested ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['hotel_request'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>b) How would you rate your accomodations for Hygiene & Cleanliness?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['hotel_clean'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>c) How was the quality & quanity of meal?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['hotel_quality'] ?></h5>
                  </div>
                </div>
              </div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-xs-12">
                <h5>5. Quality of Sightseeing Services:</h5>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>a) Did you get all sightseeing as per itinerary ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['siteseen'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>b) Did you get enough time on sightseeing ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['siteseen_time'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>c) How was the knowledge & performance of the tour guide?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['tour_guide'] ?></h5>
                  </div>
                </div>
              </div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-xs-12">
                <h5>6. Please answer the following few questions based on your experience using us :</h5>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>a) How did you find overall booking experience ?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['booking_experience'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>b) Would you travel again with us in the future?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['travel_again'] ?></h5>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-md-8 col-xs-12"><p>c) Would you recommend us to people around you?</p></div>
                  <div class="col-md-4 col-xs-12">
                    <h5 class="no-marg" style="margin-left: 10px !important;"><?= $sq_feed['hotel_recommend'] ?></h5>
                  </div>
                </div>
              </div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-md-8 col-xs-12">
                <h5>7. How satisfied were you with the level and quality of service surrounding your trip?</h5>
                <?php
                 if ($sq_feed['add_comment']!="") {
                 ?>
                     <div class="col-xs-12 mg_tp_10">
                             <span class="main_block">

                              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                              <?php echo "<label>Comment <em>:</em></label> ".$sq_feed['add_comment']; ?>

                        </span>
                     </div>
                 <?php
                 }
                 ?>
              </div>
              <div class="col-md-4 col-xs-12"><h5><?= $sq_feed['quality_service'] ?></h5></div>
            </div>
            <hr class="no-marg main_block">

            <div class="row mg_tp_10 mg_bt_10">
              <div class="col-md-8 col-xs-12"><h5>8. From your front door until your return, How would you rate your trip overall ?</h5></div>
              <div class="col-md-4 col-xs-12 mg_tp_10">
                <?php
                    $star=1;
                    while ($star <= $sq_feed['trip_overall']) {
                ?>
                        <i class="fa fa-star" aria-hidden="true" style="color: #cfb53b;"></i>
                <?php
                    $star++;
                    }
                ?>
              </div>
            </div>
            <hr class="no-marg main_block">
        </div> 

    </div>

</div>