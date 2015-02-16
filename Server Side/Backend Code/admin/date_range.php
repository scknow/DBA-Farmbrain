	<?php
						  include "connection.php";
						  $s_date=$_POST['sd'];
						  $e_date=$_POST['ed'];
						  // echo $s_date . $e_date;die;
							$sql="SELECT * FROM supplier";
							$result = mysql_query($sql);
							$sup_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$sup_arr[$row['supplierid']] = $row['businessname'];
							}
							$sql="SELECT * FROM customer";
							$result = mysql_query($sql);
							$cust_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cust_arr[$row['customerid']] = $row['businessname'];
							}
							$sql="SELECT * FROM customergroup";
							$result = mysql_query($sql);
							$cg_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cg_arr[$row['customergroupid']] = $row['customergroupname'];
							}
							if(!isset($_SESSION['supplierid']))
							{
								if(($s_date!='')&&($e_date!=''))
								{
									$sql="SELECT * FROM pricing where datefrom >= '$s_date' AND dateto>='$e_date';";
								}
								else if(($s_date!='')&&($e_date==''))
								{
									$sql="SELECT * FROM pricing where datefrom >= '$s_date'";
								}
								else if(($s_date=='')&&($e_date!=''))
								{
									$sql="SELECT * FROM pricing where dateto<='$e_date'";
								}
								else
								{
									$sql="SELECT * FROM pricing";
								}
							}
							else
							{
								$supplierid = $_SESSION['supplierid'];
								$sql="SELECT * FROM pricing WHERE supplierid=".$supplierid;
							}
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['productid']."$$"."productid"."$$".'pricing';
								$line_id=$row['productid'];
								echo "<tr id='$line_id'>";
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['productid']."') name='check[]' value='".$row['productid']."'></td>";
								
								$max_id=str_pad($row['productid'],6, '0',STR_PAD_LEFT);					
								echo "<td onclick=product_edit('$id');><a href='#'>DBAP{$max_id}</a></td>";
								
								echo "<td>{$row['upc']}</td>";
								echo "<td>{$sup_arr[$row['supplierid']]}</td>";
								echo "<td>{$row['productname']}</td>";
								if($row['customergroup']==-1){
									echo "<td>All</td>";
								}else{
									echo "<td>{$cg_arr[$row['customergroup']]}</td>";
								}
								if($row['customerid']==-1){
									echo "<td>All</td>";
								}else{
									echo "<td>{$cust_arr[$row['customerid']]}</td>";
								}
								echo "<td>{$row['minodrqty']}</td>";
								echo "<td>{$row['incrementodrqty']}</td>";
								echo "<td>{$row['datefrom']}</td>";
								echo "<td>{$row['dateto']}</td>";
								
								echo "<td>{$row['price']}</td>";
								if($row['active']){
									echo "<td>Yes</td>";
								}else{
									echo "<td>No</td>";
								}
								echo "<td style='display:none;'>{$row['supplierid']}</td>";
								echo "<td style='display:none;'>{$row['customerid']}</td>";
								echo "<td style='display:none;'>{$row['customergroup']}</td>";
								echo "<td style='display:none;'>{$row['productid']}</td>";
								echo "</tr>";								
							}
	?>
					  