<?php
include_once("../../model/model.php");
$entry_id = $_POST['entry_id'];
$type = $_POST['type'];
$sq_entry = mysql_fetch_assoc(mysql_query("select * from modulewise_video_master where entry_id='$entry_id'"));
$video_url = $sq_entry['video_url'];
?>
<div class="modal fade guidlines_modal" id="mydescp" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <?php if($type == 2){ ?>
    <!-- Description Modal -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Guidlines&nbsp;<i class="fa fa-thumbs-o-up" aria-hidden="true"></i></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <p><?php echo $sq_entry['description']; ?></p>
            </div>
        </div>
      </div>
    </div>
    <?php }
    if($type == 1){?>
    <!-- Video Modal -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Video&nbsp;<i class="fa fa-thumbs-o-up" aria-hidden="true"></i></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <div class="vid_block">
                <div class="btnHidder"></div>
                  <iframe src="<?= $video_url.'preview' ?>" width="100%" height="488px"  frameborder="0" allowTransparency="true" allowfullscreen></iframe>
              </div>
            </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<script>
$('#mydescp').modal('show');
$('#mydescp').on('hide.bs.modal', function(e) {   
    $("#mydescp iframe").attr("src", $("#mydescp iframe").attr("src"));
});
</script>