<?php
class role_mgt{

///////////// User roles save start/////////////////////////////////////////////////////////////////////////////////////////
function role_mgt_save()
{
  $role_id = $_POST['role_id'];
  $name = $_POST['name'];
  $link = $_POST['link'];
  $rank = $_POST['rank'];
  $priority = $_POST['priority'];
  $description = $_POST['description'];
  $icon = $_POST['icon'];

  $sq = mysql_query("delete from user_assigned_roles where role_id = '$role_id'");
  if(!$sq)
  {
    echo "Sorry can not update user roles.";
  }   

  for($i=0; $i<sizeof($name); $i++)
  {
    $sq = mysql_query("select max(id) as max from user_assigned_roles");
    $value = mysql_fetch_assoc($sq);
    $max_id = $value['max'] + 1; 

    $sq = mysql_query("insert into user_assigned_roles (id, role_id, name, link, rank, priority, description, icon) values ('$max_id' ,'$role_id', '$name[$i]', '$link[$i]', '$rank[$i]', '$priority[$i]', '$description[$i]', '$icon[$i]')");
  } 

  echo "Roles Assigned!";

}
///////////// User roles save end/////////////////////////////////////////////////////////////////////////////////////////

}
?>