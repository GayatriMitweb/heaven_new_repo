<?php 
class checklist{

    public function checklist_save()
    {
        $booking_id = $_POST['booking_id'];
        $entity_id_arr = $_POST['entity_id_arr'];
        $ass_emp_id_arr = $_POST['ass_emp_id_arr'];
        $branch_admin_id = $_POST['branch_admin_id'];
        $tour_type = $_POST['tour_type'];
        $status_arr = $_POST['status_arr'];
        $entry_id_arr = $_POST['entry_id_arr'];
      
        
        $count = sizeof($entry_id_arr);
        for($i=0; $i<sizeof($entity_id_arr); $i++){
        if($entry_id_arr[$i]==''){
           

                $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from checklist_package_tour"));
                $id = $sq_max['max'] + 1;
    
                $sq_checklist = mysql_query("insert into checklist_package_tour( id, branch_admin_id, booking_id, tour_type,entity_id,assigned_emp_id,status ) values ( '$id', '$branch_admin_id', '$booking_id','$tour_type' ,'$entity_id_arr[$i]','$ass_emp_id_arr[$i]','$status_arr[$i]')");
                if(!$sq_checklist){
                    echo "error--Sorry, Some status are not marked!";
                    exit;
                }
         
            
        }else{
           
               
            $sq_update1 =  mysql_query("update checklist_package_tour set assigned_emp_id='$ass_emp_id_arr[$i]', status='$status_arr[$i]' where id = '$entry_id_arr[$i]'");
                              
               
                if(!$sq_update1){
                    echo "error--Sorry, Some status are not Updated!";
                    exit;
                }
            }
        }
        
        echo "Checklist updated successfully!";
        exit;
        
    }
}
?>