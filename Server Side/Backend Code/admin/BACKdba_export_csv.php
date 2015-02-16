<?php
//Create connection
include "connection.php";
session_start();
define("DB_NAME", "dbadev"); // db name
define("TABLE_NAME", $_REQUEST["type"]); // table
define("COL_NAME", $_REQUEST["type_nam"]);
define("PAGENAME", $_REQUEST["page_name"]);
// define("IDENTITY", $_GET["identifier"]);
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'submit') {
	
	$id_array = explode(',', $_REQUEST['list']);// return array
	
	if($id_array[0] == ''){
		$id_count = 0; // count array
	}else{
		$id_count = count($id_array); // count array
	}	
	
	$out = '';
	$field_name  = mysql_list_fields( DB_NAME, TABLE_NAME ); //, $conn);
	
	$count_field = mysql_num_fields($field_name); // count the table field

	for($i = 0; $i < $count_field; $i++) { // name of all fields
		$l= mysql_field_name($field_name, $i);
		$out .= $l . ', ';
	} 

	$out .= "\n"; // echo new line
	if($id_count != 0)
	{
		for($j = 0; $j < $id_count; $j++) { // each checked
			$id = $id_array[$j];
			//$query='';
			if(isset($_SESSION["supplierid"])){
				$query = mysql_query("SELECT * FROM ". TABLE_NAME ." WHERE ". COL_NAME ." = '$id' and supplierid='".$_SESSION["supplierid"]."'");
			}else{			
				$query = mysql_query("SELECT * FROM ". TABLE_NAME ." WHERE ". COL_NAME ." = '$id'");
			}
			while ($row = mysql_fetch_array($query)) {
				for($i = 0; $i < $count_field; $i++) {
					$l = mysql_field_name($field_name, $i);
					switch($l){
						case 'productid':
							if(PAGENAME == "product"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAP' . $max_id . ', ';
							}else{
								$sql_query=mysql_query("select productlabel from productportfolio where productid=".$row[$i]);
								if(mysql_num_rows($sql_query)!=0){
								$res_data = mysql_fetch_array($sql_query);
								$out.=$res_data[0] . ', ';
								}else{
									$out .= 'N/A' . ', ';
								}
							}
							break;
						case 'productcategoryid':
							if(PAGENAME == "prod_cat"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAPC' . $max_id . ', ';								
							}else{
								$sql_query = mysql_query("select productcategoryname from productcategory where productcategoryid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= 'N/A' . ', ';
								}
							}

							break;
						case 'productsubcategoryid':
							$sql_query = mysql_query("select productsubcategoryname from productsubcategory where productsubcategoryid='".$row[$i]."'");
							if(mysql_num_rows($sql_query)!=0){
								$res_data = mysql_fetch_array($sql_query);
								$out.=$res_data[0] . ', ';
							}else{
								$out .= 'N/A' . ', ';
							}
							// $max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							// $out .= 'DBAPS' . $max_id . ', ';
							break;
						case 'manufid':
						case 'productmanufacturer':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAM' . $max_id . ', ';
							break;
						case 'brandid':
						case 'brand':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAB' . $max_id . ', ';
							break;
						case 'customergroupid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBACG' . $max_id . ', ';
							break;
						case 'customerid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAC' . $max_id . ', ';
							break;
						case 'supplierid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAS' . $max_id . ', ';
							break;
						case 'userid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBASU' . $max_id . ', ';
							break;
						case 'rid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBASC' . $max_id . ', ';
							break;
						case 'id':
							switch(PAGENAME){
								case 'pricing':
									$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
									$out .= 'DBAP' . $max_id . ', ';
									break;
								case 'order_prof':
									$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
									$out .= 'DBAGP' . $max_id . ', ';
									break;
							}
							break;
						case 'promotionid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAES' . $max_id . ', ';
							break;
						case 'eventid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAEM' . $max_id . ', ';
							break;
						default:
							$out.=$row[$i] . ', ';  // echo new line per data
					}
				}
				$out .= "\n";  // echo new line per data
			}
		}
	}else{
			if(isset($_SESSION["supplierid"])){
				$query = mysql_query("SELECT * FROM ". TABLE_NAME ." WHERE supplierid='".$_SESSION["supplierid"]."'");
			}else{
				$query = mysql_query("SELECT * FROM ". TABLE_NAME);
			}
			while ($row = mysql_fetch_array($query)) {
				for($i = 0; $i < $count_field; $i++) {				
					$l = mysql_field_name($field_name, $i);
					switch($l){
						case 'productid':
							if(PAGENAME == "product"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAP' . $max_id . ', ';
							}else{
								$sql_query=mysql_query("select productlabel from productportfolio where productid=".$row[$i]);
								if(mysql_num_rows($sql_query)!=0){
								$res_data = mysql_fetch_array($sql_query);
								$out.=$res_data[0] . ', ';
								}else{
									$out .= 'N/A' . ', ';
								}
							}
							// $max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							// $out .= 'DBAP' . $max_id . ', ';
							break;
						case 'productcategoryid':
							$sql_query = mysql_query("select productcategoryname from productcategory where productcategoryid='".$row[$i]."'");
							if(mysql_num_rows($sql_query)!=0){
								$res_data = mysql_fetch_array($sql_query);
								$out.=$res_data[0] . ', ';
							}else{
								$out .= 'N/A' . ', ';
							}
							// $max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							// $out .= 'DBAPC' . $max_id . ', ';
							break;
						case 'productsubcategoryid':
							$sql_query = mysql_query("select productsubcategoryname from productsubcategory where productsubcategoryid='".$row[$i]."'");
							if(mysql_num_rows($sql_query)!=0){
								$res_data = mysql_fetch_array($sql_query);
								$out.=$res_data[0] . ', ';
							}else{
								$out .= 'N/A' . ', ';
							}
							// $max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							// $out .= 'DBAPS' . $max_id . ', ';
							break;
						case 'manufid':
						case 'productmanufacturer':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAM' . $max_id . ', ';
							break;
						case 'brandid':
						case 'brand':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAB' . $max_id . ', ';
							break;
						case 'customergroupid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBACG' . $max_id . ', ';
							break;
						case 'customerid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAC' . $max_id . ', ';
							break;
						case 'supplierid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAS' . $max_id . ', ';
							break;
						case 'userid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBASU' . $max_id . ', ';
							break;
						case 'rid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBASC' . $max_id . ', ';
							break;
						case 'id':
							switch(PAGENAME){
								case 'pricing':
									$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
									$out .= 'DBAP' . $max_id . ', ';
									break;
								case 'order_prof':
									$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
									$out .= 'DBAGP' . $max_id . ', ';
									break;
							}
							break;
						case 'promotionid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAES' . $max_id . ', ';
							break;
						case 'eventid':
							$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
							$out .= 'DBAEM' . $max_id . ', ';
							break;
						default:
							$out.=$row[$i] . ', '; // echo new line per data
					}
				}
				$out .= "\n";  // echo new line per data
			}
	}
	
	// Output to browser with appropriate mime type.
	 header("Content-type: text/x-csv"); 
	 header("Content-Disposition: attachment; filename=". PAGENAME ."_".time().".csv");
	 echo $out; // output
	 exit;
}
?>