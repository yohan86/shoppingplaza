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
    
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $profileImage = $_FILES['image'];
    $imageurl = '';

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if(in_array($profileImage['type'], $allowedTypes)){
        $imagename = time()."-".basename($profileImage['name']);
        $imagedir ="../images/testimonials/";
        $imagepath = $imagedir.$imagename;

        if(!file_exists($imagedir)){
            mkdir($imagedir, 0777, true);
        };

        if(move_uploaded_file($profileImage['tmp_name'], $imagepath)){
            $imageurl = "images/testimonials/$imagename";
        };

    }
   

    $itemsql = "INSERT INTO testimonials (title,content,author,profileimage) VALUES('$title','$content','$author','$imageurl')";
    if($conn->query($itemsql) == true){
        $successmsg = "Added Testimonials";
    }else{
        $errormsg ="Error :". $conn->error;
    }
    
    
    
    }

 ?>
    <div class="page-wrapper">
        <h2 class="page-title">Add Testimonials</h2>

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
                <form method='POST' action='add_testimonials.php' enctype="multipart/form-data">
                    <div class="field-wrapper">
                        <label>Title</label>
                        <input type="text" name="title" value="" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Author</label>
                        <input type="text" name="author" value="" required />
                    </div>
                    
                    <div class="field-wrapper">
                        <label>Description:</label>
                        <textarea type="text" name="content" value=""></textarea>
                    </div>
                    <div class="field-wrapper">
                        <label>Profile Image:</label>
                        <input type="file" name="image" id="image"  accept="image/*" />
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