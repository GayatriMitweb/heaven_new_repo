<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Package Tour Information',15) ?>

<div class="header_bottom">
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<form action="package/index.php" class="no-marg pull-right" method="POST">
      &nbsp;&nbsp;<button class="btn btn-info btn-sm ico_left" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Package Tour</button>&nbsp;&nbsp;
		</form>
    <button class="btn btn-info btn-sm ico_left pull-right" onclick="save_package_modal()" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Destination</button>
	</div>
</div>
</div>
  <div class="app_panel_content Filter-panel">
      <div class="col-md-3 col-sm-6">
        <select id="dest_name"  name="dest_name" title="Select Destination" class="form-control" onchange="list_reflect(this.value)"  style="width:100%"> 
          <option value="">Destination</option>
           <?php 
           $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
           while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
              <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
              <?php } ?>
        </select>
      </div>
 </div>

<div class="app_panel_content">

<div id="div_modal_content"></div>
<div id="div_modal_content1"></div>
<div id="div_tours_list" class="loader_parent"></div>
<div id="div_view_modal"></div>
<?= end_panel() ?>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#dest_name').select2();
function incl_reflect(cmb_tour_type,offset=''){
  var tour_type = $("#"+cmb_tour_type).val();
  var base_url = $("#base_url").val();
  $.post(base_url+'view/tours/master/inc/inclusion_reflect.php', {tour_type : tour_type,type:'package' }, function(data){
      var incl_arr = JSON.parse(data);
      var incl_id = 'inclusions'+offset;
      var excl_id = 'exclusions'+offset;

      var $iframe = $('#'+incl_id+'-wysiwyg-iframe');
      $iframe.contents().find("body").html('');
      $iframe.ready(function(){
        $iframe.contents().find("body").append(incl_arr['includes']);
      });

      var $iframe1 = $('#'+excl_id+'-wysiwyg-iframe');
      $iframe1.contents().find("body").html('');
      $iframe1.ready(function() {
        $iframe1.contents().find("body").append(incl_arr['excludes']);
      });
    });
}

function list_reflect(dest_name){
    $('#div_tours_list').append('<div class="loader"></div>');
    var dest_id = $('#dest_name').val();
    $.post('list_reflect.php', {dest_id : dest_id}, function(data){
        $('#div_tours_list').html(data);
    });
}
list_reflect();

function update_modal(package_id){
    $('#update_btn'+package_id).button('loading');
    $.post('update_modal.php', {package_id : package_id}, function(data){
        $('#update_btn'+package_id).button('reset');
        $('#div_modal_content1').html(data);
    });
}

function view_modal(package_id){
  $.post('view/index.php', { package_id: package_id }, function(data){
    $('#div_view_modal').html(data);
  });
}

function total_cost()
{
    var tour_cost = $('#tour_cost').val();
    var service_tax = $('#service_tax').val();
    var markup_cost = $('#markup_cost').val();
    var total_tour_cost = $('#total_tour_cost').val();

    if(tour_cost==""){ tour_cost = 0;}
    if(service_tax==""){service_tax = 0;}
    if(markup_cost==""){ markup_cost = 0;}
    if(total_tour_cost==""){total_tour_cost = 0;}

    var total = parseFloat(tour_cost) + parseFloat(markup_cost);

    var service_tax_amount = (parseFloat(total)/100) * parseFloat(service_tax);

    total_tour_cost = parseFloat(total) + parseFloat(service_tax_amount);

    $('#service_tax_subtotal').val(service_tax_amount.toFixed(2));

    $('#total_tour_cost').val(total_tour_cost.toFixed(2));
 
}

function save_package_modal()
{
    $('#btn_savepackage_btn').button('loading');
    $.post('save_package_modal.php', {}, function(data){
        $('#btn_savepackage_btn').button('reset');
        $('#div_modal_content').html(data);
    });
}
function package_clone(package_id){
		var base_url = $('#base_url').val();
		$('#vi_confirm_box').vi_confirm_box({
      	callback: function(data1){
        if(data1=="yes"){
		$.ajax({
			type:'post',
			url: base_url+'controller/custom_packages/package_clone.php',
			data:{ package_id : package_id },
			success:function(result){
				msg_alert(result);
				console.log(result);
				list_reflect();
			}
		});

          }
        }
    });
}
function get_transport_cost(transport_vehicle){
    var vehicle_id = $("#"+transport_vehicle).val();
    var offset = transport_vehicle.substring(12)
    $.post('package/get_transport_cost.php', {vehicle_id : vehicle_id}, function(data){
        $('#cost'+offset).val(data);
    });
}

</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>