//Create Order screen DS
var products_list = new Array(); //Stores all products data indexed by product_id
/*
products_list[product_id]
	.product_data
		.title
		.description 
		.image 
		.weight
		.pack_quantity
		.case_quantity
		.unitofmeasure
	.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.valueinvoice
		.percentinvoice
		.minimum_quantity 
		.priceincrease = true/false
		.last_order_date
		.last_order_quantity
*/
var order_list = new Array(); //Stores present order list indexed by product_id
/*
order_list[product_id]
	.product_data
		.title
		.description 
		.image 
		.weight
		.pack_quantity
		.case_quantity
		.unitofmeasure
	.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.valueinvoice 
		.percentinvoice 
		.minimum_quantity 
		.priceincrease = true/false
		.last_order_date
		.last_order_quantity
	.moqioqflag = true/false
	.substitutes[product_id]
	.supplier_settings[supplier_id]
		.premium
		.name 
	.selected_supplier = -1/supplier_id
	.selectedprice
	.available_suppliers[supplierid]
	.quantity
*/
var global_supplier_settings = new Array(); //Stores global supplier settings indexed by supplier_id
/*
global_supplier_settings[supplier_id]
	.premium
	.name
*/
var suppliers_list = new Array(); //Stores all suppliers and their mov values indexed by supplier_id
/*
suppliers_list[supplier_id]
	.name
	.mov
	.tolerance
*/
var selected_suppliers_list = new Array(); //Store the selected suppliers and their total order values by supplier_id
/*
selected_suppliers_list[supplier_id]
	.totalvalue
	.color
*/


//Order review screen DS
var supplier_orders_list = new Array();  //Stores all finalized orders indexed by supplier_id
/*
supplier_orders_list[supplier_id]
	.products_list[product_id]
		.product_data 
			.title
			.description 
			.image
			.price
			.quantity
			.rebate
			.offinvoice
			.moqioqflag = false/true
	.totalvalue
	.color 0 - RED, 1 - YELLOW, 2 - GREEN
	.requested_delivery_date
	.ordered - false/true

*/
var default_order_profile_id;
var order_profiles_list = new Array();
/*
order_profiles_list[profile_id]
	.name
	.default
	.profile_id 
	.products_list[product_id]
		.quantity
		.supplier_settings[supplier_id]
			.premium
			.name 
*/
//Creates an onscreen notification 
function notification(msg)
{
	alert(msg); //TBD - add the navigator options here as well 
}

//Creates an onscreen ask notification
function ask_notification(msg)
{
	return confirm(msg); //TBD - add the navigator options here as well 
}

//Creates review order
function create_review_order()
{
	var zeroquantitytoggle = false; 
	//If MOQ and IOQ of any products is not matching alert and return 
	$.each(order_list, function (product_id, individual_product)
	{
		if (individual_product.quantity==0) zeroquantitytoggle = true;
		if (individual_product.moqioqflag)
		{
			notification ("MOQ and IOQ values for product " + individual_product.product_data.title + " is not matching");
			return;
		}
	});
	if (zeroquantitytoggle!=0) notification("Products with zero quantity will be dropped");
	//Empty the supplier_orders_list
	while(supplier_orders_list.length>0) { supplier_orders_list.pop(); }
	//Iterate through order_list and push into supplier order list page 
	$.each(order_list, function (product_id, individual_product)
	{
		supplier_id = individual_product.selected_supplier;
		if (supplier_id!=-1)
		{
			//Copy the value into the products list of the supplier order list 
			supplier_orders_list[supplier_id].products_list[product_id].product_data = $.extend({}, individual_product.product_data);
			supplier_orders_list[supplier_id].products_list[product_id].price = individual_product.selected_price;
			supplier_orders_list[supplier_id].products_list[product_id].quantity = individual_product.quantity;
			supplier_orders_list[supplier_id].products_list[product_id].moqioqflag = true;
			//Add the total for the supplier
			supplier_orders_list[supplier_id].totalvalue = supplier_orders_list[supplier_id].totalvalue + (individual_product.price * individual_product.quantity);
			supplier_orders_list[supplier_id].ordered = false;
		}
	});
	//Calculate the mov flags
	or_recalculate_mov_flag();
	//Draw the basic frame for - TBD 
	//Draw the order review screen 
	redraw_order_review();	
}

