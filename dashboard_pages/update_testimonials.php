<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

  </head>
  <body>
  <?php 
  include('../header.php');
  include('../conn.php');

  $currentreview = (isset($_GET['review'])) ? $_GET['review'] :"";

  
 
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
    $id = $_POST['reviewid'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $profileImage = $_FILES['image'];
    $imageurl = '';
    $oldimage = (isset($_POST['oldimage']))? $_POST['oldimage'] : "";

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if(in_array($profileImage['type'], $allowedTypes)){
       
        $imagename = time()."-".basename($profileImage['name']);
        $imagedir ="../images/testimonials/";
        $imagepath = $imagedir.$imagename;

        $oldimagepath = "../".$oldimage;
 

        if(isset($oldimage) && file_exists($oldimagepath)){
            unlink($oldimagepath);
        }

        if(!file_exists($imagedir)){
            mkdir($imagedir, 0777, true);
        };

        if(move_uploaded_file($profileImage['tmp_name'], $imagepath)){
            $imageurl = "images/testimonials/$imagename";
        };

    }else{
        $imageurl = $oldimage;
    }

    $updatereview = "UPDATE testimonials SET  title='$title', content='$content', author='$author', profileimage='$imageurl' WHERE id='$id'";
    if($conn->query($updatereview) == true){
       header("Location: ../index.php");

    }else{
        $errormsg ="Error :". $conn->error;
    }
    
    
    
    }else{

        if(!isset($currentreview)){
          
        }else{
            
        $updatesql ="SELECT * FROM testimonials WHERE id='$currentreview'";
        $reviewresult = $conn->query($updatesql);
        $reviewitem = $reviewresult->fetch_assoc();

    ?>
        <div class="page-wrapper">
        <h2 class="page-title">Add Testimonials</h2>

        <?php
            if($errormsg){
                echo "<div class='success-msg'>".$errormsg."</div>";
            }
        ?>

        <div class="columns-wrapper contact">
           
            <div class="columns form login">
                <form method='POST' action='update_testimonials.php' enctype="multipart/form-data">
                    <div class="field-wrapper">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php if(isset($reviewitem['title'])) echo $reviewitem['title'];?>" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Author</label>
                        <input type="text" name="author" value="<?php if(isset($reviewitem['author'])) echo $reviewitem['author'];?>" required />
                    </div>
                    
                    <div class="field-wrapper">
                        <label>Description:</label>
                        <textarea type="text" name="content"><?php if(isset($reviewitem['content'])) echo $reviewitem['content'];?></textarea>
                    </div>
                    <div class="field-wrapper">
                        <img src="../<?php if(isset($reviewitem['profileimage'])) echo $reviewitem['profileimage'];?>" width="100" alt="profile image" />
                        <label>Profile Image:</label>
                        <input type="file" name="image" id="image"  accept="image/*" />
                    </div>
                    <input type="hidden" name="reviewid" value="<?php if(isset($reviewitem['id'])) echo $reviewitem['id'];?>" />
                    <input type="hidden" name="oldimage" value="<?php if(isset($reviewitem['profileimage'])) echo $reviewitem['profileimage'];?>" />
                    <div class="field-wrapper button">
                        <button type="submit">Update</button>
                    </div>

                </form>
            </div>
        </div>
        </div>



    <?php
    }
    } ?>
    


        

    <?php include('../footer.php'); ?>

  </body>