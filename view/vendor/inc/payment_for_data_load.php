<?php
include "../../../model/model.php";
$emp_id= $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$estimate_type = $_POST['estimate_type'];
$offset = $_POST['offset'];
$estimate_type_id = $_POST['estimate_type_id'];
$branch_status = $_POST['branch_status'];
 
if($estimate_type=="Group Tour"){
?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select class="form-control" style="width:100%" id="tour_id<?= $offset ?>" name="tour_id<?= $offset ?>" onchange="tour_group_dynamic_reflect(this.id,'tour_group_id<?= $offset ?>');"> 
        <?php 
        if($estimate_type_id==""){
        ?>
        <option value="">Select Tour</option>
        <?php
        }
        else{
          $sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$estimate_type_id'"));
          $sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_tour_group[tour_id]'"));
          echo '<option value="'.$sq_tour['tour_id'].'">'.$sq_tour['tour_name'].'</option>';
        }
        $sq=mysql_query("select tour_id,tour_name from tour_master");
        while($row=mysql_fetch_assoc($sq)){
          echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
        }
        ?>
    </select>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select class="form-control" id="tour_group_id<?= $offset ?>" name="tour_group_id<?= $offset ?>" style="width:100%"> 
        <?php 
        if($estimate_type_id==""){
        ?>
        <option value=""> Select Tour Group </option>
        <?php
        }
        else{
          $sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$estimate_type_id'"));
          $tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']));
          echo '<option value="'.$estimate_type_id.'">'.$tour_group.'</option>';
        }
        ?>
    </select>
  </div>
  <script>
    $('#tour_id<?= $offset ?>, #tour_group_id<?= $offset ?>').select2();
  </script>
<?php
}

if($estimate_type=="Package Tour"){
?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select id="booking_id<?= $offset ?>" name="booking_id<?= $offset ?>" style="width:100%"> 
          <?php 
          if($estimate_type_id!=""){

              $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$estimate_type_id' order by booking_id desc"));
               
              $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));      
              ?>
              <option value="<?php echo $estimate_type_id ?>"><?php echo get_package_booking_id($estimate_type_id)." : ".$sq_customer_info['first_name'].' '.$sq_customer_info['last_name']; ?></option>
              <?php
          } ?>
          <option value="">Select Booking</option>
          <?php
          $query = "select * from package_tour_booking_master where 1 ";
          if($branch_status=='yes'){
            if($role=='Branch Admin' || $role=='Backoffice'){
            $query .= " and branch_admin_id = '$branch_admin_id'";
            } 
            elseif($role=='Sales'){
              $query .= " and emp_id='$emp_id'";
              }
          }
          $query .= " order by booking_id desc";
          $sq_booking = mysql_query($query);
          while($row_booking = mysql_fetch_assoc($sq_booking))

          {
              $created_at = $row_booking['booking_date'];
              $yr = explode("-", $created_at);
              $year =$yr[0];
              $sq_customer = mysql_fetch_assoc(mysql_query("select first_name, middle_name, last_name from customer_master where customer_id='$row_booking[customer_id]'"));

               ?>

               <option value="<?php echo $row_booking['booking_id'] ?>"><?php echo get_package_booking_id($row_booking['booking_id'],$year)."-"." ".$sq_customer['first_name']." ".$sq_customer['last_name']; ?></option>

               <?php    

          }    

 
          ?>
      </select>
  </div>
  <script>
  $('#booking_id<?= $offset ?>').select2();
  </script>
<?php 
}