//Recalculate the mov flags 
function or_recalculate_mov_flag()
{
	//Check MOV validation and figure out colors 
	$.each(supplier_orders_list, function (supplier_id, order_details)
	{
		//Check if the total of the supplier wrt MOV and Tolerance 
		var mov = suppliers_list[supplier_id].mov;
		var tolerance = suppliers_list[supplier_id].tolerance;
		if (order_details.totalvalue>=mov) 
			supplier_orders_list[supplier_id].color = 2; //GREEN
		else if (order_details.totalvalue>=(mov*(1-(tolerance/100))))
			supplier_orders_list[supplier_id].color = 1; //YELLOW 
		else
			supplier_orders_list[supplier_id].color = 0; //RED

	});
}


//Change quantity function on order review page
function or_change_quantity(supplier_id, product_id, qty)
{
	supplier_orders_list[supplier_id].products_list[product_id].quantity = qty;
	var moq = order_list[product_id].pricing_list[supplier_id].moq;
	var ioq = order_list[product_id].pricing_list[supplier_id].ioq;
	if ((qty<moq)||((qty-moq)%ioq!=0)) 
	{
		supplier_orders_list[supplier_id].products_list[product_id].moqioqflag = false;
	}
	//Recalculate MOv flag 
	or_recalculate_mov_flag();
	//Redraw the order review screeen
	redraw_order_review();
}

//Delete product function on order review page 
function or_remove_product(supplier_id, product_id)
{
	//Reduce the product total from the supplier total 
	var total_to_be_deducted = supplier_orders_list[supplier_id].products_list[product_id].price * supplier_orders_list[supplier_id].products_list[product_id].quantity;
	supplier_orders_list[supplier_id].totalvalue = supplier_orders_list[supplier_id].totalvalue - total_to_be_deducted;
	//Remove the product from the list 
	var index = $.inArray(product_id, supplier_orders_list[supplier_id].products_list);
	if (index!=-1) supplier_orders_list[supplier_id].products_list.splice(index,1);
	//Recalculate the Mov flags 
	or_recalculate_mov_flag();
	//Redraw the order review screen
	redraw_order_review();
}

//Reshuffles products into other suppliers - TBD
function or_remove_supplier(supplier_id)
{
	//Find all products from this supplier

	//Make a temp order list with limited supplier settings options 

	//

}

//Submits the order for all the suppliers
function or_place_all_orders()
{
	//loop for each supplier and place order for only those suppliers which are not placed yet 
	$.each (supplier_orders_list, function (supplier_id, supplier_order_detail)
	{
		if (!supplier_order_detail.ordered)
		{
			//Place order for the supplier
			or_place_order(supplier_id);
		}
	});
}


//Submits the order for the supplier
function or_place_order(supplier_id)
{
	//Loop through each product and prepare JSON to be sent 

	//Set the ordered flag for the supplier

	//Ask for redraw

}

//Bring back changes from Order Review - TBD
function return_from_review_order()
{
	//Check if a particular supplier has been ordered already 
	$.each(supplier_orders_list, function (supplier_id, supplier_order_detail){
		//If ordered 
		if (supplier_orders_list[supplier_id].ordered)
		{
			//Drop all these products from the order_list
			$.each(supplier_orders_list[supplier_id].products_list, function(product_id, product_details)
			{
				delete order_list[product_id];
			});
		}
		else
		//if not ordered 
		{
			//Check quantity changes and products dropped and apply that order_list	
			$.each(supplier_orders_list[supplier_id].products_list, function(product_id, product_details)
			{
				
			});


		}		
		
	});
	//Recalculate selected suppliers
	recalculate_selected_suppliers();
}

//Draw the Order review screen - TBD
function redraw_order_review()
{
	//open the modal box if it is not visible already 
	//clear the html 
	//for each supplier prepare an HTML listing 
		//for each product under the supplier make a HTML listing 
}

