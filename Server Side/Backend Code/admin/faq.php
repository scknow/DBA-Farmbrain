<? 
	include "connection.php";	
	// if(isset($_REQUEST['add_price']))
	// {
		// $arg='file';
		// //print_r($_FILES['file']);
		// $temp = explode(".", $_FILES[$arg]["name"]);
		// $allowedExts = array("gif", "jpeg", "jpg", "png");		
		// $extension = end($temp);
		// if ((($_FILES[$arg]["type"] == "image/gif")
		// || ($_FILES[$arg]["type"] == "image/jpeg")
		// || ($_FILES[$arg]["type"] == "image/jpg")		
		// || ($_FILES[$arg]["type"] == "image/png"))
		// && ($_FILES[$arg]["size"] < 600000)
		// && in_array($extension, $allowedExts)) {
		  // if ($_FILES[$arg]["error"] > 0) {
			// echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  // } 
		  // else
		  // {			
			// $image_name=rand(1,100000);
			// $image_name_new=$arg."_".$image_name.".".$extension;			
			// if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  // echo $_FILES[$arg]["name"] . " already exists. ";
			// } 
			// else 
			// {
			  // move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);	
				// //echo "in";
			// }
		  // }
		// }
		
		// $name="upload/".$image_name_new;
		// @session_start();
		// $ClientIDs = $_SESSION['cid'];
		// mysql_query("update Client set logo='$name' where ClientID='$ClientIDs'");
	// }
	include "header.php";
	
	
?>
			
			<!-- left menu starts -->
			<div class="span2 main-menu-span" style='display:none;'>
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a class="ajax-link" href="ui.html"><i class="icon-eye-open"></i>						
						<span class="hidden-tablet"> Application Setting</span></a>
						<ul style='list-style:none;' style='padding-left:9px;' class='nav nav-tabs nav-stacked main-menu'>
							<li><a class="ajax-link" href="#" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Change Logo</span></a></li>
							<li><a id='product_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Change theme</span></a>
							</li>							
							
							
						</ul>
						</li>
						
						</ul>
						
				</div><!--/.well -->
			</div><!--/span-->
			
			<!-- left menu ends -->
			<div id="content" class="span10" style='width: 100%;'>
			<!-- content starts -->			
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="help_mail.php">Help & Support</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">FAQ</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable" style='width:72%;margin: 0 auto;'>		
				<div class="box span12" style='width:100%;min-height:219px;overflow:hidden;float:left'>				
				<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>FAQ</h2>
				</div>
					<div class="box-content">					
						
						
					</div>
				</div>	
				
				
				<!--
				<div class="well" data-original-title style='width:10%;float:left;margin-right: 10px;'>
						<a href='nodeType_field_master.php'>Node Type</a>						
				</div>
				</div>-->
			
			</div><!--/row-->		
		<!-- content ends -->
		</div><!--/#content.span10-->
	
	</div><!--/fluid-row-->
	
	<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">close</button>
				<h3>Update Logo</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					
						  <fieldset>							
							<div class="control-group select1">							
							<label class="control-label" for="inputError">Choose new logo</label>
							<div class="controls"> 
								<input type='file' name='file' id='file' required>
							</div>
							</div>
							
							
						  <input type='hidden' name='add_edit' id='add_edit' value='0'/>
						  <input type='hidden' name='field_id' id='field_id' value='0'/>
						  </fieldset>
						
						</div>
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<input type='submit' value='Submit' name='add_price' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
			</div>
			</form> 
		</div>

	
	
	
		<? include "footer.php"?>
		