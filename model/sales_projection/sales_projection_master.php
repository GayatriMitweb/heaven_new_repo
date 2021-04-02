<?php  

class sales_projection_master{

public function sales_projection_save()
{

	$total_g = $_POST['total_g'];
	$total_p = $_POST['total_p'];
	$total_b = $_POST['total_b'];
	$total_c = $_POST['total_c'];
	$total_pp = $_POST['total_pp'];
	$total_h = $_POST['total_h'];
	$total_v = $_POST['total_v'];
	$total_t = $_POST['total_t'];
	$total_f = $_POST['total_f'];
	$total_ms = $_POST['total_ms'];
	$total = $_POST['total'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$bud_strong_g = $_POST['bud_strong_g'];
	$bud_cold_g = $_POST['bud_cold_g'];
	$bud_hot_g = $_POST['bud_hot_g'];
	$bud_strong_p = $_POST['bud_strong_p'];
	$bud_hot_p = $_POST['bud_hot_p'];
	$bud_cold_p = $_POST['bud_cold_p'];
	$bud_strong_pp = $_POST['bud_strong_pp'];
	$bud_cold_pp = $_POST['bud_cold_pp'];
	$bud_hot_pp = $_POST['bud_hot_pp'];
	$bud_strong_v = $_POST['bud_strong_v'];
	$bud_hot_v = $_POST['bud_hot_v'];
	$bud_cold_v = $_POST['bud_cold_v'];
	$bud_hot_t = $_POST['bud_hot_t'];
	$bud_strong_t = $_POST['bud_strong_t'];
	$bud_cold_t = $_POST['bud_cold_t'];
	$bud_strong_ms = $_POST['bud_strong_ms'];
	$bud_hot_ms = $_POST['bud_hot_ms'];
	$bud_cold_ms = $_POST['bud_cold_ms'];
	$bud_strong_f = $_POST['bud_strong_f'];
	$bud_hot_f = $_POST['bud_hot_f'];
	$bud_cold_f = $_POST['bud_cold_f'];
	$bud_strong_h = $_POST['bud_strong_h'];
	$bud_hot_h = $_POST['bud_hot_h'];
	$bud_cold_h = $_POST['bud_cold_h'];
	$bud_strong_c = $_POST['bud_strong_c'];
	$bud_hot_c = $_POST['bud_hot_c'];
	$bud_cold_c = $_POST['bud_cold_c'];
	$bud_strong_b = $_POST['bud_strong_b'];
	$bud_hot_b = $_POST['bud_hot_b'];
	$bud_cold_b = $_POST['bud_cold_b'];
	$pro_s_g = $_POST['pro_s_g'];
	$pro_h_g = $_POST['pro_h_g'];
	$pro_c_g = $_POST['pro_c_g'];
	$pro_s_p = $_POST['pro_s_p'];
	$pro_h_p = $_POST['pro_h_p'];
	$pro_c_p = $_POST['pro_c_p'];
	$pro_s_v = $_POST['pro_s_v'];
	$pro_c_v = $_POST['pro_c_v'];
	$pro_h_v = $_POST['pro_h_v'];
	$pro_s_pp = $_POST['pro_s_pp'];
	$pro_c_pp = $_POST['pro_c_pp'];
	$pro_h_pp = $_POST['pro_h_pp'];
	$pro_s_ms = $_POST['pro_s_ms'];
	$pro_c_ms = $_POST['pro_c_ms'];
	$pro_h_ms = $_POST['pro_h_ms'];
	$pro_s_f = $_POST['pro_s_f'];
	$pro_c_f = $_POST['pro_c_f'];
	$pro_h_f = $_POST['pro_h_f'];
	$pro_s_t = $_POST['pro_s_t'];
	$pro_c_t = $_POST['pro_c_t'];
	$pro_h_t = $_POST['pro_h_t'];
	$pro_s_c = $_POST['pro_s_c'];
	$pro_c_c = $_POST['pro_c_c'];
	$pro_h_c = $_POST['pro_h_c'];
	$pro_s_h = $_POST['pro_s_h'];
	$pro_c_h = $_POST['pro_c_h'];
	$pro_h_h = $_POST['pro_h_h'];
	$pro_s_b = $_POST['pro_s_b'];
	$pro_c_b = $_POST['pro_c_b'];
	$pro_h_b = $_POST['pro_h_b'];

$from_date = date('Y-m-d', strtotime($from_date));
$to_date = date('Y-m-d', strtotime($to_date));
$created_at = date("Y-m-d");

$sq_count = mysql_num_rows(mysql_query("select * from sales_projection where from_date='$from_date' and to_date='$to_date'"));

	if($sq_count==0){

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from sales_projection"));
		$id = $sq_max['max'] + 1;

		$sq_pro = mysql_query("insert into sales_projection (id, from_date, to_date, total_g, total_p, total_b, total_c, total_pp , total_h, total_v,total_t,total_f,total,bud_strong_g,bud_cold_g,bud_hot_g,bud_strong_p,bud_hot_p,bud_cold_p,bud_strong_v,bud_hot_v,bud_cold_v,
			bud_strong_f,bud_hot_f,bud_cold_f,bud_strong_t,bud_cold_t,bud_hot_t,bud_strong_pp,bud_hot_pp,bud_cold_pp,bud_strong_h,bud_hot_h,
			bud_cold_h,bud_strong_c,bud_hot_c,bud_cold_c,bud_strong_b,bud_hot_b,bud_cold_b,pro_s_g,pro_h_g,pro_c_g, pro_s_p, pro_h_p, pro_c_p, pro_s_v, pro_c_v,pro_h_v, pro_s_pp,pro_c_pp,pro_h_pp,pro_s_f,pro_c_f,pro_h_f,pro_s_t,pro_c_t,pro_h_t,pro_s_c,pro_c_c,pro_h_c,
			pro_s_h, pro_c_h, pro_h_h,pro_s_b,pro_c_b,pro_h_b,total_ms,bud_strong_ms,bud_cold_ms,bud_hot_ms,pro_s_ms,pro_h_ms,pro_c_ms) values ('$id' , '$from_date', '$to_date', '$total_g', '$total_p','$total_b','$total_c','$total_pp','$total_h', '$total_v','$total_t', '$total_f','$total','$bud_strong_g','$bud_cold_g','$bud_hot_g','$bud_strong_p' ,'$bud_hot_p', '$bud_cold_p','$bud_strong_v','$bud_hot_v','$bud_cold_v','$bud_strong_f', '$bud_hot_f','$bud_cold_f','$bud_strong_t' ,'$bud_cold_t',
			'$bud_hot_t','$bud_strong_pp','$bud_hot_pp','$bud_cold_pp','$bud_strong_h','$bud_hot_h','$bud_cold_h','$bud_strong_c','$bud_hot_c',
			'$bud_cold_c','$bud_strong_b','$bud_hot_b','$bud_cold_b','$pro_s_g','$pro_h_g','$pro_c_g','$pro_s_p','$pro_h_p','$pro_c_p',
			'$pro_s_v','$pro_c_v','$pro_h_v','$pro_s_pp','$pro_c_pp','$pro_h_pp','$pro_s_f','$pro_c_f','$pro_h_f','$pro_s_t','$pro_c_t',
			'$pro_h_t','$pro_s_c','$pro_c_c','$pro_h_c','$pro_s_h','$pro_c_h','$pro_h_h','$pro_s_b','$pro_c_b','$pro_h_b','$total_ms','$bud_strong_ms','$bud_cold_ms','$bud_hot_ms','$pro_s_ms','$pro_h_ms','$pro_c_ms')");
	 
		if($sq_pro){
			echo "Sales Projection information saved !";
			exit;
		}
		else{
			echo "error--Sorry Sales Projection not saved successfully!";
			exit;
		}
	 }
	 else{
	 	$sq_pro1 = mysql_query("update sales_projection set total_g='$total_g', total_p='$total_p', total_b='$total_b', total_c='$total_c', total_pp='$total_pp' , total_h='$total_h', total_v='$total_v',total_t='$total_t',total_f='$total_f',total='$total',bud_strong_g='$bud_strong_g',bud_cold_g='$bud_cold_g',bud_hot_g='$bud_hot_g',bud_strong_p='$bud_strong_p',bud_hot_p='$bud_hot_p',bud_cold_p='$bud_cold_p',bud_strong_v='$bud_strong_v',bud_hot_v='$bud_hot_v',bud_cold_v='$bud_cold_v',bud_strong_f='$bud_strong_f',bud_hot_f='$bud_hot_f',bud_cold_f='$bud_cold_f',bud_strong_t='$bud_strong_t',bud_cold_t='$bud_cold_t',bud_hot_t='$bud_hot_t',bud_strong_pp='$bud_strong_pp',bud_hot_pp='$bud_hot_pp',bud_cold_pp='$bud_hot_pp',bud_strong_h='$bud_strong_h',bud_hot_h='$bud_hot_h',bud_cold_h='$bud_cold_h',bud_strong_c='$bud_strong_c',bud_hot_c='$bud_hot_c',bud_cold_c='$bud_cold_c',bud_strong_b='$bud_strong_b',bud_hot_b='$bud_hot_b',bud_cold_b='$bud_cold_b',pro_s_g='$pro_s_g',pro_h_g='$pro_h_g',pro_c_g='$pro_c_g',pro_s_p='$pro_s_p',pro_h_p='$pro_h_p',pro_c_p='$pro_c_p',pro_s_v='$pro_s_v',pro_c_v='$pro_c_v',pro_h_v='$pro_h_v',pro_s_pp='$pro_s_pp',pro_c_pp='$pro_c_pp',pro_h_pp='$pro_h_pp',pro_s_f='$pro_s_f',pro_c_f='$pro_c_f',pro_h_f='$pro_h_f',pro_s_t='$pro_s_t',pro_c_t='$pro_c_t',pro_h_t='$pro_h_t',pro_s_c='$pro_s_c',pro_c_c='$pro_c_c',pro_h_c='$pro_h_c',pro_s_h='$pro_s_h',pro_c_h='$pro_c_h',pro_h_h='$pro_h_h',pro_s_b='$pro_s_b',pro_c_b='$pro_c_b',pro_h_b='$pro_h_b',total_ms='$total_ms',bud_strong_ms='$bud_strong_ms',bud_cold_ms='$bud_cold_ms',bud_hot_ms='$bud_hot_ms',pro_s_ms='$pro_s_ms',pro_c_ms='$pro_c_ms',pro_h_ms='$pro_h_ms' where from_date='$from_date' and to_date='$to_date'");
	    if(!$sq_pro1){
			echo "error--Sorry Sales Projection not updated successfully!";
			exit;
		}
		else{
			echo "Sales Projection information updated !";
			exit;
		}

	}


}
}
?>
