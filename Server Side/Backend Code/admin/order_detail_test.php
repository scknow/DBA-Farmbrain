<?
session_start();
include "connection.php";
$id = $_POST['d'];
$dateprice = $_POST['priceondate'];
$sql = "SELECT * FROM `orderdetail` WHERE orderid='$id'";
$result = mysql_query($sql);
// $tot_count = 0;
while($val = mysql_fetch_array($result))
{
$subtitue_product=$val['substituteproductids'];
$pro_array=explode(",",$subtitue_product);
$name_product=get_product_name($val['productid']);
$qty=$val['quantity'];
$listed_price=$val['listedprice']*$qty;
$confirm_status=$val['confirmedstatus'];
$receivedquantity=$val['receivedquantity'];


$line_item_num=$val['orderdetailid'];

$str.="<tr><td>".$line_item_num."</td><td>".$name_product['productlabel']."</td><td>".$qty."</td>";
$str.="<td><select onchange='update_confirm_price()' name='subs_id' id='price_val'><option value='-1'>All</option>";

$header='<thead><tr><th Style="width:5%">Line item #</th><th>Product</th><th>Qty Requested</th><th>Substitute product</th><th>Confirmed Qty</th><th>Amount</th><th>Unit price</th><th>Confirmed Status</th></tr></thead>';

for($i=0;$i<sizeof($pro_array);$i++)
{
	
	$val1=get_product_name($pro_array[$i]);
	$id=$pro_array[$i];
	$price_get=get_product_price($id,$dateprice);
	$string=$pro_array[$i]."%%%".$price_get;
	
	$str.="<option value=".$string.">".$val1['productlabel']."</option>";
}
	if($receivedquantity!='0')
	{
		$d_od=$val['orderdetailid'];
		$sqlss=mysql_query("select * from orderdetailfeedback where orderdetailid='$d_od'");
		if(mysql_num_rows($sqlss)!=0)
		{
			$rowss=mysql_fetch_assoc($sqlss);		
			$damaga_pic='http://antloc.com/dba/webservices/uploads/'.$rowss['pic'];
			$str.="</td><td><input type='text' id='qty' name='cqty".$val['orderdetailid']."' style='height: 28px;' value=".$receivedquantity." disabled></td><td><input type='text' id='price' name='cprrce' value='$".format_change($listed_price*$receivedquantity)."'  style='height: 28px;' disabled></td><td><input type='text' id='price' name='cprrce' value='$".format_change($listed_price)."'  style='height: 28px;' disabled></td><td><select name='confrm_Status' id='confrm_Status' disabled><option value='0'>Pending</option><option value='1' >Confirmed</option><option value='2' selected>Received</option></select></td><td><input id='order_pid' name='order_pid' type='hidden' value='".$val['orderdetailid']."' /><ul class='thumbnails gallery'><li id='image-1' class='thumbnail'><a style='background:url(".$damaga_pic.")' title='".$rowss['message']."' href='".$damaga_pic."' class='cboxElement'><img src='".$damaga_pic."' alt=''></a></li></ul></td></tr></select>";
		}
		else
		{
			$str.="</td><td><input type='text' id='qty' name='cqty".$val['orderdetailid']."' style='height: 28px;' value=".$receivedquantity."></td><td><input type='text' id='price' name='cprrce' value='".format_change($listed_price*$receivedquantity)."'  style='height: 28px;'></td><td><input type='text' id='price' name='cprrce' value='$".format_change($listed_price)."'  style='height: 28px;' disabled></td><td><select name='confrm_Status' id='confrm_Status'><option value='0'>Pending</option><option value='1' >Confirmed</option><option value='2' selected>Received</option></select></td><td><input id='order_pid' name='order_pid' type='hidden' value='".$val['orderdetailid']."' /></td></tr></select>";
		}
		
		$header='<thead><tr><th Style="width:5%">Line item #</th><th>Product</th><th>Ordered Qty</th><th>Substitute product</th><th>Received Qty</th><th>Amount</th><th>Unit price</th><th>Status</th><th>Damage</th></tr></thead>';
	}
	else if($confirm_status==1)
	{
		$str.="</td><td><input type='text' id='qty' name='cqty".$val['orderdetailid']."' style='height: 28px;' value=".$val['confirmedquantity']."></td><td><input type='text' id='price' name='cprrce' value='".format_change($listed_price*$val['confirmedquantity'])."'  style='height: 28px;'></td><td><input type='text' id='price' name='cprrce' value='$".format_change($listed_price)."'  style='height: 28px;' disabled></td><td><select name='confrm_Status' id='confrm_Status'><option value='0'>Pending</option><option value='1' selected>Confirmed</option><option value='2'>Received</option></select></td><td><input id='order_pid' name='order_pid' type='hidden' value='".$val['orderdetailid']."' /></td></tr></select>";
	}
	else
	{
		$str.="</td><td><input type='text' id='qty' name='cqty".$val['orderdetailid']."' style='height: 28px;' value=".$qty."></td><td><input type='text' id='price' name='cprrce' value='".format_change($listed_price*$qty)."'  style='height: 28px;'></td><td><input type='text' id='price' name='cprrce' value='$".format_change($listed_price)."'  style='height: 28px;' disabled><td><select name='confrm_Status' id='confrm_Status'><option value='0' selected>Pending</option><option value='1'>Confirmed</option><option value='2'>Received</option></select></td><td><input id='order_pid' name='order_pid' type='hidden' value='".$val['orderdetailid']."' /></td></tr></select>";
		
		
	}
	$totl_qty=$totl_qty+$qty;
	// $tot_count+=1;
}
$str=$header."<tbody>".$str."</tbody>";
echo $str."&&".$totl_qty;

function get_product_name($pid)
{
	$sql = "SELECT * FROM `productportfolio` WHERE productid='$pid'";
	$result = mysql_query($sql);
	$val1 = mysql_fetch_array($result);
	return $val1;
}
function get_product_price($prd_id,$ondate)
{
	$sql="SELECT * FROM pricing where datefrom <='$ondate' AND dateto>='$ondate' and productid='$prd_id'";
	$row=mysql_query($sql);
	$val = mysql_fetch_array($row);	
	return $val['price'];
}
function format_change($currrency)
{
	return number_format((float)$currrency, 2, '.', '');
}

?>