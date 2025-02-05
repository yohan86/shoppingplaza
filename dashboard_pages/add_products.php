<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

  </head>
  <body>
  <?php 
  include('../header.php');
  include('../conn.php');
 
    $typesList = $successmsg = $errormsg = '';

    $typesSql = "SELECT * FROM product_types";
    $result = $conn->query($typesSql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $typesList .= "<option value='".htmlspecialchars($row['pcode'])."'>" . htmlspecialchars($row['pname']) ."</option>";
        }
    } else {
        $typesList = "<option>No product types</option>";
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $productname = $_POST['pname'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $featured = (isset($_POST['featured']) && $_POST['featured'] == 'true') ? 1 : 0;
    $home = (isset($_POST['home']) && $_POST['home'] == 'true') ? 1 : 0;
    $viewlabel = (isset($_POST['viewlabel']) && $_POST['viewlabel'] == 'true') ? 1 : 0;
    $description = $_POST['description'];
    $pimage = $_FILES['image'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($pimage['type'], $allowedTypes)) {
        $imageName = time() . '-' . basename($pimage['name']);

        $targetDir = "../images/products/$category/$brand/"; // Directory to store the uploaded images
        
        $targetFile = $targetDir . $imageName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true); // Create the directory with 0777 permissions, recursively
        }

        if (move_uploaded_file($pimage['tmp_name'], $targetFile)) {

            $imagepath = "images/products/$category/$brand/$imageName"; 
            $productsql = "INSERT INTO products (pname, price, brand, category, featured, home, new, description, imagepath) VALUES('$productname','$price','$brand','$category','$featured', '$home', '$viewlabel', '$description','$imagepath')";
            if($conn->query($productsql) == true){
               $successmsg = "Added Product";
            }else{
                $errormsg ="Error :". $conn->error;
            }
        }else{
           $errormsg = "Image upload fail";
        }
    }
    
    }

 ?>
    <div class="page-wrapper">
        <h2 class="page-title">Welcome to Dashboard</h2>
        <p>You can add products here</p>
        <?php
            if($successmsg){
                echo "<div class='success-msg'>".$successmsg."</div>";
            }
            if($errormsg){
                echo "<div class='success-msg'>".$errormsg."</div>";
            }
        ?>

        <div class="columns-wrapper contact">
           
            <div class="columns form login">
                <form method='POST' action='add_products.php' enctype="multipart/form-data">
                    <div class="field-wrapper">
                        <label>Product Name:</label>
                        <input type="text" name="pname" value="" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Price:</label>
                        <input type="text" name="price" value="" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Brand:</label>
                        <select  name="brand" id="brand" required >
                            <?php echo $typesList; ?>
                        </select>
                    </div>
                    <div class="field-wrapper">
                        <label>Category:</label>
                        <select name="category" required >
                            <option value="phones">Phones</option>
                            <option value="phone_accessories">Phone Accessories</option>
                        </select>
                    </div>
                    <div class="field-wrapper checkbox">
                        <input type="checkbox" name="featured" value="true" />
                        <label>Featured Product</label>
                    </div>
                    <div class="field-wrapper checkbox">
                        <input type="checkbox" name="home" value="true" />
                        <label>Show Home</label>
                    </div>
                    <div class="field-wrapper checkbox">
                        <input type="checkbox" name="newlabel" value="true" />
                        <label>New Label</label>
                    </div>
                    <div class="field-wrapper">
                        <label>Description:</label>
                        <textarea type="text" name="description" value=""></textarea>
                    </div>
                    <div class="field-wrapper">
                        <label>Product Image:</label>
                        <input type="file" name="image" id="image" accept="image/*" required  />
                    </div>
                    <div class="field-wrapper button">
                        <button type="submit">Add Item</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php include('../footer.php'); ?>

  </body>