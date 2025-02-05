<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <?php include('../header.php'); ?>

    <div class="page-wrapper">
        <h2 class="page-title">Product Types</h2>
        <div class="columns-wrapper contact">
        <?php
        // Include the database connection
        include('../conn.php');

        // Check if the request is an AJAX request by checking the HTTP_X_REQUESTED_WITH header
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pcode']) && isset($_POST['pname'])) {
            // Sanitize user inputs
            $pcode = mysqli_real_escape_string($conn, $_POST['pcode']);
            $pname = mysqli_real_escape_string($conn, $_POST['pname']);
            
            // SQL to insert the new product type
            $addtypessql = "INSERT INTO product_types (pcode, pname) VALUES('$pcode', '$pname')";
            
            // Execute the query
            if ($conn->query($addtypessql) === true) {
                echo "Added Product Type";
                header("Location: " . $_SERVER['PHP_SELF']);
            } else {
                // Error in insertion
                echo "Error: " . $conn->error;
            }
            exit; // Stop further execution after AJAX request is handled
        }
        ?>

        <!-- Product Type Form -->
        <div class="columns form addptypes">
            <form id="productForm" method="POST" action="product_types.php">
                <div class="field-wrapper">
                    <label>Product Type Code:</label>
                    <input type="text" name="pcode" id="pcode" required />
                </div>
                <div class="field-wrapper">
                    <label>Product Type Name:</label>
                    <input type="text" name="pname" id="pname" required />
                </div>
                <div class="field-wrapper button">
                    <button type="submit">Add Type</button>
                </div>
            </form>
        </div>

        <h3>Product Type List</h3>
        <ul id="productList">
            <!-- Product types will be displayed here -->
            <?php
            // Initially display the product types when the page loads
            $typesSql = "SELECT * FROM product_types";
            $result = $conn->query($typesSql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row['pname']) . " (" . htmlspecialchars($row['pcode']) . ")</li>";
                }
            } else {
                echo "<li>No product types available.</li>";
            }
            ?>
        </ul>

        </div>
    </div>

    <div id="footer-wrapper">
        <div class="footer">
            <div id="main-menu">
                <li class="menu-item"><a>Shop</a></li>
                <li class="menu-item"><a href="./contact.html">Contact Us</a></li>
            </div>
            <p>No 18, Kaluthara Rd, Matugama</p>
        </div>
    </div>


  </body>
</html>
