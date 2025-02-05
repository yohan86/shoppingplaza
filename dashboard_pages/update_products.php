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
$newimagepath = '';




    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $productId = $_POST['product_id'];
    $productname = $_POST['pname'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $featured = (isset($_POST['featured']) && $_POST['featured'] == 'true') ? 1 : 0;
    $home = (isset($_POST['home']) && $_POST['home'] == 'true') ? 1 : 0;
    $newlabel = (isset($_POST['newlabel']) && $_POST['newlabel'] == 'true') ? 1 : 0;
    $description = $_POST['description'];
    $pimage = (isset($_FILES['image']))? $_FILES['image']: '';
    $oldimagepath = (isset($_POST['currentimagepath']))? "../".$_POST['currentimagepath']: '';

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($pimage['type'], $allowedTypes)) {
        $newimage = time().'-'.basename($pimage['name']);

        $newdirpath = "../images/products/$category/$brand/";
        $oldimagedirpath = dirname($oldimagepath);


        $newfile = $newdirpath.$newimage;


        if(!empty($oldimagepath) && file_exists($oldimagepath)){
            unlink($oldimagepath);
        }

        if(!file_exists($newdirpath)){
            mkdir($newdirpath, 0777, true);
        }

        if(move_uploaded_file($pimage['tmp_name'], $newfile )){
            $newimagepath = "images/products/$category/$brand/$newimage";
        }
    
    }else{
        $newimagepath = $_POST['currentimagepath'];
    }


        $updatesql = "UPDATE products SET 
        pname='$productname', price='$price', brand='$brand',
        category='$category', featured='$featured', 
        home='$home', new='$newlabel', description='$description', imagepath='$newimagepath' WHERE pid='$productId'";

        if($conn->query($updatesql) == true){
            header("Location: ../index.php");
      
        }else{
            $errormsg ='ERROR'.$conn->error;
        }
   
    
    }else{

        if(!isset($_GET['product'])){
    
            header("Location: ../index.php");
            exit;
    
        }else{
            $productId = $_GET['product'];
            $updatesql = "SELECT * FROM products WHERE pid='$productId'";
            $updateresult = $conn->query($updatesql);
            $previewrow = $updateresult->fetch_assoc();



            $typesSql = "SELECT * FROM product_types";
            $result = $conn->query($typesSql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($previewrow['brand'] === $row['pcode'])? 'selected':'';
                    $typesList .= "<option value='".htmlspecialchars($row['pcode'])."' $selected>" . htmlspecialchars($row['pname']) ."</option>";
                }
            } else {
                $typesList = "<option>No product types</option>";
            }


        }

    }

 ?>
    <div class="page-wrapper">
        <h2 class="page-title">Update Products</h2>
        
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
                <form method='POST' action='update_products.php' enctype="multipart/form-data">
                    <div class="field-wrapper">
                        <label>Product Name:</label>
                        <input type="text" name="pname" value="<?php if(isset($previewrow['pname'])) echo $previewrow['pname']; ?>" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Price:</label>
                        <input type="text" name="price" value="<?php if(isset($previewrow['price'])) echo $previewrow['price']; ?>" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Brand:</label>
                        <select  name="brand" id="brand" required >
                            <?= $typesList?>
                        </select>
                    </div>
                    <div class="field-wrapper">
                        <label>Category:</label>
                        <select name="category" required >
                            <option value="phones" <?php if(isset($previewrow['category']) && $previewrow['category'] === 'phones') echo 'selected';?>>Phones</option>
                            <option value="phone_accessories" <?php if(isset($previewrow['category']) && $previewrow['category'] === 'phone_accessories') echo 'selected';?>>Phone Accessories</option>
                        </select>
                    </div>
                    <div class="field-wrapper checkbox">
                        <input type="checkbox" name="featured" value="true" <?php if((isset($previewrow['featured']) &&  $previewrow['featured'] === '1')) echo 'checked';?> />
                        <label>Featured Product</label>
                    </div>
                    <div class="field-wrapper checkbox">
                        <input type="checkbox" name="home" value="true" <?php if((isset($previewrow['home']) && $previewrow['home'] === '1')) echo 'checked';?> />
                        <label>Show Home</label>
                    </div>
                    <div class="field-wrapper checkbox">
                        <input type="checkbox" name="newlabel" value="true" <?php if((isset($previewrow['new']) && $previewrow['new'] === '1')) echo 'checked';?> />
                        <label>New Label</label>
                    </div>
                    <div class="field-wrapper">
                        <label>Description:</label>
                        <textarea type="text" name="description"><?php if(isset($previewrow['description'])) echo $previewrow['description'];?></textarea>
                    </div>
                    <div class="field-wrapper">
                    <?php if(isset($previewrow['imagepath'])){ ?> 
                        <img src="../<?= $previewrow['imagepath']?>" alt="Current Product Image" width="100" height="100" />
                    <?php } ?>
                        <label>Product Image:</label>
                        <input type="file" name="image" id="image" accept="image/*" />
                    </div>
                    <input type="hidden" name="product_id" value="<?php if(isset($productId)) echo $productId;?>" />
                    <input type="hidden" name="currentimagepath" value="<?php if(isset($previewrow['imagepath'])) echo $previewrow['imagepath'];?>" />
                    <div class="field-wrapper button">
                        <button type="submit" name="updateitem">Update</button>
                    </div>

                </form>
            </div>
        </div>
    
    </div>
    <?php include('../footer.php'); ?>

  </body>