<? 
	//retrieve session data
	include "connection.php";	
	include "header.php";
?>
	<style>
		body{
			overflow-x:hidden;
		}
	</style>
			
			
			<!-- left menu ends -->
			<div id="content" class="span10" style='width: 100%;'>
			<!-- content starts -->			
			
			<div class="row-fluid sortable" style="margin:0 auto;width: 74%;">		
				<div class="box span12" style='width:50%;height:250px;overflow-y:scroll;float:left'>
				<div class="box-header well" data-original-title>
						<h2>User Management</h2>						
				</div>
				<?php if(isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] == 1){ ?>
					<div class="box-header well" data-original-title>
						<center><a href="customer_reg_form.php?add=1" class="btn btn-setting btn-info" onclick='redirect("customer_reg_form.php?add=1")'  style='height: 19px;width: 150px;'><i class="icon-cog"></i> Add Customer</a></center>
					</div>
					<div class="box-header well" data-original-title>
						<center><a href="create_user.php?add=1" onclick='redirect("create_user.php?add=1")'  class="btn btn-setting btn-info"  style='height: 19px;width: 150px;'><i class="icon-cog"></i> Add Customer user</a></center>
					</div>	
					<div class="box-header well" data-original-title>
						<center><a href="sup_reg.php?add=1" onclick='redirect("sup_reg.php?add=1")'  class="btn btn-setting btn-info"  style='height: 19px;width: 150px;'><i class="icon-cog"></i> Add Supplier</a></center>
					</div>
					<div class="box-header well" data-original-title>
						<center><a href="create_sales_user.php?add=1" onclick='redirect("create_sales_user.php?add=1")' class="btn btn-setting btn-info"  style='height: 19px;width: 150px;'><i class="icon-cog"></i> Add Sales user</a></center>
					</div>
				<?php } ?>	
				<div class="box-content exit_user" style='display:none;'>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Select</th>
								  <th>Partner Id</th>
								  <th>User Id</th>
								  <th style='display:none'>Name</th>
							  </tr>
						  </thead>   
						  <tbody>
						  
							
					  </table> 
						<button class='btn' onclick="deletentries()">Delete Selected</button>
					</div>
				</div><!--/span-->	
				
				<div class="box span12" style='width:42%;height:250px;overflow:hidden;float:left'>
				<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Configuration</h2>						
				</div>
				<div class="box-content">
				<div style="background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(0,0,0,0.1) 100%);" class="well" data-original-title>
					<center><a href="application_settings.php" class="btn btn-info" onclick='redirect("application_settings.php")' style='height: 19px;width: 150px;'><i class="icon-cog"></i>Application settings</a></center>
				</div>
				
				</div>
					
				</div><!--/span-->	
				
				<div class="box span12" style='width:50%;height:210px;overflow:hidden;float:left;margin-left: 0;'>
				<div  class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>System Performance</h2>						
				</div>
				<div class="box-content">
				<div style="background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(0,0,0,0.1) 100%);" class="well" data-original-title>
					<center>
						<?php $row= mysql_query('SELECT table_schema dbadev,Round(Sum(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM   information_schema.tables 
					GROUP  BY table_schema'); 
					$count=mysql_fetch_array($row);
					echo "<b>Total Memory Consumption </b><p style='font-size:34px;margin-top:6px'>".$count['DB Size in MB']." MB</p>";
			?>
					</center>
					<center><a href="#" class="btn btn-info" style='height: 19px;width: 150px;margin-top: 18px;'><i class="icon-cog"></i>Usage statistics</a></center>
				</div>
				
				</div>
					
				</div><!--/span-->
				
				<div class="box span12" style='width:42%;height:210px;overflow:hidden;float:left'>
				
				<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Help and Support</h2>						
				</div>
				<div class="box-header well" data-original-title>
					<center><a href="help_mail.php" class="btn btn-setting btn-info" onclick='redirect("help_mail.php")' style='height: 19px;width: 150px;'><i class="icon-cog"></i> Help and Support</i></a></center>
				</div>
					
				</div><!--/span-->	
				
			</div><!--/row-->		
		<!-- content ends -->
		</div><!--/#content.span10-->
	
	</div><!--/fluid-row-->

	
		<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
		<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">	
		
		<? include "footer.php"?>		
	
		
<script>
	function redirect(url)
	{
		// alert(url);
		window.location.assign("http://antloc.com/dba/admin/"+url)
	}
				
</script>
			
