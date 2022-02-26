<?php
include 'config.php';
$id=$_GET['id'];
$skey=$_GET['skey'];
$qry=mysqli_query($config,"SELECT * FROM billing WHERE id='$id'");
$row=mysqli_fetch_assoc($qry);
$mno=$row['Mno'];
$month=$row['CollectionMonth'];
//delete from collections
if(mysqli_query($config,"DELETE FROM collections WHERE Mno='$mno' AND CollectionMonth='$month'")){
    //delete from billing
    if(mysqli_query($config,"DELETE FROM billing WHERE id='$id'")){
        header('location:collectionslist.php?skey='.$skey);
    }
}

?>