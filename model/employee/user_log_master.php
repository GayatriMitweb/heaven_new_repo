<?php 

class user_log_master{



public function user_log_update()

{

	$att_date = $_POST['att_date'];

	$emp_id_arr = $_POST['emp_arr'];

	$att_date = date('Y-m-d', strtotime($att_date));
    $status_arr= $_POST['status_arr'];

    //echo "<script>alert($emp_id_arr);</script>";
    //print_r($emp_id_arr);die;
	for($i=0; $i<sizeof($emp_id_arr); $i++){
 

    $att_query = mysql_num_rows(mysql_query("select * from employee_attendance_log where emp_id='$emp_id_arr[$i]' and att_date='$att_date'"));
 
    $sq_max = mysql_fetch_assoc(mysql_query("select max(attendance_id) as max from employee_attendance_log"));

	$attendance_id = $sq_max['max'] + 1;

    	if($att_query == 0){

    		    $sq_log = mysql_query("insert into employee_attendance_log ( attendance_id, emp_id, att_date, status ) values ( '$attendance_id',  '$emp_id_arr[$i]', '$att_date', '$status_arr[$i]' )");
    		    
    	}
    	else
    	{
    		 
    		   	$sq_log = mysql_query("update employee_attendance_log set status='$status_arr[$i]' where att_date='$att_date' and  emp_id='$emp_id_arr[$i]'");
    	}
    
	 
    }
    if($sq_log){
	echo "Attendance has been successfully saved.";
	}
	else{
		echo "error--Attendance not saved";
	}

}



public function attendance_csv_save()

{

    $vendor_csv_dir = $_POST['vendor_csv_dir'];

    $flag = true;



    $vendor_csv_dir = explode('uploads', $vendor_csv_dir);

    $vendor_csv_dir = BASE_URL.'uploads'.$vendor_csv_dir[1];



    begin_t();



    $count = 1;



    $arrResult  = array();

    $handle = fopen($vendor_csv_dir, "r");

    if(empty($handle) === false) {



        while(($data = fgetcsv($handle, ",")) !== FALSE){

            if($count>0)

            {                

                $sq_max = mysql_fetch_assoc(mysql_query("select max(attendance_id) as max from employee_attendance_log"));

				$attendance_id = $sq_max['max'] + 1;



                $emp_id = $data[0];

                $year = $data[1];

                $month = $data[2];

                $present_days = $data[3];

                $total_days = $data[4];

                $absent_days = $data[5];

                $calculated_salary = $data[6];

                $hra = $data[7];

                $conveyance = $data[8];

                $incentive = $data[9];

                $other_addition = $data[10];

                $provident_fund = $data[11];

                $e_s_i = $data[12];

                $loan = $data[13];

                $profession_tax = $data[14];

                $tsd_it = $data[15];

                $other_deduction = $data[16];

                $total_addition = $data[17];

                $total_deduction = $data[18];

                $payable_salary = $data[19];                  

			    $att_query = mysql_num_rows(mysql_query("select * from employee_attendance_log where month='$month' and year='$year' and emp_id='$emp_id'"));



			    $sq_max = mysql_fetch_assoc(mysql_query("select max(attendance_id) as max from employee_attendance_log"));

				$attendance_id = $sq_max['max'] + 1;

				

			    	if($att_query == 0){

			    		    $sq_log = mysql_query("insert into employee_attendance_log ( attendance_id, emp_id, year, month, present_days, total_days, absent_days, calculated_salary, hra, conveyance, incentive, other_addition, provident_fund, e_s_i, loan, profession_tax, tsd_it, other_deduction, total_addition, total_deduction, payable_salary ) values ( '$attendance_id',  '$emp_id', '$year', '$month', '$present_days', '$total_days', '$absent_days', '$calculated_salary','$hra','$conveyance', '$incentive' , '$other_addition', '$provident_fund', '$e_s_i', '$loan', '$profession_tax', '$tsd_it', '$other_deduction', '$total_addition', '$total_deduction', '$payable_salary' )");

			    	}

			    	else

			    	{

			    		   	$sq_log = mysql_query("update employee_attendance_log set attendance_id='$attendance_id', emp_id='$emp_id', year='$year', month ='$month' , present_days='$present_days', total_days='$total_days',absent_days='$absent_days',calculated_salary='$calculated_salary', hra='$hra', conveyance='$conveyance', incentive='$incentive', other_addition='$other_addition', provident_fund='$provident_fund', e_s_i='$e_s_i',loan='$loan',profession_tax='$profession_tax', tsd_it='$tsd_it', other_deduction='$other_deduction', total_addition='$total_addition',total_deduction='$total_deduction',payable_salary='$payable_salary' where emp_id='$emp_id' and month='$month' and year='$year'");

			    	}

			    
				for($i=0; $i<sizeof($log_id_arr); $i++){

					$remark1 = addslashes($remark_arr[$i]);	
					if($log_id_arr[$i]!=""){



						$sq_log = mysql_query("update user_logs set status='$status_arr[$i]', remark='$remark1' where log_id='$log_id_arr[$i]'");

						if(!$sq_log){

							echo "error--Error in some entries!";

							exit;

						}



					}

					else{



						$sq_max = mysql_fetch_assoc(mysql_query("select max(log_id) as max from user_logs"));

						$log_id = $sq_max['max'] + 1;



					    $sq_log = mysql_query("insert into user_logs ( log_id, login_id, login_date, status, remark ) values ( '$log_id', '$login_id', '$login_date_arr[$i]', '$status_arr[$i]', '$remark1' )");

					    if(!$sq_log){

					    	echo "Sorry log entry is not done!";

					    	exit;

					    }



					}

					

				}



				echo "Attendance has been successfully saved."; 

			}  

            



            $count++;



        }

       

        fclose($handle);

    }



    if($flag){

      commit_t();

      echo "Attendance imported";

      exit;

    }

    else{

      rollback_t();

      exit;

    }





}



}

?>