<?php 

$flag = true;

class tours_master{



///////////// Tour Master Save Start/////////////////////////////////////////////////////////////////////////////////////////

function tour_master_save($tour_type, $tour_name, $adult_cost, $child_with_cost,$child_without_cost , $infant_cost, $with_bed_cost,$visa_country_name,$company_name, $from_date, $to_date, $capacity,$active_flag,$train_from_location_arr,$train_to_location_arr,$train_class_arr,$from_city_id_arr , $to_city_id_arr, $plane_from_location_arr,$plane_to_location_arr,$airline_name_arr,$plane_class_arr,$day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$route_arr,$cabin_arr,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr,$inclusions, $exclusions,$pdf_url,$daywise_url,$dest_name)

{

  $tour_type = mysql_real_escape_string($tour_type);  
  $tour_name = mysql_real_escape_string($tour_name);  
  $tour_cost = mysql_real_escape_string($tour_cost); 
  $adult_cost = mysql_real_escape_string($adult_cost);  
  $child_with_cost = mysql_real_escape_string($child_with_cost);  
  $child_without_cost = mysql_real_escape_string($child_without_cost);
  $infant_cost = mysql_real_escape_string($infant_cost);  
  $with_bed_cost = mysql_real_escape_string($with_bed_cost);  
  $without_bed_cost = mysql_real_escape_string($without_bed_cost); 
  $active_flag = mysql_real_escape_string($active_flag); 
  //$inclusions = mysql_real_escape_string($inclusions);
  //$exclusions = mysql_real_escape_string($exclusions);
  $pdf_url = mysql_real_escape_string($pdf_url); 
  $dest_name = mysql_real_escape_string($dest_name); 


   $tour_name_count = mysql_num_rows(mysql_query("select * from tour_master where tour_name='$tour_name'"));

   if($tour_name_count>0)

   {

    echo "error--This tour name already exists.";

    return false;

    exit;

   } 



   $sq = mysql_query("select max(tour_id) as max from tour_master");

   $value = mysql_fetch_assoc($sq);

   $max_tour_id = $value['max'] + 1;



   begin_t();

   $inclusions = addslashes($inclusions);
   $exclusions = addslashes($exclusions);

   

   $sq = mysql_query("insert into tour_master(tour_id, tour_name, tour_type, adult_cost, child_with_cost,child_without_cost, infant_cost, with_bed_cost,visa_country_name,company_name, inclusions, exclusions, active_flag,pdf_url,dest_id) values('$max_tour_id', '$tour_name', '$tour_type', '$adult_cost', '$child_with_cost','$child_without_cost', '$infant_cost', '$with_bed_cost', '$visa_country_name','$company_name', '$inclusions', '$exclusions', '$active_flag','$pdf_url','$dest_name') ");



   if($sq)

   {

    // tour groups

     for($i=0; $i<sizeof($from_date); $i++)

     {

        $sq = mysql_query("select max(group_id) as max from tour_groups");

        $value = mysql_fetch_assoc($sq);

        $max_group_id = $value['max'] + 1;



        $from_date[$i] = mysql_real_escape_string($from_date[$i]);  
        $to_date[$i] = mysql_real_escape_string($to_date[$i]);  
        $capacity[$i] = mysql_real_escape_string($capacity[$i]); 
        $from_date[$i]=date("Y-m-d", strtotime($from_date[$i]));  
        $to_date[$i]=date("Y-m-d", strtotime($to_date[$i]));  



        $sq1 = mysql_query("insert into tour_groups(group_id, tour_id, from_date, to_date, capacity, status) values ('$max_group_id','$max_tour_id','$from_date[$i]','$to_date[$i]','$capacity[$i]','Active')");

        if(!$sq1){

          $GLOBALS['flag'] = false;

          echo "error--Error in tour groups!";

        }

        

     } 

      //prepare daywise url
      $all_url = array();
    $daywise_url = trim($daywise_url,',');
    $comma_url = explode(",",$daywise_url);
    foreach($comma_url as $eq_url){
      array_push($all_url,explode("=", $eq_url));
    }
   //

     // day-wise program

     for($i=0; $i<sizeof($day_program_arr); $i++)

       {

          $sq = mysql_query("select max(entry_id) as max from group_tour_program");

          $value = mysql_fetch_assoc($sq);

          $max_group_id = $value['max'] + 1;
          $meal_plan_arr[$i] = mysql_real_escape_string($meal_plan_arr[$i]);

          $special_attaraction_arr[$i] = addslashes($special_attaraction_arr[$i]);
          $day_program_arr[$i] = addslashes($day_program_arr[$i]);
          $overnight_stay_arr[$i] = addslashes($overnight_stay_arr[$i]);
          $image_url = "";
          foreach($all_url as $url){
            if($url[0]-1 == $i){
              $image_url = $url[1];
              break;
            }
          }
          $sq1 = mysql_query("insert into group_tour_program( entry_id, tour_id, attraction, day_wise_program, stay,meal_plan,daywise_images)values('$max_group_id','$max_tour_id','$special_attaraction_arr[$i]', '$day_program_arr[$i]', '$overnight_stay_arr[$i]','$meal_plan_arr[$i]','$image_url')");

          if(!$sq1){

            $GLOBALS['flag'] = false;

            echo "error--Error in Package Program!";

          }

        }



        $this->train_entries_save($max_tour_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr);

        $this->plane_entries_save($max_tour_id,$from_city_id_arr, $to_city_id_arr,$plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr);

        $this->hotel_entries_save($max_tour_id,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr);

        $this->cruise_entries_save($max_tour_id, $route_arr, $cabin_arr);


        if($GLOBALS['flag']){

          commit_t();

          echo "Group Tour has been successfully saved.";
          global $b2c_flag;
          $tour_name = str_replace(' ', '_', $tour_name);
          if($b2c_flag == '1'){
              $file_name = '../../../../group_tours/'.$tour_name.'-'.$max_tour_id.'.php';
              $this->create_tour_file($file_name);
          }

          exit;

        }

        else{

          rollback_t();

        }

      

        

      } 

      else

      {

    rollback_t();

    echo "error--Error in Group Tour.";

  } 

}

public function create_tour_file($file_name){

  global $b2c_flag;
  if($b2c_flag == '1'){
    $myfile = fopen($file_name, "w");
    $txt = '<?php include "../group-tour-detail.php"; ?>';

    fwrite($myfile, $txt);
    fclose($myfile);
  }
}


public function train_entries_save($max_tour_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr)
{

  for($i=0; $i<sizeof($train_from_location_arr); $i++){

    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_train_entries"));
    $id = $sq_max['max']+1;

    $sq_train = mysql_query("insert into group_train_entries ( id, tour_id, from_location, to_location, class ) values ( '$id', '$max_tour_id', '$train_from_location_arr[$i]', '$train_to_location_arr[$i]', '$train_class_arr[$i]' )");

    if(!$sq_train){

      echo "error--Train information not saved!";

      exit;
    }
  }

}

public function hotel_entries_save($max_tour_id,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr){
  for($i=0; $i<sizeof($city_name_arr); $i++){
    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_hotel_entries"));
    $id = $sq_max['max']+1;

    $sq_plane = mysql_query("insert into group_tour_hotel_entries ( id, tour_id ,city_id, hotel_id, hotel_type, total_nights) values ( '$id','$max_tour_id','$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_type_arr[$i]', '$total_days_arr[$i]' )");

    if(!$sq_plane){

      echo "error--Hotel information not saved!";

      exit;

    }
  }
}

public function plane_entries_save($max_tour_id, $from_city_id_arr,  $to_city_id_arr, $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr)

{

  for($i=0; $i<sizeof($plane_from_location_arr); $i++){

    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_plane_entries"));
    $id = $sq_max['max']+1;

    $from_location = array_slice(explode(' - ', $plane_from_location_arr[$i]), 1);
    $from_location = implode(' - ',$from_location);
    $to_location = array_slice(explode(' - ', $plane_to_location_arr[$i]), 1);
    $to_location = implode(' - ',$to_location);

    $sq_plane = mysql_query("insert into group_tour_plane_entries ( id, tour_id, from_city, from_location, to_city,to_location,airline_name, class) values ( '$id', '$max_tour_id', '$from_city_id_arr[$i]', '$from_location', '$to_city_id_arr[$i]', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]' )");

    if(!$sq_plane){

      echo "error--Plane information not saved!";

      exit;

    }

  }





}

// Cruise 
public function cruise_entries_save($max_tour_id, $route_arr, $cabin_arr)
{
  for($i=0; $i<sizeof($route_arr); $i++){

    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_cruise_entries"));
    $id = $sq_max['max']+1;

    $sq_cruise = mysql_query("insert into group_cruise_entries ( id, tour_id, route, 
      cabin ) values ( '$id', '$max_tour_id', '$route_arr[$i]', '$cabin_arr[$i]')");

    if(!$sq_cruise){

      echo "error--Cruise information not saved!";

      exit;
    }
  }
}

///////////// Tour Master Save End/////////////////////////////////////////////////////////////////////////////////////////



///////////// Tour Master Update Start/////////////////////////////////////////////////////////////////////////////////////////

function tour_master_update($tour_id,$tour_type, $tour_name, $adult_cost, $child_with_cost,$child_without_cost, $infant_cost, $with_bed_cost,$visa_country_name,$company_name, $from_date, $to_date, $capacity,$tour_group_id,$active_flag,$train_from_location_arr,$train_to_location_arr,$train_class_arr,$train_id_arr,$from_city_id_arr, $to_city_id_arr,$plane_from_location_arr,$plane_to_location_arr,$airline_name_arr,$plane_class_arr,$plane_id_arr,$day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$entry_id_arr,$route_arr,$cabin_arr,$c_entry_id_arr,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr,$hotel_entry_id_arr,$inclusions,$exclusions,$daywise_url)

{



  $tour_type = mysql_real_escape_string($tour_type);  

  $tour_name = mysql_real_escape_string($tour_name);    

  $adult_cost = mysql_real_escape_string($adult_cost);  

  $child_with_cost = mysql_real_escape_string($child_without_cost);  
  $child_without_cost = mysql_real_escape_string($child_with_cost);

  $infant_cost = mysql_real_escape_string($infant_cost);  

  $with_bed_cost = mysql_real_escape_string($with_bed_cost);

  $active_flag = mysql_real_escape_string($active_flag); 

  $visa_country_name = mysql_real_escape_string($visa_country_name); 

  $company_name = mysql_real_escape_string($company_name);

  $inclusions = addslashes($inclusions);
  $exclusions = addslashes($exclusions);



  $cur_tour_name_sq = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$tour_id'"));

  $cur_tour_name = $cur_tour_name_sq['tour_name'];



   $tour_name_count = mysql_num_rows(mysql_query("select * from tour_master where tour_name='$tour_name'"));

   if($tour_name_count>0 && $tour_name!=$cur_tour_name)

   {

    echo "error--This tour name already exists.";

    return false;

    exit;

   } 

   begin_t();



   $sq = mysql_query("update tour_master set tour_name='$tour_name',tour_type='$tour_type',adult_cost='$adult_cost', child_with_cost='$child_with_cost',child_without_cost='$child_without_cost', infant_cost='$infant_cost', with_bed_cost='$with_bed_cost',visa_country_name = '$visa_country_name',company_name='$company_name', active_flag='$active_flag', inclusions='$inclusions', exclusions='$exclusions' where tour_id='$tour_id'"); 



   if($sq){



        // tour groups

       for($i=0; $i<sizeof($from_date); $i++)

       {



          $from_date[$i] = mysql_real_escape_string($from_date[$i]);  

          $to_date[$i] = mysql_real_escape_string($to_date[$i]);  

          $capacity[$i] = mysql_real_escape_string($capacity[$i]); 



          $from_date[$i]=date("Y-m-d", strtotime($from_date[$i]));  

          $to_date[$i]=date("Y-m-d", strtotime($to_date[$i]));  



         $sq_group_no = mysql_num_rows(mysql_query("select * from tour_groups where group_id='$tour_group_id[$i]' "));



         if($sq_group_no==1)

         {

            $sq1 = mysql_query("update tour_groups set from_date='$from_date[$i]', to_date='$to_date[$i]', capacity='$capacity[$i]' where group_id='$tour_group_id[$i]'");

            if(!$sq1)

             {

                $GLOBALS['flag'] = false;

                echo "error--Tour group not saved at row ".($i+1);

                //exit;

             } 

             

         }

         else

         { 

           $sq = mysql_query("select max(group_id) as max from tour_groups");

           $value = mysql_fetch_assoc($sq);

           $max_group_id = $value['max'] + 1;        



            $sq1 = mysql_query("insert into tour_groups(group_id, tour_id, from_date, to_date, capacity, status) values ('$max_group_id','$tour_id','$from_date[$i]','$to_date[$i]','$capacity[$i]','Active')");

           

            if(!$sq1)

             {

                $GLOBALS['flag'] = false;

                echo "error--Tour group not saved at row ".($i+1);

                //exit;

             } 



         }

       } 
       $all_url = array();
       $daywise_url = trim($daywise_url,',');
       $comma_url = explode(",",$daywise_url);
       foreach($comma_url as $eq_url){
         array_push($all_url,explode("=", $eq_url));
       }
       // daywise program

      for($i=0; $i<sizeof($day_program_arr); $i++)

       {

          
          $entry_id_arr[$i] = mysql_real_escape_string($entry_id_arr[$i]);
          $meal_plan_arr[$i] = mysql_real_escape_string($meal_plan_arr[$i]);

          $special_attaraction1 = addslashes($special_attaraction_arr[$i]);
          $day_program1 = addslashes($day_program_arr[$i]);
          $overnight_stay1 = addslashes($overnight_stay_arr[$i]);
          $image_url = NULL;
          foreach($all_url as $url){
            if($url[0]-1 == $i){
              $image_url = $url[1];
              break;
            }
          }
          
          if($image_url == NULL){
            $check_query = mysql_fetch_assoc(mysql_query("select daywise_images from group_tour_program where entry_id=".$entry_id_arr[$i]));
            $image_url = $check_query['daywise_images'];
          }
          
          $query_pckg = "update group_tour_program set attraction = '$special_attaraction1', day_wise_program = '$day_program1', stay = '$overnight_stay1', meal_plan='$meal_plan_arr[$i]', daywise_images = '$image_url' where entry_id='$entry_id_arr[$i]'";   


          $sq2 = mysql_query($query_pckg);

          if(!$sq2){

            $GLOBALS['flag'] = false;

            echo "error--Error in package program!";

          }

        } 



       $this->train_entries_update($tour_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_id_arr);
       $this->plane_entries_update($tour_id,$from_city_id_arr, $to_city_id_arr, $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $plane_id_arr);
       $this->hotel_entries_update($tour_id,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr,$hotel_entry_id_arr);
       $this->cruise_entries_update($tour_id,$route_arr, $cabin_arr, $c_entry_id_arr);

       if($GLOBALS['flag']){
          commit_t();
          echo "Group Tour has been successfully updated.";
          exit;
       }
       else{
         rollback_t();
         echo "error--Tour details not updated!";
         exit;
       }



   }

   else

   {

    rollback_t();

    echo "Error.";

   } 

}

public function train_entries_update($tour_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_id_arr)

{

  for($i=0; $i<sizeof($train_from_location_arr); $i++){



    if($train_id_arr[$i] != ""){

      $sq_train = mysql_query("update group_train_entries set from_location='$train_from_location_arr[$i]', to_location='$train_to_location_arr[$i]', class='$train_class_arr[$i]' where id='$train_id_arr[$i]' ");

      if(!$sq_train){

        echo "error--Train information not updated!";

        exit;

      }

    }

    else{

      $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_train_entries"));

      $id = $sq_max['max']+1;



      $sq_train = mysql_query("insert into group_train_entries ( id, tour_id, from_location, to_location, class ) values ( '$id', '$tour_id', '$train_from_location_arr[$i]', '$train_to_location_arr[$i]', '$train_class_arr[$i]' )");

      if(!$sq_train){

        echo "error--Train information not saved!";

        exit;

      }

    }

  }

}

public function hotel_entries_update($tour_id,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr,$hotel_entry_id_arr){
  for($i=0; $i<sizeof($city_name_arr); $i++){
    if($hotel_entry_id_arr[$i] != ""){
        $sq_hotel = mysql_query("update group_tour_hotel_entries set city_id = '$city_name_arr[$i]', hotel_id = '$hotel_name_arr[$i]', hotel_type = '$hotel_type_arr[$i]', total_nights = '$total_days_arr[$i]' where id='$hotel_entry_id_arr[$i]'");
      
      if(!$sq_hotel){

        echo "error--Hotel information not saved!";

        exit;
      }
    }
    else{
      $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_hotel_entries"));
      $id = $sq_max['max']+1;
      $sq_hotel = mysql_query("insert into group_tour_hotel_entries ( id, tour_id,city_id, hotel_id, 
      hotel_type,  total_nights) values ( '$id','$tour_id', '$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_type_arr[$i]', '$total_days_arr[$i]')");
      if(!$sq_hotel){

        echo "error--Hotel information not saved!";

        exit;
      }
    }
  }
}

public function plane_entries_update($tour_id,$from_city_id_arr, $to_city_id_arr, $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $plane_id_arr)

{

  for($i=0; $i<sizeof($plane_from_location_arr); $i++){
      $from_location = array_slice(explode(' - ', $plane_from_location_arr[$i]), 1);
      $from_location = implode(' - ',$from_location);
      $to_location = array_slice(explode(' - ', $plane_to_location_arr[$i]), 1);
      $to_location = implode(' - ',$to_location);
      if($plane_id_arr[$i]=="")

      {

        $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_plane_entries"));

        $id = $sq_max['max']+1;
        
        


        $sq_plane = mysql_query("insert into group_tour_plane_entries ( id, tour_id,from_city, to_city, from_location, to_location,airline_name, class) values ( '$id', '$tour_id', '$from_city_id_arr[$i]', '$to_city_id_arr[$i]', '$from_location', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]' )");
        echo "insert into group_tour_plane_entries ( id, tour_id,from_city, to_city, from_location, to_location,airline_name, class) values ( '$id', '$tour_id', '$from_city_id_arr[$i]', '$to_city_id_arr[$i]', '$from_location', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]' )";

        if(!$sq_plane)

        {

          echo "error--Record not inserted.";

          exit;

        }

      }else

      {

        $sq_update=mysql_query("UPDATE `group_tour_plane_entries` SET  `from_location`='$from_location',`to_location`='$to_location',airline_name='$airline_name_arr[$i]',`class`='$plane_class_arr[$i]',from_city='$from_city_id_arr[$i]', to_city='$to_city_id_arr[$i]' WHERE `id`='$plane_id_arr[$i]'");

        if(!$sq_update)

        {

          echo "error--Record not updated";

          exit;

        }

      }

  }


}


// Cruise 
public function cruise_entries_update($tour_id, $route_arr, $cabin_arr, $c_entry_id_arr)
{
  for($i=0; $i<sizeof($route_arr); $i++){


    if($c_entry_id_arr[$i] != ""){
        $sq_cruise = mysql_query("update group_cruise_entries set  route = '$route_arr[$i]', cabin = '$cabin_arr[$i]' where id='$c_entry_id_arr[$i]'");

      if(!$sq_cruise){

        echo "error--Cruise information not saved!";

        exit;
      }
    }
    else{
      $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_cruise_entries"));
      $id = $sq_max['max']+1;

      $sq_cruise = mysql_query("insert into group_cruise_entries ( id, tour_id, route, 
        cabin ) values ( '$id', '$tour_id', '$route_arr[$i]', '$cabin_arr[$i]')");

      if(!$sq_cruise){

        echo "error--Cruise information not saved!";

        exit;
      }
    }
  }
}
///////////// Tour Master Update End/////////////////////////////////////////////////////////////////////////////////////////







/////////////////*** Upload Tour Adnary Save start *********////////////////////////////////

function upload_tour_adnary_save($tour_id, $adnary_url)

{

  $sq = mysql_query("update tour_master set adnary_url = '$adnary_url' where tour_id='$tour_id'");

  if(!$sq)

  {

    echo "Error";

    exit;

  } 

  else

  {

    echo "Itinerary Uploaded successfully.";

    exit;

  }  

}

/////////////////*** Upload Tour Adnary Save end *********////////////////////////////////


    function images_delete_update(){
      
      $entry_id = $_POST['entry_id'];
      //$url = $_POST['image_url'];
      $sq1 = mysql_query("update group_tour_program set daywise_images='' where entry_id='$entry_id'");
      if(!sq1){
        echo "error-- Image not deleted";
      }
      else{
        //echo "Deleted sucessfully";
      }
    }
}


?>