<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
<?php 
include('header.php');
include ('conn.php');
$mesg = $error ='';
?>
    <div class="page-wrapper">
        <h2 class="page-title">Register Form</h2>
        <div class="columns-wrapper contact">
           
            <div class="columns form register">
                
                <?php
                  if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $fname = $_POST['firstname'];
                    $lname = $_POST['lastname'];
                    $city = $_POST['city'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hashpassword = password_hash($password, PASSWORD_DEFAULT);


                    $usersql = "SELECT * FROM users WHERE email='$email'";
                    $userresult = $conn->query($usersql);

                    if($userresult->num_rows > 0){
                      $mesg = "User already exists, please use different email address";
             
                    }else{
    
                    $sql = "INSERT INTO users (Fname, Lname, email, city, password) VALUES ('$fname', '$lname', '$email', '$city', '$hashpassword') ";

                      if($conn->query($sql) === true){
                        header("Location:login.php");
                        exit;
                      }else{
                        echo 'error'.$conn->error;
                      }
                    $conn->close();
                  }
                  }

                  if($mesg){
                    echo "<p>{$mesg}</p>";
                  }
                  if($error){
                    echo "<p>{$error}</p>";
                  }

                ?>



                <form method='POST' action='register.php'>
                    <div class="field-wrapper">
                        <label>First Name:*</label>
                        <input type="text" name="firstname" value="" />
                    </div>
                    <div class="field-wrapper">
                        <label>Last Name:</label>
                        <input type="text" name="lastname" value="" />
                    </div>
                    <div class="field-wrapper">
                        <label>City:</label>
                        <input type="text" name="city" value="" />
                    </div>
                    <div class="field-wrapper">
                        <label>Email:*</label>
                        <input type="text" name="email" value="" />
                    </div>
                    <div class="field-wrapper">
                        <label>Password:</label>
                        <input type="password" name="password" value="" required />
                    </div>
                    

                    <div class="field-wrapper button">
                        <span class="small-text">* Required Fields</span>
                        <button type="submit">Submit</button>
                    </div>

                </form>

              

            </div>
        </div>
    </div>
<?php include("footer.php"); ?>

  </body>
  </html>