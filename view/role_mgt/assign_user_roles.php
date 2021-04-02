<?php
include "../../model/model.php";
/*======******Header******=======*/
// require_once('../layouts/admin_header.php');
?>
 <!-- begin_panel('User Privilege',5)  -->
               
<div class="app_panel_content Filter-panel">
  <div class="row">
      <div class="col-md-4 col-md-offset-4">
          <select id="role_id" name="role_id" onchange="assign_user_roles_reflect()" class="form-control" title="Select Role">
              <option value="">Select Role</option>
              <?php
                  $sq = mysql_query("select * from role_master where active_flag='Active'");
                  while($row = mysql_fetch_assoc($sq))
                  {
                   ?>
                      <option value="<?php echo $row['role_id'] ?>"><?php echo $row['role_name'] ?></option>
                   <?php       
                  }
              ?>
          </select>
          <small>Note : Set permission for individual Role</small>
      </div>
  </div>
</div>

<div id="div_user_roles" class="main_block"></div>    
<?= end_panel() ?>         

<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>      

<script>
$('#role_id').select2();
//*****************************************Assign User roles start****************************************************\\
function assign_user_roles_reflect()
{
  var role_id = $("#role_id").val();
  var role_name = $('#role_id').select2('data')[0].text;
  $.post( "../role_mgt/assign_user_roles_reflect.php" , { role_id : role_id, role_name : role_name  } , function ( data ) {

                $ ("#div_user_roles").html( data ) ;
                        
          } ) ; 

}
//*****************************************Assign User roles end****************************************************\\
</script>