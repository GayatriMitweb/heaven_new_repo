<?php
include "../../../../../model/model.php";
include_once('../../../../layouts/fullwidth_app_header.php');
$quotation_id = $_POST['quotation_id'];
$package_id = $_POST['package_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$emp_id = $_SESSION['emp_id'];
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
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
                <span class="text">Daywise Gallery</span>
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


<script src="<?php echo BASE_URL ?>view/package_booking/quotation/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/js/calculation.js"></script>
<script>
$('#enquiry_id, #currency_code, #transport_vehicle1').select2();
$('#from_date12, #to_date12, #quotation_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_arrval1,#txt_dapart1, #train_arrival_date,#train_departure_date').datetimepicker({ format:'d-m-Y H:i:s' });

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
function get_excursion_amount_update(eleid)
{
    var base_url = $('#base_url').val();
    var total_adult = $('#total_adult12').val();
    var children_without_bed = $('#children_without_bed12').val();
    var children_with_bed = $('#children_with_bed12').val();
    var total_infant = $('#total_infant12').val();
    var exc_date_arr = new Array();
    var exc_arr = new Array();
    var transfer_arr = new Array();

    var id = eleid.split('-');
    
    total_adult = (total_adult == '') ? 0 : total_adult;
    children_without_bed = (children_without_bed == '') ? 0 : children_without_bed;
    children_with_bed = (children_with_bed == '') ? 0 : children_with_bed;
    total_infant = (total_infant == '') ? 0 : total_infant;

    exc_date_arr.push($('#exc_date-'+id[1]).val());
    exc_arr.push($('#excursion-'+id[1]).val());
    transfer_arr.push($('#transfer_option-'+id[1]).val());

    $.post(base_url+"view/package_booking/quotation/home/excursion_amount_load.php" , { exc_date_arr : exc_date_arr,exc_arr:exc_arr,transfer_arr:transfer_arr,total_adult:total_adult,children_without_bed:children_without_bed,children_with_bed:children_with_bed,total_infant:total_infant} , function ( data ){
        var amount_arr = JSON.parse(data);
        $('#excursion_amount-'+id[1]).val(amount_arr[0]['total_cost']);
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<?php
include_once('../../../../layouts/fullwidth_app_footer.php');
?>