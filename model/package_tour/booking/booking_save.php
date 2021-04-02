<?php 

$flag = true;

class booking_save{

///////////////////////***Package tour booking save form start*********//////////////

function package_tour_booking_master_save()

{ 

    $row_spec ='sales';

    $emp_id = $_POST['emp_id'];
    $customer_id = $_POST['customer_id'];
    $quotation_id = $_POST['quotation_id'];
    $unique_timestamp = $_POST['unique_timestamp'];
    $branch_admin_id = $_POST['branch_admin_id'];
    $financial_year_id = $_POST['financial_year_id'];
 

    //** Getting tour information    

    $tour_name = $_POST['tour_name'];

    $package_id = $_POST['package_id'];

    $tour_type = $_POST['tour_type'];

    $tour_from_date = $_POST['tour_from_date'];

    $tour_to_date = $_POST['tour_to_date'];

    $total_tour_days = $_POST['total_tour_days'];

    $taxation_type = $_POST['taxation_type'];


    


    //** Getting member information    

    $m_honorific = $_POST['m_honorific'];

    $m_first_name = $_POST['m_first_name'];

    $m_middle_name = $_POST['m_middle_name'];

    $m_last_name = $_POST['m_last_name'];

    $m_gender = $_POST['m_gender'];

    $m_birth_date = $_POST['m_birth_date'];

    $m_age = $_POST['m_age'];

    $m_adolescence = $_POST['m_adolescence'];

    $m_passport_no = $_POST['m_passport_no'];

    $m_passport_issue_date = $_POST['m_passport_issue_date'];

    $m_passport_expiry_date = $_POST['m_passport_expiry_date'];


    $contact_person_name = $_POST['contact_person_name'];

    $email_id = $_POST['email_id'];

    $mobile_no = $_POST['mobile_no'];

    $address = $_POST['address'];

    $country_name = $_POST['country_name'];

    $city = $_POST['city'];

    $state = $_POST['state'];



    //** Traveling information overall

    $train_expense = $_POST['train_expense'];

    $train_service_charge = $_POST['train_service_charge'];

    $train_taxation_id = $_POST['train_taxation_id'];

    $train_service_tax = $_POST['train_service_tax'];

    $train_service_tax_subtotal = $_POST['train_service_tax_subtotal'];

    $total_train_expense = $_POST['total_train_expense'];



    $plane_expense = $_POST['plane_expense'];

    $plane_service_charge = $_POST['plane_service_charge'];

    $plane_taxation_id = $_POST['plane_taxation_id'];

    $plane_service_tax = $_POST['plane_service_tax'];

    $plane_service_tax_subtotal = $_POST['plane_service_tax_subtotal'];

    $total_plane_expense = $_POST['total_plane_expense'];

    $cruise_expense = $_POST['cruise_expense'];
    $cruise_service_charge = $_POST['cruise_service_charge'];
    $cruise_taxation_id = $_POST['cruise_taxation_id'];
    $cruise_service_tax = $_POST['cruise_service_tax'];
    $cruise_service_tax_subtotal = $_POST['cruise_service_tax_subtotal'];
    $total_cruise_expense = $_POST['total_cruise_expense'];

    $total_travel_expense = $_POST['total_travel_expense'];
    $train_ticket_path = $_POST['train_ticket_path'];

    $plane_ticket_path = $_POST['plane_ticket_path'];
    $cruise_ticket_path = $_POST['cruise_ticket_path']; 



    //**Traveling information for train

    $train_uploaded_doc_path = $_POST['train_uploaded_doc_path'];

    $train_travel_date = $_POST['train_travel_date'];

    $train_from_location = $_POST['train_from_location'];

    $train_to_location = $_POST['train_to_location'];

    $train_train_no = $_POST['train_train_no'];

    $train_travel_class = $_POST['train_travel_class'];

    $train_travel_priority = $_POST['train_travel_priority'];

    $train_amount = $_POST['train_amount'];

    $train_seats = $_POST['train_seats'];



    //**Traveling information for plane
    $from_city_id_arr = $_POST['from_city_id_arr'];
    $to_city_id_arr = $_POST['to_city_id_arr'];
    $plane_uploaded_doc_path = $_POST['plane_uploaded_doc_path'];

    $plane_travel_date = $_POST['plane_travel_date'];

    $plane_from_location = $_POST['plane_from_location'];

    $plane_to_location = $_POST['plane_to_location'];

    $plane_amount = $_POST['plane_amount'];

    $plane_seats = $_POST['plane_seats'];

    $plane_company = $_POST['plane_company'];

    $arraval_arr =$_POST['arraval_arr'];


    // Cruise
    $cruise_dept_date_arr =$_POST['cruise_dept_date_arr'];
    $cruise_arrival_date_arr =$_POST['cruise_arrival_date_arr'];
    $route_arr =$_POST['route_arr'];
    $cabin_arr =$_POST['cabin_arr'];
    $sharing_arr =$_POST['sharing_arr'];
    $cruise_seats_arr =$_POST['cruise_seats_arr'];
    $cruise_amount_arr =$_POST['cruise_amount_arr'];

    //**Hoteling details

    $city_id = $_POST['city_id'];

    $hotel_id = $_POST['hotel_id'];

    $hotel_from_date = $_POST['hotel_from_date'];

    $hotel_to_date = $_POST['hotel_to_date'];

    $hotel_rooms = $_POST['hotel_rooms'];

    $hotel_catagory = $_POST['hotel_catagory'];

    $room_type = $_POST['room_type'];

    $meal_plan = $_POST['meal_plan'];

    $confirmation_no = $_POST['confirmation_no'];
  
    // Transport
    $transp_vehicle_arr =$_POST['transp_vehicle_arr'];
    $transp_start_date =$_POST['transp_start_date'];
    $trans_pickuptype_arr=$_POST['trans_pickuptype_arr'];
    $trans_pickup_arr=$_POST['trans_pickup_arr'];
    $trans_droptype_arr=$_POST['trans_droptype_arr'];
    $trans_drop_arr=$_POST['trans_drop_arr'];
    $trans_count_arr=$_POST['trans_count_arr'];
    
    // Activity
    $exc_city_arr =$_POST['exc_city_arr'];
    $exc_name_arr =$_POST['exc_name_arr'];
    $exc_date_arr = $_POST['exc_date_arr'];
    $transfer_arr = $_POST['transfer_arr'];

    // Itinerary
    $special_attraction_arr =$_POST['special_attraction_arr'];
    $day_program_arr =$_POST['day_program_arr'];
    $stay_arr =$_POST['stay_arr'];
    $meal_plan_arr =$_POST['meal_plan_arr'];

    $dest_id =$_POST['dest_id'];
    $package1 =$_POST['package1'];
    $incl =$_POST['incl'];
    $excl =$_POST['excl'];
    $incl = addslashes($incl);
    $excl = addslashes($excl);

    //**Visa Details

    $visa_country_name = $_POST['visa_country_name'];

    $visa_amount = $_POST['visa_amount'];

    $visa_service_charge = $_POST['visa_service_charge'];

    $visa_taxation_id = $_POST['visa_taxation_id'];

    $visa_service_tax = $_POST['visa_service_tax'];

    $visa_service_tax_subtotal = $_POST['visa_service_tax_subtotal'];

    $visa_total_amount = $_POST['visa_total_amount'];

  

    $insuarance_company_name = $_POST['insuarance_company_name'];

    $insuarance_amount = $_POST['insuarance_amount'];

    $insuarance_service_charge = $_POST['insuarance_service_charge'];

    $insuarance_taxation_id = $_POST['insuarance_taxation_id'];

    $insuarance_service_tax = $_POST['insuarance_service_tax'];

    $insuarance_service_tax_subtotal = $_POST['insuarance_service_tax_subtotal'];

    $insuarance_total_amount = $_POST['insuarance_total_amount'];



    //**Costing details

    $total_hotel_expense = $_POST['total_hotel_expense'];

    $service_charge = $_POST['service_charge'];

    $subtotal = $_POST['subtotal'];
    $basic_amount = $_POST['basic_amount'];
    $tour_taxation_id = $_POST['tour_taxation_id']; 
    $tour_service_tax = $_POST['tour_service_tax'];
    $tour_service_tax_subtotal = $_POST['tour_service_tax_subtotal'];
    $currency_code = $_POST['currency_code'];
    $rue_cost = $_POST['rue_cost'];
    $subtotal_with_rue = $_POST['subtotal_with_rue'];
    $net_total = $_POST['net_total'];
    
    $actual_tour_cost = $_POST['actual_tour_cost'];

    //**Payment details
    $payment_date = $_POST['payment_date'];
    $payment_mode = $_POST['payment_mode'];
    $payment_amount = $_POST['payment_amount'];
    $bank_name = $_POST['bank_name'];
    $transaction_id = $_POST['transaction_id'];
    $payment_for = $_POST['payment_for'];
    $p_travel_type = $_POST['p_travel_type'];
    $bank_id_arr = $_POST['bank_id_arr'];
    $credit_amount_arr = $_POST['credit_amount_arr'];
    $credit_charges_arr = $_POST['credit_charges_arr'];
    $credit_card_details_arr = $_POST['credit_card_details_arr'];


    //**Form information

    $special_request = $_POST['special_request'];
    $special_request = addslashes($special_request);
    
    $due_date = $_POST['due_date'];

    $booking_date = $_POST['booking_date'];





    $unique_timestamp_count = mysql_num_rows(mysql_query("select unique_timestamp from package_tour_booking_master where unique_timestamp='$unique_timestamp'"));



    if($unique_timestamp_count>0){

      echo "Error! This timestamp already exists.";

      exit;

    }
    $roundoff = $_POST['roundoff'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $reflections = json_encode($reflections);
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    
    foreach($bsmValues[0] as $key => $value){
      switch($key){
      case 'basic' : $basic_amount = ($value != "") ? $value : $basic_amount;break;
      case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      case 'markup' : $markup = ($value != "") ? $value : $markup;break;
      case 'discount' : $discount = ($value != "") ? $value : $discount;break;
      }
    }
    $bsmValues = json_encode($bsmValues);
    $tour_from_date = date("Y-m-d", strtotime($tour_from_date));

    $tour_to_date = date("Y-m-d", strtotime($tour_to_date));

    $due_date = get_date_db($due_date);

    $booking_date = get_datetime_db($booking_date);

    begin_t();

    $max_booking_id1 = mysql_fetch_assoc(mysql_query("select max(booking_id) as max from package_tour_booking_master"));

    $max_booking_id = $max_booking_id1['max']+1;

    $sq_booking = mysql_query("insert into package_tour_booking_master (booking_id,dest_id,new_package_id,quotation_id, emp_id, customer_id, branch_admin_id,financial_year_id, tour_name,package_id, tour_type, tour_from_date, tour_to_date, total_tour_days, taxation_type, required_rooms, child_with_bed, child_without_bed, contact_person_name, email_id, mobile_no,  address, country_name, city, state, train_upload_ticket, plane_upload_ticket, cruise_upload_ticket,  train_expense, train_service_charge, train_taxation_id, train_service_tax, train_service_tax_subtotal, total_train_expense, plane_expense, plane_service_charge, plane_taxation_id, plane_service_tax, plane_service_tax_subtotal, total_plane_expense,  cruise_expense, cruise_service_charge, cruise_taxation_id, cruise_service_tax, cruise_service_tax_subtotal, total_cruise_expense, total_travel_expense, visa_country_name, visa_amount, visa_service_charge, visa_taxation_id, visa_service_tax, visa_service_tax_subtotal, visa_total_amount, insuarance_company_name, insuarance_amount, insuarance_service_charge, insuarance_taxation_id, insuarance_service_tax, insuarance_service_tax_subtotal, insuarance_total_amount, total_hotel_expense, service_charge, subtotal, tour_service_tax, tour_service_tax_subtotal, currency_code, rue_cost, subtotal_with_rue, net_total, actual_tour_expense, special_request, booking_date, due_date, unique_timestamp,inclusions,exclusions,reflections,basic_amount,bsm_values,roundoff) values ('$max_booking_id','$dest_id','$package1','$quotation_id', '$emp_id', '$customer_id', '$branch_admin_id','$financial_year_id', '$tour_name','$package_id', '$tour_type', '$tour_from_date', '$tour_to_date', '$total_tour_days', '$taxation_type', '', '', '', '$contact_person_name', '$email_id', '$mobile_no', '$address', '$country_name', '$city', '$state', '$train_ticket_path', '$plane_ticket_path', '$cruise_ticket_path', '$train_expense', '$train_service_charge', '$train_taxation_id', '$train_service_tax', '$train_service_tax_subtotal', '$total_train_expense', '$plane_expense', '$plane_service_charge', '$plane_taxation_id', '$plane_service_tax', '$plane_service_tax_subtotal', '$total_plane_expense', '$cruise_expense', '$cruise_service_charge', '$cruise_taxation_id', '$cruise_service_tax', '$cruise_service_tax_subtotal', '$total_cruise_expense', '$total_travel_expense', '$visa_country_name', '$visa_amount', '$visa_service_charge', '$visa_taxation_id', '$visa_service_tax', '$visa_service_tax_subtotal', '$visa_total_amount', '$insuarance_company_name', '$insuarance_amount', '$insuarance_service_charge', '$insuarance_taxation_id', '$insuarance_service_tax', '$insuarance_service_tax_subtotal', '$insuarance_total_amount', '$total_hotel_expense', '$service_charge', '$subtotal',  '$tour_service_tax', '$tour_service_tax_subtotal', '$currency_code', '$rue_cost', '$subtotal_with_rue', '$net_total', '$actual_tour_cost', '$special_request', '$booking_date', '$due_date', '$unique_timestamp','$incl','$excl','$reflections','$basic_amount','$bsmValues','$roundoff')");



    if(!$sq_booking)

    {

      rollback_t();

      echo "Booking details not saved.";

      exit;

    }  

    else

    {

      //**This saves package tour travelers details

      $this->package_tour_travelers_details_master_save($max_booking_id, $m_honorific, $m_first_name, $m_middle_name, $m_last_name, $m_gender, $m_birth_date, $m_age, $m_adolescence, $m_passport_no, $m_passport_issue_date, $m_passport_expiry_date);



    //** This function stores the traveling information

    $this->package_tour_traveling_information_save( $max_booking_id, $train_travel_date, $train_from_location, $train_to_location, $train_train_no, $train_travel_class, $train_travel_priority, $train_amount, $train_seats, $plane_travel_date,$from_city_id_arr, $plane_from_location, $to_city_id_arr, $plane_to_location, $plane_amount, $plane_seats, $plane_company, $arraval_arr,$cruise_dept_date_arr, $cruise_arrival_date_arr, $route_arr, $cabin_arr, $sharing_arr, $cruise_seats_arr, $cruise_amount_arr);



    //** This function stores the hotel accomodation information

    $this->package_tour_hotel_accomodation_information_save($max_booking_id, $city_id, $hotel_id, $hotel_from_date, $hotel_to_date, $hotel_rooms, $hotel_catagory, $room_type, $meal_plan, $confirmation_no);

    //** This function stores the transport information
    $this->package_tour_tranpsort_information_save($max_booking_id, $transp_vehicle_arr, $transp_start_date,$trans_pickuptype_arr,$trans_pickup_arr,$trans_droptype_arr,$trans_drop_arr,$trans_count_arr);

    //** This function stores the excursion information
    $this->package_tour_exc_information_save($max_booking_id, $exc_city_arr, $exc_name_arr,$exc_date_arr,$transfer_arr);

    //** This function stores the itinerarary information
    if($quotation_id == 0){
      $this->package_tour_itinerary_inf_save($max_booking_id, $special_attraction_arr, $day_program_arr,$stay_arr,$meal_plan_arr);
    }

    //Get Particular
    $particular = $this->get_particular($customer_id,$tour_name,$tour_from_date,($total_tour_days-1));

    //**=============**Finance Entries save start**============**//
    $booking_save_transaction = new booking_save_transaction;
    $booking_save_transaction->finance_save($max_booking_id, $row_spec, $branch_admin_id,$particular);
    //**=============**Finance Entries save end**============**//



    if($GLOBALS['flag']){

      commit_t();

      echo "Package Tour has been successfully saved.";

      


      //** This function send sms of booking successfull

        $this->booking_successfull_sms_send($mobile_no,$tour_name,$customer_id);        

        

        //** This function saves payment master details

        $this->package_tour_payment_master_save($customer_id,$max_booking_id, $payment_date, $payment_mode, $payment_amount, $bank_name, $transaction_id, $payment_for, $p_travel_type, $bank_id_arr, $branch_admin_id , $emp_id,$credit_amount_arr,$credit_charges_arr,$credit_card_details_arr);   



        $total_payment = 0;

        // payment email send

        $payment_master  = new payment;
        for($i=0; $i<sizeof($payment_date); $i++){

            $total_payment = $total_payment + $payment_amount[$i];

        }

        //Update customer credit note balance
        $payment_amount1 = $total_payment;
        $sq_credit_note = mysql_query("select * from credit_note_master where customer_id='$customer_id'");
        $i=0;
        while($row_credit = mysql_fetch_assoc($sq_credit_note)) {

            if($row_credit['payment_amount'] <= $payment_amount1 && $payment_amount1 != '0'){
                $payment_amount1 = $payment_amount1 - $row_credit['payment_amount'];
                $temp_amount = 0;
            }
            else{
                $temp_amount = $row_credit['payment_amount'] - $payment_amount1;
                $payment_amount1 = 0;
            }
            $sq_credit = mysql_query("update credit_note_master set payment_amount ='$temp_amount' where id='$row_credit[id]'");
            
        }

        $payment_master->payment_email_notification_send($max_booking_id,$total_payment,$payment_mode[0], $payment_date[0]);

        //payment sms send
        $payment_master->payment_sms_notification_send($max_booking_id, $total_payment, $payment_mode[0],$customer_id);

        $total_tour_expense = $total_travel_expense + $actual_tour_cost;
        $balance_amount = $total_tour_expense - $total_payment;

        //** This function send mail after booking is done

        $this->send_mail_to_traveler($max_booking_id, $tour_name, $tour_from_date, $tour_to_date, $customer_id, $email_id,$m_first_name,$total_tour_expense, $total_payment);

        //Getting customer Ledger
        $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
        $cust_gl = $sq_cust['ledger_id'];

        global $transaction_master;
       
        exit;
      }
      else{
        rollback_t();
        exit;
      }
    }
}

//////////////////***Package tour booking save form end*********//////////////


function get_particular($customer_id,$tour_name,$tour_from_date,$total_tour_days){

  $sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];

  return $tour_name.' for '.$cust_name.' for '.$total_tour_days.' Nights starting from '.get_date_user($tour_from_date);
}

//////////////***Package tour travelers details master save start*****///////



function package_tour_travelers_details_master_save($max_booking_id, $m_honorific, $m_first_name, $m_middle_name, $m_last_name, $m_gender, $m_birth_date, $m_age, $m_adolescence, $m_passport_no, $m_passport_issue_date, $m_passport_expiry_date)

{

  for($i=0; $i<sizeof($m_first_name); $i++)

  {

    //$max_traveler_id = $max_traveler_id + 1;

    $sq = mysql_query("select max(traveler_id) as max from package_travelers_details");

    $value = mysql_fetch_assoc($sq);

    $max_traveler_id = $value['max'] + 1;



    $m_honorific[$i] = mysql_real_escape_string($m_honorific[$i]);

    $m_first_name[$i] = mysql_real_escape_string($m_first_name[$i]);

    $m_middle_name[$i] = mysql_real_escape_string($m_middle_name[$i]);

    $m_last_name[$i] = mysql_real_escape_string($m_last_name[$i]);

    $m_gender[$i] = mysql_real_escape_string($m_gender[$i]);

    $m_birth_date[$i] = mysql_real_escape_string($m_birth_date[$i]);

    $m_age[$i] = mysql_real_escape_string($m_age[$i]);

    $m_adolescence[$i] = mysql_real_escape_string($m_adolescence[$i]);    

    $m_passport_no[$i] = mysql_real_escape_string($m_passport_no[$i]);    

    $m_passport_issue_date[$i] = mysql_real_escape_string($m_passport_issue_date[$i]);    

    $m_passport_expiry_date[$i] = mysql_real_escape_string($m_passport_expiry_date[$i]);



    $m_birth_date[$i] = date("Y-m-d", strtotime($m_birth_date[$i]));

    $m_passport_issue_date[$i] = date("Y-m-d", strtotime($m_passport_issue_date[$i]));

    $m_passport_expiry_date[$i] = date("Y-m-d", strtotime($m_passport_expiry_date[$i]));

     

    $sq = mysql_query("insert into package_travelers_details (traveler_id, booking_id, m_honorific, first_name, middle_name, last_name, gender, birth_date, age, adolescence, passport_no, passport_issue_date, passport_expiry_date, status) values ('$max_traveler_id', '$max_booking_id', '$m_honorific[$i]', '$m_first_name[$i]', '$m_middle_name[$i]', '$m_last_name[$i]', '$m_gender[$i]', '$m_birth_date[$i]', '$m_age[$i]', '$m_adolescence[$i]', '$m_passport_no[$i]', '$m_passport_issue_date[$i]', '$m_passport_expiry_date[$i]', 'Active')");   



    if(!$sq)

    {

      $GLOBALS['flag'] = false;

      echo "Error at row".($i+1)." for traveler members.";

    }  

    

  }



}



///////////////////////***Package tour travelers details master save end*********//////////////





///////////////////////***Package tour schedule master master save start*********//////////////



function package_tour_traveling_information_save( $max_booking_id, $train_travel_date, $train_from_location, $train_to_location, $train_train_no, $train_travel_class, $train_travel_priority, $train_amount, $train_seats, $plane_travel_date, $from_city_id_arr, $plane_from_location, $to_city_id_arr, $plane_to_location, $plane_amount, $plane_seats, $plane_company, $arraval_arr,$cruise_dept_date_arr, $cruise_arrival_date_arr, $route_arr, $cabin_arr, $sharing_arr, $cruise_seats_arr, $cruise_amount_arr )

{



  //**Saves Train Information    

      

      for($i=0; $i<sizeof($train_travel_date); $i++)

      {

        //$max_train_id = $max_train_id + 1;

        $sq = mysql_query("select max(train_id) as max from package_train_master");

        $value = mysql_fetch_assoc($sq);

        $max_train_id = $value['max'] + 1;



        $train_travel_date[$i] = mysql_real_escape_string($train_travel_date[$i]);

        $train_from_location[$i] = mysql_real_escape_string($train_from_location[$i]);

        $train_to_location[$i] = mysql_real_escape_string($train_to_location[$i]);

        $train_train_no[$i] = mysql_real_escape_string($train_train_no[$i]);

        $train_travel_class[$i] = mysql_real_escape_string($train_travel_class[$i]);

        $train_travel_priority[$i] = mysql_real_escape_string($train_travel_priority[$i]);

        $train_amount[$i] = mysql_real_escape_string($train_amount[$i]);

        $train_seats[$i] = mysql_real_escape_string($train_seats[$i]);



        $train_travel_date[$i] = date("Y-m-d, H:i", strtotime($train_travel_date[$i]));        

       



        $sq = mysql_query(" insert into package_train_master (train_id, booking_id, date, from_location, to_location, train_no, amount, seats, train_priority, train_class ) values ('$max_train_id', '$max_booking_id', '$train_travel_date[$i]', '$train_from_location[$i]', '$train_to_location[$i]', '$train_train_no[$i]', '$train_amount[$i]', '$train_seats[$i]', '$train_travel_priority[$i]', '$train_travel_class[$i]') ");

        if(!$sq)

        {

          $GLOBALS['flag'] = false;

          echo "Error at row".($i+1)." for train information.";

          //exit;

        }   





      }  





      //**Saves Plane Information          

      for($i=0; $i<sizeof($plane_travel_date); $i++)

      {

        //$max_plane_id = $max_plane_id + 1;

        $sq = mysql_query("select max(plane_id) as max from package_plane_master");

        $value = mysql_fetch_assoc($sq);

        $max_plane_id = $value['max'] + 1;

        $from_city_id_arr[$i] = mysql_real_escape_string($from_city_id_arr[$i]);
        $to_city_id_arr[$i] = mysql_real_escape_string($to_city_id_arr[$i]);
        $plane_travel_date[$i] = mysql_real_escape_string($plane_travel_date[$i]);

        $plane_from_location[$i] = mysql_real_escape_string($plane_from_location[$i]);

        $plane_to_location[$i] = mysql_real_escape_string($plane_to_location[$i]);

        $plane_amount[$i] = mysql_real_escape_string($plane_amount[$i]);

        $plane_seats[$i] = mysql_real_escape_string($plane_seats[$i]);

        $plane_company[$i] = mysql_real_escape_string($plane_company[$i]);

        $arraval_arr[$i] = mysql_real_escape_string($arraval_arr[$i]);



        $plane_travel_date[$i] = date("Y-m-d H:i:s", strtotime($plane_travel_date[$i]));

        $arraval_arr[$i] = date('Y-m-d H:i:s', strtotime($arraval_arr[$i]));

        $from_location = array_slice(explode(' - ', $plane_from_location[$i]), 1);
        $from_location = implode(' - ',$from_location);
        $to_location = array_slice(explode(' - ', $plane_to_location[$i]), 1);
        $to_location = implode(' - ',$to_location);

        $sq = mysql_query(" insert into package_plane_master (plane_id, booking_id, date,from_city, from_location, to_city,to_location, company, amount, seats, arraval_time ) values ('$max_plane_id', '$max_booking_id', '$plane_travel_date[$i]', '$from_city_id_arr[$i]',  '$from_location', '$to_city_id_arr[$i]', '$to_location', '$plane_company[$i]', '$plane_amount[$i]', '$plane_seats[$i]', '$arraval_arr[$i]') ");



        if(!$sq)

        {

          $GLOBALS['flag'] = false;

          echo "Error at row".($i+1)." for Flight information.";

          //exit;

        }  

      }

      //**Saves Cruise Information    

      

      for($i=0; $i<sizeof($cruise_dept_date_arr); $i++)

      {

        $sq = mysql_query("select max(cruise_id) as max from package_cruise_master");
        $value = mysql_fetch_assoc($sq);
        $max_cruise_id = $value['max'] + 1;

        $cruise_dept_date_arr[$i] = mysql_real_escape_string($cruise_dept_date_arr[$i]);
        $cruise_arrival_date_arr[$i] = mysql_real_escape_string($cruise_arrival_date_arr[$i]);
        $route_arr[$i] = mysql_real_escape_string($route_arr[$i]);
        $cabin_arr[$i] = mysql_real_escape_string($cabin_arr[$i]);
        $sharing_arr[$i] = mysql_real_escape_string($sharing_arr[$i]);
        $cruise_seats_arr[$i] = mysql_real_escape_string($cruise_seats_arr[$i]);
        $cruise_amount_arr[$i] = mysql_real_escape_string($cruise_amount_arr[$i]);

        $cruise_dept_date_arr[$i] = date("Y-m-d, H:i:s", strtotime($cruise_dept_date_arr[$i]));        
        $cruise_arrival_date_arr[$i] = date("Y-m-d, H:i:s", strtotime($cruise_arrival_date_arr[$i])); 
       



        $sq = mysql_query("insert into package_cruise_master (cruise_id, booking_id, dept_datetime, arrival_datetime, route, cabin,sharing, seats, amount ) values ('$max_cruise_id', '$max_booking_id', '$cruise_dept_date_arr[$i]', '$cruise_arrival_date_arr[$i]', '$route_arr[$i]', '$cabin_arr[$i]', '$sharing_arr[$i]', '$cruise_seats_arr[$i]', '$cruise_amount_arr[$i]') ");

        if(!$sq)

        {

          $GLOBALS['flag'] = false;

          echo "Error at row".($i+1)." for cruise information.";

          //exit;

        }   





      }  

}



///////////////////////***Package tour schedule master master save end*********//////////////





///////////////////////***Package tour Hotel accomodation information save start*********//////////////



function package_tour_hotel_accomodation_information_save($max_booking_id, $city_id, $hotel_id, $hotel_from_date, $hotel_to_date, $hotel_rooms, $hotel_catagory, $room_type, $meal_plan, $confirmation_no)

{

  for($i=0; $i<sizeof($hotel_id); $i++)

  {

    $hotel_from_date[$i] = date("Y-m-d h:i:s", strtotime($hotel_from_date[$i]));

    $hotel_to_date[$i] = date("Y-m-d h:i:s", strtotime($hotel_to_date[$i]));



    $city_id[$i] = mysql_real_escape_string($city_id[$i]);

    $hotel_id[$i] = mysql_real_escape_string($hotel_id[$i]);

    $hotel_from_date[$i] = mysql_real_escape_string($hotel_from_date[$i]);

    $hotel_to_date[$i] = mysql_real_escape_string($hotel_to_date[$i]);

    $hotel_rooms[$i] = mysql_real_escape_string($hotel_rooms[$i]);

    $hotel_catagory[$i] = mysql_real_escape_string($hotel_catagory[$i]);

    $room_type[$i] = mysql_real_escape_string($room_type[$i]);

    $meal_plan[$i] = mysql_real_escape_string($meal_plan[$i]);

    $confirmation_no[$i] = mysql_real_escape_string($confirmation_no[$i]);



    $sq = mysql_query("select max(id) as max from package_hotel_accomodation_master");

    $value = mysql_fetch_assoc($sq);

    $max_hotel_id = $value['max'] + 1;

    $sq_hotel = mysql_query("insert into package_hotel_accomodation_master (id, booking_id, city_id, hotel_id, from_date, to_date, rooms, catagory, room_type, meal_plan, confirmation_no) value ('$max_hotel_id', '$max_booking_id', '$city_id[$i]', '$hotel_id[$i]', '$hotel_from_date[$i]', '$hotel_to_date[$i]', '$hotel_rooms[$i]', '$hotel_catagory[$i]', '$room_type[$i]', '$meal_plan[$i]', '$confirmation_no[$i]')");

    if(!$sq_hotel)

    {

      $GLOBALS['flag'] = false;

      echo "Hotel accomodation information not saved.";

    }  





  }  

}



///////////////////////***Package tour Hotel accomodation information save end*********//////////////

//Transport Save
function package_tour_tranpsort_information_save($max_booking_id, $transp_vehicle_arr, $transp_start_date,$trans_pickuptype_arr,$trans_pickup_arr,$trans_droptype_arr,$trans_drop_arr,$trans_count_arr){
    for($i=0; $i<sizeof($transp_vehicle_arr); $i++){
        $sq = mysql_query("select max(entry_id) as max from package_tour_transport_master");
        $value = mysql_fetch_assoc($sq);
        $max_entry_id = $value['max'] + 1;

        $transp_vehicle_arr[$i] = mysql_real_escape_string($transp_vehicle_arr[$i]);
        $transp_start_date[$i] = mysql_real_escape_string($transp_start_date[$i]);
        $trans_pickuptype_arr[$i] = mysql_real_escape_string($trans_pickuptype_arr[$i]);
        $trans_pickup_arr[$i] = mysql_real_escape_string($trans_pickup_arr[$i]);
        $trans_droptype_arr[$i] = mysql_real_escape_string($trans_droptype_arr[$i]);
        $trans_drop_arr[$i] = mysql_real_escape_string($trans_drop_arr[$i]);
        $trans_count_arr[$i] = mysql_real_escape_string($trans_count_arr[$i]);

        $transp_start_date[$i] = date("Y-m-d", strtotime($transp_start_date[$i]));

        $pickup_type = explode("-",$trans_pickup_arr[$i])[0];
        $drop_type = explode("-",$trans_drop_arr[$i])[0];
        $pickup = explode("-",$trans_pickup_arr[$i])[1];
        $drop = explode("-",$trans_drop_arr[$i])[1];

        $sq = mysql_query("INSERT INTO `package_tour_transport_master`(`entry_id`, `booking_id`, `transport_bus_id`, `transport_from_date`, `pickup`, `pickup_type`, `drop`, `drop_type`, `vehicle_count`) values ('$max_entry_id', '$max_booking_id', '$transp_vehicle_arr[$i]', '$transp_start_date[$i]', '$pickup', '$pickup_type', '$drop', '$drop_type', '$trans_count_arr[$i]')");

        if(!$sq){
          $GLOBALS['flag'] = false;
          echo "Error at row".($i+1)." for Transport information.";
        }
    }
}

//Activity Save
function package_tour_exc_information_save($max_booking_id, $exc_city_arr, $exc_name_arr,$exc_date_arr,$transfer_arr){
  for($i=0; $i<sizeof($exc_city_arr); $i++){
      $sq = mysql_query("select max(entry_id) as max from package_tour_excursion_master");
      $value = mysql_fetch_assoc($sq);
      $max_entry_id = $value['max'] + 1;

      $exc_city_arr[$i] = mysql_real_escape_string($exc_city_arr[$i]);
      $exc_name_arr[$i] = mysql_real_escape_string($exc_name_arr[$i]);
      $exc_date_arr[$i] = mysql_real_escape_string($exc_date_arr[$i]);
      $transfer_arr[$i] = mysql_real_escape_string($transfer_arr[$i]);
      $exc_date_arr[$i] = get_datetime_db($exc_date_arr[$i]);
      $sq = mysql_query("insert into package_tour_excursion_master (entry_id, booking_id, city_id, exc_id,exc_date,transfer_option) values ('$max_entry_id', '$max_booking_id', '$exc_city_arr[$i]', '$exc_name_arr[$i]','$exc_date_arr[$i]','$transfer_arr[$i]')");

      if(!$sq){
        $GLOBALS['flag'] = false;
        echo "Error at row".($i+1)." for Activity information.";
      }
  }
}

//Ititnerary Save
function package_tour_itinerary_inf_save($max_booking_id, $special_attraction_arr, $day_program_arr,$stay_arr,$meal_plan_arr){
  for($i=0; $i<sizeof($day_program_arr); $i++){
      $sq = mysql_query("select max(entry_id) as max from package_tour_schedule_master");
      $value = mysql_fetch_assoc($sq);
      $max_entry_id = $value['max'] + 1;
      
      $special_attraction_arr1 = addslashes($special_attraction_arr[$i]);
      $day_program_arr1 = addslashes($day_program_arr[$i]);
      $stay_arr1 = addslashes($stay_arr[$i]);

      $sq = mysql_query(" insert into package_tour_schedule_master (entry_id, booking_id, attraction, day_wise_program, stay,meal_plan) values ('$max_entry_id', '$max_booking_id', '$special_attraction_arr1', '$day_program_arr1', '$stay_arr1', '$meal_plan_arr[$i]')");

      if(!$sq){
        $GLOBALS['flag'] = false;
        echo "Error at row".($i+1)." for Itinerary information.";
      }
  }
}

///////////////////////////////////***** Package Tour payment master save start *********/////////////////////////////////////////////////////////////

