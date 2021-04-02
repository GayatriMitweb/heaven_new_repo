<?php
include "../../../model/model.php";
$entity_id=$_POST['entity_id'];

?>
<div class="modal fade profile_box_modal" id="view_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		
		<div class="mg_tp_20"></div>
      	<h3 class="editor_title">To Do Entries</h3>
		<div class="panel panel-default panel-body app_panel_style">
			<div class="profile_box_padding">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
						<div class="profile_box">
				        	<?php
				        		$sq_query=mysql_query("select * from to_do_entries where entity_id='$entity_id' "); 
							while($row_query=mysql_fetch_assoc($sq_query))
							{
							  ?>
			    				 
				      		    <div class="to_do_name" class="form-control" style="margin-bottom: 30px">
				                   <p> <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>  <?= $row_query['entity_name'] ?></p>                 
				                </div>
					           <?php
					       	}

					           ?>
			        	</div> 
					</div>
				</div>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
<script>
	$('#view_modal').modal('show');
</script>