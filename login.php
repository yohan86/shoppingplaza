<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
    <?php include('header.php');



      $emaillError = '';
      $passwordError ='';
    ?>
    <div class="page-wrapper">
        <h2 class="page-title">Login</h2>
        <div class="columns-wrapper contact">
           
            <div class="columns form login">

                <?php
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                   
                  if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['password'])){
                    $email = $_POST['email'];
                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      $storedpw = $row['password'];
                      if(password_verify($_POST['password'], $storedpw )){
                         
                         $_SESSION['user'] = $row['Fname'];
                         $_SESSION['email'] = $row['email'];
                         if($row['Fname'] === 'Admin'){
                            header('Location: dashboard_pages/orders.php');
                         }else{
                          header('Location: dashboard.php');
                         }
                         
                      }else{
                        echo 'incorret';
                      }
                    }else{
                      echo 'no user found';
                    }
                  
                  
                  }else{
                    echo 'Email or Password incorrect';
                  ?>  
                    <form method='POST' action='login.php'>
                      <div class="field-wrapper">
                          <label>Email:</label>
                          <input type="email" name="email" value="<?= isset($_POST['email'])? $_POST['email']: '';?>" required />
                      </div>
                      <div class="field-wrapper">
                          <label>Password:</label>
                          <input type="text" name="password" value="" required />
                      </div>
                      <div class="field-wrapper button">
                          <button type="submit">Login</button>
                      </div>

                    </form>

                  <?php
                  }


                }else{
                ?>

                    <form method='POST' action='login.php'>
                      <div class="field-wrapper">
                          <label>Email:</label>
                          <input type="email" name="email" value="" required />
                      </div>
                      <div class="field-wrapper">
                          <label>Password:</label>
                          <input type="password" name="password" value="" required />
                      </div>
                      <div class="field-wrapper button">
                          <button type="submit">Login</button>
                      </div>

                    </form>
                
                
                <?php } ?>
            </div>
        </div>
    </div>
<?php
    include('footer.php');
?>

  </body>