 function package_tour_payment_master_save($customer_id,$max_booking_id, $payment_date, $payment_mode, $payment_amount, $bank_name, $transaction_id, $payment_for, $p_travel_type, $bank_id_arr, $branch_admin_id , $emp_id,$credit_amount_arr,$credit_charges_arr,$credit_card_details_arr)
 {
   
    $financial_year_id = $_SESSION['financial_year_id'];
    for($i=0; $i<sizeof($payment_date); $i++)
    {
       $payment_date[$i] = date("Y-m-d", strtotime($payment_date[$i]));
       $clearance_status = ($payment_mode[$i]=="Cheque" || $payment_mode[$i]=="Credit Card") ? "Pending" : "";   

     $sq = mysql_query("SELECT MAX(payment_id) as max FROM package_payment_master");
     $value = mysql_fetch_assoc($sq);
     $max_payment_id = $value['max'] + 1;
     $max_payment_id = $max_payment_id;

     $q = "insert into package_payment_master (payment_id, booking_id, financial_year_id, branch_admin_id , emp_id ,date, payment_mode, amount, bank_name, transaction_id, payment_for, travel_type, bank_id, clearance_status, advance_status,credit_charges,credit_card_details ) values ('$max_payment_id', '$max_booking_id', '$financial_year_id', '$branch_admin_id' , '$emp_id', '$payment_date[$i]', '$payment_mode[$i]', '$payment_amount[$i]', '$bank_name[$i]', '$transaction_id[$i]', '$payment_for[$i]', '$p_travel_type[$i]', '$bank_id_arr[$i]', '$clearance_status','true','$credit_charges_arr[$i]','$credit_card_details_arr[$i]') ";

     $sq= mysql_query($q);



     if(!$sq)

      {

        $GLOBALS['flag'] = false;

        echo "Error for payment information for $payment_for[$i].";

        //exit;

      }  

      else

      {



        $this->package_receipt_master_save( $max_booking_id, $max_payment_id, $payment_for[$i]);



        //Payment Finance

        $booking_save_transaction = new booking_save_transaction;

        $booking_save_transaction->payment_finance_save($max_booking_id, $max_payment_id, $branch_admin_id, $payment_date[$i], $payment_mode[$i], $payment_amount[$i], $transaction_id[$i], $bank_id_arr[$i], $payment_date[$i], $clearance_status,$credit_charges_arr[$i],$credit_card_details_arr[$i]);



        //Bank and Cash Book Save
        if($payment_mode[$i] != 'Credit Note'){
          $booking_save_transaction->bank_cash_book_save($max_booking_id, $max_payment_id, $payment_date[$i], $payment_mode[$i], $payment_amount[$i], $transaction_id[$i], $payment_date[$i], $bank_name[$i], $bank_id_arr[$i], $branch_admin_id,$credit_charges_arr[$i],$credit_card_details_arr[$i]);
        }


      }  

    }  

 }





///////////////////////////////////***** Package Tour payment master save end *********/////////////////////////////////////////////////////////////





//////////////////////////////////**Package Tour Receipt master save start *********/////////////////////////////////////////////////////////////



