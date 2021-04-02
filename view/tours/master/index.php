<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Group Tour Information',14) ?>
<div class="header_bottom">
  <div class="row mg_tp_10">
      <div class="col-md-12 text-right">
        <form action="save/index.php" class="no-marg pull-right" method="POST">
        &nbsp;&nbsp;<button class="btn btn-info btn-sm ico_left" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Group Tour</button>&nbsp;&nbsp;
        </form>
      </div>
  </div>
</div> 

  <!--=======Header panel end======--> 


  <div class="app_panel_content">
    <div id="div_modal_content"></div>
    <div id="div_tours_list" class="loader_parent"></div>
  </div>
</div>
<?= end_panel() ?>

<script>
function list_reflect()
{
  $('#div_tours_list').append('<div class="loader"></div>');
	$.post('list_reflect.php', {}, function(data){
		$('#div_tours_list').html(data);
	});
}
list_reflect();

// function save_modal()
// {
// 	$('#btn_save_modal').button('loading');
// 	$.post('save/save_group_tour.php', {}, function(data){
// 		$('#btn_save_modal').button('reset');
// 		$('#div_modal_content').html(data);
// 	});
// }

function update_modal(tour_id)
{
 
	$.post('update/update_group_tour.php', {tour_id : tour_id}, function(data){
		$('#div_modal_content').html(data);
	});
}
function tour_master_validate( tour_type, tour_name, tour_cost, service_tax, adult_cost , children_cost, infant_cost, adnary_upload_dir, from_date, to_date, capacity)
{
  
  var count = 0;

  var table = document.getElementById("tbl_dynamic_tour_group");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked == true)
    {
      count++;
      var from_date = row.cells[2].childNodes[0].value;
      var to_date = row.cells[3].childNodes[0].value;
      var capacity = row.cells[4].childNodes[0].value;

      if(from_date=="")
      {
        error_msg_alert("Select from date in row"+(i+1));
        return false;
      }
      if(to_date=="")
      {
        error_msg_alert("Select to date in row"+(i+1));
        return false;
      }
      if(capacity=="")
      {
        error_msg_alert("Enter enter in row"+(i+1));
        return false;
      }  
    }  

  }

  if(count==0)
  {
    error_msg_alert("Select at least one tour group.");
    return false;
  }  
  return true;

}
function display_modal(tour_id)
{
	$.post('view/index.php', {tour_id : tour_id}, function(data){
		$('#div_modal_content').html(data);
	});
}
</script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>