<?php
$flag = true;
class custom_package{
   //save
   function package_master_save($tour_type,$dest_id,$package_code,$package_name,$total_days,$total_nights,$inclusions,$exclusions, $status ,$city_name_arr, $hotel_name_arr, $hotel_type_arr,$total_days_arr,$vehicle_name_arr,$drop_arr,$drop_type_arr,$pickup_arr,$pickup_type_arr,$day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$adult_cost,$child_cost,$infant_cost,$child_with,$child_without,$extra_bed,$currency_id,$taxation_type,$taxation_id,$service_tax){

      $created_at =date('Y-m-d H:i');

      $tour_name_count = mysql_num_rows(mysql_query("select * from custom_package_master where package_name='$package_name'"));
      if($tour_name_count>0){
      echo "error--This package name already exist.";
      return false;
      exit;
      }

      $sq = mysql_query("select max(package_id) as max from custom_package_master");
      $value = mysql_fetch_assoc($sq);
      $max_tour_id = $value['max'] + 1;
      begin_t();

      $inclusions = addslashes($inclusions);
      $exclusions = addslashes($exclusions);
      $taxation = array();
      array_push($taxation,array(
         "taxation_type"=>$taxation_type,
         "taxation_id"=>$taxation_id,
         "service_tax"=>$service_tax
      ));
      $taxation = json_encode($taxation);
      $sq = mysql_query("insert into custom_package_master(package_id,dest_id, package_code, package_name, total_days, total_nights,adult_cost,child_cost,infant_cost,child_with,child_without,extra_bed,inclusions,exclusions, status,created_at,tour_type,currency_id,taxation) values('$max_tour_id','$dest_id', '$package_code', '$package_name', '$total_days', '$total_nights','$adult_cost','$child_cost','$infant_cost','$child_with','$child_without','$extra_bed','$inclusions','$exclusions','$status','$created_at','$tour_type','$currency_id','$taxation')");

      if($sq){

         for($i=0; $i<sizeof($day_program_arr); $i++){

            $sq = mysql_query("select max(entry_id) as max from custom_package_program");
            $value = mysql_fetch_assoc($sq);
            $max_group_id = $value['max'] + 1;

            $meal_plan_arr[$i] = mysql_real_escape_string($meal_plan_arr[$i]);
            $special_attaraction1 = addslashes($special_attaraction_arr[$i]);
            $day_program_arr1 = addslashes($day_program_arr[$i]);
            $overnight_stay1 = addslashes($overnight_stay_arr[$i]);
            $sq1 = mysql_query("insert into custom_package_program( entry_id, package_id, attraction, day_wise_program, stay, meal_plan)values('$max_group_id','$max_tour_id','$special_attaraction1', '$day_program_arr1', '$overnight_stay1','$meal_plan_arr[$i]')");

            if(!$sq1){
            $GLOBALS['flag'] = false;
            echo "error--Error in Package Program!";
            }
         }

       //Hotel Details
      for($i=0; $i<sizeof($city_name_arr); $i++){

         $sq = mysql_query("select max(entry_id) as max from custom_package_hotels");
         $value = mysql_fetch_assoc($sq);
         $max_hotel_id = $value['max'] + 1;

         $city_name_arr[$i] = mysql_real_escape_string($city_name_arr[$i]);
         $hotel_name_arr[$i] = mysql_real_escape_string($hotel_name_arr[$i]);
         $hotel_type_arr[$i] = mysql_real_escape_string($hotel_type_arr[$i]);
         $total_days_arr[$i] = mysql_real_escape_string($total_days_arr[$i]);
         $image_url_arr[$i] = mysql_real_escape_string($image_url_arr[$i]);

         $sq2 = mysql_query("insert into custom_package_hotels(entry_id, package_id, city_name, hotel_name, hotel_type,total_days,image_url)values('$max_hotel_id','$max_tour_id','$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_type_arr[$i]','$total_days_arr[$i]','')");

         if(!$sq2){
         $GLOBALS['flag'] = false;
         echo "error--Error in Hotel details!";
         }
      }

      //Transport Details
      for($i=0; $i<sizeof($vehicle_name_arr); $i++){

         $sq = mysql_query("select max(entry_id) as max from custom_package_transport");
         $value = mysql_fetch_assoc($sq);
         $max_tr_id = $value['max'] + 1;


         $pickup_type = explode("-",$pickup_arr[$i])[0];
         $drop_type = explode("-",$drop_arr[$i])[0];
         $pickup = explode("-",$pickup_arr[$i])[1];
         $drop = explode("-",$drop_arr[$i])[1];
         
         $cost_name_arr[$i] = mysql_real_escape_string($cost_name_arr[$i]);
         $sq2 = mysql_query("INSERT INTO `custom_package_transport`(`entry_id`, `package_id`, `vehicle_name`, `pickup`, `drop`, `pickup_type`, `drop_type`) values('$max_tr_id','$max_tour_id','$vehicle_name_arr[$i]', '$pickup', '$drop', '$pickup_type', '$drop_type')");

         if(!$sq2){
            $GLOBALS['flag'] = false;
            echo "error--Error in Transport details!";
         }
      }

      $sq_def_image = mysql_fetch_assoc(mysql_query("select image_url from default_package_images where dest_id='$dest_id'"));
      $image_url = $sq_def_image['image_url'];
      $sq = mysql_query("select max(image_entry_id) as max from custom_package_images");
      $value = mysql_fetch_assoc($sq);
      $max_image_id = $value['max'] + 1;
      $sq3 = mysql_query("insert into custom_package_images(image_entry_id, image_url, package_id)values('$max_image_id','$image_url','$max_tour_id')");
      if(!$sq3){
         $GLOBALS['flag'] = false;
         echo "error--Error in Gallary!";
      }

      if($GLOBALS['flag']){
         commit_t();
         global $b2c_flag;
         $package_fname = str_replace(' ', '_', $package_name);
         if($b2c_flag == '1'){
            $file_name = '../../../package_tours/'.$package_fname.'-'.$max_tour_id.'.php';
            $this->create_tour_file($file_name);
         }
         echo "Package Tour has been successfully saved.";
         exit;
      }
      else{
         rollback_t();
      }        
   }      

   else{
   rollback_t();
   echo "error--Package Not Saved";
   }
}


//update
function package_master_update($package_id1,$dest_id,$package_code,$package_name,$total_days,$total_nights,$transport_id,$inclusions,$exclusions, $status ,$city_name_arr, $hotel_name_arr, $hotel_type_arr,$total_days_arr,$hotel_check_arr,$vehicle_name_arr,$vehicle_check_arr,$drop_arr,$drop_type_arr,$pickup_arr,$pickup_type_arr,$tr_entry_arr,$checked_programe_arr, $day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr, $entry_id_arr,$hotel_entry_id_arr,$adult_cost,$child_cost,$infant_cost,$child_with,$child_without,$extra_bed,$currency_id,$taxation_type,$taxation_id,$service_tax){

   $package_code = mysql_real_escape_string($package_code);
   $package_name = mysql_real_escape_string($package_name);  
   $total_days = mysql_real_escape_string($total_days); 
   $total_nights = mysql_real_escape_string($total_nights);  
   $package_id = mysql_real_escape_string($package_id1);
   $status = mysql_real_escape_string($status);

   $taxation = array();
   $taxation = json_encode($taxation);

   begin_t();
   global $b2c_flag;
   if($b2c_flag == '1'){
      
      $sq_query = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id'"));
      if($sq_query['clone']=='yes' && $sq_query['update_flag']=='0'){

         $package_fname = str_replace(' ', '_', $package_name);
         $file_name = '../../../package_tours/'.$package_fname.'-'.$max_tour_id.'.php';
         $this->create_tour_file($file_name);
      }
   }
   $sq_query_count = mysql_num_rows(mysql_query("select * from custom_package_master where (package_name = '$package_name' and package_id != '$package_id')"));

   if($sq_query_count == 0){ 

   $inclusions = addslashes($inclusions);
   $exclusions = addslashes($exclusions);
   $sq = mysql_query("update custom_package_master set package_code ='$package_code', package_name = '$package_name', total_days = '$total_days', total_nights = '$total_nights',adult_cost='$adult_cost',child_cost='$child_cost',infant_cost='$infant_cost',child_with='$child_with',child_without='$child_without',extra_bed='$extra_bed',inclusions='$inclusions',exclusions ='$exclusions', status ='$status', currency_id='$currency_id',taxation='$taxation',update_flag='1' where package_id = '$package_id'");
   }

   else{
      $GLOBALS['flag'] = false;
      echo "error--This package name already exist.";
      exit;
   }

    if($sq){

       for($i=0; $i<sizeof($day_program_arr); $i++){

          $meal_plan_arr[$i] = mysql_real_escape_string($meal_plan_arr[$i]);
          $entry_id_arr[$i] = mysql_real_escape_string($entry_id_arr[$i]);
          $special_attaraction1 = addslashes($special_attaraction_arr[$i]);
          $day_program_arr1 = addslashes($day_program_arr[$i]);
          $overnight_stay1 = addslashes($overnight_stay_arr[$i]);

          if($checked_programe_arr[$i]=='true'){
            if($entry_id_arr[$i] == ''){
               $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from custom_package_program"));
               $id = $sq_max['max']+1;

               $sq1 = mysql_query("insert into custom_package_program( entry_id, package_id, attraction, day_wise_program, stay, meal_plan)values('$id','$package_id','$special_attaraction1', '$day_program_arr1', '$overnight_stay1','$meal_plan_arr[$i]')");
               if(!$sq1){
                  echo "error--Tour Itinerary not saved!";
                  exit;
                }
            }
            else{
               $query_pckg = "update custom_package_program set day_wise_program = '$day_program_arr1', attraction = '$special_attaraction1', stay = '$overnight_stay1',meal_plan='$meal_plan_arr[$i]' where entry_id='$entry_id_arr[$i]'";   
            
               $sq1 = mysql_query($query_pckg);
               if(!$sq1){
                  $GLOBALS['flag'] = false;
                  echo "error--Error in package program!";
               }
            }
         }else{
            $sq_iti = mysql_query("Delete from custom_package_program where entry_id='$entry_id_arr[$i]'");
            if(!$sq_iti){
               echo "error--Itinarary not updated!";
               exit;
             }
         }
        }
      //Hotel
       for($i=0; $i<sizeof($city_name_arr); $i++){

          $city_name_arr[$i] = mysql_real_escape_string($city_name_arr[$i]);
          $hotel_name_arr[$i] = mysql_real_escape_string($hotel_name_arr[$i]);
          $hotel_type_arr[$i] = mysql_real_escape_string($hotel_type_arr[$i]);
          $total_days_arr[$i] = mysql_real_escape_string($total_days_arr[$i]);
          $hotel_check_arr[$i] = mysql_real_escape_string($hotel_check_arr[$i]);
          $hotel_entry_id_arr[$i] = mysql_real_escape_string($hotel_entry_id_arr[$i]);

         if($hotel_check_arr[$i] == 'true'){
            if($hotel_entry_id_arr[$i] != ''){
               $sq2 = mysql_query("update custom_package_hotels set city_name = '$city_name_arr[$i]', hotel_name = '$hotel_name_arr[$i]', hotel_type = '$hotel_type_arr[$i]',total_days = '$total_days_arr[$i]' where entry_id='$hotel_entry_id_arr[$i]'");
            }
            else{
               $sq = mysql_query("select max(entry_id) as max from custom_package_hotels");
               $value = mysql_fetch_assoc($sq);
               $max_hotel_id = $value['max'] + 1;
               $sq2 = mysql_query("insert into custom_package_hotels(entry_id, package_id, city_name, hotel_name, hotel_type,total_days,image_url)values('$max_hotel_id','$package_id','$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_type_arr[$i]','$total_days_arr[$i]','')");
            }
         }
         else{
            $sq2 = mysql_query("delete from custom_package_hotels where entry_id='$hotel_entry_id_arr[$i]'");
         }
         
         if(!$sq2){
         $GLOBALS['flag'] = false;
         echo "error--Error in Hotel details!";
         }
      }
      
      //Transport Details
      $pickup_arr[$i] = mysql_real_escape_string($pickup_arr[$i]);
      $pickup_type_arr[$i] = mysql_real_escape_string($pickup_type_arr[$i]);
      $drop_arr[$i] = mysql_real_escape_string($drop_arr[$i]);
      $drop_type_arr[$i] = mysql_real_escape_string($drop_type_arr[$i]);
      $vehicle_check_arr[$i] = mysql_real_escape_string($vehicle_check_arr[$i]);
      $vehicle_name_arr[$i] = mysql_real_escape_string($vehicle_name_arr[$i]);
      $tr_entry_arr[$i] = mysql_real_escape_string($tr_entry_arr[$i]);
      for($i=0; $i<sizeof($vehicle_name_arr); $i++){

         $pickup_type = explode("-",$pickup_arr[$i])[0];
         $drop_type = explode("-",$drop_arr[$i])[0];
         $pickup = explode("-",$pickup_arr[$i])[1];
         $drop = explode("-",$drop_arr[$i])[1];

         if($vehicle_check_arr[$i] == 'true'){

            if($tr_entry_arr[$i] != ''){

               $sq2 = mysql_query("update custom_package_transport set `vehicle_name` = '$vehicle_name_arr[$i]',`drop`='$drop',`drop_type`='$drop_type',`pickup`='$pickup',`pickup_type`='$pickup_type' where entry_id='$tr_entry_arr[$i]'");
            }
            else{
               $sq = mysql_query("select max(entry_id) as max from custom_package_transport");
               $value = mysql_fetch_assoc($sq);
               $max_tr_id = $value['max'] + 1;

               $sq2 = mysql_query("INSERT INTO `custom_package_transport`(`entry_id`, `package_id`, `vehicle_name`, `pickup`, `pickup_type`, `drop`, `drop_type`)values('$max_tr_id','$package_id','$vehicle_name_arr[$i]', '$pickup','$pickup_type', '$drop', '$drop_type')");
               if(!$sq2){
               $GLOBALS['flag'] = false;
               echo "error--Error in Transport details!";
               }
            }
         }
         else{
            $sq2 = mysql_query("delete from custom_package_transport where entry_id='$tr_entry_arr[$i]'");
         }
      }

      if($GLOBALS['flag']){
         commit_t();
         echo "Package Tour has been successfully updated.";
         exit;
      }
      else{
         rollback_t();
      }
   }
   else{
   rollback_t();
   echo "error--Package Tour not updated!";
   }
}

function create_tour_file($file_name){

   global $b2c_flag;
   $myfile = fopen($file_name, "w");
   $txt = '<?php include "../tour-details.php"; ?>';

   fwrite($myfile, $txt);
   fclose($myfile);
}
  public function delete_hotel_image(){

    $image_id = $_POST['image_id'];

    $sq_delete = mysql_query("delete from hotel_vendor_images_entries where id='$image_id'");

    if($sq_delete){

      echo "Image Deleted";

    }



  }

}



