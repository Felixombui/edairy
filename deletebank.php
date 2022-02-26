<?php
include 'headers.php';
$id=$_GET['id'];
$bankqry=mysqli_query($config,"SELECT * FROM banks WHERE id='$id'");
$bankrow=mysqli_fetch_assoc($bankqry);
$bankname=$bankrow['BankName'];
$confirmation='<form method="post"><img src="images/question.png" width="23" height="23" align="left">Are you sure you want to delete <b>'.$bankname.'</b> from the list of banks?<br><br><input type="submit" id="smallbutton" name="yes" value="Yes"> </form> <br> <a href="listofbanks.php"><input type="submit" id="smallbutton" name="no" value="No"></a>';
if($_POST['yes']){
$deleteqry=mysqli_query($config,"DELETE FROM banks WHERE id='$id'");
if($deleteqry){
    $confirmation='<div class="success"><img src="images/success.png" width="23" height="23" align="left">Record has been deleted successfully.</div>';
}else{
    $confirmation='<div class="error"><img src="images/error.png" with="23" height="23" align="left">Action failed! Record was not deleted!>/div>'; 
}
}
?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><img src="images/bank.png" width="23" height="23" align="left"><a href="listofbanks.php">List of Banks</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr class="dashboardheader"><td>
           <img src="images/bank.png" width="50" height="50" align="left">Delete Bank?
       </td></tr>
    <tr><td>
        
            <table width="50%" align="center">
                <tr><td><?php echo $confirmation ?></td></tr>
                
            </table>
            <table width="50%" align="center"><tr><td><?php echo $error ?></td></tr></table>
        
    </td></tr>
    </table>
    </td></tr>
</table>