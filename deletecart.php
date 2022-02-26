<?php
session_start();
$mno=$_SESSION['mno'];
include 'config.php';
$cartid=$_GET['cartid'];
mysqli_query($config,"DELETE FROM cart WHERE id='$cartid'");
    header('location:issueitems.php?mno='.$mno);


?>