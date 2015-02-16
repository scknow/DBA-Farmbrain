	<?php
		include "connection.php";
							//////////////
							$grp_id=$_POST['group_id'];
							$customer_id=$_POST['customer_id'];
							$str='';
							if($grp_id==-1 && $customer_id==-1)
							{
								$query=mysql_query("select SUM(totalfinalordered),businessname,customergroupname,totalcmsn,agentcmsn,seccmsn,repcmsn,othercmsn,netcmsn from customer,`order`,customergroup where `order`.customerid=customer.customerid and customer.customergroupid=customergroup.customergroupid group by `order`.customerid");
							}
							else if($grp_id!=-1)
							{
								$query=mysql_query("select SUM(totalfinalordered),businessname,customergroupname,totalcmsn,agentcmsn,seccmsn,repcmsn,othercmsn,netcmsn from customer,`order`,customergroup where `order`.customerid=customer.customerid and customer.customergroupid=customergroup.customergroupid and customer.customergroupid='$grp_id' group by `order`.customerid");
							}
							else if($customer_id!=-1)
							{
								$query=mysql_query("select SUM(totalfinalordered),businessname,customergroupname,totalcmsn,agentcmsn,seccmsn,repcmsn,othercmsn,netcmsn from customer,`order`,customergroup where `order`.customerid=customer.customerid and `order`.customerid='$customer_id' and customer.customergroupid=customergroup.customergroupid group by `order`.customerid");
							}
							
							if(mysql_num_rows($query)!=0)
							{
								while($row=mysql_fetch_array($query))
								{
									
									 $totalcmsn=($row['SUM(totalfinalordered)']*$row['totalcmsn'])/100;
									 $agentcmsn=($row['SUM(totalfinalordered)']*$row['agentcmsn'])/100;
									 $seccmsn=($row['SUM(totalfinalordered)']*$row['seccmsn'])/100;
									 $repcmsn=($row['SUM(totalfinalordered)']*$row['repcmsn'])/100;
									 $othercmsn=($row['SUM(totalfinalordered)']*$row['othercmsn'])/100;
									 $netcmsn=($row['SUM(totalfinalordered)']*$row['netcmsn'])/100;
									
									$str.= "<tr>";
									$str.= "<td>".$row['customergroupname']."</td>";
									$str.= "<td>".$row['businessname']."</td>";									
									$str.= "<td>".$row['SUM(totalfinalordered)']." $</td>";
									if($totalcmsn!=0){
									$str.= "<td>".$totalcmsn."(".$row['totalcmsn']."%)</td>";
									}
									else{
										$str.= "<td>0</td>";
									}
									if($agentcmsn!=0){
									$str.= "<td>".$agentcmsn."(".$row['agentcmsn']."%)</td>";	
									}
									else{$str.= "<td>0</td>";}
									if($seccmsn!=0){
									$str.= "<td>".$seccmsn."(".$row['seccmsn']."%)</td>";}
									else{
										$str.= "<td>0</td>";
									}
									if($repcmsn!=0){
									$str.= "<td>".$repcmsn."(".$row['repcmsn']."%)</td>";	}
									else{
										$str.= "<td>0</td>";
									}
									if($othercmsn!=0){
									$str.= "<td>".$othercmsn."(".$row['othercmsn']."%)</td>";}
									else{
										$str.= "<td>0</td>";
									}
									if($netcmsn!=0){
									$str.= "<td>".$netcmsn."(".$row['netcmsn']."%)</td>";}
									else{
										$str.= "<td>0</td>";
									}
									
									$str.= "</tr>";
								}
							}
							echo $customer_group;
							echo $str;
							?>
						 