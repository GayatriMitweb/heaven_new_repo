<?php include "../../model/model.php"; ?>
<?php
  
        $term=$_GET['term'];
        $offset=$_GET['page']*100;
        $valueasText = $_GET['valueasText'];
        $q=mysql_query("select * from city_master where active_flag='Active' and city_name LIKE '$term%' LIMIT 100 OFFSET $offset");
        while($row = mysql_fetch_assoc($q)){
            if($valueasText == "true")
                $array['results'][]=array('id'=>$row['city_name'],'text'=>$row['city_name']);    
            else
                $array['results'][]=array('id'=>$row['city_id'],'text'=>$row['city_name']);
        }
        $rows = mysql_num_rows($q);
        if($rows == 100){
            $array['pagination']=array("more"=>true);
        }
        else if($rows < 100){
            
            $array['pagination']=array("more"=>false);
        }  

    echo  json_encode($array);
?>