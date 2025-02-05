<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="script.js"></script>

  </head>
  <body>
    <?php 
    include('header.php');
    include('conn.php');
    $itemid = $_GET['item'];
    $item = '';
    $itemsql = "SELECT * FROM products WHERE pid='$itemid'";

    $result = $conn->query($itemsql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

          $itemid = $row["pid"];
          $item .=<<<EOD
            <div class="item-details">
                <h2 class="page-title">{$row['pname']}</h2>
                <div class="left-column">
                    <div class="item-image">
                    <img src="{$row['imagepath']}" />
                    </div>
                </div>
                <div class="right-column">
                    <div class="detail-column">
                        <div class="item-intro">{$row['description']}</div>
                        <div class="availability">Available Now</div>
                        <div class="price">Rs.{$row['price']}</div>
                        <form class="add_to_cart_form" name="add_to_cart_form"  action="" data-product-id="{$itemid}">
                            <input type="hidden" name="product_id" value="{$itemid}" />
                            <input type="hidden" name="product_name" value="{$row['pname']}" />
                            <input type="hidden" name="quantity" value="1" min="1" />
                            <input type="hidden" name="price" value="{$row['price']}" / >
                            <button type="submit" name="add_to_cart">Add To Cart</button>
                        </form>
                        <a href="dashboard_pages/update_products.php?product={$itemid}">Edit</a>
                    </div>
                </div>
            </div>
          EOD;
        }
    }
    ?>
    <div class="page-wrapper">
        <?php echo $item; ?>
    </div>

    <?php
    include('footer.php');
?>

  </body>