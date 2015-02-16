<?php
include "header.php";
	
?>
			
			<!-- left menu starts -->
			<!-- left menu starts -->
<?
include "menu.php";
?>
			
			<!-- left menu ends -->
			<div id="content" class="span10" style='width: 82%;background: url("images/background.jpg");min-height: 600px;float: left; background-repeat: no-repeat; background-size: 100% 100%;'>
			<!-- content starts -->		
					<ul class="dul_goo" >
					<?php if(isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] == 1){ ?>
						<li><a class='btn btn-setting btn-info' onclick='redirect("sup_reg.php")' href="#"><p>Supplier</p></a></li>
						<li><a class='btn btn-setting btn-info' onclick='redirect("customer_reg_form.php")' href=""><p>Customer</p></a></li>
						<li><a class='btn btn-setting btn-info' href="#" onclick='redirect("create_edit_prod.php")' ><p>Product</p></a></li>
						<li><a class='btn btn-setting btn-info' onclick='redirect("pricing.php")' href="#"><p>Pricing</p></a></li>
					<?php } ?>
					</ul>
				
		<!-- content ends -->
		</div><!--/#content.span10-->
				



<?php	
	include "footer.php";
	
?>
		<script>
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;

	
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

$("#stng").click(function() {
	$( "#one" ).slideToggle(700);
});

function redirect(url)
{
	window.location.assign("http://antloc.com/dba/admin/"+url)
}
			</script>