<?php
$hotel_traveller_arr = array();
for($i=0;$i<sizeof($traveller_details);$i++){
  if($traveller_details[$i]->service->name == 'Hotel'){
    array_push($hotel_traveller_arr,$traveller_details[$i]);
  }
  else if($traveller_details[$i]->service->name == 'Activities'){

  }
}
?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
	    <div class="profile_box main_block b2b_block">
	    <legend>Contact Person Details</legend>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block"> 
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <?php
                        $yr = explode("-", get_datetime_db($query['created_at']));
                        echo $query['fname'].' '.$query['lname'].'&nbsp'.'('.get_b2b_booking_id($query['booking_id'],$yr[0]).')'; ?>
                    </span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <?php echo $query['email_id']; ?>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <?php echo $query['contact_no']; ?> 
                    </span>
                    <?php
                    $sq_country = mysql_fetch_assoc(mysql_query("select country_code,country_name from country_list_master where country_id='$query[country_id]'"));
                    ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        <?php echo $sq_country['country_name'].'('.$sq_country['country_code'].')' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
        <div class="profile_box main_block">
        <span class="main_block">
            Special Request : <?php echo $query['sp_request'] ?>
        </span>
        </div>
    </div>
</div>

<div class="row mg_tp_10">
	<div class="col-md-12">
		<div class="profile_box main_block">
			<?php if(sizeof($hotel_traveller_arr)>0){ ?>
			<legend>Hotel Details</legend>
			<div class="col-md-12">
                <?php for($i=0;$i<sizeof($hotel_traveller_arr);$i++){
                    $hotel_id = $hotel_traveller_arr[$i]->service->id;
                    $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id='$hotel_id'"));
                ?>
                <h5 class="serviceTitle"><?= $sq_hotel['hotel_name'] ?></h5>
                <div class="row">
                <!-- Roomwise Traveller -->
                <?php for($j=0;$j<sizeof($hotel_traveller_arr[$i]->service->room_arr);$j++){ ?>
                    <div class='col-md-6'>
                        <div class='col-md-12'><u><?= 'Room '.($j+1) ?></u></div>
                        <div class='col-md-12'>
                            <ul>
                            <!-- Adults -->
                            <?php for($k=0;$k<sizeof($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr);$k++){
                                 $pass_name =  ($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->honorofic.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->fname).' '.($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->lname);
                            ?>
                            <li><?php echo $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->adult_count.' : '.$pass_name ?></li>
                            <?php } ?>
                            <!-- Children -->
                            <?php for($k=0;$k<sizeof($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr);$k++){
                                 $pass_name = ($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->chonorofic.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->cfname).' '.($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->clname);
                            ?>
                            <li><?php echo $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->child_count.' : '.$pass_name ?></li>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                </div>
            <?php } ?>
            </div>
            <?php } ?> 
        </div>
    </div>
</div>
</div>
    