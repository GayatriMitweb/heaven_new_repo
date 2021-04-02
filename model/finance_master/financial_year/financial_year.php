<?php 
class financial_year{

public function financial_year_save()
{
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$active_flag = $_POST['active_flag'];

	$created_at = date('Y-m-d H:i:s');
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$sq_count = mysql_num_rows(mysql_query("select from_date from financial_year where from_date='$from_date'"));
	if($sq_count>0){
		echo "error--Financial year already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(financial_year_id) as max from financial_year"));
	$financial_year_id = $sq_max['max'] + 1;

	begin_t();
	$sq_financial_year = mysql_query("insert into financial_year (financial_year_id, from_date, to_date, active_flag, created_at) values ('$financial_year_id', '$from_date', '$to_date', '$active_flag', '$created_at')");
	if($sq_financial_year){
		commit_t();
		echo "Financial Year has been successfully saved.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Financial year not saved!";
		exit;
	}

}

public function financial_year_update()
{
	$financial_year_id = $_POST['financial_year_id'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$active_flag = $_POST['active_flag'];
	
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$sq_count = mysql_num_rows(mysql_query("select from_date from financial_year where from_date='$from_date' and financial_year_id!='$financial_year_id'"));
	if($sq_count>0){
		echo "error--Financial year already exists!";
		exit;
	}

	begin_t();

	$sq_financial_year = mysql_query("update financial_year set from_date='$from_date', to_date='$to_date', active_flag='$active_flag' where financial_year_id='$financial_year_id'");
	if($sq_financial_year){
		commit_t();
		echo "Financial Year has been successfully updated.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Financial year not updated!";
		exit;
	}

}

}
?>