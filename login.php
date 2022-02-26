<?php
include 'config.php';
//login process start
if($_POST['login']){
    $username=addslashes($_POST['username']);
    $password=addslashes($_POST['password']);
    if(empty($username)){
        $error='<img src="images/error.png" width="20" height="20"> You must enter your username!';
    }else{
        if(empty($password)){
            $error='<img src="images/error.png" width="20" height="20"> You must enter your password!';
        }else{
            $encpassword=md5($password,false);
            $loginqry=mysqli_query($config,"SELECT * FROM users WHERE username='$username' AND password='$encpassword'");
            if(mysqli_num_rows($loginqry)>0){
                //login credentials exist in db
                $loginrow=mysqli_fetch_assoc($loginqry);
                $status=$loginrow['status'];
                if($status=='Active'){
                    $fullnames=$loginrow['FirstName'].' '.$loginrow['OtherNames'];
                    session_start();
                    $_SESSION['fullnames']=$fullnames;
                    $_SESSION['username']=$username;
                    $_SESSION['active']=true;
                    header('location:index.php');
                }else{
                    $error='<img src="images/error.png" width="20" height="20"> Error! You are not allowed to access this system!';
                }
                
            }else{
                $error='<img src="images/error.png" width="20" height="20"> Login failed! Please try again.';
            }
        }
    }
}
//login process end
include 'styles.html';

?>

<div id="parent">
<form id="form_login" action="" method="POST">
    <img src="images/Logo.png" width="100" height="100"><br>
<img src="images/user.png" width="18" height="18"><input type="text" name="username" size="32" placeholder="Enter username"><p>
    <img src="images/key.png" width="18" height="18"><input type="password" name="password" size="32" placeholder="Enter password"></p>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="login" value="Login"><p>
    <a href="recover.php">Forgot your password?</a><br>
    <?php echo $error ?>
</form>
</div