if($estimate_type=="Car Rental"){
?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="booking_id<?= $offset ?>" id="booking_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
          <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }  
          else{
            $sq_booking = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$estimate_type_id'"));
            $customer_id = $sq_booking['customer_id'];
            $created_at = $sq_booking['created_at'];
              $yr = explode("-", $created_at);
              $year =$yr[0];
            $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
            ?>
            <option value="<?= $sq_booking['booking_id'] ?>"><?= get_car_rental_booking_id($sq_booking['booking_id'],$year).' : '.$sq_customer_info['first_name'].' '.$sq_customer_info['last_name'] ?></option>
            <?php
          }
           $query = "select * from car_rental_booking where 1 ";
           if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
          $query .= " order by booking_id desc";
          $sq_booking = mysql_query($query);
          while($row_booking = mysql_fetch_assoc($sq_booking)){
            $created_at = $row_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $customer_id = $row_booking['customer_id'];
            $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
            ?>
            <option value="<?= $row_booking['booking_id'] ?>"><?= get_car_rental_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer_info['first_name'].' '.$sq_customer_info['last_name'] ?></option>
            <?php
          }
          ?>
      </select>
  </div>
  <script>
  $('#booking_id<?= $offset ?>').select2();
  </script>
<?php
}

if($estimate_type=="Visa Booking"){
?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="visa_id<?= $offset ?>" id="visa_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }
          else{
            $sq_visa = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id='$estimate_type_id' "));
            $created_at = $sq_visa['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_visa[customer_id]'"));
            ?>
            <option value="<?= $sq_visa['visa_id'] ?>"><?= get_visa_booking_id($sq_visa['visa_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php 
          }
          ?>
          <?php
          $query = "select * from visa_master where 1 ";
          if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
          }
          $query .= " order by visa_id desc";
          $sq_visa = mysql_query($query);
          while($row_visa = mysql_fetch_assoc($sq_visa)){

            $created_at = $row_visa['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));
            ?>
            <option value="<?= $row_visa['visa_id'] ?>"><?= get_visa_booking_id($row_visa['visa_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php
          }
      ?> 
    </select>     
  </div>
  <script>
    $('#visa_id<?= $offset ?>').select2();
  </script>
<?php
}


if($estimate_type=="Passport Booking"){
?>  
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="passport_id<?= $offset ?>" id="passport_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }
          else{
            $sq_passport = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$estimate_type_id'"));
            $created_at = $sq_passport['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport[customer_id]'"));
            ?>
            <option value="<?= $sq_passport['passport_id'] ?>"><?= get_passport_booking_id($sq_passport['passport_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php 
          }
          ?>
          <?php
            $query = "select * from passport_master where 1 ";
           if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
          $query .= " order by passport_id desc";
          $sq_passport = mysql_query($query);
          while($row_passport = mysql_fetch_assoc($sq_passport)){

            $created_at = $row_passport['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));
            ?>
            <option value="<?= $row_passport['passport_id'] ?>"><?= get_passport_booking_id($row_passport['passport_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php
          }
      ?> 
    </select>     
  </div>
  <script>
    $('#passport_id<?= $offset ?>').select2();
  </script>
<?php
}


if($estimate_type=="Ticket Booking"){
?>  
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="ticket_id<?= $offset ?>" id="ticket_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }
          else{
            $sq_ticket = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$estimate_type_id' "));
            $created_at = $sq_ticket['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
            ?>
            <option value="<?= $sq_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($sq_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php 
          }
          ?>
          <?php
          $query = "select * from ticket_master where 1 ";
           if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
          $query .= " order by ticket_id desc";
          $sq_ticket = mysql_query($query);
          while($row_ticket = mysql_fetch_assoc($sq_ticket)){

            $created_at = $row_ticket['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
            ?>
            <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php
          }
      ?> 
    </select>     
  </div>
  <script>
    $('#ticket_id<?= $offset ?>').select2();
  </script>
<?php
}

if($estimate_type=="Train Ticket Booking"){
?>  
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="train_ticket_id<?= $offset ?>" id="train_ticket_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }
          else{
            $sq_ticket = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$estimate_type_id'"));
            $created_at = $sq_ticket['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
            ?>
            <option value="<?= $sq_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($sq_ticket['train_ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php 
          }
          ?>
          <?php
           $query = "select * from train_ticket_master where 1 ";
           if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
          $query .= " order by train_ticket_id desc";
          $sq_ticket = mysql_query($query);
          while($row_ticket = mysql_fetch_assoc($sq_ticket)){

            $created_at = $row_ticket['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
            ?>
            <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php
          }
      ?> 
    </select>     
  </div>
  <script>
    $('#train_ticket_id<?= $offset ?>').select2();
  </script>
<?php
}

if($estimate_type=="Hotel Booking"){
?>  
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="booking_id<?= $offset ?>" id="booking_id<?= $offset ?>"  style="width:100%">
      <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }
          else{
            $sq_hotel_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$estimate_type_id'"));
            $created_at = $sq_hotel_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_hotel_booking[customer_id]'"));
            ?>
            <option value="<?= $sq_hotel_booking['booking_id'] ?>"><?= get_hotel_booking_id($sq_hotel_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php 
          }
          ?>
          <?php
           $query = "select * from hotel_booking_master where 1 ";
           if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
          $query .= " order by booking_id desc";
          $sq_hotel_booking = mysql_query($query);
          while($row_ticket = mysql_fetch_assoc($sq_hotel_booking)){

            $created_at = $row_ticket['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
            ?>
            <option value="<?= $row_ticket['booking_id'] ?>"><?= get_hotel_booking_id($row_ticket['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php
          }
      ?> 
    </select>     
  </div>
  <script>
    $('#booking_id<?= $offset ?>').select2();
  </script>
<?php
}

if($estimate_type=="Bus Booking"){
  ?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="booking_id<?= $offset ?>" id="booking_id<?= $offset ?>" style="width:100%">
      <?php 
        if($estimate_type_id==""){
          ?>
          <option value="">Select Booking</option>
          <?php
        }
        else{
          $sq_booking = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$estimate_type_id'"));
            $created_at = $sq_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
          ?>
          <option value="<?= $sq_booking['booking_id'] ?>"><?= get_bus_booking_id($sq_booking['booking_id']).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?> </option>
           <?php
        }
          $query = "select * from bus_booking_master where 1 ";
            if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
          $query .= " order by booking_id desc";
          $sq_booking = mysql_query($query);
         while($row_booking = mysql_fetch_assoc($sq_booking)){
            
            $created_at = $row_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

           $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
           ?>
          <option value="<?= $row_booking['booking_id'] ?>"><?= get_bus_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?> </option>
           <?php
         }
      ?>
    </select>
  </div>
  <script>
    $('#booking_id<?= $offset ?>').select2();
  </script>
  <?php
}

if($estimate_type=="B2B Booking"){
  ?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="booking_id<?= $offset ?>" id="booking_id<?= $offset ?>" style="width:100%">
      <?php 
        if($estimate_type_id==""){
          ?>
          <option value="">Select Booking</option>
          <?php
        }
        else{
          $sq_booking = mysql_fetch_assoc(mysql_query("SELECT * FROM `b2b_booking_master` where booking_id='$estimate_type_id'"));
          $created_at = $sq_booking['created_at'];
          $yr = explode("-", $created_at);
          $year =$yr[0];
          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
          ?>
          <option value="<?= $sq_booking['booking_id'] ?>"><?= get_b2b_booking_id($sq_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?> </option>
           <?php
        }
          $sq_booking = mysql_query("select * from b2b_booking_master where 1 order by booking_id desc");
         while($row_booking = mysql_fetch_assoc($sq_booking)){
            
            $created_at = $row_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

           $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
           ?>
          <option value="<?= $row_booking['booking_id'] ?>"><?= get_b2b_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?> </option>
           <?php
         }
      ?>
    </select>
  </div>
  <script>
    $('#booking_id<?= $offset ?>').select2();
  </script>
  <?php
}

if($estimate_type=="Forex Booking"){
  ?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="booking_id<?= $offset ?>" id="booking_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
        if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
        }
        else{
          $sq_booking = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$estimate_type_id'"));
            $created_at = $sq_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
          ?>
          <option value="<?= $sq_booking['booking_id'] ?>"><?= get_forex_booking_id($sq_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
          <?php
        }
        $query = "select * from forex_booking_master where 1 ";
        if($branch_status=='yes'){
          if($role=='Branch Admin' || $role=='Backoffice'){
          $query .= " and branch_admin_id = '$branch_admin_id'";
          } 
          elseif($role=='Sales'){
            $query .= " and emp_id='$emp_id'";
            }
        }
        $query .= " order by booking_id desc";
        $sq_booking = mysql_query($query);
        while($row_booking = mysql_fetch_assoc($sq_booking)){

            $created_at = $row_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
          ?>
          <option value="<?= $row_booking['booking_id'] ?>"><?= get_forex_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
          <?php
        }
      ?>
    </select>
  </div>
  <script>
    $('#booking_id<?= $offset ?>').select2();
  </script>
  <?php
}

if($estimate_type=="Miscellaneous Booking"){
  ?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="misc_id<?= $offset ?>" id="misc_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
        if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
        }
        else{
          $sq_booking = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master where misc_id='$estimate_type_id'"));
            $created_at = $sq_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
          ?>
          <option value="<?= $sq_booking['misc_id'] ?>"><?= get_misc_booking_id($sq_booking['misc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
          <?php
        }
        
        $query = "select * from miscellaneous_master where 1 ";
        if($branch_status=='yes'){
          if($role=='Branch Admin' || $role=='Backoffice'){
          $query .= " and branch_admin_id = '$branch_admin_id'";
          } 
          elseif($role=='Sales'){
            $query .= " and emp_id='$emp_id'";
            }
        }
        $query .= " order by misc_id desc";
        $sq_booking = mysql_query($query);
        while($row_booking = mysql_fetch_assoc($sq_booking)){

            $created_at = $row_booking['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];

          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
          ?>
          <option value="<?= $row_booking['misc_id'] ?>"><?= get_misc_booking_id($row_booking['misc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
          <?php
        }
      ?>

    </select>
  </div>
  <script>
    $('#misc_id<?= $offset ?>').select2();
  </script>
  <?php
}

if($estimate_type=="Excursion Booking"){
?>
  <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
    <select name="exc_id<?= $offset ?>" id="exc_id<?= $offset ?>" onchange="get_supplier_costing(this.value,'<?php echo $estimate_type; ?>','estimate_count');" style="width:100%">
      <?php 
          if($estimate_type_id==""){
            ?>
            <option value="">Select Booking</option>
            <?php
          }
          else{
            $sq_exc = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$estimate_type_id' "));
            $created_at = $sq_exc['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc[customer_id]'"));
            ?>
            <option value="<?= $sq_exc['exc_id'] ?>"><?= get_exc_booking_id($sq_exc['exc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php 
          }
          ?>
          <?php
            $query = "select * from excursion_master where 1 ";
            if($branch_status=='yes'){
              if($role=='Branch Admin' || $role=='Backoffice'){
              $query .= " and branch_admin_id = '$branch_admin_id'";
              } 
              elseif($role=='Sales'){
                $query .= " and emp_id='$emp_id'";
                }
            }
            $query .= " order by exc_id desc";
            $sq_exc = mysql_query($query);
          while($row_exc = mysql_fetch_assoc($sq_exc)){
            $created_at = $row_exc['created_at'];
            $yr = explode("-", $created_at);
            $year =$yr[0];
            $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_exc[customer_id]'"));
            ?>
            <option value="<?= $row_exc['exc_id'] ?>"><?= get_exc_booking_id($row_exc['exc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php
          }
      ?> 
    </select>     
  </div>
  <script>
    $('#exc_id<?= $offset ?>').select2();
  </script>
<?php
}
?>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>