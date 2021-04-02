<?php
include_once("../../../../model/model.php");
$entry_id = $_POST['entry_id'];
$sq_gallary =  mysql_fetch_assoc(mysql_query("select * from gallary_master where entry_id = '$entry_id'"));
?>

<div class="modal fade" id="display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 900px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
      <div>
        <?php   
            //$newUrl = preg_replace('/(\/+)/','/',$sq_gallary['image_url']); 
            //$download_url = BASE_URL.str_replace('../', '', $newUrl);
            $url = $sq_gallary['image_url'];
            $pos = strstr($url,'uploads');
            if ($pos != false)   {
                $newUrl1 = preg_replace('/(\/+)/','/',$sq_gallary['image_url']); 
                $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
            }
            else{
                $newUrl =  $sq_gallary['image_url']; 
            }
        ?>
            <img src="<?php echo $newUrl; ?>" height="auto" width="100%">
      </div>     
      <div name="img_description">
        <p><?php echo $sq_gallary['description']; ?></p>
      </div>   
    </div>
  </div>
</div>
</div>
<script>
$('#display_modal').modal('show');
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>