 function package_receipt_master_save( $max_booking_id, $max_payment_id, $payment_of)

 {



  $sq_payment_amt = mysql_fetch_assoc(mysql_query("select amount from package_payment_master where payment_id='$max_payment_id'"));



  if($sq_payment_amt['amount']!=0)

  {

      $sq_r = mysql_query("SELECT max(receipt_id) as max FROM package_receipt_master");

      $max_receipt = mysql_fetch_assoc($sq_r);

      $max_receipt_id = $max_receipt['max'] + 1;



    //$cur_date = date('Y-m-d');



    $sq_receipt_date = mysql_fetch_assoc(mysql_query("select date from package_payment_master where payment_id='$max_payment_id'"));



    //$cur_date = date("Y-m-d", strtotime($cur_date));

   

    $sq = mysql_query(" insert into package_receipt_master (receipt_id, booking_id, payment_id, receipt_for, receipt_of, receipt_date) values ('$max_receipt_id','$max_booking_id', '$max_payment_id', '', '$payment_of', '$sq_receipt_date[date]')");

    if(!$sq)

    {

      $GLOBALS['flag'] = false;

      echo "Error for receipt save.";

    }

    

  }    



 }



//////////////////////////////////**Package Tour Receipt master save end *********/////////////////////////////////////////////////////////////