//Init of create order - on launch 
function init_create_order()
{
	//Fetch product data and pricing data from server 
	fetch_product_data();
	//Fetch the suppliers list from server 
	fetch_suppliers_list();
	//Set zero values into global supplier settings
	init_global_supplier_settings();
	//Get the order profiles and load them too
	fetch_order_profiles_list();
	//Initialize the add product modal window
	init_add_product();
}

//Fetch all order profiles lists from the server - TBD
function fetch_order_profiles_list()
{
	//Call the server API to get order profile names and the default order profile

	//Fetch and default order profile and load it into order list 

}

//Save the order list into order profile on server - TBD
function save_order_profile(profile_id)
{
	if (profile_id === undefined)
	{
		//Save new 
	}
	else 
	{
		//Save into old profile_id

	}

}

//Fetch product and pricing data 
/*function fetch_product_data()
{
	//Call server api to get all products data - TBD

	//run a loop and 
	for (ctr=0;ctr<row.length;ctr++)
		//insert into products_list array 
		//find out all pricing data for the product and place in the pricing data or the products list;
}*/

function fetch_product_data()
{
	//Call server api to get all products data - TBD
	$.ajax({
		type: "GET",
		url: base_url+"get_product.php",
		data: {}
	})
	.done(function( msg )
	{	
		obj = JSON.parse(msg);
		//run a loop and
		//insert into products_list array 
		for(i=0;i<obj.length;i++)
		{
			var row = obj[i];
			var img_path = "";
			if(row.picture1=='a' || row.picture1=="")
				img_path = "images/a.png";
			else
				img_path = base_url2+"upload/"+row.picture1;
		
			var product_data_detail=new Array();
			
			var product_data_inside = 
				{
					title : row.productlabel,
					description : row.productdescription,
					image:img_paht,
					weight:row.caseweight, 

				};
/*				
			product_data_detail.push(product_data_inside);	
			var product_data_id=
			{
				
				product_data:product_data_detail
			};			
			products_list_test[row.productid].(product_data_id);
*/
			products_list[product_id].product_data = $.extend({}, product_data_inside);
		}
	});
	//find out all pricing data for the product and place in the pricing data or the products list;
	products_list[product_id].pricing_list[supplier_id] = $.extend({}, pricing_data_inside);
}

//Fetch suppliers list from server 
function fetch_suppliers_list()
{
	//Call the server api to get all supplier data - TBD

	//run a loop and insert into suppliers_list array 
}


//Add a product from products_list into order_list 
function add_product(product_id)
{
	//find the product id in the products_list 
	if (product_id in products_list)
	{
		//find the product id in the order_list 
		if (!(product_id in order_list))
		{
			//if not found insert into order_list from products_list 
			var temp_product = {};
			temp_product = $.extend({}, products_list[product_id]);
			temp_product.moqioqflag = false;
			temp_product.substitutes = new Array;
			//Copy global supplier settings 
			temp_product.supplier_settings = new Array();
			temp_product.selected_supplier = -1;
			temp_product.selected_price = 0;
			temp_product.quantity = 0;
			//Copy whatever is in the temp 
			order_list[product_id] = $.extend({},temp_product);
			//Copy global supplier settings
			order_list[product_id].supplier_settings = $.extent({},global_supplier_settings);			
			//Find recommended supplier
			find_recommended_supplier(product_id);
			//Recalculate the selected suppliers list
			recalculate_selected_suppliers();
			
		}
	}	
}

//Remove a product from order_list 
function remove_product(product_id)
{
	//find the product id in order_list
	if (product_id in order_list)
	{
		//if found then splice the order from 
		var index = $.inArray(product_id, order_list);
		order_list.splice(index,1);
		//Recalculate selected suppliers list 
		recalculate_selected_suppliers();
	}	
}

//Add or remove depending on whats present status
function toggle_product(product_id)
{
	if (product_id in order_list)
		remove_product(product_id);
	else
		add_product(product_id);
}

