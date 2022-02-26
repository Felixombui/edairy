<?php
include 'config.php';
if($_POST['recover']){
    $username=addslashes($_POST['username']);
    $idno=addslashes($_POST['idno']);
    if(empty($username)){
        $error='<div class="err"><img src="images/error.png" width="23" height="23">Enter your username!';
    }else{
        if(empty($idno)){
            $error='<div class="err"><img src="images/error.png" width="23" height="23">Enter your Id number!';  
        }else{
            $recqry=mysqli_query($config,"SELECT * FROM users WHERE username='$username' AND IDNumber='$idno'");
            if(mysqli_num_rows($recqry)>0){
                $recrow=mysqli_fetch_assoc($recqry);
                $fullnames=$recrow['FirstName'].' '.$recrow['OtherNames'];
                $username=$recrow['username'];
                session_start();
                $_SESSION['fullnames']=$fullnames;
                $_SESSION['username']=$username;
                $_SESSION['active']=true;
                header('location:changepass.php');
            }else{
                $error='<div class="err"><img src="images/error.png" width="23" height="23">Enter username and ID Number do not match any user record!';
            }
        }
    }
    
}
include 'styles.html';

?>

<div id="parent">
<form id="form_login" action="" method="POST">
    <img src="images/Logo.png" width="100" height="100"><br>
<img src="images/user.png" width="18" height="18"><input type="text" name="username" size="32" placeholder="Enter username"><p>
    <img src="images/key.png" width="18" height="18"><input type="text" name="idno" size="32" placeholder="Enter Your ID Number"></p>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="recover" value="Recover"><p>
    <a href="login.php">Back to Login</a><br>
    <?php echo $error ?>
</form>
</div