<?php
include 'headers.php';

if($_POST['save']){
    $bankname=$_POST['bankname'];
    $bankqry=mysqli_query($config,"SELECT * FROM banks WHERE BankName='$bankname'");
    if(mysqli_num_rows($bankqry)>0){
        $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> The bank name you entered already exists in te bank register!</div>';
    }else{
        $insertbank=mysqli_query($config,"INSERT INTO banks(BankName) VALUES('$bankname')");
        if($insertbank){
            $error='<div class="success"><img src="images/success.png" width="20" height="20" align="left"> Bank has been saved successfully.</div>';
        }else{
            $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> Bank saving failed! Please try again or contact your system admin!</div>';
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
        <tr><td><img src="images/bank.png" width="23" height="23" align="left"><a href="listofbanks.php">List of Banks</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr class="dashboardheader"><td>
           <img src="images/bank.png" width="50" height="50" align="left"> New Member
       </td></tr>
    <tr><td>
        <form action="" method="POST">
            <table width="50%" align="center">
                <tr><td>Bank Name:</td><td><input type="text" name="bankname" ></td></tr>
                
                <tr><td></td><td><input type="submit" value="Save Member" name="save"</td></tr>
            </table>
            <table width="50%" align="center"><tr><td><?php echo $error ?></td></tr></table>
        </form>
    </td></tr>
    </table>
    </td></tr>
</table>