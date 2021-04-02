<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<div class="app_panel">
<div class="app_panel_head">Tour Cities</div>
<div class="app_panel_content">

<div class="row col-md-8 col-md-offset-2">
    
    <div>

      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#new_tour_cities_tab" aria-controls="new_tour_cities_tab" role="tab" data-toggle="tab">New Tour Cities</a></li>
        <li role="presentation"><a href="#tour_cities_list_tab" aria-controls="tour_cities_list_tab" role="tab" data-toggle="tab">Tour Cities List</a></li>
      </ul>

      <div class="tab-content">
        
        <!--***********Tab 1 Start************-->
        <div role="tabpanel" class="tab-pane active" id="new_tour_cities_tab">

            <div class="panel panel-default panel-body mg_bt_-1 text-center">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <label for="cmb_tour_id">Select Tour Name</label>
                        <select id="cmb_tour_id_s" name="cmb_tour_id_s" class="form-control" onchange="tour_city_list_load(this.id)">
                            <option value="select">Select Tour</option>
                            <?php 
                             $sq_tour_info = mysql_query("select tour_id, tour_name from tour_master");
                             while($row = mysql_fetch_assoc($sq_tour_info))
                             {
                             ?>
                             <option value="<?php echo $row['tour_id'] ?>"><?php echo $row['tour_name'] ?></option>
                             <?php   
                             }    
                            ?>
                        </select>
                    </div>
                </div>
            </div>  
            
            <div class="panel panel-default panel-body pad_8 text-center mg_bt_-1">
            <div class="row mg_bt_10"> <div class="col-md-12 text-right">
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_city_name')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Row</button>
                <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_city_name')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete Row</button>
            </div> </div>

            <div class="row"> <div class="col-md-12"> <div class="table-responsive">
                    
                <table id="tbl_dynamic_city_name" name="tbl_dynamic_city_name" class="table table-hover mg_bt_0"  cellspacing="0">
                    <tr>
                        <td><input id="chk_tour_group1" type="checkbox" checked></td>
                        <td><input class="form-control" style="max-width:100px" value="1" type="text" name="username" placeholder="Sr. No." disabled /></td>
                        <td><select class="form-control app_select2" id="cmb_city_1" name="cmb_city" style="width:100%">
                                <option value="select">Select City Name</option>
                                <?php 
                                $sq = mysql_query("select * from city_master");
                                while($row = mysql_fetch_assoc($sq))
                                {
                                  ?>
                                  <option value="<?php echo $row['city_id'] ?>"><?php echo $row['city_name'] ?></option>
                                  <?php  
                                }    
                                ?>
                            </select>
                        </td>        
                    </tr>                                
                </table>

            </div> </div> </div>
            </div>

            <div class="panel panel-default panel-body pad_8 text-center mg_bt_0">
                <button class="btn btn-success" onclick="tour_cities_save()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Tour Cities</button>                                        
            </div>




        </div>
        <!--***********Tab 1 End************-->

        <!--***********Tab 2 Start************-->
        <div role="tabpanel" class="tab-pane" id="tour_cities_list_tab">
            
                <div class="panel panel-default panel-body mg_bt_-1 text-center">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <label for="cmb_tour_id">Select Tour Name</label>
                            <select id="cmb_tour_id" name="cmb_tour_id" class="form-control" onchange="tour_city_list_load(this.id)">
                                <option value="select">Select Tour</option>
                                <?php 
                                 $sq_tour_info = mysql_query("select tour_id, tour_name from tour_master");
                                 while($row = mysql_fetch_assoc($sq_tour_info))
                                 {
                                 ?>
                                 <option value="<?php echo $row['tour_id'] ?>"><?php echo $row['tour_name'] ?></option>
                                 <?php   
                                 }    
                                ?>
                            </select>
                        </div>
                    </div>
                </div>    
                <div id="div_city_list"></div>
                <div id="div_city_list_update"></div>    

        </div>
        <!--***********Tab 2 end************-->

      </div>

    </div>

    
</div>    

</div>
</div>
          
                    
<script>
$('#cmb_city_1').select2();
</script>
<script src="js/tour_cities.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>