//Function init_add_product 
function init_add_product()
{
	$.each(products_list, function (product_id, product_details)
	{
		var productlabel = product_details.product_data.title;
		var productdescription = product_details.product_data.description;
		if (product_details.image!=""&&product_details.image!="a")
			img_str = base_url2+"upload/"+product_details.image;
		else 
			img_str = "images/a.png"; //Use default image 
		if (product_id in order_list) checked = " checked "; else checked = "";
		//Write the product box html 
		str = str + "<div class='pp-product pickpc'><div class='pp-product-selector'><input class='product_picker_check' id='product_picker_check_'"+product_id+"' type='checkbox' "+checked+" onclick=toggle_product('"+product_id+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_str+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+productlabel+"</div><div class='pp-product-description'>"+productdescription+"</div></div></div>";

	})
	$("#product_view1").html(str);
}

//Function to show the add product modal box
function show_add_product()
{
	//Unselect all products 
	$(".product_picker_check").prop('checked', false);
	//Update the products in the product picker 
	$.each(order_list, function (product_id, product_details)
	{
		$("#product_picker_check_"+product_id).prop('checked', true);
	});
	$('.overlay').fadeIn(100); 
	$('#product_picker').fadeIn(100); 	
}
//Function to hide add product modal box
function hide_add_product()
{
	//hide the modal box 
	$('.overlay').hide(); 
	$('#product_picker').hide(); 	
	//Redraw the screen 
	redraw_order_list();
}

//Initialize the global supplier settings 
function init_global_supplier_settings()
{
	//for each supplier 
	$.each(suppliers_list, function (key, value)
	{
		global_supplier_settings[key].premium = 0;
		global_supplier_settings[key].name = suppliers_list[key].name;
	});

}

//Open global supplier panel
function show_global_supplier_settings()
{
	//Check if order list is empty 
	if (order_list.length>0)
	{	
		if (!ask_notification("Changing global supplier settings will change individual product supplier settings. Are you sure you want to proceed?"))
			return;
	}
	//Draw the global supplier settings page 
	//Draw the items on the page as per global settings values 
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		var supplier_name = supplier_details.name;
		var checked = "";
		var premium = 0;
		//Check if this global 
		if (supplier_id in global_supplier_settings) 
		{
			checked = " checked ";
			premium = global_supplier_settings[supplier_id].premium;
		}
		//Write the HTML
		str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='glob_"+supplier_id+"' "+checked+" /></div><div class='ss-supplier-label'>"+supplier_name+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+premium+"' id='gprem"+supplier_id+"' /> %</div></div>";

	});
	//Include the HTML into basic frame
	$("#sup_list_view_global").html(str);		
	//make things visible
	$('.overlay').fadeIn(100); 
	$('#setng_supplier_global').fadeIn(100);

}

//Hides the global supplier settings panel
function hide_global_supplier_settings()
{
	//Empty the html 
	$("#sup_list_view_global").html("");
	//Hide the modal box 
	$('.overlay').hide(); 
	$('#setng_supplier_global').hide();
	//Nothing else to be done 
}


//Apply a new global supplier settings
function change_global_supplier_settings()
{
	//Empty the global supplier settings array 
	while (global_supplier_settings.length>0){global_supplier_settings.pop();}
	//For each supplier - get the check mark, supplierid and premium values
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		var divname = "glob_"+supplier_id;
		if ($("#"+divname).prop("checked"))
		{
			global_supplier_settings[supplier_id].name = suppliers_list[supplier_id].name;
			global_supplier_settings[supplier_id].premium = $("#gprem"+supplier_id).val();
		}
	});
	//For each product 
	$.each(order_list, function (product_id, product_details)
	{
		//Empty the supplier settings of the product 
		while (order_list[product_id].supplier_settings.length>0){order_list[product_id].supplier_settings.pop();}
		//copy the global supplier settings into order_list product supplier settings
		order_list[product_id].supplier_settings = $.extend({}, global_supplier_settings);
		//reevaluate the recommeded supplier 
		find_recommended_supplier(product_id);
		
	});
	//Recalculate selected suppliers
	recalculate_selected_suppliers();
	//Hide the global supplier settings modal
	hide_global_supplier_settings();
	//Redraw the order list 
	redraw_order_list();	

}

