<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["bquantity"])) {
			$bid = $_GET['bid'];
			$productByCode = $db_handle->runQuery("SELECT * FROM book WHERE bid = $bid ");
			$itemArray = array($productByCode[0]["bid"]=>array('bname'=>$productByCode[0]["bname"], 'bid'=>$productByCode[0]["bid"], 'bquantity'=>$_POST["bquantity"], 'bprice'=>$productByCode[0]["bprice"], 'filename'=>$productByCode[0]["filename"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["bid"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["bid"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["bquantity"])) {
									$_SESSION["cart_item"][$k]["bquantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["bquantity"] += $_POST["bquantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["bid"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<HTML>
<HEAD>
<TITLE>Welcome to LEGACYcart</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<div id="shopping-cart">
<div class="txt-heading">LEGACYcart</div>

<a id="btnEmpty" href="home.php?action=empty">Empty Cart</a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Book ID</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["bquantity"]*$item["bprice"];
		?>
				<tr>
				<td><img src="<?php echo "product-images/".$item['filename']; ?>" class="cart-item-image" /><?php echo $item["bname"]; ?></td>
				<td><?php echo $item["bid"]; ?></td>
				<td style="text-align:right;"><?php echo $item["bquantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$item["bprice"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="home.php?action=remove&bid=<?php echo $item["bid"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["bquantity"];
				$total_price += ($item["bprice"]*$item["bquantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>	

<form method="POST">
	<input type="hidden" name = "totalAmt" value="<?php echo $total_price;?>">
	<input type="submit" value="Order Now" name = "ordernow">
</form>

  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}


if(isset($_POST['ordernow'])) {
	$_SESSION['totalamt'] = $_POST['totalAmt'];
	header('location:checkout.php');
}


?>
</div>

<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM book ORDER BY bid ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="home.php?action=add&bid=<?php echo $product_array[$key]["bid"]; ?>">
			<div class="product-image"><img class="bookimage" src="<?php echo "product-images/".$product_array[$key]["filename"]; ?>"></div>
			<div class="product-tile-footer">
			<div class="product-title"><?php echo $product_array[$key]["bname"]; ?></div>
			<div class="product-price"><?php echo "$".$product_array[$key]["bprice"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="bquantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
			</div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>
</BODY>
</HTML>