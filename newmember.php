<?php
include 'headers.php';
$mno=$_GET['mno'];
if(empty($mno)){
    //do nothing
}else{
    $qry=mysqli_query($config,"SELECT * FROM members WHERE mno='$mno'");
    $row=mysqli_fetch_assoc($qry);

}
if($_POST['save']){
    if(empty($mno)){
    $mnumber=addslashes($_POST['mno']);
    $firstname=addslashes($_POST['firstname']);
    $othernames=addslashes($_POST['othernames']);
    $gender=addslashes($_POST['gender']);
    $phonenumber=addslashes($_POST['phonenumber']);
    $idnumber=addslashes($_POST['idnumber']);
    $bank=addslashes($_POST['bank']);
    $accountnumber=addslashes($_POST['accountnumber']);
    if(empty($mnumber) or empty($firstname) or empty($othernames)){
        $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> Error! You have omitted important data!</div>';
    }else{
        $checkqry=mysqli_query($config,"SELECT * FROM members WHERE mno='$mnumber'");
        if(mysqli_num_rows($checkqry)>0){
            $checkrow=mysqli_fetch_assoc($checkqry);
            $names=$checkrow['FirstName'].' '.$checkrow['OtherNames'];
            $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> Member number '.$mnumber.'  already exists. It belongs to '.$names.'.</div>';
        }else{
        $memberqry=mysqli_query($config,"INSERT INTO members(mno,FirstName,OtherNames,Gender,PhoneNumber,IDNumber,Bank,AccountNo) VALUES('$mnumber','$firstname','$othernames','$gender','$phonenumber','$idnumber','$bank','$accountnumber')");
        if($memberqry){
            $error='<div class="success"><img src="images/success.png" width="20" height="20" align="left"> Member has been saved successfully.</div>';
        }else{
            $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> Error! Member was not saved!</div>';
        }
            
    }
    }
}else{
    $mnumber=addslashes($_POST['mno']);
    $firstname=addslashes($_POST['firstname']);
    $othernames=addslashes($_POST['othernames']);
    $gender=addslashes($_POST['gender']);
    $phonenumber=addslashes($_POST['phonenumber']);
    $idnumber=addslashes($_POST['idnumber']);
    $bank=addslashes($_POST['bank']);
    $accountnumber=addslashes($_POST['accountnumber']);
    $memberqry=mysqli_query($config,"UPDATE members SET FirstName='$firstname',OtherNames='$othernames',Gender='$gender',PhoneNumber='$phonenumber',IDNumber='$idnumber',Bank='$bank',AccountNo='$accountnumber' WHERE mno='$mno'");
    if($memberqry){
        $error='<div class="success"><img src="images/success.png" width="20" height="20" align="left"> Member has been updated successfully.</div>';
    }else{
        $error='<div class="err"><img src="images/error.png" width="20" height="20" align="left"> Error! Member update failed!</div>';
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
        <tr><td><img src="images/personnel.png" width="20" height="20" align="left"><a href="memberslist.php">Members List</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr class="dashboardheader"><td>
           <img src="images/AddUser.png" width="50" height="50" align="left"> New Member
       </td></tr>
    <tr><td>
        <form action="" method="POST">
            <table width="50%" align="center">
                <tr><td>Member Number:</td><td><input type="text" name="mno" value="<?php echo $row['mno'] ?>"></td></tr>
                <tr><td>First Name</td><td><input type="text" name="firstname" value="<?php echo $row['FirstName'] ?>"></td></tr>
                <tr><td>Other Names</td><td><input type="text" name="othernames" value="<?php echo $row['OtherNames'] ?>"></td></tr>
                <tr><td>Gender</td><td><select name="gender"><option>Male</option><option>Female</option></select></td></tr>
                <tr><td>Phone Number</td><td><input type="text" name="phonenumber"value="<?php echo $row['PhoneNumber'] ?>" ></td></tr>
                <tr><td>ID Number</td><td><input type="text" name="idnumber" value="<?php echo $row['IDNumber'] ?>"></td></tr>
                <tr><td>Bank</td><td><select name="bank">
                    <?php
                        $bankqry=mysqli_query($config,"SELECT * FROM banks");
                        while($bankrow=mysqli_fetch_assoc($bankqry)){
                            $bank=addslashes($bankrow['BankName']);
                            echo '<option>'.$bank.'</option>';
                        }
                    ?>
                </select></td></tr>
                <tr><td>Account No:</td><td><input type="text" name="accountnumber" value="<?php echo $row['AccountNo'] ?>"></td></tr>
                <tr><td></td><td><input type="submit" value="Save Member" name="save"</td></tr>
            </table>
            <table width="50%" align="center"><tr><td><?php echo $error ?></td></tr></table>
        </form>
    </td></tr>
    </table>
    </td></tr>
</table>