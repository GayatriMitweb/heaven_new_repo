<?php
  include "../../../model/model.php";
?>
  <div class="modal fade" id="attractions_view_modal" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Tourism Attractions</h4>
	      </div>
	      <div class="modal-body text-center">
	        
			<div class="row">
				<div class="col-md-6 mg_bt_10">
					<select name="dest_id" id="dest_id" title="Destination Name" style="width:100%" onchange="load_tourism_attr()">
              <option value="">Destination</option>
               <?php 
               $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
               while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                  <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                  <?php } ?>
          </select>
				</div>
      <div>
    </div>

      

      <div class="main_block">  
          <div id="div_list"></div>
      </div>
		    
	 </div>
	  
	</div> 
  </div>
  </div>
  </div>  
  <div id="div_modal"></div> 
  <div id="div_modal1"></div> 
<script type="text/javascript">
$('#attractions_view_modal').modal('show');
$('#dest_id').select2();
</script> 
<script src="../js/fourth_coming_attraction.js"></script>
 
 