<?php include "../../model/model.php"; ?>
<?php
//$role_id = $_SESSION['role_id'];
// require_once('../layouts/admin_header.php');
?>
 <!-- begin_panel('Branch Privilege',6)> -->
 <div class="alert alert-danger hidden" role="alert" id="branch_permission">
 Please upgrade the subscription to add to set branch privileges.
 <button type="button" class="close" onclick="remove_hidden_class()"><span>x</span></button>
</div>
 <span class="note">You need to select the permissions to avoid other branches to view them.</span>
<div class="panel panel-default panel-body mg_tp_20 mg_bt_-1">
<h4>Branchwise Permissions</h4>
        
		<?php
		$count=0;
		$alternate = true;
		$rank_array = array();
		$xml=simplexml_load_file("../../xml/role_management.xml");
		foreach($xml->menu_desc as $value)
		{
			$name = $value->name;
			$link = $value->link;
			$rank = $value->rank;
			$priority = $value->priority;
			$description = $value->description;
			$icon = $value->menu_icon;

			$assigned_role = mysql_num_rows(mysql_query("select * from branch_assign where name='$name' and link='$link' and branch_status='yes'"));
			if($assigned_role>=1){
				$status = "checked";
			}
			else{
				$status = "";
			}
			
			$disabled_status =mysql_query("select * from branch_assign where link='$link' and branch_status='disabled' ");
			while($row=mysql_fetch_assoc($disabled_status)){
				$link_d = $row['link'];
			}
			if($link==$link_d){
				$enable_status = "disabled";
			}
			else{
				$enable_status = "";
			}	

			$count++;
			if(!in_array($rank, $rank_array)){

				$bg = ($alternate) ? "#f5f5f5" : "";
				$alternate = !$alternate;
				?>
				</div>
				<div class="panel panel-default panel-body mg_bt_-1 pd_tp_5 pd_bt_0" style="background:<?= $bg ?>; padding-left:30px">
				<?php
			}

			if($priority==1){
				echo "<div class='row'><div class='col-md-12' style='padding:10px 0 0px 0;'>";
			}
			?>

			<div class="col-md-3 mg_bt_10">
				<input id="<?php echo 'chk_'.$count ?>" name="chk_role_mgt" data-offset="<?= $count ?>" type="checkbox" <?php echo $status; ?> <?php echo $enable_status; ?>>
				&nbsp;&nbsp;<label for="<?php echo 'chk_'.$count ?>"><?php echo $name ?></label>
				<input type="hidden" id="role_name_<?= $count ?>" value="<?php echo $name ?>">
				<input type="hidden" id="role_link_<?= $count ?>" value="<?php echo $link ?>">
				<input type="hidden" id="role_rank_<?= $count ?>" value="<?php echo $rank ?>">
				<input type="hidden" id="role_priority_<?= $count ?>" value="<?php echo $priority ?>">
				<input type="hidden" id="role_description_<?= $count ?>" value="<?php echo $description ?>">
				<input type="hidden" id="role_icon_<?= $count ?>" value="<?php echo $icon ?>">
			</div>
			<?php
			if($priority==1){
				echo "</div></div>";
			}
			if(!in_array($rank, $rank_array)){
				$rank = (string)$rank;
				$rank_array[] = $rank;
			} 	
		}
		?>

</div>
<div class="panel panel-default panel-body mg_bt_10 text-center pad_8">
    <button class="btn btn-sm btn-success" id="btn_save" onclick="branch_mgt_save()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>     
</div>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?> 
<script>

/////////////***********User roles save start******************************************************
function branch_mgt_save()
{
   var base_url = $("#base_url").val(); 
   //var role_id = $("#role_id").val(); 

    
  var name = new Array();
  var link = new Array(); 
  var rank = new Array(); 
  var priority = new Array(); 
  var description = new Array(); 
  var icon = new Array(); 

  $('input[name="chk_role_mgt"]').each(function(){

  	if($(this).is(':checked')){

  	  var offset = $(this).attr('data-offset');

  	  var name1 = $('#role_name_'+offset).val();
      var link1 = $('#role_link_'+offset).val();
      var rank1 = $('#role_rank_'+offset).val();
      var priority1 = $('#role_priority_'+offset).val();
      var description1 = $('#role_description_'+offset).val();
      var icon1 = $('#role_icon_'+offset).val();
      
      name.push(name1);       
      link.push(link1);       
      rank.push(rank1);       
      priority.push(priority1);       
      description.push(description1);         
      icon.push(icon1); 

  	}

  });

  $('#btn_save').button('loading');

  switch(<?= $setup_package ?>){
	case 1	:
	case 2	: 	{
		$('#branch_permission').removeClass('hidden');   $('#btn_save').button('reset'); window.location.href = '#top'
	}break;
	case 3	: 
	case 4	:
		{
		$.post( 
               base_url+"controller/group_tour/branch_mgt_save.php",
               { 'name[]' : name, 'link[]' : link  , 'rank[]' : rank, 'priority[]' : priority, 'description[]' : description, 'icon[]': icon  },
               function(data) {  
               		$('#btn_save').button('reset');
               		msg_popup_reload(data);
               });
	}break;
}
  
}

/////////////***********User roles save end*****************************************************
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>