//Open global supplier panel
function show_product_supplier_settings(product_id)
{
	//Draw the items on the page as per global settings values 
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		var supplier_name = supplier_details.name;
		var checked = "";
		var premium = 0;
		//Check if this global 
		if (supplier_id in order_list[product_id].supplier_settings) 
		{
			checked = " checked ";
			premium = order_list[product_id].supplier_settings[supplier_id].premium;
		}
		//Write the HTML
		str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='supsettings_"+supplier_id+"_"+product_id+"' "+checked+" /></div><div class='ss-supplier-label'>"+supplier_name+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+premium+"' id='supsetting_premium_"+supplier_id+"_"+product_id+"' /> %</div></div>";

	});
	//Include the HTML into basic frame
	$("#sup_list_view_global").html(str);		
	//make things visible
	$('.overlay').fadeIn(100); 
	$('#setng_supplier_global').fadeIn(100);

}

//Hides the global supplier settings panel
function hide_product_supplier_settings()
{
	//Empty the html 
	$("#sup_list_view_global").html("");
	//Hide the modal box 
	$('.overlay').hide(); 
	$('#setng_supplier_global').hide();
	//Nothing else to be done 
}

//Function to show a dialog with product substitutes
function show_product_substitutes(product_id)
{
	var substitute_html = "";
	//For each product go throuhg and create the HTML
	$.each(products_list, function(product_id, product_details)
	{
		var img_str = product_details.product_data.image;
		var productlabel = product_details.product_data.title;
		var checked = "";
		var padding = "000000" ;
		var padded_product_id = "DBAP" + padding.substring(0, 6 - product_id.length) + product_id;
		var productdescription = product_details.product_data.description;
		if (product_id in order_list[product_id].substitutes) checked = " checked ";
		//Add the HTML of this product 
		substitute_html = substitute_html + "<div class='pp-product'><div class='pp-product-selector'><input id='"+product_id+"' type='checkbox' "+checked+" /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_str
					+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"
					+productlabel+"</div><div class='pp-product-description'>Product ID-"
					+padded_product_id+" - "+productdescription+"</div></div></div>";
		//Select only those products which are in the substitutes list of the product in order list 
	});
	//copy html into the modal
	$("#product_view2").html(kpr);
	//Show the modal box 
	$('.overlay').fadeIn(100); 
	$('#product_picker2').fadeIn(100);
}

//Function to hide a dialog with product substitutes
function hide_product_substitutes()
{
	//Hide the substitute modal 
	$("#product_view2").html("");
	$('.overlay').hide(); 
	$('#product_picker2').hide();
}

//Change the product substitutes
//This function is called on the top tick of substitutes modal box 
function change_product_substitutes(product_id)
{
	//Empty the products substitutes for this product 
	while (order_list[product_id].substitutes.length>0) {order_list[product_id].substitutes.pop();}
	//iterate through HTML and find products which are checked 
	$("#product_view2 input[type=checkbox]").each(function() {
    	if ($(this).prop('checked'))
    	{
    		var substitute_product = $(this).prop('id');
    		order_list[product_id].substitutes[substitute_product] = true;
    	}
	});
	//hide the products substitutes modal 
	hide_product_substitutes();

}

