<?php
include 'headers.php';

if($_POST['save']){
    $itemname=$_POST['itemname'];
    $cost=$_POST['cost'];
    $itmqry=mysqli_query($config,"SELECT * FROM stockcard WHERE ItemName='$itemname'");
    if(mysqli_num_rows($itmqry)>0){
        $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> The item name you entered already exists in the stock register!</div>';
    }else{
        $insertbank=mysqli_query($config,"INSERT INTO stockcard(ItemName,CostOfItem) VALUES('$itemname','$cost')");
        if($insertbank){
            $error='<div class="success"><img src="images/success.png" width="20" height="20" align="left"> Item has been saved successfully.</div>';
        }else{
            $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> Item saving failed! Please try again or contact your system admin!</div>';
        }
    }
}
?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><img src="images/bank.png" width="23" height="23" align="left"><a href="store.php">Store</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr class="dashboardheader"><td>
           <img src="images/bank.png" width="50" height="50" align="left"> Stock Card
       </td></tr>
    <tr><td>
        <form action="" method="POST">
            <table width="50%" align="center">
                <tr><td>Item Name:</td><td><input type="text" name="itemname" ></td></tr>
                <tr><td>Item Cost:</td><td><input type="text" name="cost" ></td></tr>
                <tr><td></td><td><input type="submit" value="Save Item" name="save"</td></tr>
            </table>
            <table width="50%" align="center"><tr><td><?php echo $error ?></td></tr></table>
        </form>
    </td></tr>
    </table>
    </td></tr>
</table>