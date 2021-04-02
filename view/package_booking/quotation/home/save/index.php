<?php
include "../../../../../model/model.php";
include_once('../../../../layouts/fullwidth_app_header.php');
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<!-- Tab panes -->
<div class="bk_tab_head bg_light">
    <ul> 
        <li>
            <a href="javascript:void(0)" id="tab1_head" class="active">
                <span class="num" title="Enquiry">1<i class="fa fa-check"></i></span><br>
                <span class="text">Enquiry</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab2_head">
                <span class="num" title="Package">2<i class="fa fa-check"></i></span><br>
                <span class="text">Package</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_daywise_head">
                <span class="num" title="Daywise Gallery">3<i class="fa fa-check"></i></span><br>
                <span class="text">Daywise Images</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab3_head">
                <span class="num" title="Travel And Stay">4<i class="fa fa-check"></i></span><br>
                <span class="text">Travel And Stay</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab4_head">
                <span class="num" title="Costing">5<i class="fa fa-check"></i></span><br>
                <span class="text">Costing</span>
            </a>
        </li>
    </ul>
</div>

<div class="bk_tabs">
    <div id="tab1" class="bk_tab active">
        <?php include_once("tab1.php"); ?>
    </div>
    <div id="tab2" class="bk_tab">
        <?php include_once("tab2.php"); ?>
    </div>
    <div id="tab_daywise" class="bk_tab">
        <?php include_once("daywise_images.php"); ?>
    </div>
    <div id="tab3" class="bk_tab">
        <?php include_once("tab3.php"); ?>
    </div>
    <div id="tab4" class="bk_tab">
        <?php include_once("tab4.php"); ?>
    </div>
</div>  
<script>
$('#enquiry_id, #currency_code').select2();

$('#from_date, #to_date, #quotation_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_arrval1,#txt_dapart1,#train_arrival_date,#train_departure_date').datetimepicker({ format:'d-m-Y H:i:s' });
/**Hotel Name load start**/
function hotel_name_list_load(id)
{
  var city_id = $("#"+id).val();
  var count = id.substring(9);
  $.get( "../hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name-"+count).html( data ) ;                            
  } ) ;   
}
function hotel_type_load(id)
{
  var hotel_id = $("#"+id).val();
  var count = id.substring(10);
  $.get( "../hotel/hotel_type_load.php" , { hotel_id : hotel_id } , function ( data ) {
        $ ("#hotel_type"+count).val( data ) ;  
  } ) ;   
}
/**Excursion Name load**/
function get_excursion_list(id)
{
  var city_id = $("#"+id).val();
  var base_url = $('#base_url').val();
  
  var count = id.substring(10);  
  $.post(base_url+"view/package_booking/quotation/home/excursion_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#excursion-"+count).html( data ) ;                            
  } ) ;   
}

/**Excursion Amount load**/
function get_excursion_amount()
{
    var base_url = $('#base_url').val();
    var total_adult = $('#total_adult').val();
    var children_without_bed = $('#children_without_bed').val();
    var children_with_bed = $('#children_with_bed').val();
    var total_infant = $('#total_infant').val();
    var exc_date_arr = new Array();
    var exc_arr = new Array();
    var transfer_arr = new Array();

    total_adult = (total_adult == '') ? 0 : total_adult;
    children_without_bed = (children_without_bed == '') ? 0 : children_without_bed;
    children_with_bed = (children_with_bed == '') ? 0 : children_with_bed;
    total_infant = (total_infant == '') ? 0 : total_infant;
    
    var table = document.getElementById("tbl_package_tour_quotation_dynamic_excursion");
    var rowCount = table.rows.length;

    for(var i=0; i<rowCount; i++){

        var row = table.rows[i];
        var exc_date = row.cells[2].childNodes[0].value;
        var exc = row.cells[4].childNodes[0].value;
        var transfer = row.cells[5].childNodes[0].value;

        exc_date_arr.push(exc_date);
        exc_arr.push(exc);
        transfer_arr.push(transfer);
    }
    var exc_adult_cost = 0;
    var exc_child_cot = 0;
    var exc_infant_cost = 0;
    $.post(base_url+"view/package_booking/quotation/home/excursion_amount_load.php" , { exc_date_arr : exc_date_arr,exc_arr:exc_arr,transfer_arr:transfer_arr,total_adult:total_adult,children_without_bed:children_without_bed,children_with_bed:children_with_bed,total_infant:total_infant} , function ( data ){
        var amount_arr = JSON.parse(data);
        for(var i=0; i<amount_arr.length; i++){

            var row = table.rows[i];
            if(row.cells[0].childNodes[0].checked){

                row.cells[6].childNodes[0].value = amount_arr[i]['total_cost'];
                var exc_adult_cost1 = amount_arr[i]['adult_cost'];
                var exc_child_cot1 = amount_arr[i]['child_cost'];
                var exc_infant_cost1 = amount_arr[i]['infant_cost'];
            }
            else{

                row.cells[6].childNodes[0].value = 0;
                var exc_adult_cost1 = 0;
                var exc_child_cot1 = 0;
                var exc_infant_cost1 = 0;
            }
            exc_adult_cost = parseFloat(exc_adult_cost) + parseFloat(exc_adult_cost1);
            exc_child_cot = parseFloat(exc_child_cot) + parseFloat(exc_child_cot1);
            exc_infant_cost = parseFloat(exc_infant_cost) + parseFloat(exc_infant_cost1);
        }
        $('#exc_adult_cost').val(exc_adult_cost);
        $('#exc_child_cost').val(exc_child_cot);
        $('#exc_infant_cost').val(exc_infant_cost);
    });
}
</script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/js/calculation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<?php
include_once('../../../../layouts/fullwidth_app_footer.php');
?>