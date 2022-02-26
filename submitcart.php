<?php
session_start();
include 'config.php';
$mno=$_GET['mno'];
$month=$_SESSION['month'];
$submitqry=mysqli_query($config,"SELECT * FROM cart WHERE mno='$mno'");
while($submitrow=mysqli_fetch_assoc($submitqry)){
    $id=$submitrow['id'];
    $date=date('d/m/y');
    $names=$submitrow['names'];
    $item=$submitrow['item'];
    $cost=$submitrow['cost'];
    $insertqry=mysqli_query($config,"INSERT INTO store(Mno,Names,ItemCode,ItemName,ItemAmount,AmountPayable,AmountPaid,balance,SalesDate,SalesMonth) VALUES('$mno','$names','$item','$item','1','$cost','0.0','$cost','$date','$month')");
    if($insertqry){
        mysqli_query($config,"DELETE FROM cart WHERE id='$id'");
    }
}
$_SESSION['membernames']='';
$_SESSION['mno']='';
header('location:issueitems.php');
?>