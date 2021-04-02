<?php
include "../../../model/model.php";
/*======******Header******=======*/

$booker_id = $_SESSION['booker_id'];
?>   
<div class="row text-center mg_bt_20">
    <label for="group_cancel" class="app_dual_button active">
        <input type="radio" id="group_cancel" name="cr_group" checked onchange="booking_group_reflect()">
        &nbsp;&nbsp;Cancel
    </label>    
    <label for="group_refund" class="app_dual_button" onchange="booking_group_reflect()">
        <input type="radio" id="group_refund" name="cr_group">
        &nbsp;&nbsp;Refund
    </label>
</div>

<div id="div_group_booking_content_reflect" class="main_block"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
    function booking_group_reflect()
    {
        var id= $('input[name="cr_group"]:checked').attr('id');
        if(id=="group_cancel")
        {
            $.post('cancel/index.php',{}, function(data){
                $('#div_group_booking_content_reflect').html(data);
            });
        }
        if(id=="group_refund")
        {
            $.post('refund/index.php',{},function(data){
                $('#div_group_booking_content_reflect').html(data);
            });
        }
    }
    booking_group_reflect();
</script>