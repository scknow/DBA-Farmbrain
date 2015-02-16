<div class="span2 main-menu-span">
	<div class="well nav-collapse sidebar-nav">
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li><a class="ajax-link" href="#"><i class="icon-eye-open"></i>
			<span class="hidden-tablet"> Master Data</span></a>
						<ul style='list-style:none;' style='padding-left:9px;' class='nav nav-tabs nav-stacked main-menu'>
							<?
							if(!isset($_SESSION['supplierid'])){
							?>
							<li><a id='product_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/product.png') !important"></i>					
							<span class="hidden-tablet">Product</span><i style='float: right; font-size: 19px;' id="i1">+</i></a>
								<ul style='list-style:none;margin:0;padding-left:4px; display:none' class='nav nav-tabs nav-stacked main-menu' id='product_ul'>
									<li><a class="ajax-link" href="create_edit_prod.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/product.png') !important" ></i><span class="hidden-tablet">Product</span></a></li>
									<li><a class="ajax-link" href="create_prod_cat.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/category.png') !important" ></i><span class="hidden-tablet">Category</span></a></li>
									<li><a class="ajax-link" href="create_prod_sub.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/subcategory.png') !important"></i><span class="hidden-tablet">Sub Category</span></a></li>
									<li><a class="ajax-link" href="manufact.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/manufacturer.png') !important"></i><span class="hidden-tablet">Manufacturer</span></a></li>
									<li><a class="ajax-link" href="brand.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/brand.png') !important"></i><span class="hidden-tablet">Brand</span></a></li>
								</ul>
							</li>
							
							<li><a id='customer_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/customer.png') !important"></i>					
							<span class="hidden-tablet">Customers</span><i style='float: right; font-size: 19px;' id="i2" >+</i></a>
								<ul style='list-style:none;margin:0;padding-left:4px; display:none' class='nav nav-tabs nav-stacked main-menu' id='customer_ul'>
									<li><a class="ajax-link" href="customer_reg_form.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/customer.png') !important"></i><span class="hidden-tablet">Customers</span></a></li>
									<li><a class="ajax-link" href="create_user.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/customeruser.png') !important"></i><span class="hidden-tablet">Customer Users</span></a></li>
									<li><a class="ajax-link" href="customer_group.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/customergroups.png') !important"></i><span class="hidden-tablet">Customer Group</span></a></li>
								</ul>
							</li>
							<?
							}
							?>
							
							<li><a id='supplier_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/suppliers.png') !important"></i>					
							<span class="hidden-tablet">Suppliers</span><i style='float: right; font-size: 19px;' id="i3" >+</i></a>
								<ul style='list-style:none;margin:0;padding-left:4px; display:none' class='nav nav-tabs nav-stacked main-menu' id='supplier_ul'>
									<li><a class="ajax-link" href="sup_reg.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/suppliers.png') !important"></i><span class="hidden-tablet">Supplier</span></a></li>
									<li><a class="ajax-link" href="create_sales_user.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/salesuser.png') !important"></i><span class="hidden-tablet">Supplier User</span></a></li>
									<li><a class="ajax-link" href="relation.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/customeruser.png') !important"></i><span class="hidden-tablet">Customer Relation</span></a></li>
									<li><a class="ajax-link" href="pricing.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/pricing.png') !important"></i><span class="hidden-tablet">Pricing</span></a></li>
									<li><a class="ajax-link" href="promotion.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open" style="background:url('icon/promotions.png') !important"></i><span class="hidden-tablet">Promotions</span></a></li>
									</li>
								</ul>
							</li>
							<?
							if(!isset($_SESSION['supplierid'])){
							?>
							<li><a class="ajax-link" href="#" id='node_li' style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-list-alt" style="background:url('icon/events.png') !important"></i>					
							<span class="hidden-tablet">Marketing</span><i style='float: right; font-size: 19px;' id="i4" >+</i></a>
							<ul style='list-style:none;margin:0;display:none;' class='nav nav-tabs nav-stacked main-menu' style='padding-left:15px;display:none' id='node_ul'>
								<li><a class="ajax-link" href="promotional_event.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Marketing</span></a></li>
							</ul></li>
							
							<li><a class="ajax-link" href="testing.php" id='' style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-list-alt" style="background:url('icon/global.png') !important"></i>					
							<span class="hidden-tablet">Order Profile</span><i style='float: right;font-weight: bold;font-size: 19px;'></i></a></li>
							
							<?
							}
							?>
							
				</ul>
			</li>
		</ul>			
	</div><!--/.well -->
</div><!--/span-->
