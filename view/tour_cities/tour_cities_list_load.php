<?php 
include "../../model/model.php";

$tour_id = $_POST['tour_id'];
?>
<div class="panel  panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<legend>Tour Cities List</legend>
  <table class="table table-hover mg_bt_0"  cellspacing="0">
    <thead>
      <tr class="table-heading12">
        <td>Sr. No</td>
        <td>City Name</td>
        <td>Edit</td>
      </tr>  
    </thead>  
    <tbody>
      <?php
      $count=0;
      $sq = mysql_query("select * from tour_city_names where tour_id='$tour_id'");
      while($row=mysql_fetch_assoc($sq))
      {
        $count++;
       ?>
       <tr>
          <td><?php echo $count ?></td>
          <td>
            <?php 
                $sq_city_info = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row[city_id]'")); 

                echo $sq_city_info['city_name'];
            ?>
          </td>
          <td>            
            <button onclick="tour_city_update_modal(<?php echo $row['id'] ?>, <?php echo $tour_id ?>)" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i></button>
          </td>
       </tr> 
       <?php 
      }  
      ?>
    </tbody>  
  </table>  
</div> </div> </div>
</div>