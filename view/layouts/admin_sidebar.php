<?php
global $app_version;
if(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['app_version']==$app_version ){

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $sq = mysql_query("select role_id,emp_id from roles where user_name='$username' and password='$password' ");
    if($row=mysql_fetch_assoc($sq)){

        $sq_role = mysql_fetch_assoc(mysql_query("select * from role_master where role_id='$row[role_id]'"));
        $role = $sq_role['role_name'];
        $role_id = $row['role_id'];
        $emp_id = $row['emp_id'];
    }   

    $_SESSION['role'] = $role; 
    $current_file = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar_inner main_block"> 
    <div id="cssmenu" style="width:100%"> 

        <ul>
            <?php
            $unique_menu = array();
            $sq_roles1 = mysql_num_rows(mysql_query("select distinct(rank) from user_assigned_roles where role_id='$role_id'"));
            
            $sq_roles1 = mysql_query("select distinct(rank) from user_assigned_roles where role_id='$role_id'");
            while($row_roles1 = mysql_fetch_assoc($sq_roles1)){

                if(!in_array($row_roles1['rank'], $unique_menu)){

                    $rank_count = mysql_num_rows(mysql_query("select * from user_assigned_roles where rank='$row_roles1[rank]' and role_id='$role_id'"));
                    if($rank_count>1){
                        $rank_arr = array();
                        $link_arr = array();
                        $name_arr = array();
                        $priority_arr = array();
                        $description_arr = array();
                        $icon_arr = array();

                        $sq_roles2 = mysql_query("select * from user_assigned_roles where rank='$row_roles1[rank]' and role_id='$role_id'");
                        while($row_roles2 = mysql_fetch_assoc($sq_roles2)){

                            array_push($rank_arr, $row_roles2['rank']);
                            array_push($link_arr, $row_roles2['link']);
                            array_push($name_arr, $row_roles2['name']);
                            array_push($priority_arr, $row_roles2['priority']);
                            array_push($description_arr, $row_roles2['description']);
                            array_push($icon_arr, $row_roles2['icon']);
                        }

                        for($i=0; $i<sizeof($rank_arr); $i++){

                            if($link_arr[$i]==$current_file){
                                $active_class = "active";
                                break;                                  
                            }   
                            else{                                    
                                $active_class = "";                         
                            }   
                        }
                    ?>
                    <li class="<?php echo $active_class ?> has-sub"><a href="#" class="has-sub"  style="cursor:default"><i class="<?= $icon_arr[0] ?>"></i>&nbsp;&nbsp;<?php echo $name_arr[0]; ?></a>
                        <ul>
                        <?php for($i=1; $i<sizeof($rank_arr); $i++){

                                if($name_arr[$i]=="Ticket Support" || $name_arr[$i]=="User Manual"){
                                    $new_tb = "target='_blank'";
                                }
                                else{
                                    $new_tb = "";
                                }
                                ?>
                                    <li><a  href="<?php echo BASE_URL."view/".$link_arr[$i] ?>" <?= $new_tb ?> ><i class="<?= $icon_arr[$i] ?>"></i>&nbsp;&nbsp;<?php echo $name_arr[$i] ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                <?php   
                }
                else{

                    $sq_roles4 = mysql_fetch_assoc(mysql_query("select * from user_assigned_roles where  rank='$row_roles1[rank]' and role_id='$role_id' ")); 
                    if($sq_roles4['link']== $current_file){
                        $active_class = "active";
                    }   
                    else{
                        $active_class = "";                         
                    } ?>
                    <li class="<?php echo $active_class ?> "><a href="<?php echo BASE_URL."view/".$sq_roles4['link'] ?>"><i class="<?= $sq_roles4['icon'] ?>"></i>&nbsp;&nbsp;<?php echo $sq_roles4['name'] ?></a></li>
            <?php }
                }
                array_push($unique_menu , $row_roles1['rank']);
            } 
            ?>                  
        </ul>
    </div>
</div><!--/sidebar-wrap-close-->

<?php
}   
else{
    exit;
}
?>