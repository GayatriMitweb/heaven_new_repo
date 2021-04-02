<?php
include "../../model/model.php";
?>

    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12">
            <select class="form-control" id="cmb_tour_name" name="cmb_tour_name" title="Tour Name" onchange="cancel_tour_group_reflect(); "> 
                <option value="">Select Tour Name </option>
                <?php
                    $sq=mysql_query("select tour_id, tour_name from tour_master order by tour_name");
                    while($row=mysql_fetch_assoc($sq))
                    {
                      echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }    
                ?>
            </select>
        </div>
    </div>
<div id="div_tour_group_reflect" class="main_block"></div>


<?= end_panel(); ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>             
<script src="js/cancel_tour_group.js"></script>
<script type="text/javascript">
    $('#cmb_tour_name').select2();
</script>