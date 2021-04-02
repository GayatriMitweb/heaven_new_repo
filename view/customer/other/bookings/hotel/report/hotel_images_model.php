<?php
include('../../../../../../model/model.php');
$hotel_id = $_POST['hotel_id'];

$sq_hotel_nm = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
$hotel=$sq_hotel_nm['hotel_name'];
$sq_img = mysql_query("SELECT * from hotel_vendor_images_entries where hotel_id='$hotel_id'");
$counter=0;
$slides='';
$Indicators='';
while($row=mysql_fetch_array($sq_img))
{
  $url=$row['hotel_pic_url'];
   if($counter == 0)
        {
        $Indicators.='<li data-target="#carousel-example-generic" data-slide-to="'.$counter.'" class="active"></li>';
        $slides .= '<div class="item active">
                  <img src="'.$url.'" alt="'.$hotel.'" />
                  <div class="carousel-caption">
                    <h4>'.$hotel.'</h4>       
                  </div>
                </div>';
        }else
        {
          $Indicators.='<li data-target="#carousel-example-generic" data-slide-to="'.$counter.'" class="active"></li>';
          $slides .= '<div class="item">
                  <img src="'.$url.'" alt="'.$hotel.'" />
                  <div class="carousel-caption">
                   <h3>'.$hotel.'</h3>  
                  </div>
                </div>';
        }

  $counter++;
}
?>


<div class="modal fade" tabindex="" role="dialog" id="images_view">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->

            <ol class="carousel-indicators">
            <?php echo $Indicators; ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
               <?php echo $slides; ?>  
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
          </div>        
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
  $('#images_view').modal('show');
</script>