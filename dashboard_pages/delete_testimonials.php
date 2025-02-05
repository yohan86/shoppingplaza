<?php
include("../conn.php");

if(isset($_GET['review'])){
    $reviewid = $_GET['review'];
    $sql = "DELETE FROM testimonials WHERE id='$reviewid'";
    if($conn->query($sql) == true){
        header("Location: ../index.php"); 
    }else{
        exit;
    }


}else{
   header("Location: ../index.php");
}