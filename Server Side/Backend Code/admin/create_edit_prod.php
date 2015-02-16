<?php
include "connection.php";

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {

		$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
		$mob='/^\d+$/';
		
		//Import uploaded file to Database
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		$hdata = fgetcsv($handle, 1000, ",");
		$header ="";
		foreach($hdata as $h)
		{
			//if(trim($h)!="")
			$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		
		$status = "false";
		$msg = "";
		$line_no = 2;
		$out="";
		$is_error=0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			//$phone = $data[2];
			//echo trim($data[0])." ".trim($data[1]);
			if ( (trim($data[2])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[17])=="")||(trim($data[10])==""))
			{
				$msg .= "Some field is missing. Not uploading.<br> ";
				$status = "true";
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= $data[3] . ', ';
				$out .= $data[4] . ', ';
				$out .= $data[5] . ', ';
				$out .= $data[6] . ', ';
				$out .= $data[7] . ', ';
				$out .= $data[8] . ', ';
				$out .= $data[9] . ', ';
				$out .= $data[10] . ', ';
				$out .= $data[11] . ', ';
				$out .= $data[12] . ', ';
				$out .= $data[13] . ', ';
				$out .= $data[14] . ', ';
				$out .= $data[15] . ', ';
				$out .= $data[16] . ', ';
				$out .= $data[17] . ', ';
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
				//$out .= $data[0] . ', ';
				//$out .= "Some field is missing ,";
				//$out .= "\n";
			}		
			else
			{
				$productid = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				$qrcodeid = trim($data[1]);
				$productname = trim($data[2]);
				$productdesc = trim($data[3]);
				$product_catName = trim($data[4]);
				$product_subCat_name = trim($data[5]);
				$brand_name = trim($data[6]);
				$unitofmeasure = trim($data[7]);
				$packquantity = trim($data[8]);
				$skuupc = trim($data[9]);
				$mfgskuupc = trim($data[10]);
				$casequantity = trim($data[11]);
				$caseweight= trim($data[12]);
				$casegtin = trim($data[13]);
				$palletquantity = trim($data[14]);
				$shelflife= trim($data[15]);
				$suggestedretailshelflife = trim($data[16]);
				$product_manufatcur_name = trim($data[17]);
				
				
				$count=mysql_query("select * from productcategory where productcategoryname LIKE '%$product_catName%'");
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$productcategoryid=$row['productcategoryid'];
					$status = "true";
				}
				else
				{
					// echo "No such category available";
					$out .= $data[0] . ', ';
					$out .= $data[1] . ', ';
					$out .= $data[2] . ', ';
					$out .= $data[3] . ', ';
					$out .= $data[4] . ', ';
					$out .= $data[5] . ', ';
					$out .= $data[6] . ', ';
					$out .= $data[7] . ', ';
					$out .= $data[8] . ', ';
					$out .= $data[9] . ', ';
					$out .= $data[10] . ', ';
					$out .= $data[11] . ', ';
					$out .= $data[12] . ', ';
					$out .= $data[13] . ', ';
					$out .= $data[14] . ', ';
					$out .= $data[15] . ', ';
					$out .= $data[16] . ', ';
					$out .= $data[17] . ', ';
					$out .= "No such category available,";
					$out .= "\n";
					$status = "false";
					$is_error=1;
				}
				
				$count = mysql_query("select * from productsubcategory where productcategoryid='$productcategoryid' and productsubcategoryname LIKE '%$product_subCat_name%'");
				
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$productsubcategoryid=$row['productsubcategoryid'];
					$status = "true";
				}
				else
				{
					// echo "No subCategory available for this category";
					$out .= $data[0] . ', ';
					$out .= $data[1] . ', ';
					$out .= $data[2] . ', ';
					$out .= $data[3] . ', ';
					$out .= $data[4] . ', ';
					$out .= $data[5] . ', ';
					$out .= $data[6] . ', ';
					$out .= $data[7] . ', ';
					$out .= $data[8] . ', ';
					$out .= $data[9] . ', ';
					$out .= $data[10] . ', ';
					$out .= $data[11] . ', ';
					$out .= $data[12] . ', ';
					$out .= $data[13] . ', ';
					$out .= $data[14] . ', ';
					$out .= $data[15] . ', ';
					$out .= $data[16] . ', ';
					$out .= $data[17] . ', ';
					$out .= "No subCategory available for this category";
					$out .= "\n";
					$status = "false";
					$is_error=1;
					// $status = "false";
				}
				
				$count=mysql_query("select * from manufacturer where manufname LIKE '%$product_manufatcur_name%'");
				
				// echo "select * from manufacturer where manufname LIKE '%$product_manufatcur_name%'";
				
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$productmanufacturer=$row['manufid'];
					$status = "true";
				}
				else
				{
					foreach($data as $h)
					{
						//if(trim($h)!="")
							$out .= trim($h) . ', ';
					}
					$out .= "No such manufacture added" . ', ';
					//$out .= $data[5] . ', ';
					//$out .= "No such manufacture added ,";
					$out .= "\n";
					$status = "false";
					$is_error=1;
				}
				
				$count=mysql_query("select * from brand where brandname LIKE '%$brand_name%' and manufid LIKE '%$productmanufacturer%'");
				
				
				
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$brand_id=$row['brandid'];
					$status = "true";
				}
				else
				{
					$out .= $data[0] . ', ';
					$out .= $data[1] . ', ';
					$out .= $data[2] . ', ';
					$out .= $data[3] . ', ';
					$out .= $data[4] . ', ';
					$out .= $data[5] . ', ';
					$out .= $data[6] . ', ';
					$out .= $data[7] . ', ';
					$out .= $data[8] . ', ';
					$out .= $data[9] . ', ';
					$out .= $data[10] . ', ';
					$out .= $data[11] . ', ';
					$out .= $data[12] . ', ';
					$out .= $data[13] . ', ';
					$out .= $data[14] . ', ';
					$out .= $data[15] . ', ';
					$out .= $data[16] . ', ';
					$out .= $data[17] . ', ';
					$out .= "No such brand regarding this  manufacture";
					$out .= "\n";
					$status = "false";
					$is_error=1;
					// echo "No such brand regarding this  manufacture";
					//$out .= $data[6] . ', ';
					//$out .= "No such brand available ,";
					//$out .= "\n";
					// $status = "false";
				}
				
				if(($status == "true")&&($is_error!=1))
				{
					if($productid == ''){
						$sql = "INSERT INTO productportfolio( productlabel, productdescription, productcategoryid, productsubcategoryid, brand, unitofmeasure, packquantity, skuupc,mfgskuupc,casequantity, caseweight, casegtin, palletquantity,shelflife, suggestedretailshelflife, productmanufacturer) VALUES ('$productname', '$productdesc', '$productcategoryid', '$productsubcategoryid', '$brand_id', '$unitofmeasure', '$packquantity', '$skuupc','$mfgskuupc','$casequantity', '$caseweight', '$casegtin', '$palletquantity', '$shelflife', '$suggestedretailshelflife','$productmanufacturer')";
					}else{
						$sql = "UPDATE productportfolio SET productlabel='$productname', productdescription='$productdesc', productcategoryid='$productcategoryid', productsubcategoryid='$productsubcategoryid', brand='$brand_id', unitofmeasure='$unitofmeasure', packquantity='$packquantity', skuupc='$skuupc',mfgskuupc='$mfgskuupc',casequantity='$casequantity', caseweight='$caseweight', casegtin='$casegtin', palletquantity='$palletquantity',  shelflife='$shelflife', suggestedretailshelflife='$suggestedretailshelflife', productmanufacturer='$productmanufacturer' WHERE productid='$productid' ";
					}
					mysql_query($sql);
				}
				else
				{
					$out .= "Error at row - ". $line_no;
					$out .= "\n";
				}
			}
			$line_no++;
		}
		if($out!="")
		{
			// $header = urldecode($_REQUEST["header"]);
			// $out = urldecode($_REQUEST["data"]);
			header("Content-type: text/x-csv");
			header("Content-Disposition: attachment; filename=Error_cat_".time().".csv");
			echo $header."\n".$out;// output
			exit;
			// echo "<script></script>";
			// echo '<script>$.post( "download_errors.php", { data: '.urlencode($out).', header: '.urlencode($header).' } );</script>';
			// echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
			// echo "<script>location.href='download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."';alert('Uploaded but with some errors');</script>";
		}else
		{
			echo "<script>alert('File uploaded successfully');</script>";
		}
		// echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
}
else if(isset($_REQUEST['submit'])){
		$productlabel = $_POST['productlabel'];
		$productdescription = $_POST['productdescription'];
		$productcategoryid = $_POST['productcategoryid'];
		$productsubcategoryid = $_POST['productsubcategoryid'];
		$brand = $_POST['brand'];
		$unitofmeasure = $_POST['unitofmeasure'];
		$packquantity = $_POST['packquantity'];
		$skuupc = $_POST['skuupc'];
		$mfgskuupc = $_POST['mfgskuupc'];
		$casequantity = $_POST['casequantity'];
		$caseweight = $_POST['caseweight'];
		$casegtin = $_POST['casegtin'];
		$palletquantity = $_POST['palletquantity'];
		$attributetype = $_POST['attributetype'];
		$add_edit=$_POST['add_edit'];
		
		$shelflife = $_POST['shelflife'];
		$suggestedretailshelflife = $_POST['suggestedretailshelflife'];
		$productmanufacturer = $_POST['productmanufacturer'];
		$attachment = "";
		if($add_edit==0)
		{
			$file1='a';				
			if(!file_exists($_FILES['picture1']['tmp_name']) || !is_uploaded_file($_FILES['picture1']['tmp_name'])) {
				$picture1='a';
			}
			else
			{
				$picture1=upload_file('picture1');
			}
			
			if(!file_exists($_FILES['file']['tmp_name'][0]) || !is_uploaded_file($_FILES['file']['tmp_name'][0])) 
			{
				
			}
			else
			{
				upload_file_multiple('file1',$max_id,$attributetype);
			}
			
			$sql = "INSERT INTO productportfolio( productlabel, productdescription, productcategoryid, productsubcategoryid, brand, unitofmeasure, packquantity, skuupc,mfgskuupc, casequantity, caseweight, casegtin, palletquantity, picture1, file1, shelflife, suggestedretailshelflife, productmanufacturer, attachment,active) VALUES ('$productlabel', '$productdescription', '$productcategoryid', '$productsubcategoryid', '$brand', '$unitofmeasure', '$packquantity', '$skuupc','$mfgskuupc','$casequantity', '$caseweight', '$casegtin', '$palletquantity', '$picture1', '$file1', '$shelflife', '$suggestedretailshelflife', '$productmanufacturer', '$attachment','1')";
			
			mysql_query($sql);
			echo mysql_error();
			
			$sql="SELECT MAX( productid  ) FROM productportfolio";
			$result=mysql_query($sql);
			$temp=mysql_fetch_array($result);
			$max_id = $temp['MAX( productid  )'];		
			
			
			
		}
		else
		{
			$id=$_POST['field_id'];
			$status=$_POST['status'];
			$productid=$_POST['field_id'];
			if(!file_exists($_FILES['picture1']['tmp_name']) || !is_uploaded_file($_FILES['picture1']['tmp_name'])) {
				$picture1='a';
			}
			else
			{
				$picture1=upload_file('picture1');
				$sql = "UPDATE productportfolio SET picture1='$picture1' WHERE productid='$id'";
				//echo $sql;
				mysql_query($sql);
				echo mysql_error();
			}
			if(!file_exists($_FILES['file']['tmp_name'][0]) || !is_uploaded_file($_FILES['file']['tmp_name'][0])) {
				
			}
			else
			{
				upload_file_multiple_update($productid,$attributetype);
			}
			$sql = "UPDATE productportfolio SET productlabel='$productlabel', productdescription='$productdescription', productcategoryid='$productcategoryid', productsubcategoryid='$productsubcategoryid', brand='$brand', unitofmeasure='$unitofmeasure', packquantity='$packquantity', skuupc='$skuupc',mfgskuupc='$mfgskuupc',casequantity='$casequantity', caseweight='$caseweight', casegtin='$casegtin', palletquantity='$palletquantity',  shelflife='$shelflife', suggestedretailshelflife='$suggestedretailshelflife', productmanufacturer='$productmanufacturer',active='$status' WHERE productid='$id' ";
			
			//upload_file_multiple('file1',$max_id,$attributetype);
			mysql_query($sql);
			echo mysql_error();
		}
		
		header('Location: ' . basename($_SERVER['PHP_SELF']));
		exit();
	}
	function upload_file($arg)
	{
		$image_name_new = "a";
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("gif", "jpeg", "jpg", "png");		
		$extension = end($temp);
		if ((($_FILES[$arg]["type"] == "image/gif")
		|| ($_FILES[$arg]["type"] == "image/jpeg")
		|| ($_FILES[$arg]["type"] == "image/jpg")		
		|| ($_FILES[$arg]["type"] == "image/png"))
		&& ($_FILES[$arg]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES[$arg]["error"] > 0) {
			echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  } 
		  else
		  {			
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;			
			if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  echo $_FILES[$arg]["name"] . " already exists. ";
			} 
			else 
			{
			  move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);			  
			}
		  }
		}
		return $image_name_new;
	}
	function upload_file1($arg)
	{		
		$image_name_new = "a";
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("docx", "pdf");		
		$extension = end($temp);
		if ((($_FILES[$arg]["type"] == "image/docx")
		|| ($_FILES[$arg]["type"] == "image/pdf"))
		&& ($_FILES[$arg]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES[$arg]["error"] > 0) {
			echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  } 
		  else
		  {			
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;			
			if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  echo $_FILES[$arg]["name"] . " already exists. ";
			} 
			else 
			{
			  move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);			  
			}
		  }
		}
		return $image_name_new;
	}
	function upload_file_multiple($arg,$productid,$type)
	{
		$p=0;
		foreach($_FILES['file1']['tmp_name'] as $key => $tmp_name )
		{
			
			$file_name = $key.$_FILES['file1']['name'][$key];
			$file_size =$_FILES['file1']['size'][$key];
			$file_tmp =$_FILES['file1']['tmp_name'][$key];
			$file_type=$_FILES['file1']['type'][$key];
			 if($file_size > 7097152)
			{
				$errors[]='File size must be less than 2 MB';
			}	
			$temp = explode(".", $_FILES[$arg]["name"][$key]);
			$extension = end($temp);
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;
				
			$desired_dir="upload";
			if(empty($errors)==true){
			  
					move_uploaded_file($file_tmp,"upload/".$image_name_new);
					$sql = "INSERT INTO productattributestable(productid, attributepic, attributetype)VALUES('$productid','$image_name_new','$type[$p]')";
			
					mysql_query($sql);
					$p++;
				}
			
				else
				{
						print_r($errors);
				}
			}
			
		
		if(empty($error)){
			//echo "Success";
		}
	}
	function upload_file_multiple_update($productid,$type)
	{
		$p=0;
		foreach($_FILES['file1']['tmp_name'] as $key => $tmp_name )
		{
			if(is_uploaded_file($_FILES['file1']['tmp_name'][$p]))
			{
				$file_name = $key.$_FILES['file1']['name'][$key];
				$file_size =$_FILES['file1']['size'][$key];
				$file_tmp =$_FILES['file1']['tmp_name'][$key];
				$file_type=$_FILES['file1']['type'][$key];
				if($file_size > 7097152)
				{
					$errors[]='File size must be less than 2 MB';
				}	
			$temp = explode(".", $_FILES['file1']["name"][$key]);
			$extension = end($temp);
			$image_name=rand(1,100000);
			$image_name_new="file1_".$image_name.".".$extension;
				
			$desired_dir="upload";
			if(empty($errors)==true)
			{
			  
				$id=$_POST[$p];
				move_uploaded_file($file_tmp,"upload/".$image_name_new);
				if(isset($_POST[$p]))
				{
					$sql="update productattributestable set attributepic='$image_name_new',attributetype='$type[$p]' where attributeId='$id'";
				}
				else
				{
					
					$sql = "INSERT INTO productattributestable(productid, attributepic, attributetype)VALUES('$productid','$image_name_new','$type[$p]')";
				}
					
					mysql_query($sql);
					$p++;
				}
			
				else
				{
						print_r($errors);
				}
			}
		else
		{
			$id=$_POST[$p];
			$sql="update productattributestable set attributetype='$type[$p]' where attributeId='$id'";
			mysql_query($sql);
		}
}
		
		if(empty($error)){
			//echo "Success";
		}
	}
	include "header.php";
	include "menu.php";