 ///////////////////////////////////***** Send mail to traveler *********/////////////////////////////////////////////////////////////

function send_mail_to_traveler($booking_id, $tour_name, $tour_from_date, $tour_to_date, $customer_id, $email_id, $m_first_name,$total_tour_expense, $total_payment)

{

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url,$encrypt_decrypt,$secret_key,$currency_logo;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;



  $from_date = date('d-m-Y', strtotime($tour_from_date));
  $to_date = date('d-m-Y', strtotime($tour_to_date));

  if($email_id==""){
    $email_id=$app_email_id;
    $name = "Admin";
  }
  else  
  $name = $m_first_name[0];

  $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $mobile_no = $sq_booking['mobile_no'];
  $tour_name = $sq_booking['tour_name'];
  $date = $sq_booking['booking_date'];
  $yr = explode("-", $date);
  $year =$yr[0];

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

  $username = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
  $password = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
  $link = BASE_URL.'/view/customer/';

  $subject = 'Booking confirmation acknowledgement! ('.get_package_booking_id($booking_id,$year). ' )';

  $passengers_infant = mysql_fetch_assoc(mysql_query("select count(*) as cnt from package_travelers_details where booking_id = ".$booking_id." and adolescence = 'Infant'"));
  $passengers_adult = mysql_fetch_assoc(mysql_query("select count(*) as cnt from package_travelers_details where booking_id = ".$booking_id." and adolescence = 'Adult'"));
  $passengers_child = mysql_fetch_assoc(mysql_query("select count(*) as cnt from package_travelers_details where booking_id = ".$booking_id." and adolescence = 'Child'"));

  $content .='
  <tr>
  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>
    <tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $from_date.'</td></tr>
    <tr><td style="text-align:left;border: 1px solid #888888;">Total Guest</td>   <td style="text-align:left;border: 1px solid #888888;">'.$passengers_adult['cnt'].' Adult(s),'.$passengers_child['cnt'].' Children(s),'.$passengers_infant['cnt'].' Infant(s)</td></tr> 
    <tr><td style="text-align:left;border: 1px solid #888888;">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($total_tour_expense,2).'</td></tr>
    <tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($total_payment,2).'</td></tr>
    <tr><td style="text-align:left;border: 1px solid #888888;">Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($total_tour_expense - $total_payment,2).'</td></tr>
  </table>
</tr>
  ';
  $content .= mail_login_box($username, $password,$link);


global $model,$backoffice_email_id;

  $model->app_email_send('14',$name,$email_id, $content, $subject);
if($backoffice_email_id!="")
  $model->app_email_send('14',"Team",$backoffice_email_id, $content, $subject);

}

//////////////////**Booking successfull sms send to traveler start**//////////

