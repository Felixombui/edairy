<?php
session_start();
if(empty($_SESSION['active'])){
    header('location:login.php');
}else{
    $fullnames=$_SESSION['fullnames'];
    $username=$_SESSION['username'];
}
include 'config.php';
    if($_POST['change']){
        $newpassword=addslashes($_POST['newpassword']);
        $repeatpassword=addslashes($_POST['repeatpassword']);
        if(empty($newpassword)){
            $error='<div class="err"><img src="images/error.png" width="23" height="23">You must create a new password!'; 
        }else{
            if($newpassword==$repeatpassword){
                $password=md5($newpassword);
                $changeqry=mysqli_query($config,"UPDATE users SET `password`='$password' WHERE username='$username'");
                if($changeqry){
                    header('location:index.php');
                }else{
                    $error='<div class="err"><img src="images/error.png" width="23" height="23">Error! Password change failed! Please contact your system admin.';
                }
            }else{
                $error='<div class="err"><img src="images/error.png" width="23" height="23">Error! Your passwords do not match.';
            }
        }
    }
include 'styles.html';

?>

<div id="parent">
<form id="form_login" action="" method="POST">
    <img src="images/Logo.png" width="100" height="100"><br>
    <?php echo $fullnames.'.' ?> Change your password now.<p>
<img src="images/key.png" width="18" height="18"><input type="password" name="newpassword" size="32" placeholder="New Password"><p>
    <img src="images/key.png" width="18" height="18"><input type="password" name="repeatpassword" size="32" placeholder="Confirm new password"></p>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="change" value="Change Password"><p>
    <a href="index.php">Go back home</a><br>
    <?php echo $error ?>
</form>
</div