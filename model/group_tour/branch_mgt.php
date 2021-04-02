<?php
class branch_mgt{

///////////// User roles save start/////////////////////////////////////////////////////////////////////////////////////////
function branch_mgt_save()
{
  //$role_id = $_POST['role_id'];
  $name = $_POST['name'];
  $link = $_POST['link'];
  $rank = $_POST['rank'];
  $priority = $_POST['priority'];
  $description = $_POST['description'];
  $icon = $_POST['icon'];

  $sq = mysql_query("delete from branch_assign where branch_status!='disabled'");
  if(!$sq)
  {
    echo "Sorry can not update Branch filter.";
  }   

  for($i=0; $i<sizeof($name); $i++)
  {
    $sq1 = mysql_query("select max(id) as max from branch_assign");
    $value = mysql_fetch_assoc($sq1);
    $max_id = $value['max'] + 1; 

    $sq1 = mysql_query("insert into branch_assign (id, name, link, rank, priority, description, icon, branch_status) values ('$max_id' ,'$name[$i]', '$link[$i]', '$rank[$i]', '$priority[$i]', '$description[$i]', '$icon[$i]', 'yes')");
  } 
  
    echo "Branchwise filter assigned!";
  

}
///////////// User roles save end/////////////////////////////////////////////////////////////////////////////////////////

}
?>