//Function which redraws the order list page - TBD - WIP
function redraw_order_list()
{
	//Find out selected suppliers list 
	recalculate_selected_suppliers();
	var html_str = "";
	//Iterate through each product 
	$.each(order_list, function(product_id, product_details)
	{
		var padding = "000000" ;
		var padded_product_id = "DBAP" + padding.substring(0, 6 - product_id.length) + product_id;
		var img_str;
		var productlabel = product_details.product_data.title;
		var productquantity = product_details.product_data.quantity;
		var productpackquantity = product_details.product_data.pack_quantity;
		var productunitofmeasure = product_details.product_data.unitofmeasure;
		var productselectedprice = product_details.selected_price;
		var productselectedsupplier = product_details.selected_supplier;
		var productselectedsuppliername = suppliers_list[productselectedsupplier].name;
		var product_category = product_details.category;
		var product_sub_category = product_details.subcategory;
		var product_last_order_date = product_details.pricing_list[productselectedsupplier].last_order_date;
		var product_last_order_qty = product_details.pricing_list[productselectedsupplier].last_order_quantity;
		var productioq = product_details.pricing_list[productselectedsupplier].ioq;
		var productmoq = product_details.pricing_list[productselectedsupplier].moq;
		var productcasequantity = product_details.product_data.case_quantity;

		
		if (product_details.product_data.image==""||product_details.product_data.image=="a")
			img_str = "images/a.png";
		else
			img_str = base_url2+"upload/"+product_details.product_data.image;

		var qty_border = "";
		if (product_details.moqioqflag)
			qty_border=" style='border:1px solid #ff0000' "; //color to be changed - TBD

		//Go through offers - TBD

		/*str = str + "<tr class='co_contain_tr' ><td class='one' ><p onclick=togle_lower('"+product_id+"')>"+productlabel+"<b>"+productpackquantity+productunitofmeasure+"</b></p> <div class='drop-1' >$"+productselectedprice+"<br />";
		if(productselectedprice==0)
		{
			var percentinvoice = products_list[product_id].pricing_list[product_details.selected_supplier].percentinvoice;
			var offinvoice = products_list[product_id].pricing_list[product_details.selected_supplier].offinvoice;
			var minqty = products_list[product_id].pricing_list[product_details.selected_supplier].minimum_quantity;
			if(percentinvoice!=0){
				str = str + "<p>"+percentinvoice+"% on minimum qty "+minqty+"</p>";
			}else if(offinvoice!=0){
				str = str + "<p>"+offinvoice+" value off on minimum qty "+minqty+"</p>";
			}
		}*/

		//Supplier selector HTML
		if (productselectedsupplier!=-1) 
		{
			pricing_html = '<div class="drop-1">$'+productselectedprice+'<br><center onclick="show_supplier_selector(\"'+product_id+'\"")">'+productselectedsuppliername+'</center><img class="drop1" src="images/drop.png"onclick="show_supplier_selector(\"'+product_id+'\"")"><div class="open-info-main1" id="supplier_selector_dropdown_'+product_id+'" style="display: none;">';
			$.each(order_list[product_id].pricing_list, function (supplier_id, pricing_details)
			{
				if (supplier_id in order_list[product_id].available_suppliers_list)	
				{
					var available_suppliername = suppliers_list[supplier_id].name;
					var available_supplierprice = products_list[product_id].pricing_list[supplier_id].price;
					pricing_html = pricing_html + '<li onclick="change_supplier(\"'+product_id+'\",\"'+supplier_id+'\")>$'+available_supplierprice+' '+available_suppliername+'</li>'; //TBD
				}
			});
			pricing_html = pricing_html + '</div></div>';
		}
		else
		{
			pricing_html = '<div class="drop-1"><br><center style="color:red">No Supplier</center><img class="drop1" src="images/drop.png"><div class="open-info-main1" style="display: none;"></div></div>';
		}
		
		//Quantity and Deletion HTML 
		quantity_html = '<td class="large-width"><span onclick="change_product_quantity(\"'+product_id'\",\"'+(parsetInt(productquantity)+1)+'\"")">+</span><input type="number" '+qty_border+' onclick="this.select();" value="'+parsetInt(this.value)+'" onchange="change_product_quantity(\"'+product_id'\",\"'+parsetInt(this.value)+'\"")"><span onclick="change_product_quantity(\"'+product_id'\",\"'+(parsetInt(this.value)-1)+'\"")">-</span></td><td class="small-width"><u><img src="images/delete.png" onclick="remove_product(\"'+product_id+'\")"></u></td>';
		

		html_str = html_str + '<tr class="co_contain_tr"><td class="one" onclick="togle_lower(\"'+product_id+'\"")"><p>'+productlabel+'<b>'+productunitofmeasure+'</b></p>' 
					+ pricing_html + '<div class="more"><h1></h1></div></td>'
					+ quantity_html + '</tr>"';

		var substitute_html="<div class='substitutes'><div class='addsubstitute' onclick='show_product_substitutes("+product_id+")'>Add/Edit Substitute</div><div class='substitute_list'>";
		//Iterate through each substitute already added 
		$.each(order_list[product_id].substitutes, function(substitute_id, substitute_details)
		{
			substitute_html = substitute_html + "<div class='substitute'><div class='substitute_product'>"+products_list[substitute_id].product_data.title+"</div></div>";
		});
		substitute_html = substitute_html + "</div></div>";

		html_str = html_str + '<tr class="open-info" id="lower2" style="display: table-row;"><td><div class="left"><img style="width:30%" src="'+img_str
					+'"></div><div class="right"><p></p><h4><b>Product ID:</b>'+padded_product_id+'</h4><br><h4><b>Category:</b>'+product_category
					+'</h4><br><h4><b>unit measure:</b>'+productunitofmeasure+'</h4><br><h4><b>Case Quantity:</b>'+productcasequantity
					+'</h4><br><h4><b>Case wt</b></h4><h4><b>Pack Qty</b>'+productpackquantity+'</h4><br><h4><b>Minimum Order Qty:</b>'+productmoq
					+'</h4><br><h4><b>Incremental Order Qty:</b>'+productioq+'</h4><br><h4><b>Last Order Qty:</b> '+product_last_order_qty
					+'</h4><br><h4><b>Last Order Date:</b> '+product_last_order_date+'</h4><br></div></td>'
					+'<td><a href="#" onclick="">Supplier Settings</a><a href="#" onclick="show_product_supplier_settings(\"'+product_id+'\")">Substitutes </a>'+substitute_html+'</td></tr>';
	});
	//Draw the base line with coloring as per MOV and Tolerance 
	var footer_html = "";
	//Get the total number of suppliers 
	var supplier_count = selected_suppliers_list.length();
	$.each (selected_suppliers_list, function(supplier_id, supplier_details)
	{
		var color;
		if (supplier_details.color==0) 
			color =  "style='border-top: 3px solid rgb(206, 0, 0);'"
		else if (supplier_details.color==1)
			color =  "style='border-top: 3px solid rgb(206, 0, 0);'" //TBD - Yellow color 
		else 
			color =  "style='border-top: 3px solid rgb(105, 172, 53);'";
		//Make the box div 
		footer_html = footer_html + "<li id='footer"+supplier_id+"' "+color+"   onclick=place_supplier('"+sup_obj[supindxof].supplierid+"')>"+sup_obj[supindxof].businessname+"</li>";
	});

	//Depending on count of suppliers change the width classes  
	if(supplier_count==1){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down');
	}
	else if(supplier_count==2){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down4');
	}else if(supplier_count>2){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down2');
	}
	$("#lis_div").html(html_str);
	$("#footer_down").html(footer_html);

}

