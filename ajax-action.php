<?php
// Create a session or resume the current one
session_start();
// Include product.php file with has the list of products
require_once("Product.php");

// Check if action has a value
if (!empty($_POST["action"])) {
	//
	// 
	// Switch statement to determine which action to take on cart
	//
	//
	switch ($_POST["action"]) {
			// Switch case that adds a product to the cart
		case "add":
			// Loop over products
			foreach ($products as $product) {
				// Check to get the correct product from the products array that the user clicked
				if ($product['name'] == $_POST["name"]) {
					// Create Session array structure
					$array =  array($product["name"] => array('name' => $product["name"], 'quantity' => 1, 'price' => $product["price"]));
					// Check if the cart array is empty
					if (!empty($_SESSION["cart_item"])) {
						// Get all array keys from the cart array
						$cartKeysArray = array_keys($_SESSION["cart_item"]);
						// Check if the product the user clicked on exists in the cart already
						if (in_array($product["name"], $cartKeysArray)) {
							// Item exists in the cart - add 1 to quantity
							$_SESSION["cart_item"][$product["name"]]["quantity"] = $_SESSION["cart_item"][$product["name"]]["quantity"] + 1;
						} else {
							// Item doesn't exist in the cart - add product to cart
							$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $array);
						}
					} else {
						// Cart is empty - add product to cart
						$_SESSION["cart_item"] = $array;
					}
				}
			}
			break;
			// Switch case that removes a product from the cart
		case "remove":
			// Check if cart is empty
			if (!empty($_SESSION["cart_item"])) {
				// Get all array keys from the cart array
				$cartKeysArray = array_keys($_SESSION["cart_item"]);
				// Check if the product the user clicked on exists in the cart already
				if (in_array($_POST["name"], $cartKeysArray))
					// Item exists in the cart - Remove item from cart
					unset($_SESSION["cart_item"][$_POST["name"]]);
				// Check if cart is empty	
				if (empty($_SESSION["cart_item"]))
					// Cart is empty - Destroy cart
					unset($_SESSION["cart_item"]);
			}
			break;
			// Switch case that empties the cart
		case "empty":
			// Check if cart is empty
			if (!empty($_SESSION["cart_item"])) {
				// Cart is not empty - Destroy Cart
				unset($_SESSION["cart_item"]);
			}
			break;
	}
}
?>
<?php
// Check if cart is set
if (isset($_SESSION["cart_item"])) {
	$total = 0;
?>
	<!-- table that displays the cart items  -->
	<div class="table-responsive container">
		<table class="table table-hover table-dark table-bordered ">
			<thead class="thead-dark ">
				<tr>
					<th><strong>Name</strong></th>
					<th><strong>Price</strong></th>
					<th><strong>Quantity</strong></th>
					<th><strong>Item Total</strong></th>
					<th> </th>
				</tr>
			</thead>
			<tbody>
				<?php
				// Loop over cart to display each product that is in the cart
				foreach ($_SESSION["cart_item"] as $item) {
					$item_Total = $item["price"] * $item["quantity"];
				?>
					<tr>
						<td class="align-middle"><strong><?php echo $item["name"]; ?></strong></td>
						<td class="align-middle"><?php echo "$" . number_format($item["price"], 2); ?></td>
						<td class="align-middle"><?php echo $item["quantity"] . "x"; ?></td>
						<td class="align-middle"><?php echo "$" . number_format($item_Total, 2); ?></td>
						<td class="align-middle"><button type="button" class="btn btn-warning" onClick="cartAction('remove','<?php echo $item["name"]; ?>')" class="btnRemoveAction cart-action">Remove</button></td>
					</tr>
				<?php
					$total += ($item["price"] * $item["quantity"]);
				}
				?>

				<tr>
					<td colspan="3" align=right><strong>Total:</strong></td>
					<td><?php echo "$" . number_format($total, 2); ?></td>
					<td><button type="button" class="btn btn-danger" id="ClearCart" onClick="cartAction('empty')">
							Clear Cart
						</button></td>
				</tr>
			</tbody>
		</table>
	</div>

<?php
} else {
	// Cart is empty - display that the cart is empty
?>
	<div class="table-responsive container">
		<table class="table table-hover table-dark table-bordered ">
			<thead class="thead-dark ">
				<tr>
					<th><strong>Your Shopping cart is empty!</strong></th>
				</tr>
			</thead>
		</table>
	</div>

<?php } ?>