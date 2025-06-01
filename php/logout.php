<?php

session_start();
include'php/db.php';
if (isset($_SESSION['unique_id'])){
    $logout_id=mysqli_real_escape_string($conn, $_GET['logout.php']);
    if(isset($_logout_id)){
        session_unset();
        session_destroy();
        header("location:../login.php");
    }
    else{
        header("location:../index.php");
    }
}
else{
        header("location:../login.php");
}
?>