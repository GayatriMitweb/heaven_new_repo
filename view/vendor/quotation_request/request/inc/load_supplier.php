<?php

include "../../../../../model/model.php";



$quotation_for = $_POST['quotation_for'];


if($quotation_for=="Transport"){
$city=mysql_query("select distinct(city_id) from transport_agency_master");
while($sq_city=mysql_fetch_assoc($city)){
    $getCity=mysql_fetch_assoc(mysql_query("select city_name,city_id from city_master where city_id=$sq_city[city_id]"));
?>
    <optgroup value='<?= $getCity['city_id'];?>' label="<?= $getCity['city_name'];?>">
    <?php
    $hotel=mysql_query("select transport_agency_name , transport_agency_id from transport_agency_master where city_id=$sq_city[city_id]");
    while($sq_hotel=mysql_fetch_assoc($hotel)){
    ?>
        <option value="<?= $sq_hotel['transport_agency_id'];?>"><?= $sq_hotel['transport_agency_name']; ?></option>
    <?php
    }
    ?>
    </optgroup>
<?php
}
}

if($quotation_for=="Hotel"){
    $city=mysql_query("select distinct(city_id) from hotel_master");
    while($sq_city=mysql_fetch_assoc($city)){
        $getCity=mysql_fetch_assoc(mysql_query("select city_name,city_id from city_master where city_id=$sq_city[city_id]"));
	?>
        <optgroup value='<?= $getCity['city_id'];?>' label="<?= $getCity['city_name'];?>">
        <?php
        $hotel=mysql_query("select hotel_name , hotel_id from hotel_master where city_id=$sq_city[city_id]");
        while($sq_hotel=mysql_fetch_assoc($hotel)){
        ?>
            <option value="<?= $sq_hotel['hotel_id'];?>"><?= $sq_hotel['hotel_name']; ?></option>
        <?php
        }
        ?>
        </optgroup>
	<?php
    }
}

if($quotation_for=="DMC"){
$city=mysql_query("select distinct(city_id) from dmc_master");
    while($sq_city=mysql_fetch_assoc($city)){
        $getCity=mysql_fetch_assoc(mysql_query("select city_name,city_id from city_master where city_id=$sq_city[city_id]"));
	?>
        <optgroup value='<?= $getCity['city_id'];?>' label="<?= $getCity['city_name'];?>" value="<?= $getCity['city_id'];?>">
        <?php
        $hotel=mysql_query("select company_name , dmc_id from dmc_master where city_id=$sq_city[city_id]");
        while($sq_hotel=mysql_fetch_assoc($hotel)){
        ?>
            <option value="<?= $sq_hotel['dmc_id'];?>"><?= $sq_hotel['company_name']; ?></option>
        <?php
        }
        ?>
        </optgroup>
	<?php
}
}
?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