//Function to show supplier selector - TBD
function show_supplier_selector(product_id)
{


}
//Function to hide supplier selector - TBD
function hide_supplier_selector(product_id)
{

}

//Apply product supplier settings
function change_product_supplier_settings(product_id)
{
	//get information from checkmark and supplier id and premium values from HTML
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		var supplier_checkbox = "supsettings_"+supplier_id+"_"+product_id;
		var premium_input_name = "supsetting_premium_"+supplier_id+"_"+product_id;
		if ($("#"+supplier_checkbox).prop("checked"))
		{
			order_list[product_id].supplier_settings[supplier_id].name = suppliers_list[supplier_id].name;
			order_list[product_id].supplier_settings[supplier_id].premium = $("#"+premium_input_name).val();
		}
	});	
}

//Calculates the the most suitable supplier for the product_id within the order_list
function find_recommended_supplier(product_id)
{
	find_available_suppliers(product_id);
	//if available_suppliers are zero show no suppliers and put -1 in selected supplier 
	if (order_list[product_id].available_suppliers.length==0)
	{
		order_list[product_id].selected_supplier = -1;
		order_list[product_id].selected_price = 0;
		return;
	}
	var temp_supplier_pricing = new Array();
	var minimum_price = 10000000;
	//Create a temp list of supplier ids and prices (with premium adjustment) of available suppliers
	$.each(order_list[product_id].available_suppliers, function(supplier_id, value)
	{
		temp_supplier_pricing[supplier_id] = order_list[product_id].pricing_list[supplier_id].price * (1-(order_list[product_id].supplier_settings[supplier_id].premium/100));
		if (temp_supplier_pricing[supplier_id]<minimum_price) minimum_price = temp_supplier_pricing[supplier_id];
	});
	recommended_supplier_id = temp_supplier_pricing.indexOf(minimum_price);
	change_supplier(product_id, recommended_supplier_id);
}

