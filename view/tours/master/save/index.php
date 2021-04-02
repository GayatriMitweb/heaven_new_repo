<?php
include "../../../../model/model.php";
include_once('../../../layouts/fullwidth_app_header.php'); 
?>

<!-- Tab panes -->
<div class="bk_tab_head bg_light">
    <ul> 
        <li>
            <a href="javascript:void(0)" id="tab1_head" class="active">
                <span class="num" title="Tour">1<i class="fa fa-check"></i></span><br>
                <span class="text">Tour</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab2_head">
                <span class="num" title="Travelling">2<i class="fa fa-check"></i></span><br>
                <span class="text">Travelling</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab3_head">
                <span class="num" title="Daywise Images">3<i class="fa fa-check"></i></span><br>
                <span class="text">Daywise Images</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab4_head">
                <span class="num" title="Costing">4<i class="fa fa-check"></i></span><br>
                <span class="text">Costing</span>
            </a>
        </li>
    </ul>
</div>

<div class="bk_tabs">
<div id="tab1" class="bk_tab active">
    <?php include_once("package_tab1.php"); ?>
</div>
<div id="tab2" class="bk_tab">
    <?php include_once("travelling_tab2.php"); ?>
</div>
<div id="tab3" class="bk_tab">
    <?php include_once("dayswise_tab3.php"); ?>
</div>
<div id="tab4" class="bk_tab">
    <?php include_once("costing_tab4.php"); ?>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>view/tours/js/master.js"></script>

<script>

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

    $('#total_tour_cost').val(total_tour_cost);

    
}

function display_image(entry_id)
{
  $.post('display_image_modal.php', {entry_id : entry_id}, function(data){
    $('#div_modal').html(data);
  });
}
function incl_reflect(cmb_tour_type,offset='')
{
  var tour_type = $("#"+cmb_tour_type).val();
  var base_url = $("#base_url").val();
  $.post(base_url+'view/tours/master/inc/inclusion_reflect.php', {tour_type : tour_type,type:'package' }, function(data){
        var incl_arr = JSON.parse(data);
        var incl_id = 'inclusions'+offset;
        var excl_id = 'exclusions'+offset;
        var $iframe = $('#'+incl_id+'-wysiwyg-iframe');
            $iframe.contents().find("body").html('');
          $iframe.ready(function() {
            $iframe.contents().find("body").append(incl_arr['includes']);
        });

        var $iframe1 = $('#'+excl_id+'-wysiwyg-iframe');
            $iframe1.contents().find("body").html('');
          $iframe1.ready(function() {
            $iframe1.contents().find("body").append(incl_arr['excludes']);
        });
    });
}
function get_transport_cost(transport_vehicle){
    var vehicle_id = $("#"+transport_vehicle).val();
    var offset = transport_vehicle.substring(12);
    $.post('get_transport_cost.php', {vehicle_id : vehicle_id}, function(data){
        $('#cost'+offset).val(data);
    });
}
</script>
<?php 
include_once('../../../layouts/fullwidth_app_footer.php');
?>