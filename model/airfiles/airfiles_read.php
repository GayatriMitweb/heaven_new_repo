<?php
Class AirFiles {
    public function __construct(){
      $errors = array();
      $errors['Amadeus'] = $this->Amadeus();
      $errors['Galileo'] = $this->Galileo();
      echo json_encode($errors);
    }
    public function Amadeus(){
        $errors = array();
        $file_read = true;
        $directory = '../../airfiles/amadeus';
        $dir_files = array_diff(scandir($directory), array('..', '.'));
        if(empty($dir_files)){
          $errors['common']['file_present'] = false;  //No FIles Error
          return $errors;
        }
        $arrAmadeus = array();
        $arrTicket = array();
        $arrPax = array();
        $arrno_tkt = array();
        foreach($dir_files as $files){
            $handle = fopen($directory.'/'.$files,"r");
            $Amadeus = array();
            $coupen_no=0;
            $tkt_ctr = 0;
            $pax_ctr = 0;
            $no_pax = array();
            $Ticket = array();
            $no_tkt = array();
            if ($handle) {
                while (($line = fgets($handle)) !== false)  {
                  if (substr($line,0,5)==="MUC1A"){
                    $PNRNo=substr($line,6,6);
                    $Ticket['PNR_No'] = substr($line,6,6);
                  }
          
                  if (substr($line,0,2)==="D-"){
                    $Book_Date11="20".Substr(substr($line,9,6),0,2)."-".Substr(substr($line,9,6),-4,2)."-".Substr(substr($line,9,6),-2);
                    $Ticket['Book_date'] = $Book_Date11;
                  }
          
                  if (substr($line,0,2)==="H-"){
                    $coupen_no = $coupen_no +1;
          
                    $Amadeus[$coupen_no] = array(
                      "Departure_Travel" => substr($line,69,5).date("Y"),
                      "Arrival_Travel" => substr($line,84,5).date("Y"),
                      "Departure_Time" => substr($line,74,4),
                      "Arrival_Time" =>substr($line,79,4),
                      "Flight_No" => substr($line,54,10),
                      "Airline" => substr($line,$this->FndStringPos($line,";",5)+1,2),
                      "Class" => substr($line,$this->FndStringPos($line,";",5)+14,1),
                      "Sector_From" => substr($line,$this->FndStringPos($line,";",1)+5,3),
                      "Sector_To" => substr($line,$this->FndStringPos($line,";",3)+1,3)
                    );
                  }
                  if ((substr($line,0,2)==="K-") or (substr($line,0,3)==="KN-")){
                    $strtstring=0;
                    If (substr($line,0,2)==="K-"){
                      $strtstring = 3 ;
                    }
                    else {
                      $strtstring = 4 ;
                    }

                    $currency_code = $this->getCurrency();

                    $Ticket['Currency']=substr($line,$strtstring,3);
                    if (substr($line,$strtstring,3)!=$currency_code){
                        $Ticket['Basic_Fare'] = substr($line,$this->FndStringPos($line,";",1)+4,$this->FndStringPos($line,";",2)-$this->FndStringPos($line,";",1)-5);
                        $Ticket['Total_Amount'] = substr($line,$this->FndStringPos($line,$currency_code,2)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,2))-$this->FndStringPos($line,$currency_code,2)-3);
                      }
                      else {
                        $Ticket['Basic_Fare'] = substr($line,$strtstring+3,$this->FndStringPos($line,";",1)-($strtstring+3));
                        $Ticket['Total_Amount'] = substr($line,$this->FndStringPos($line,$currency_code,2)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,2))-$this->FndStringPos($line,$currency_code,2)-3);
                      }
                  }
                  if ((substr($line,0,4)==="KFTF") or (substr($line,0,4)==="KFTI") or (substr($line,0,4)==="KNTI") or (substr($line,0,4)==="KS-R") or (substr($line,0,3)==="K-R")){
                    $Ticket['Tax1_Name']= substr($line,$this->FndStringPos($line,";",2)-5,2);
                    $Ticket['Tax1_Value']=substr($line,$this->FndStringPos($line,$currency_code,1)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,1))-strpos($line,$currency_code)-8);
                    $Ticket['Tax2_Name']=substr($line,$this->FndStringPos($line,";",3)-5,2);
                    $Ticket['Tax2_Value']=substr($line,$this->FndStringPos($line,$currency_code,2)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,2))-$this->FndStringPos($line,$currency_code,2)-8);
                    if (strlen(rtrim((substr($line,$this->FndStringPos($line,";",4)-5,2))))==2){
          
                        $Ticket['Tax3_Name']=substr($line,$this->FndStringPos($line,";",4)-5,2);
                        $Ticket['Tax3_Value']= substr($line,$this->FndStringPos($line,$currency_code,3)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,3))-$this->FndStringPos($line,$currency_code,3)-8);
                        $Ticket['Tax4_Name']=substr($line,$this->FndStringPos($line,";",5)-5,2);
                        $Ticket['Tax4_Value']=substr($line,$this->FndStringPos($line,$currency_code,4)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,4))-$this->FndStringPos($line,$currency_code,4)-8);
                        $Ticket['Tax5_Name']=substr($line,$this->FndStringPos($line,";",6)-5,2);
                        $Ticket['Tax5_Value']=substr($line,$this->FndStringPos($line,$currency_code,5)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,5))-$this->FndStringPos($line,$currency_code,5)-8);
                        $Ticket['Tax6_Name']=substr($line,$this->FndStringPos($line,";",7)-5,2);
                        $Ticket['Tax6_Value']=substr($line,$this->FndStringPos($line,$currency_code,6)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,6))-$this->FndStringPos($line,$currency_code,6)-8);
                        $Ticket['Tax7_Name']=substr($line,$this->FndStringPos($line,";",8)-5,2);
                        $Ticket['Tax7_Value']=substr($line,$this->FndStringPos($line,$currency_code,7)+3,strpos($line,";",$this->FndStringPos($line,$currency_code,7))-$this->FndStringPos($line,$currency_code,7)-8);
                      }
                  }
                  if (substr($line,0,3)==="TAX"){
                    $Ticket['Stax1_Name']=substr($line,$this->FndStringPos($line,";",1)-3,2);
                    $Ticket['Stax1_Value']=substr($line,$this->FndStringPos($line,$currency_code,1)+3,$this->FndStringPos($line,";",1)-$this->FndStringPos($line,$currency_code,1)-6);
                    $ctax_i = 2;
                    while(strlen(rtrim((substr($line,$this->FndStringPos($line,";",$ctax_i)-3,2))))==2){
                      $Ticket['Stax'.$ctax_i.'_Name']=substr($line,$this->FndStringPos($line,";",$ctax_i)-3,2);
                      $Ticket['Stax'.$ctax_i.'_Value']=substr($line,$this->FndStringPos($line,$currency_code,$ctax_i)+3,$this->FndStringPos($line,";",$ctax_i)-$this->FndStringPos($line,$currency_code,$ctax_i)-6);
                      $ctax_i++;
                    }
                  }
                  if (Substr($line,0,2)==="I-"){
                    $pax_ctr = $pax_ctr +1 ;
          
                    $chd=$this->FndStringPos($line,"CHD",1);
                    $inf=$this->FndStringPos($line,"INF",1);
                    $Pax_Type="Adult";
                    if ($chd !="")
                    {
                      $Pax_Type="Child";
                    }
                    elseif ($inf!="") {
                      $Pax_Type="Infant";
                    }
                    else {
                      $Pax_Type="Adult";
                    }
                    
                    if ($Pax_Type==="Adult")
                    {
                      $Ticket['Pax_Name']=str_replace("/"," ",substr($line,8,$this->FndStringPos($line,";;",1)-8));
                      $no_pax[$pax_ctr] = array(
                        "Pax_Name" => str_replace("/"," ",substr($line,8,$this->FndStringPos($line,";;",1)-8)),
                        "Pax_Type" => $Pax_Type
                      );
          
                    }
                    else {
                      $Ticket['Pax_Name']=str_replace("/"," ",substr($line,8,$this->FndStringPos($line,";;",1)-13));
                      $no_pax[$pax_ctr] = array(
                        "Pax_Name" => str_replace("/"," ",substr($line,8,$this->FndStringPos($line,";;",1)-13)),
                        "Pax_Type" => $Pax_Type
                      );
                    }
                  }
                  if (Substr($line,0,2)==="T-"){
                    $tkt_ctr = $tkt_ctr + 1;
                    if (strpos($line,"-",8)){  // Check for conjuction Ticket
                    
                      $no_tkt[$tkt_ctr] = array(
                        "Ticket_No" => str_replace("-"," ",substr($line,3,strlen($line)-8))
                      );
          
                      $Ticket['Ticket_No'] = str_replace("-"," ",substr($line,3,strlen($line)-8));
                      $last99 = substr($line,strlen($line)-4,2); // if last two digit of Conjuction Ticket is 99 or 00
                      if (($last99 =='99') or ($last99 =='00')){
                        $test_st=(str_replace("-"," ",substr($line,6,strlen($line)-8)));
                        $Ticket['CTicket_No'] = substr($line,3,3).' '.intval($test_st)+1;
                        $no_tkt[$tkt_ctr] = array(
                          "CTicket_No" => substr($line,3,3).' '.intval($test_st)+1
                        );
                      }
                      else {
                        $Ticket['CTicket_No'] = str_replace("-"," ",substr($line,3,strlen($line)-10).substr($line,strlen($line)-4,2));

                        $no_tkt[$tkt_ctr] = array(
                          "CTicket_No" => str_replace("-"," ",substr($line,3,strlen($line)-10).substr($line,strlen($line)-4,2))
                        );
                      }
                    }
                    else {
                      $Ticket['Ticket_No'] = str_replace("-"," ",substr($line,3,strlen($line)));
                      $no_tkt[$tkt_ctr] = array(
                        "Ticket_No" => str_replace("-"," ",substr($line,3,strlen($line)))
                      );          
                    }
                  }
                }
          
                if(isset($Ticket['PNR_No']) && isset($Ticket['Ticket_No']) && !empty($no_pax) && !empty($Amadeus)){
                  array_push($arrAmadeus, $Amadeus);
                  array_push($arrTicket, $Ticket);
                  array_push($arrno_tkt, $no_tkt);
                  array_push($arrPax, $no_pax);
                }
                fclose($handle);
                
                $file_read_flag = false;
              }else {
                $file_read_flag = true;
              }
        }
        // echo "<pre>";
        // echo json_encode($arrAmadeus);
        // echo json_encode($arrTicket);
        // echo json_encode($arrno_tkt);
        // echo json_encode($arrPax);
        $erroReturn = array();
        $erroReturn = $this->saveGDS($arrAmadeus, $arrTicket, $arrno_tkt, $arrPax, 'Amadeus');
          $erroReturn['common']['file_read'] = $file_read;
          $erroReturn['common']['file_present'] = true;
          if($erroReturn['common']['save'] && $erroReturn['common']['file_read'] && $erroReturn['common']['file_present'] && empty($erroReturn['airport']) && empty($erroReturn['airline'])){
            $this->moveAirfiles('Amadeus', $directory, $dir_files);
          }
          return $erroReturn;
        
        
    }
    public function Galileo(){
      ini_set("auto_detect_line_endings", true);
      $errors = array();
      $file_read = true;
      $directory = '../../airfiles/galileo';
      $dir_files = array_diff(scandir($directory), array('..', '.'));
      if(empty($dir_files)){
        $errors['common']['file_present'] = false;  //No FIles Error
        return $errors;
      }

      $arrGalileo = array();
      $arrTicket = array();
      $arrPax = array();
      $arrno_tkt = array();

      foreach($dir_files as $files){
        $handle = fopen($directory.'/'.$files,"r");
        $Galileo = array();
        $coupen_no=0;
        $tkt_ctr = 0;
        $pax_ctr = 0;
        $no_pax = array();
        $Ticket = array();
        $no_tkt = array();
        $line_count = 0;
        if ($handle) {
          while (($line = fgets($handle)) !== false)  {
            $line_count++;
            $Pnr_chk=intval(substr($line,0,1));
            if($line_count < 7){
              if ($Pnr_chk>0 and $Pnr_chk<10){
                $PNRNo=substr($line,17,7);
                if ($PNRNo !=""){
                  $Ticket['PNR_No'] = substr($line,17,7);
                }
              }
            }
            if (substr($line,0,2)=="T5"){
              $Ticket['Book_date'] = $this->datetimeFormatter(substr($line,20,7));
            }
            if (substr($line,0,3)=="A02"){
              $tkt_ctr++;
              $Ticket['Ticket_No'] =substr($line,49,10);
              $no_tkt[$tkt_ctr] = array(
                // "Ticket_No" => str_replace("-"," ",substr($line,3,strlen($line)-8))
                "Ticket_No" => substr($line,49,10)
              );
              $Ticket['Pax_Name']=str_replace("/"," ",substr($line,3,32));
              if (substr($line,69,2) == "CH")
              {
                $Pax_Type="Child";
              }
              elseif (substr($line,69,2) == "IN") {
                $Pax_Type="Infant";
              }
              else {
                $Pax_Type="Adult";
              }
              $pax_ctr = $pax_ctr +1 ;

              $no_pax[$pax_ctr] = array(
                "Pax_Name" => str_replace("/"," ",substr($line,3,32)),
                "Pax_Type" => $Pax_Type
              );
            }
            if (substr($line,0,3)=="A04"){
              $coupen_no = $coupen_no +1;
              $Galileo[$coupen_no] = array(
                "Departure_Travel" => substr($line,30,5).date("Y"),
                "Arrival_Travel" => substr($line,147,5).date("Y"),
                "Departure_Time" => substr($line,35,4),
                "Arrival_Time" =>substr($line,40,4),
                "Flight_No" => substr($line,23,4),
                "Airline" => substr($line,5,2),
                "Class" => substr($line,26,2),
                "Sector_From" => substr($line,46,3),
                "Sector_To" => substr($line,62,3)
              );
            }
            if (substr($line,0,3)=="A07"){
              $Currency=$this->getCurrency();
              $Ticket['Basic_Fare'] = substr($line,$this->FndStringPos($line,$Currency,1)+3,$this->FndStringPos($line,$Currency,2)-$this->FndStringPos($line,$Currency,1)-3);
              $Ticket['Total_Amount'] = substr($line,$this->FndStringPos($line,$Currency,2)+3,$this->FndStringPos($line,$Currency,3)-$this->FndStringPos($line,$Currency,2)-3);
              $Ticket['Tax1_Name']= substr($line,$this->FndStringPos($line,"T2",1)-2,2);
              $Ticket['Tax1_Value']=substr($line,$this->FndStringPos($line,"T1",1)+3,$this->FndStringPos($line,"T2",1)-$this->FndStringPos($line,"T1",1)-5);
              $Ticket['Tax2_Name']=substr($line,$this->FndStringPos($line,"T3",1)-2,2);
              $Ticket['Tax2_Value']=substr($line,$this->FndStringPos($line,"T2",1)+3,$this->FndStringPos($line,"T3",1)-$this->FndStringPos($line,"T2",1)-5);
              $Ticket['Tax3_Name']=substr($line,strlen($line)-3,2);
              $Ticket['Tax3_Value']=substr($line,$this->FndStringPos($line,"T3",1)+3,8);
            }
            if (substr($line,0,2)=="IT"){
              $Ticket['YQ']=substr($line,$this->FndStringPos($line,"YQ",1)-8,8);
            }
          }
          if(isset($Ticket['PNR_No']) && isset($Ticket['Ticket_No']) && !empty($no_pax) && !empty($Galileo)){
            array_push($arrGalileo, $Galileo);
            array_push($arrTicket, $Ticket);
            array_push($arrno_tkt, $no_tkt);
            array_push($arrPax, $no_pax);
          }
          fclose($handle);
          $file_read_flag = false;
          }
        else {
          $file_read_flag = true;
        }
    
      }
    // echo "<pre>";
        // echo json_encode($arrGalileo);
        // echo json_encode($arrTicket);
        // echo json_encode($arrno_tkt);
        // echo json_encode($arrPax);
        $erroReturn = array();
        $erroReturn = $this->saveGDS($arrGalileo, $arrTicket, $arrno_tkt, $arrPax, 'Galileo');
          $erroReturn['common']['file_read'] = $file_read;
          $erroReturn['common']['file_present'] = true;
          if($erroReturn['common']['save'] && $erroReturn['common']['file_read'] && $erroReturn['common']['file_present'] && empty($erroReturn['airport']) && empty($erroReturn['airline'])){
            $this->moveAirfiles('Galileo', $directory, $dir_files);
          }
          return $erroReturn;
 
    }
    
    public function saveGDS($arrGDS, $arrTicket, $arrno_tkt, $arrPax, $type){
      $cflag = true;
      $aflag = true;
      $alflag = true;
      $unsavedAirp = array();
      $unsavedAirline = array();
      $errors = array();
      begin_t();
      for ($i = 0; $i < sizeof($arrGDS); $i++) { 
        $other_taxes = 0;
        $yq = 0;
        if($type == 'Amadeus'){
          for($key = 1; $key <= 10; $key++){ //Change here from 10 to number of taxes if there is increase in taxes
            if($arrTicket[$i]["Tax".$key."_Name"] == 'YQ'){
              $yq = ($arrTicket[$i]["Tax".$key."_Value"]);
            }
          } 
          $s_tax = 1;
          while(!empty($arrTicket[$i]["Stax".$s_tax."_Name"])){
            $other_taxes += $arrTicket[$i]["Stax".$s_tax."_Value"];
            $s_tax++;
          }
        }
        if($type == 'Galileo'){
          for($key = 1; $key <= 3; $key++){ 
              $other_taxes += ($arrTicket[$i]["Tax".$key."_Value"]);
          }
          $yq = $arrTicket[$i]['YQ'];
        }
        $yq = ($yq == '') ? 0 : $yq;
        $other_taxes -= $yq;
        $bookDate = $arrTicket[$i]["Book_date"];
        $totalCost = $arrTicket[$i]["Total_Amount"];
        $basicFare = $arrTicket[$i]["Basic_Fare"];

        $sq_max = mysql_fetch_assoc(mysql_query("SELECT max(ticket_airfile_id) as max from ticket_master_airfile"));
        $ticket_id = $sq_max['max'] + 1;

        $ticket_master = mysql_query("INSERT INTO `ticket_master_airfile` (ticket_airfile_id, total_cost, basic_cost,yq_tax, other_taxes, issue_date) VALUES ('$ticket_id', '$totalCost', '$basicFare','$yq','$other_taxes','$bookDate' ) ");

        if(!$ticket_master){
          $cflag = false;
        }
        
        for ($j = 1; $j <= sizeof($arrPax[$i]); $j++){
          $adolescence = $arrPax[$i][$j]['Pax_Type'];
          $nameArray = explode(' ', trim($arrPax[$i][$j]["Pax_Name"], ' '));
          $remove = ['.', 'Mrs', 'Miss', 'Ms', 'Master', 'Dr', 'Mr'];
          $nameArray = str_ireplace($remove, '', $nameArray);
          if(sizeof($nameArray) == 1){
              $first_name = $nameArray[0];
              $middle_name = '';
              $last_name = '';
          }
          else{
              $last_name = $nameArray[0];
              $nameArray = array_slice($nameArray, 1);
              $first_name = $nameArray[0];
              $nameArray = array_slice($nameArray, 1);
              if(!empty($nameArray))
                $middle_name = implode(' ',$nameArray);
              else
                $middle_name = '';
          }
          $ticket_no = (!empty($arrno_tkt[$i][$j]['Ticket_No'])) ? $arrno_tkt[$i][$j]['Ticket_No'] : $arrTicket[$i]['Ticket_No'];
          
          $pnr_no = $arrTicket[$i]['PNR_No'];
          $cticket_no = (!empty($arrTicket[$i]['CTicket_No'])) ? $arrTicket[$i]['CTicket_No'] : '';
          
          $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from ticket_master_entries_airfile"));
          $entry_id = $sq_max['max'] + 1;
          $sq_entry = mysql_query("INSERT INTO ticket_master_entries_airfile(`entry_id`, `ticket_airfile_id`, `gds_pnr`, `first_name`, `middle_name`, `last_name`, `adolescence`,`ticket_no`,`cticket_no`,`file_type` ) VALUES ('$entry_id','$ticket_id', '$pnr_no', '$first_name','$middle_name','$last_name', '$adolescence','$ticket_no','$cticket_no','$type')");
        
          if(!$sq_entry){
            $cflag = false;
          }
        }
        
        for ($j = 1; $j <= sizeof($arrGDS[$i]); $j++){
          $departDateTime = $this->datetimeFormatter($arrGDS[$i][$j]["Departure_Travel"], $arrGDS[$i][$j]["Departure_Time"]);
          $arrDateTime = $this->datetimeFormatter($arrGDS[$i][$j]["Arrival_Travel"], $arrGDS[$i][$j]["Arrival_Time"]);
          $airline_name = mysql_fetch_assoc(mysql_query("SELECT `airline_name` FROM `airline_master` WHERE   `active_flag` = 'Active' AND `airline_code` = '".$arrGDS[$i][$j]['Airline']."'"));
          $airline = $airline_name['airline_name'].' ('.$arrGDS[$i][$j]['Airline'].')';
          if($airline_name['airline_name'] == ''){
            array_push($unsavedAirline, $arrGDS[$i][$j]['Airline']);
          }
          

          $class = $arrGDS[$i][$j]['Class'];
          $flight_no = $arrGDS[$i][$j]['Flight_No'];

          $from_sector = mysql_fetch_assoc(mysql_query("SELECT `city_id`, `airport_name`, `airport_code` FROM `airport_master` WHERE `flag` = 'Active' AND `airport_code` = '".$arrGDS[$i][$j]['Sector_From']."'"));
          $to_sector = mysql_fetch_assoc(mysql_query("SELECT `city_id`, `airport_name` FROM `airport_master` WHERE `flag` = 'Active' AND `airport_code` = '".$arrGDS[$i][$j]['Sector_To']."'"));
          $from_city = $from_sector['city_id'];
          $from_airp = $from_sector['airport_name'].'('.$arrGDS[$i][$j]['Sector_From'].')';
          $to_city = $to_sector['city_id'];
          $to_airp = $to_sector['airport_name'].'('.$arrGDS[$i][$j]['Sector_To'].')';
          if($from_city == 0){
            array_push($unsavedAirp, $arrGDS[$i][$j]['Sector_From']);
          }
          if($to_city == 0){
            array_push($unsavedAirp, $arrGDS[$i][$j]['Sector_To']);
          }
          $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from ticket_trip_entries_airfile"));
          $entry_id = $sq_max['max'] + 1;
          $sq_entry = mysql_query("INSERT INTO ticket_trip_entries_airfile(`entry_id`, `ticket_airfile_id`, `departure_datetime`, `arrival_datetime`, `airlines_name`, `class`, `flight_no`, `from_city`, `to_city`, `departure_city`, `arrival_city`) VALUES('$entry_id', '$ticket_id', '$departDateTime', '$arrDateTime', '$airline', '$class', '$flight_no', '$from_city', '$to_city', '$from_airp', '$to_airp')");
          if(!$sq_entry){
            $cflag = false;
          }
        }
        $unsavedAirp = array_unique($unsavedAirp);
        $unsavedAirline = array_unique($unsavedAirline);
        if(!empty($unsavedAirp)){
          $aflag = false;
        }
        if(!empty($unsavedAirline)){
          $alflag = false;
        }
      }
      $errors['common']['save'] = $cflag;
      $errors['airport'] = $unsavedAirp;
      $errors['airline'] = $unsavedAirline;

      if($cflag && $aflag && $alflag){
        commit_t();
        return $errors;
      }
      else{
        rollback_t();
        return $errors;
      }
    }
    public function moveAirfiles($gdsType, $directory, $dirFiles){
      $year = date("Y");
      $month = date("M");
      $day = date("d");
      $timestamp = date('U');
      $flag = false;

      foreach($dirFiles as $file){
        if(rename($directory.'/'.$file, $this->getnewUrl($year, $month, $day, $timestamp).'/'.$gdsType.'_'.$file)){
          $flag = true;
        }
      }
    }
    public function getnewUrl($year, $month, $day, $timestamp){
      $current_dir =  '../../uploads/';
      $current_dir = $this->check_dir($current_dir , 'airfiles-build');
      $current_dir = $this->check_dir($current_dir , $year);
      $current_dir = $this->check_dir($current_dir , $month);
      $current_dir = $this->check_dir($current_dir , $day);
      $current_dir = $this->check_dir($current_dir , $timestamp);
      return $current_dir;
    }
    
    public function check_dir($current_dir, $type){	 	
      if(!is_dir($current_dir."/".$type)){
        mkdir($current_dir."/".$type);
      }	
      $current_dir = $current_dir."/".$type."/";
      return $current_dir;	
    }

    public function datetimeFormatter($date,$time){
      $day = substr($date, 0, 2);
      $month =  substr($date, 2, 3);
      $year = substr($date, 5, 6);
      $date = date('Y-m-d', strtotime($day.'-'.$month.'-'.$year));
      
      $hour = substr($time, 0, 2);
      $min = substr($time, 2, 4);
      $time = $hour . ':' . $min . ':00';
      
      return $date . ' ' . $time;
    }
    public function getCurrency(){
      $sq_app_setting = mysql_fetch_assoc(mysql_query("SELECT `currency` from app_settings"));
      $currency = $sq_app_setting['currency'];

      $currency_logo_d = mysql_fetch_assoc(mysql_query("SELECT `currency_code` FROM `currency_name_master` WHERE id=".$currency));
      return $currency_logo_d['currency_code'];
    }
    public function FndStringPos($orgstrnf,$fndstring,$strngpos){
      switch ($strngpos) {
        case '1':
            return strpos($orgstrnf,$fndstring) ;
            break;
        case '2':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1);
            break;
        case '3':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1);
            break;
        case '4':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1);
            break;
        case '5':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1)+1);
            break;
        case '6':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1)+1)+1);
            break;
        case '7':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1)+1)+1)+1);
            break;
        case '8':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1)+1)+1)+1)+1);
            break;
        case '9':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1)+1)+1)+1)+1)+1);
            break;
        case '10':
            return strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring,strpos($orgstrnf,$fndstring)+1)+1)+1)+1)+1)+1)+1)+1)+1);
            break;
        default:
          break;
      }
    }
}


?>