//Filter available suppliers based on supplier settings of the product 
function find_available_suppliers(product_id)
{
	//iterate through available suppliers and prices and put filtered ones into a available list in the order_list 
	//Empty the available suppliers list 
	while(order_list[product_id].available_suppliers.length>0) order_list[product_id].available_suppliers.pop();
	//Iterate through all Suppliers 
	for (var supplier_id in products_list[product_id].pricing_list)
	{
		supplier_id = order_list[product_id].pricing_list[ctr].supplierid;
		if (supplier_id in order_list[product_id].supplier_settings)
			order_list[product_id].available_suppliers[supplier_id] = true;
	}
}

//Change the product qty - State saving
function change_product_quantity(product_id, qty)
{
	//Save new quantity into the product in order_list 
	if (product_id in order_list)
	{
		order_list[product_id].quantity = qty;
		recalculate_moqioq_flag(product_id);
		//Highlight the box - TBD
	}
}

//Change the supplier - Redraws
function change_supplier(product_id, supplier_id)
{
	//Check if product_id is in the order_list 
	if (product_id in order_list)
	{
		//see if supplier_id is in available_suppliers_list 
		if (supplier_id in order_list[product_id].available_suppliers)
		{
			//change the selected supplier 
			order_list[product_id].selected_supplier = supplier_id;
			order_list[product_id].selected_price = order_list[product_id].pricing_list[supplier_id].price;
			//Recaluclate MOQ/IOQ validation as per present selected Supplier
			recalculate_moqioq_flag(product_id);
			recalculate_selected_suppliers();
			redraw_order_list();
		}
	}
}

//Recalculate the MOQ/IOQ flag for the product - State saving
function recalculate_moqioq_flag(product_id)
{
	var selected_supplier =order_list[product_id].selected_supplier;
	//if no supplier is selected return 
	if (selected_supplier == -1) return;
	//get supplier moq, ioq
	var moq = order_list[product_id].pricing_list[supplier_id].moq;
	var ioq = order_list[product_id].pricing_list[supplier_id].ioq;
	var product_qty = order_list[product_id].quantity;
	if ((product_qty<moq)||((product_qty-moq)%ioq!=0)
		order_list[product_id].moqioqflag = false;		
	else 
		order_list[product_id].moqioqflag = true;		
	//redraw - TBD
}

//Find all the suppliers which are being used in the present order list - State saving
function recalculate_selected_suppliers()
{
	//Empty present selected_suppliers_list 
	while (selected_suppliers_list.length>0) {selected_suppliers_list.pop();}
	//Iterate all products in order_list 
	$.each(order_list, function(product_id, individual_product)
	{
		//Find the supplier id for this product 
		supplier_id = individual_product.selected_supplier;
		//If supplier is selected 
		if (supplier_id!=-1)
		{
			//If selected_supplier_list contains then sum else initialize 
			if (supplier_id in selected_suppliers_list) 
				selected_suppliers_list[supplier_id].total = selected_suppliers_list[supplier_id].total + (individual_product.quantity * individual_product.selected_price);
			else
				selected_suppliers_list[supplier_id].total = individual_product.quantity * individual_product.selected_price;
		}

	});
	$.each(selected_suppliers_list, function(supplier_id, supplier_details)
	{
		//Based on total and MOV and Tolerance set the colors 
		var mov = suppliers_list[supplier_id].mov;
		var tolerance = suppliers_list[supplier_id].tolerance;
		var total = suppliers_list[supplier_id].total;
		if (total>=mov) 
			selected_suppliers_list[supplier_id].color = 2; //GREEN
		else if (total>=(mov*(1-(tolerance/100))))
			selected_suppliers_list[supplier_id].color = 1; //YELLOW 
		else
			selected_suppliers_list[supplier_id].color = 0; //RED
	});
}