
<div class="row" style="margin-top: 5px"> <div class="col-md-12 text-right">
    <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_hotel_infomration')"><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_hotel_infomration')"><i class="fa fa-trash"></i></button>
    <button class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" onclick="hotel_save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Hotel</button>
</div> </div>
<div class="row main_block">
    <div class="col-xs-12"> 
        <div class="table-responsive">
            <table id="tbl_package_hotel_infomration" class="table table-bordered table-hover table-striped" style="width: 1475px;">
                <tr>
                    <td><input id="check-btn-hotel-acm-1" type="checkbox" checked ></td>
                    <td><input maxlength="15" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                    <td><select id="city_name1" name="city_name1" style="width:100%" title="Select City Name" class="form-control" onchange="load_hotel_list(this.id); "><?php get_cities_dropdown(); ?>
                        </select></td>
                    <td><select id="hotel_name1" name="hotel_name1" style="width:100%" title="Select Hotel Name">
                            <option value="">*Hotel Name</option>
                        </select></td>
                    <td><input type="text" id="txt_hotel_from_date1" name="txt_hotel_from_date1" onchange="validate_transportDate('txt_hotel_from_date1' ,'txt_hotel_to_date1')" placeholder="Check-In DateTime" title="Check-In DateTime"></td>
                    <td><input type="text" id="txt_hotel_to_date1" name="txt_hotel_to_date1" onchange="validate_arrivalDate('txt_hotel_from_date1' ,'txt_hotel_to_date1')" placeholder="Check-Out DateTime" title="Check-Out DateTime"></td>
                    <td><input type="text" style="width:62px" id="txt_room1" name="txt_room1" placeholder="Room" title="Room" ></td>
                    <td><select name="txt_catagory1" id="txt_catagory1" title="Category" style="width: 106px;" class="app_select2">
                            <option value="Deluxe">Deluxe</option>
                            <option value="Semi Deluxe">Semi Deluxe</option>
                            <option value="Super Deluxe">Super Deluxe</option>
                            <option value="Standard">Standard</option>
                            <option value="Suit">Suit</option>
                            <option value="Superior">Superior</option>
                            <option value="Premium">Premium</option>
                            <option value="Luxury">Luxury</option>
                            <option value="Super luxury">Super luxury</option>
                            <option value="Villa">Villa</option>
                            <option value="Home">Home</option>
                            <option value="PG">PG</option>
                            <option value="Hall">Hall</option>
                            <option value="Economy">Economy</option>
                            <option value="Royal suite">Royal suite</option>
                            <option value="Executive Suite">Executive Suite</option>
                            <option value="Single room">Single room</option>
                            <option value="Double room">Double room</option>
                            <option value="Triple sharing room">Triple sharing room</option>
                            <option value="King">King</option>
                            <option value="Queen">Queen</option>
                            <option value="Studio">Studio</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Connecting Rooms">Connecting Rooms</option>
                            <option value="Cabana Room">Cabana Room</option>
                    </select></td>
                
                    <td><select title="Meal Plan" id="cmb_meal_plan1" name="cmb_meal_plan" title="Meal Plan" style="width:110px;">
                    <?php get_mealplan_dropdown(); ?>
                    </select></td>
                    <td><select name="room_type1" id="room_type" title="Room Type" style="width:118px;">
                            <option value="AC">AC</option>
                            <option value="Non AC">Non AC</option>
                    </select></td>
                    <td><input type="text" id="txt_hotel_acm_confirmation_no1" onchange="validate_specialChar(this.id)" name="txt_hotel_acm_confirmation_no" placeholder="Confirmation no" title="Confirmation no" style="width: 110px;"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
