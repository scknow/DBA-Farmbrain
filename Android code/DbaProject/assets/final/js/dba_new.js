var products_list = new Array(); 
function loading(){
$.ajax({
		type: "GET",
		url: base_url+"get_product_and_price.php",
		data: {}
	}).
	.done(function( msg )
	{
		//alert(msg);
		obj = JSON.parse(msg);
		for(i=0;i<obj.length;i++)
		{
			var row = obj[i];
			var img_paht = "";
			if(row.picture1=='a' || row.picture1=="")
			{
				img_paht = "images/a.png";
			}
			else
			{
				img_paht = base_url2+"upload/"+row.picture1;
			}
			
			p_index.push(row.productid);
			products_list[row.productid]=new Array();
			products_list[row.productid]['product_data']['title']=row.productlabel;
			products_list[row.productid]['product_data']['description']=row.productdescription;
			products_list[row.productid]['product_data']['image']=img_paht;products_list[row.productid]['product_data']['weight']=row.caseweight;
		}
	});
}
//Stores all products data indexed by product_id
/*
products_list[product_id]
	.product_data
		.title
		.description 
		.image 
		.weight
		.
	.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.offinvoice 
		.priceincrease = true/false
*/


var suppliers_list = new Array(); //Stores all suppliers and their mov values indexed by supplier_id
/*
suppliers_list[supplier_id]
	.name
	.mov
	.tolerance
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


functions to be written

//Fetch all order profiles lists from the server 
function fetch_order_profiles_list()
{
	//Call the server API to get order profile names and the default order profile

	//Fetch and default order profile and load it into order list 

}


//Fetch product and pricing data 
function fetch_product_data()
{
	//Call server api to get all products data - TBD

	//run a loop and 
	for (ctr=0;ctr<row.length;ctr++)
		//insert into products_list array 
		//find out all pricing data for the product and place in the pricing data or the products list;
}

//Fetch suppliers list from server 
function fetch_suppliers_list()
{
	//Call the server api to get all supplier data - TBD

	//run a loop and insert into suppliers_list array 
}