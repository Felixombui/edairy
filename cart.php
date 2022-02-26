<?php
session_start();
$membernames=$_SESSION['membernames'];
$mno=$_SESSION['mno'];
include 'config.php';
$id=$_GET['id'];
if(empty($mno)){
    echo '<script>alert("Please enter a member number and select month to proceed!")</script>';    
    //header('location:issueitems.php');
}else{
    $stockqry=mysqli_query($config,"SELECT * FROM stockcard WHERE id='$id'");
    $stockrow=mysqli_fetch_assoc($stockqry);
    $itemname=$stockrow['ItemName'];
    $cost=$stockrow['CostOfItem'];
    $cartqry=mysqli_query($config,"INSERT INTO cart(mno,names,item,cost) VALUES('$mno','$membernames','$itemname','$cost')");
    header('location:issueitems.php?mno='.$mno);
}
echo '<a href="issueitems.php"><< Go Back</a>';
include 'styles.html';
?>