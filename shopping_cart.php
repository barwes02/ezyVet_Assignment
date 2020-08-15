<!DOCTYPE html>
<?php
// Include Product.php file
require_once("Product.php");
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- internal CSS -->
    <style>
        body {
            width: 100vw;
            height: 100vh;
            background: rgb(74, 175, 244);
            background: radial-gradient(circle, rgba(74, 175, 244, 1) 32%, rgba(74, 78, 244, 1) 100%);
            text-align: center;
        }

        h1 {
            cursor: default;
        }
    </style>

</head>

<body>
    <h1 class="pt-2">Products</h1>
    <!-- table that displays the Products  -->
    <div class="table-responsive container">
        <table class="table table-hover table-dark table-bordered ">
            <thead class="thead-dark ">
                <tr>
                    <th><strong>Name</strong></th>
                    <th><strong>Price</strong></th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop over products array to display each product
                foreach ($products as $product) {
                ?>
                    <tr>
                        <td class="align-middle"><?php echo $product['name'] ?></td>
                        <td class="align-middle"> <?php echo "$" . number_format($product['price'], 2); ?></td>
                        <td class="align-middle"> <button type="button" class="btn btn-primary" id="add_<?php echo $product['name'] ?>" onClick="cartAction('add', '<?php echo $product["name"] ?>')">
                                Add Product
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <h1>Shopping Cart</h1>
    <div id="cart-item">
        <?php
        // Include ajax-action.php to keep displaying the cart after reloads
        require_once "ajax-action.php";
        ?>
    </div>
    <!-- Scripts -->
    <!-- jQuery Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Scripts -->
    <script>
        // 
        // 
        // Function that controls the cart
        //
        //
        function cartAction(action, product) {
            var queryString = "";
            if (action != "") {
                // Switch statement to determine what to add to the query 
                switch (action) {
                    // Switch case to build the add query 
                    case "add":
                        queryString = 'action=' + action + '&name=' + product;
                        break;
                        // Switch case to build the remove query 
                    case "remove":
                        queryString = 'action=' + action + '&name=' + product;
                        break;
                        // Switch case to build the empty query 
                    case "empty":
                        queryString = 'action=' + action;
                        break;
                }
            }
            // Ajax call to ajax-action.php file
            jQuery.ajax({
                url: "ajax-action.php",
                data: queryString,
                type: "POST",
                success: function(data) {
                    // Returned data - change #cart-item html to new
                    $("#cart-item").html(data);
                },
                error: function() {
                    alert('There was an error when making the AJAX call.')
                }
            });
        }
    </script>
</body>

</html>