?>
<div id='upload_hover'></div>
<div id="content" class="span10">
	<div class='bread'>			
	<ul class="breadcrumb">
		<li class="step">
			<a href="index.php">Home</a>
		</li>
		<li class="step">
			<a href="#" class="active1">Product</a>
		</li>
	</ul>
	</div>
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Product</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 125px;'><i class="icon-cog"></i> Add Product</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th Style="width:5%"><input type='checkbox' onclick='check_all()'></th>
								<th><a>Product Id</a></th>
								<th><a>Product Label</a></th>
								<th><a>Brand</a></th>
								<th><a>Case qty</a></th>
								<th><a>Unit of measure</a></th>
								<th><a>Category</a></th>
								<th><a>Sub Category</a></th>
								<th><a>document</a></th>								
								<th><a>Status</a></th>
								<th style="display:none;">manuid</th>
								<th style="display:none;">pcid</th>
								<th style="display:none;">spcid</th>
								<th style="display:none;">bid</th>
							</tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							$sql="SELECT * FROM productcategory";
							$result = mysql_query($sql);
							$cat_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cat_arr[$row['productcategoryid']] = $row['productcategoryname'];
							}
							$sql="SELECT * FROM productsubcategory";
							$result = mysql_query($sql);
							$subcat_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$subcat_arr[$row['productsubcategoryid']] = $row['productsubcategoryname'];
							}
							
							$sql="SELECT * FROM brand";
							$result = mysql_query($sql);
							$brand_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$brand_arr[$row['brandid']] = $row['brandname'];
							}
							
							$sql="SELECT * FROM manufacturer";
							$result = mysql_query($sql);
							$manf_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$manf_arr[$row['manufid']] = $row['manufname'];
							}
							//print_r($cat_arr);
							
							$sql="SELECT * FROM productportfolio ORDER BY productid DESC";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['productid']."$$"."productid"."$$".'productportfolio';
								$line_id=$row['productid'];
								echo "<tr id='$line_id'>";
								
								echo "<td class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['productid']."') name='check[]' value='".$row['productid']."'></td>";
								
								$max_id=str_pad($row['productid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAP{$max_id}</a></td>";
								echo "<td>{$row['productlabel']}</td>";
								echo "<td>{$brand_arr[$row['brand']]}</td>";
								echo "<td>{$row['casequantity']}</td>";
								echo "<td>{$row['unitofmeasure']}</td>";
								echo "<td>".$cat_arr[$row['productcategoryid']]."</td>";
								echo "<td>{$subcat_arr[$row['productsubcategoryid']]}</td>";
								if($row['file1']!='a' && $row['file1']!='')
								{
									$path=$row['file1'];
									echo "<td><a href='http://antloc.com/dba/admin/upload/{$path}'>Download file</s></td>";
								}
								else
								{
									echo "<td><a href=''>No file attach</a></td>";
								}
								

								
								
								if($row['active']==0)
								{
									echo "<td>Inactive</td>"; 
								}
								else
								{
									echo "<td>Active</td>";
								}
								echo "<td style='display:none;'>{$row['productmanufacturer']}</td>";
								echo "<td style='display:none'>{$row['productcategoryid']}</td>"; 
								echo "<td style='display:none'>{$row['productsubcategoryid']}</td>"; 
								echo "<td style='display:none'>{$row['brand']}</td>"; 
								echo "</tr>";
								
							}
							?>
						</tbody>
					</table>  
					<div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">DEACTIVE</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						
						<button id="upload_csv_btn" style="margin-right:10px"><a href="#">Upload</a></button>
					</div>
				</div>
			</div><!--/span-->			
	</div>
</div><!--/#content.span10-->


<hr>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3 id='heading'>Create Product</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
		<fieldset>	
				<div class="control-group">
					<label class="control-label" >Product ID</label>
					<div class="controls">
						<input type="text" id="p_ids" name="p_ids" value='DBAP001230' disabled />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Product Label</label>
					<div class="controls">
						<input type="text" id="productlabel" name="productlabel" required />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Description</label>
					<div class="controls">
						<textarea id="productdescription" name="productdescription" rows="5" cols=""></textarea> 
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Category</label>
					<div class="controls">
						<select name="productcategoryid" onchange="get_subcat()" id="category_id" required >
                            <?
							include "connection.php";
							$sql = "SELECT * FROM productcategory";
							echo "<option value=''>Select</option>";
							$result = mysql_query($sql);
							while($row=mysql_fetch_array($result)){
								echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
							}
							?>
                          </select> 
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label" >Sub-category</label>
					<div class="controls">
						<select name="productsubcategoryid" id="subcat_id" required >
                           
                          </select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Manufacturer</label>
					<div class="controls">
						<select name="productmanufacturer" onchange="get_brand()" id="productmanufacturer" required >
                            <?
							include "connection.php";
							$sql = "SELECT * FROM manufacturer";
							echo "<option value=''>Select</option>";
							$result = mysql_query($sql);
							while($row=mysql_fetch_array($result)){
								echo "<option value='".$row['manufid']."'>".$row['manufname']."</option>";
							}
							?>
						</select> 
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Brand</label>
					<div class="controls">
						<select name="brand" id="brand" required >
                           
                          </select>
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Unit of measure</label>
					<div class="controls">
						<input id="unitofmeasure" type="text" name="unitofmeasure" value="EA" readonly />  
					</div>
				</div>	
				
				<div class="control-group">
				<label class="control-label" >Pack quantity</label>
				<div class="controls">
				<input type="text" id="packquantity" onkeypress="return IsNumeric(event,'error');" name="packquantity" ondrop="return false;" onpaste="return false;" /><span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >UPC</label>
					<div class="controls">
						
						<input id="skuupc" type="text" name="skuupc"  onkeypress="return count_charcter(event,'error7',this,12);" ondrop="return false;" onpaste="return false;"/>
						<span id="error7" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >MFG SKU</label>
					<div class="controls">
						
						<input id="mfgskuupc" type="text" name="mfgskuupc"  onkeypress="return count_charcter(event,'error17',this,12);" ondrop="return false;" onpaste="return false;" required/>
						<span id="error17" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Case Quantity</label>
					<div class="controls">
						<input id="casequantity" type="text" name="casequantity"  onkeypress="return IsNumeric(event,'error1');" ondrop="return false;" onpaste="return false;" required/>
						<span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Case weight(In lbs)</label>
					<div class="controls">
						<input id="caseweight" type="text" name="caseweight" onkeypress="return IsNumeric1(event,'error2');" ondrop="return false;" onpaste="return false;" required/>  
						<span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Case GTIN</label>
					<div class="controls">
						<input id="casegtin" type="text" name="casegtin"  onkeypress="return count_charcter(event,'error14',this,13);" ondrop="return false;" onpaste="return false;"/>
						<span id="error14" style="color: Red; display: none">* Input digits (0 - 9)</span>
						
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Pallet Quantity</label>
					<div class="controls">
						<input id="palletquantity" type="text" name="palletquantity" onkeypress="return IsNumeric(event,'error3');" ondrop="return false;" onpaste="return false;"/>
						<span id="error3" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Storage Life(In Days)</label>
					<div class="controls">
						<input id="shelflife" type="text" name="shelflife" /> 
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Suggested shelf life(In days)</label>
					<div class="controls">
						<input id="suggestedretailshelflife" type="text" name="suggestedretailshelflife" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Picture</label>
					<div class="controls">
						<input id="picture1" type="file" name="picture1" onchange="readURL(this);" />
						<img id="blah" src="#" alt="your image" style='display:none;'/>
					</div>
				</div>
				<div id='add' name='add'>
					<div class="control-group">
						<label class="control-label" >Attribute Type</label>
						<div class="controls">
							<Select id="attributetype" name="attributetype[]" style='float:left;'>
								<option value=''>Select</option>
								<option>Nutritional</option>
								<option>Certificate Of Analysis(COA)</option>
								<option>Allergen Information</option>
								<option>Country of Origin</option>
								<option>GMO Statement</option>
								<option>Kosher</option>
							</select>
							<p style='padding: 4px;border: 1px solid #bbb;text-align:center;background: #0b840b;color: white;float: left;width: 30px;cursor:pointer' onclick='add_attribute()'>+</p>
						</div>
					
					</div>
					<div class="control-group">
					<label class="control-label" >File</label>
					<div class="controls">
						<input id="file1" type="file" name="file1[]" />  
					</div>
					</div>		
				
				</div>
				
				<div class="control-group">
					<label class="control-label" >Status</label>
					<div class="controls">
						<select name="status" id="status" required >
                           <option value='1'>Active</option>
						   <option value='0'>Inactive</option>
						</select> 
					</div>
				</div>
				
			<input type='hidden' name='add_edit' id='add_edit' value='0'/>
			<input type='hidden' name='field_id' id='field_id' value='0'/>
		</fieldset>				
		</div>	
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" onclick='hide()'>Close</a>
		<input type='submit' value='Submit' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div>
	
	</form> 
	
</div>
<div id="overlay"></div>


<? include "footer.php"?>

<script>
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;
var checkss=0;
var checklist = new Array();
var checklistjson = new Array();
$(document).ready(function(){
	$( "#product_ul" ).show();
	$( "#i1" ).html('-');
	ul3 = true;
	
	
	$.ajax({
		type: "POST",
		url: "get_cat_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].productcategoryid+"'>"+res[i].productcategoryname+"</option>";
		}
		
		$("div.myTools").html('<label>Category</label><select id="categories">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#categories').change( function() { 
			
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 11, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 11, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
	$.ajax({
		type: "POST",
		url: "get_subcat_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].productsubcategoryid+"'>"+res[i].productsubcategoryname+"</option>";
		}
		
		$("div.myTools1").html('<label>Sub Category</label><select id="subcategories">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#subcategories').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 12, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 12, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
	/* $.ajax({
		type: "POST",
		url: "get_manufact_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].manufid+"'>"+res[i].manufname+"</option>";
		}
		$("div.myTools4").html('<label>Manufacturer</label><select id="manufact">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#manufact').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 7, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 7, true ); 
			}
		});
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	 */
	$.ajax({
		type: "POST",
		url: "get_brand_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].brandid+"'>"+res[i].brandname+"</option>";
		}
		$("div.myTools5").html('<label>Brand</label><select id="brands">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#brands').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 13, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 13, true ); 
			}
		});
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
	
	
});
		
$( "#supplier_li" ).click(function() {
	$( "#supplier_ul" ).slideToggle(1000);	
	if(ul1){
		$( "#i3" ).html('+');
		ul1 = false;
	}else{
		$( "#i3" ).html('-');
		ul1 = true;
	}
});
				
$( "#customer_li" ).click(function() {
	$( "#customer_ul" ).slideToggle(1000);	
	if(ul2){
		$( "#i2" ).html('+');
		ul2 = false;
	}else{
		$( "#i2" ).html('-');
		ul2 = true;
	}	
});
				
$( "#product_li" ).click(function() {
	$( "#product_ul" ).slideToggle(1000);	
	if(ul3){
		$( "#i1" ).html('+');
		ul3 = false;
	}else{
		$( "#i1" ).html('-');
		ul3 = true;
	}
});
					
$( "#node_li" ).click(function() {
	$( "#node_ul" ).slideToggle(700);
	if(ul4){
		$( "#i4" ).html('+');
		ul4 = false;
	}else{
		$( "#i4" ).html('-');
		ul4 = true;
	}
});	
	
	
	
		function delete_item(id)
				{
					$("#"+id).hide();
					data='table_name=Product&field_name=Field&id='+id;
					$.ajax({
									type: "POST",				
									url: "delete_entery.php",
									data:data
									}).done(function( msg )
										{	
											//alert(msg);
										});
				}	
				function product_edit(id){
					$("#heading").html("Edit product");
					$("#blah").hide();
					$("#add_edit").val(1);					
					$("#myModal").show();
					$("#myModal").addClass('in');
					var $div = $('<div />').appendTo('body');
					$div.attr('class','modal-backdrop fade in');
					$.ajax({
						type: "GET",
						url: "edit.php",
						data: {d:id}
					})
					.done(function( msg ) {
						
						obj = JSON.parse(msg);
						$("#status").val(obj['active']);
						
						
						
						$("#field_id").val(obj['productid']);
						var str=obj['productid'];
						var pad = "000000";
						var ord="DBAP"+pad.substring(0, pad.length - str.length) + str;
						$("#p_ids").attr("disabled",false);
						$("#p_ids").val(ord);
						$("#p_ids").attr("disabled",true);
						
						$("#productlabel").val(obj['productlabel']);
						$("#productdescription").val(obj['productdescription']);
						$("#category_id").val(obj['productcategoryid']);
						
							
						var p_sub_id=obj['productsubcategoryid'];
						get_select_subcat(p_sub_id);					
						$("#unitofmeasure").val(obj['unitofmeasure']);
						$("#packquantity").val(obj['packquantity']);
											
						$("#skuupc").val(obj['skuupc']);
						$("#mfgskuupc").val(obj['mfgskuupc']);
						$("#casequantity").val(obj['casequantity']);
						$("#caseweight").val(obj['caseweight']);
						$("#casegtin").val(obj['casegtin']);
						
						if((obj['picture1']!='a')||(obj['picture1']!=''))
						{
							$("#blah").show();
							$('#blah').attr('src',"upload/"+obj['picture1']).width(70);
						}
						$("#palletquantity").val(obj['palletquantity']);
						$("#shelflife").val(obj['shelflife']);
						$("#suggestedretailshelflife").val(obj['suggestedretailshelflife']);
						
						$("#productmanufacturer").val(obj['productmanufacturer']);						
						get_brands(obj['brand']);
						var ids=obj['productid']+"$$productid$$productattributestable";
						
					$.ajax({
						type: "GET",
						url: "edit_attribute.php",
						data: {d:ids}
					})
					.done(function( msg ) {
						obj = JSON.parse(msg);
						
						if(obj.name.length!=0)
						{
							$("#add").html('');						
							for(i=0;i<obj.name.length;i++)
							{
								var id_new=add_attribute_new(i,obj);
								$("#attributetype"+id_new).val(obj.name[i]);
								$("#"+i).val(obj.attributeId[i]);
							}
						}
					});
					
					});
				}
			
				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();					
				}
				function add_new_function()
					{	
						$("#heading").html("Create Product");
						$("#blah").hide();
						$("#add_edit").val(0);
						var str=Math.floor((Math.random() * 1000) + 100);
						var pad = "000000";
						var ord="DBAP"+pad.substring(0, pad.length - str.length) + str;
						
						
						$(".select1 .chzn-single span").html('select');
						$(".select2 .chzn-single span").html('select');
						$(".select3 .chzn-single span").html('select');
						$(".select4 .chzn-single span").html('select');
						$(".select5 .chzn-single span").html('select');
						$(".select6 .chzn-single span").html('select');
						$(".chzn-drop").css('display','block');
						$("#all").trigger("reset");	
						$('#blah').attr('src',"#").width(70);
						$("#picture1").val("");
					}
				function checked_entries(id)
				{
						var index = checklist.indexOf(id);
						if(index==-1){
							var ide = {
								row:id
							}
							checklistjson.push(ide);
							checklist.push(id);
						}else{
							checklistjson.splice(index,1);
							checklist.splice(index,1);
						}
						//alert(checklist);
					}
					function deletentries(){
					
						var r = confirm("Are you sure you want to delete these entries ?");
						if (r == true) 
						{
							var str = JSON.stringify(checklistjson);
							//alert(str);
							$.ajax({
								type: "POST",
								url: "deactivate_check.php",
								data: {local:str, table:"productportfolio", column:"productid"}
							})
							.done(function( msg ){
							//	alert(msg);
							location.reload();
								
							});						
							
						}
					}
					
					function search_uniq(){
						var str = $("#partner_user_id").val();
						//alert(str);
						$.ajax({
							type: "GET",
							url: "search_partner.php",
							data: {term:str}
						})
						.done(function( msg ){
						//alert(msg);
							if(msg==1){
								$("#alreaytag").show();
								//document.getElementById("alsubmt").disabled = true;
							}else{
								$("#alreaytag").hide();
								//document.getElementById("alsubmt").disabled = false;
							}
						});
					}
					
					function get_subcat(){
						
						var cid=$("#category_id").val();
						
						$.ajax({
							type: "GET",
							url: "get_subcat.php",
							data: {id:cid}
						})
						.done(function( msg ) {
							$("#subcat_id").html(msg);
							
						});
					}
					function get_select_subcat(id){
						
						var cid=$("#category_id").val();
						
						$.ajax({
							type: "GET",
							url: "get_subcat.php",
							data: {id:cid}
						})
						.done(function( msg ) {
							$("#subcat_id").html(msg);
							$("#subcat_id").val(id);
						});
					}
					
					function get_brand(){
						var cid=$("#productmanufacturer").val();
						//alert(cid);
						$.ajax({
							type: "GET",
							url: "get_brand.php",
							data: {id:cid}
						})
						.done(function( msg ) {
						// alert(msg);
							$("#brand").html(msg);
						});
					}
					function get_brands(id){
						var cid=$("#productmanufacturer").val();
						
						//alert(cid);
						$.ajax({
							type: "GET",
							url: "get_brand.php",
							data: {id:cid}
						})
						.done(function( msg ) {	
							
							$("#brand").html(msg);
							$("#brand").val(id);
							
						});
					}
					
					function readURL(input) {
						$('#blah').show();
						if (input.files && input.files[0]) {
							var reader = new FileReader();

							reader.onload = function (e) {
								$('#blah')
									.attr('src', e.target.result)
									.width(70)
							};

							reader.readAsDataURL(input.files[0]);
						}
					}
					
					$('.checkall', oTable.fnGetNodes()).click(function () {
					
					});
					function check_all()
					{
						if(checkss==0)
						{
							checkss=1;							
							$($(".table").dataTable().fnGetNodes()).find('.check_box1').each(function ()
							{
									$this = $(this);
									$this.find(".checker span").addClass("checked");
									$this.find(".check_box").attr('checked', 'checked');
									
								
							});

							$($(".table").dataTable().fnGetNodes()).find(':checkbox').each(function () {
									$this = $(this);
									$this.attr('checked', 'checked');
									var id=$this.val();								
									var ide = {
									row:id
									}
								checklistjson.push(ide);
								checklist.push(id);	
								
							});
							
						}
						else
						 {
							$(".check_box").attr("checked",false);
							$(".checker span").removeClass();
							checkss=0;
							$($(".table").dataTable().fnGetNodes()).find('.check_box1').each(function ()
							{
								$this = $(this);
								$this.find(".checker span").removeClass();
								$this.find(".check_box").attr('checked',false);
							});
								checklistjson=[];
								checklist=[];
							
						}
					
									
					}
				</script>

<script>
	var selDiv = "";
		
	document.addEventListener("DOMContentLoaded", init, false);
	
	function init() {
		document.querySelector('#files').addEventListener('change', handleFileSelect, false);
		selDiv = document.querySelector("#selectedFiles");
	}
		
	function handleFileSelect(e) {
		
		if(!e.target.files || !window.FileReader) return;
		
		selDiv.innerHTML = "";
		
		var files = e.target.files;
		var filesArr = Array.prototype.slice.call(files);
		filesArr.forEach(function(f) {
			if(!f.type.match("image.*")) {
				return;
			}
	
			var reader = new FileReader();
			reader.onload = function (e) {
				var html = "<img src=\"" + e.target.result + "\">" + f.name + "<br clear=\"left\"/>";
				selDiv.innerHTML += html;				
			}
			reader.readAsDataURL(f); 
			
		});
		
		
	}
	$("#download_csv").on("click", function(e){
		download_csv_selected('productportfolio', checklist, 'product', 'submit', 'productid');
		// alert("dba_export_csv.php?type=productportfolio&list="+checklist+"&page_name=product&action=submit&type_nam=productid");
		//alert(checklist);
		// location.href="dba_export_csv.php?type=productportfolio&list="+checklist+"&page_name=product&action=submit&type_nam=productid";			
	});
	$("#download_csv_all").on("click", function(e){
		// alert("dba_export_csv.php?type=productportfolio&list="+checklist+"&page_name=product&action=submit&type_nam=productid");

		location.href="dba_export_csv.php?type=productportfolio&list=&page_name=product&action=submit&type_nam=productid";			
	});
	$("#upload_csv_btn").on("click", function(e){
		$("#upload_hover").empty();
		$("#upload_hover").css("display","block");
		$("#upload_hover").load("csv_upload_prdt.php");
	});
	$("#upload_csv_btn").on("click", function(e){
		$("#overlay").css("display","block");
		});

	
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e,id) 
		{
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById(id).style.display = ret ? "none" : "inline";
		
            return ret;
        }
		function IsNumeric1(e,id) 
		{
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 46 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById(id).style.display = ret ? "none" : "inline";
		
            return ret;
        }
		
		function count_charcter(e,id,val,req_val)
		{
			
			var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById(id).style.display = ret ? "none" : "inline";
			return ret;
			
		}

		function add_attribute()
		{
			 var x = Math.floor((Math.random() * 100) + 1);
			var div_str='<div class="hide'+x+'"><div class="control-group"><label class="control-label" >Attribute Type</label><div class="controls"><Select id="attributetype" name="attributetype[]" style="float:left;" required ><option value="">Select</option><option>Nutritional</option><option>Certificate Of Analysis(COA)</option><option>Allergen Information</option><option>Country of Origin</option><option>GMO Statement</option><option>Kosher</option></select><p style="padding: 4px;border: 1px solid #bbb;text-align:center;background: #0b840b;color: white;float: left;width: 30px;cursor:pointer" onclick="delete_attribute('+x+')">-</p></div></div><div class="control-group"><label class="control-label" >File</label><div class="controls"><input id="file1" type="file" name="file1[]" /></div></div></div>';
			$("#add").append(div_str);
				
		}
		
		function add_attribute_new(i,obj_g)
		{
			var filename=obj_g.attributepic[i]
			var x = Math.floor((Math.random() * 100) + 1);
			var download_url="http://antloc.com/dba/admin/upload/"+filename;
			if(i==0)
			{
				var div_str='<div class="hide'+x+'"><div class="control-group"><label class="control-label" >Attribute Type</label><div class="controls"><Select id="attributetype'+x+'" name="attributetype[]" style="float:left;" required ><option value="">Select</option><option>Nutritional</option><option>Certificate Of Analysis(COA)</option><option>Allergen Information</option><option>Country of Origin</option><option>GMO Statement</option><option>Kosher</option></select><p style="padding: 4px;border: 1px solid #bbb;text-align:center;background: #0b840b;color: white;float: left;width: 30px;cursor:pointer" onclick="add_attribute()">+</p></div></div><div class="control-group"><label class="control-label" >File</label><div class="controls"><input id="file1" type="file" name="file1[]" /> <a href="'+download_url+'" target="_blank">Download previous file</a></div></div></div><input type="hidden" id='+i+' name="'+i+'">';
			}
			else
			{
				var div_str='<div class="hide'+x+'"><div class="control-group"><label class="control-label" >Attribute Type</label><div class="controls"><Select id="attributetype'+x+'" name="attributetype[]" style="float:left;" required ><option value="">Select</option><option>Nutritional</option><option>Certificate Of Analysis(COA)</option><option>Allergen Information</option><option>Country of Origin</option><option>GMO Statement</option><option>Kosher</option></select><p style="padding: 4px;border: 1px solid #bbb;text-align:center;background: #0b840b;color: white;float: left;width: 30px;cursor:pointer" onclick="delete_attribute('+x+')">-</p></div></div><div class="control-group"><label class="control-label" >File</label><div class="controls"><input id="file1" type="file" name="file1[]" /><a href="'+download_url+'" target="_blank">Download previous file</a></div></div></div><input type="hidden" id='+i+' name="'+i+'">';
			}
			$("#add").append(div_str); 
			return x;				
		}
		
		function delete_attribute(id)
		{
			$(".hide"+id).remove();
		}
		
	</script>
