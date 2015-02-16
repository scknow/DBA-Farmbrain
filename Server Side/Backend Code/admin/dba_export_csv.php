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
		// echo $l . "<br>";
		switch(trim($l)){
			case 'productid':
				if(PAGENAME == "product"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='productname';
				}
				$out .= $l . ',';
				break;
			case 'productcategoryid':
				if(PAGENAME == "prod_cat"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='productcategoryname';
				}
				$out .= $l . ',';
				break;
			case 'productsubcategoryid':
				if(PAGENAME == "prod_sub_cat"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='productsubcategoryname';
				}
				$out .= $l . ',';
				break;
			case 'manufid':
			case 'productmanufacturer':
				if(PAGENAME == "manufacturer"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='manufacturername';
				}
				$out .= $l . ',';
				break;
			case 'brandid':
			case 'brand':
				if(PAGENAME == "brand"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='brandname';
				}
				$out .= $l . ',';
				break;
			case 'customergroupid':
			case 'customergroup':
				if(PAGENAME == "customer_group"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='customergroupname';
				}
				$out .= $l . ',';
				break;
			case 'customerid':
				if(PAGENAME == "customer"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='customername';
				}
				$out .= $l . ',';
				break;
			case 'supplierid':
				if(PAGENAME == "supplier"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='suppliername';
				}
				$out .= $l . ',';
				break;
			case 'userid':
				if(PAGENAME == "sales_user"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='salesusername';
				}
				$out .= $l . ',';
				break;
			case 'rid':
				if(PAGENAME == "supp_cust"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='suppliercustomername';
				}
				$out .= $l . ',';
				break;
			case 'id':
				switch(PAGENAME){
					case 'pricing':
						$l= mysql_field_name($field_name, $i);
						$out .= $l . ',';
						break;
					case 'order_prof':
						$l= mysql_field_name($field_name, $i);
						$out .= $l . ',';
						break;
				}
				break;
			case 'promotionid':
				if(PAGENAME == "promotion"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='promotionname';
				}
				$out .= $l . ',';
				break;
			case 'eventid':
				if(PAGENAME == "promotional_event"){
					$l= mysql_field_name($field_name, $i);
				}else{
					$l='promotioneventname';
				}
				$out .= $l . ',';
				break;
			case 'active':
			case 'password':
			case 'password_change':
			case 'approved':
			case 'defaultp':
				break;
			default:				
				$l= mysql_field_name($field_name, $i);
				$out .= $l . ',';
				// $out.=$row[$i] . ', ';  // echo new line per data
		}
		
	} 
	// echo $out;die;
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
					switch(trim($l)){
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
									$out .= '' . ', ';
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
									$out .= '' . ', ';
								}
							}

							break;
						case 'productsubcategoryid':
							if(PAGENAME == "prod_sub_cat"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAPS' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select productsubcategoryname from productsubcategory where productsubcategoryid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}

							break;
						case 'manufid':
						case 'productmanufacturer':
							if(PAGENAME == "manufacturer"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAM' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select manufname from manufacturer where manufid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'brandid':
						case 'brand':
							if(PAGENAME == "brand"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAB' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select brandname from brand where brandid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'customergroupid':
						case 'customergroup':
							if(PAGENAME == "customer_group"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBACG' . $max_id . ', ';
							}else{
								if($row[$i] != -1){
									$sql_query = mysql_query("select customergroupname from customergroup where customergroupid='".$row[$i]."'");
									if(mysql_num_rows($sql_query)!=0){
										$res_data = mysql_fetch_array($sql_query);
										// if($res_data[0] != -1)
											$out.=$res_data[0] . ', ';
										// else
											// $out .= 'All' . ', ';
									}else{
										$out .= '' . ', ';
									}
								}else{
									$out .= 'All' . ', ';
								}
							}
							break;
						case 'customerid':
							if(PAGENAME == "customer"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAC' . $max_id . ', ';
							}else{
								if($row[$i] != -1){
									$sql_query = mysql_query("select businessname from customer where customerid='".$row[$i]."'");
									if(mysql_num_rows($sql_query)!=0){
										$res_data = mysql_fetch_array($sql_query);
										// if($res_data[0] != -1)
											$out.=$res_data[0] . ', ';
										// else
											// $out .= 'All' . ', ';
									}else{
										$out .= '' . ', ';
									}
								}else{
									$out .= 'All' . ', ';
								}
							}
							break;
						case 'supplierid':
							if(PAGENAME == "supplier"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAS' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select businessname from supplier where supplierid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'userid':
							if(PAGENAME == "sales_user"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBASU' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select username from salesuser where userid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'rid':
							if(PAGENAME == "supp_cust"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBASC' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select supplierbusinessname from suppliercustomer where rid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
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
							if(PAGENAME == "promotion"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAES' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select type from promotion where promotionid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'eventid':
							if(PAGENAME == "promotional_event"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAEM' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select eventname from promotionalevent where eventid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'active':
						case 'password':
						case 'password_change':
						case 'approved':
						case 'defaultp':
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
					switch(trim($l)){
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
									$out .= '' . ', ';
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
									$out .= '' . ', ';
								}
							}
							break;
						case 'productsubcategoryid':
							if(PAGENAME == "prod_sub_cat"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAPS' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select productsubcategoryname from productsubcategory where productsubcategoryid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}

							break;
						case 'manufid':
						case 'productmanufacturer':
							if(PAGENAME == "manufacturer"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAM' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select manufname from manufacturer where manufid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'brandid':
						case 'brand':
							if(PAGENAME == "brand"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAB' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select brandname from brand where brandid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'customergroupid':
						case 'customergroup':
							if(PAGENAME == "customer_group"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBACG' . $max_id . ', ';
							}else{
								if($row[$i] != -1){
									$sql_query = mysql_query("select customergroupname from customergroup where customergroupid='".$row[$i]."'");
									if(mysql_num_rows($sql_query)!=0){
										$res_data = mysql_fetch_array($sql_query);
										if($res_data[0] != -1)
											$out.=$res_data[0] . ', ';
										else
											$out .= 'All' . ', ';
									}else{
										$out .= '' . ', ';
									}
								}else{
									$out .= 'All' . ', ';
								}
							}
							break;
						case 'customerid':
							if(PAGENAME == "customer"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAC' . $max_id . ', ';
							}else{
								if($row[$i] != -1){
									$sql_query = mysql_query("select businessname from customer where customerid='".$row[$i]."'");
									if(mysql_num_rows($sql_query)!=0){
										$res_data = mysql_fetch_array($sql_query);
										// if($res_data[0] != -1)
											$out.=$res_data[0] . ', ';
										// else
											// $out .= 'All' . ', ';
									}else{
										$out .= '' . ', ';
									}
								}else{
									$out .= 'All' . ', ';
								}
							}
							break;
						case 'supplierid':
							if(PAGENAME == "supplier"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAS' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select businessname from supplier where supplierid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'userid':
							if(PAGENAME == "sales_user"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBASU' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select username from salesuser where userid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'rid':
							if(PAGENAME == "supp_cust"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBASC' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select supplierbusinessname from suppliercustomer where rid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
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
							if(PAGENAME == "promotion"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAES' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select type from promotion where promotionid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'eventid':
							if(PAGENAME == "promotional_event"){
								$max_id=str_pad($row[$i],6, '0',STR_PAD_LEFT);
								$out .= 'DBAEM' . $max_id . ', ';
							}else{
								$sql_query = mysql_query("select eventname from promotionalevent where eventid='".$row[$i]."'");
								if(mysql_num_rows($sql_query)!=0){
									$res_data = mysql_fetch_array($sql_query);
									$out.=$res_data[0] . ', ';
								}else{
									$out .= '' . ', ';
								}
							}
							break;
						case 'active':
						case 'password':
						case 'password_change':
						case 'approved':
						case 'defaultp':
							break;
						default:
							$out.=$row[$i] . ', ';  // echo new line per data
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