 function booking_successfull_sms_send($mobile_no,$tour_name,$customer_id){
    global $app_name,$app_contact_no; 
    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    $fname = $sq_customer['first_name'];
    $lname = $sq_customer['last_name'];

    $message = "Dear ".$fname." ".$lname.", your Package Tour booking for ".$tour_name." is confirmed. Youcher details will send you within 2 working days prior to the tour. Please contact for more details ".$app_contact_no."";
    global $model;
    $model->send_message($mobile_no, $message);
 }

 //////////////////////////////////**Booking successfull sms send to traveler end**/////////////////////////////////////
 public function whatsapp_send(){
  global $app_contact_no,$secret_key,$encrypt_decrypt;
	$quotation_id = $_POST['quotation_id'];
  $tour_name = $_POST['tour_name'];
  $tour_date = $_POST['tour_from_date'];
  $customer_id = $_POST['customer_id'];
	$emp_id = $_POST['emp_id '];
	global $app_contact_no;
	$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
  
  
  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
  $name = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = ".$customer_id));
  $sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id= '$emp_id"));
  if($emp_id == 0){
		$contact = $app_contact_no;
	}
	else{
		$contact = $sq_emp_info['mobile_no'];
	}
	$whatsapp_msg = rawurlencode('Hello Dear '.$name[first_name].',
Hope you are doing great. This is to inform you that your booking is confirmed with us. We look forward to provide you a great experience.
*Tour Name* : '.$tour_name.'
*Travel Date* : '.$tour_date.'
Please contact for more details : '.$contact.'
Thank you.');
	$link = 'https://web.whatsapp.com/send?phone='.$contact_no.'&text='.$whatsapp_msg;
	echo $link;
}

}
?>