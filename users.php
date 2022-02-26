<?php
include 'headers.php';

if($_POST['save']){
   $idnumber=addslashes($_POST['idnumber']);
   $firstname=addslashes($_POST['firstname']);
   $othernames=addslashes($_POST['othernames']);
   $username=addslashes($_POST['username']);
   $createpassword=addslashes($_POST['createpassword']);
   $confirmpassword=addslashes($_POST['confirmpassword']);
   if(empty($idnumber)){
       $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">You must enter user id!</div>';
   }else{
       if(empty($firstname)){
        $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">You must enter the First Name!"</div>';
       }else{
           if(empty($othernames)){
            $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">You must enter Other Names!</div>';
           }else{
               if(empty($username)){
                $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">You must create a username!</div>';
               }else{
                   if(empty($createpassword)){
                    $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">You must create a password!</div>';
                   }else{
                       if($createpassword==$confirmpassword){
                           $checkuser=mysqli_query($config,"SELECT * FROM users WHERE username='$username'");
                           if(mysqli_num_rows($checkuser)>0){
                            $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">The username already exists! Please use different username."</div>';
                           }else{
                               $password=md5($createpassword,false);
                               if(mysqli_query($config,"INSERT INTO users(IDNumber,FirstName,OtherNames,username,`password`,`status`) VALUES('$idnumber','$firstname','$othernames','$username','$password','Active'")){								   
                              $error='<div class="success"><img src="images/success.png" width="23" height="23" align="left">User account created successfully.</div>';
                               }else{
								   $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left"> User account not created!';
                           }
						   }
                       }else{
                        $error='<div class="err"><img src="images/error.png" width="23" height="23" align="left">The passwords you entered do not match! Please try again.</div>';
                       }
                   }
               }
           }
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
        <tr><td><img src="images/user.png" width="23" height="23" align="left"><a href="listofusers.php">List of Users</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr class="dashboardheader"><td>
           <img src="images/AddUser.png" width="50" height="50" align="left"> New User
       </td></tr>
    <tr><td>
        <form action="" method="POST">
            <table width="50%" align="center">
                <tr><td>ID Number:</td><td><input type="text" name="idnumber" ></td></tr>
                <tr><td>First Name:</td><td><input type="text" name="firstname" ></td></tr>
                <tr><td>Other Names:</td><td><input type="text" name="othernames" ></td></tr>
                <tr><td>Username:</td><td><input type="text" name="username" ></td></tr>
                <tr><td>Create password:</td><td><input type="password" name="createpassword" ></td></tr>
                <tr><td>Confirm Password:</td><td><input type="password" name="confirmpassword" ></td></tr>
                <tr><td></td><td><input type="submit" value="Create Account" name="save"</td></tr>
            </table>
            <table width="50%" align="center"><tr><td><?php echo $error ?></td></tr></table>
        </form>
    </td></tr>
    </table>
    </td></tr>
</table>