<?php
include "../../../../model/model.php";
//$query = "select * from gallary_master where 1 ";
$dest_id = $_POST['dest_id'];
if($dest_id != '') { 
      $query = " select * from gallary_master where dest_id = '$dest_id'";
}
?>
<div class="row">
  <div class="col-md-12">
       <?php
       $count = 0;
       $sq_gallary = mysql_query($query);
       while($row_gallary = mysql_fetch_assoc($sq_gallary)){
          $count++;
            $url = $row_gallary['image_url'];
            $pos = strstr($url,'uploads');
            $entry_id =$row_gallary['entry_id'];
            $sq_gal =  mysql_fetch_assoc(mysql_query("select * from gallary_master where entry_id = '$entry_id'"));
            if ($pos != false)   {
                $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 
                $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
            }
            else{
                $newUrl =  $row_gallary['image_url']; 
            }
          
       ?>
             <div class="gallary-image">
                 <div class="col-sm-3">

                    <div class="gallary-single-image mg_bt_30 mg_bt_10_sm_xs" style="width: 100%;">
                       <img src="<?php echo $newUrl; ?>" id="image<?php echo $count; ?>" alt="title" class="img-responsive">
                         <span class="img-check-btn">
                            <input type="radio" id="image_select1<?php echo $count; ?>" name="image_check" value="<?php echo $row_gallary['image_url']; ?>">
                        </span>
                       
                       
                        <div class="table-image-btns">

                         <ul style="margin-left: -40%;">

                           <span style="color: #fff; "><?php echo $sq_gal['description'];?></span>

                         </ul>

                      </div>
                    </div>

                 </div>
             </div> 
     <?php } ?>   
  </div>    
</div> 
<script type="text/javascript">
  
  
  function display_image(entry_id)
{
  $.post('display_image_modal.php', {entry_id : entry_id}, function(data){
    $('#div_modal').html(data);
  });
}
</script> 