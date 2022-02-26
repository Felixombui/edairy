<?php
include 'headers.php';
$membersqry=mysqli_query($config,"SELECT * FROM members");
if($_POST['search']){
    $searchtext=$_POST['search'];
    $membersqry=mysqli_query($config,"SELECT * FROM members WHERE mno LIKE '%$searchtext%' OR FirstName LIKE '%$searchtext%' OR OtherNames LIKE '%$searchtext%' OR PhoneNumber LIKE '%$searchtext%' OR IDNumber LIKE '%$searchtext%' OR AccountNo LIKE '%$searchtext%'");
}
if(isset($_POST['import'])){
    if($_FILES['file']['name']){
        $filename=explode('.',$_FILES['file']['name']);
        if($filename[1]=='csv'){
            $handle=fopen($_FILES['file']['tmp_name'],"r");
            $imported=0;
            set_time_limit(600);
            while($data=fgetcsv($handle)){
                $membernumber=addslashes($data[0]);
                $firstname=addslashes($data[1]);
                $othernames=addslashes($data[2]);
                $gender=addslashes($data[3]);
                $phonenumber=addslashes($data[4]);
                $idnumber=addslashes($data[5]);
                $bank=addslashes($data[6]);
                $accountno=addslashes($data[7]);
                $insertqry=mysqli_query($config,"INSERT INTO members(mno,FirstName,OtherNames,Gender,PhoneNumber,IDNumber,Bank,AccountNo) VALUES('$membernumber','$firstname','$othernames','$gender','$phonenumber','$idnumber','$bank','$accountno')");
                $imported=$imported+1;
            }
            echo '<script language="javascript">';
            echo 'alert("'.$imported.' members imported successfully.")';
            echo '</script>';
        }else{
            echo '<script language="javascript">';
            echo 'alert("Select a CSV File")';
            echo '</script>';
        }
    }else{
        echo '<script language="javascript">';
        echo 'alert("No file selected for import!")';
        echo '</script>';
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
           <img src="images/personnel.png" width="50" height="50" align="left"> Members List
       </td></tr>
    <tr><td>
        <table class="datatable" border="0" width="100%"><tr><td>
            <form action="" method="POST">
                <input type="text" name="search" placeholder="Search Member">
            </form>
        </td><td width="50%"><form method="post" enctype="multipart/form-data"><input type="file" name="file" value="Select CSV file to import"><input type="submit" name="import" value="Import"></form></td><td><a href="exportmembers.php"><img src="images/pdf.png" width="20" height="20" align="left">Export</a></td></tr></table>
        <table width="100%" border="0"><tr  class="kichwa"><td>Mno</td><td>Names</td><td>Gender</td><td>Phone No</td><td>ID Number</td><td>Bank</td><td>Account</td><td>&nbsp;</td></tr>
        <?php
        while($memberrow=mysqli_fetch_assoc($membersqry)){
            $mno=addslashes($memberrow['mno']);
            echo '<tr class="datatable"><td>'.$mno.'</td><td>'.$memberrow['FirstName'].' '.$memberrow['OtherNames'].'</td><td>'.$memberrow['Gender'].'</td><td>'.$memberrow['PhoneNumber'].'</td><td>'.$memberrow['IDNumber'].'</td><td>'.$memberrow['Bank'].'</td><td>'.$memberrow['AccountNo'].'</td><td><a href="newmember.php?mno='.$mno.'"><img src="images/edit.png" width="20" height="20"></a></td></tr>';
        }
        ?>
    </table>
    </td></tr>
    </table>
    </td></tr>
</table>