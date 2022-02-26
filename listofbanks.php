<?php
include 'headers.php';
$membersqry=mysqli_query($config,"SELECT * FROM banks");
if($_POST['search']){
    $searchtext=$_POST['search'];
    $membersqry=mysqli_query($config,"SELECT * FROM banks WHERE id LIKE '%$searchtext%' OR BankName LIKE '%$searchtext%'");
}

?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><img src="images/bank.png" width="20" height="20" align="left"><a href="newbank.php">New Bank</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr class="dashboardheader"><td>
           <img src="images/personnel.png" width="50" height="50" align="left"> Members List
       </td></tr>
    <tr><td>
        <table class="datatable" border="0" width="100%"><tr><td>
            <form action="" method="POST">
                <input type="text" name="search" placeholder="Search Bank">
            </form>
        </td><td width="50%"><form method="post" enctype="multipart/form-data"><input type="file" name="file" value="Select CSV file to import"><input type="submit" name="import" value="Import"></form></td></tr></table>
        <table width="100%" border="0" id="reportsheader"><th>ID</th><th>Bank Name</th><th>&nbsp;</th>
        <?php
        while($memberrow=mysqli_fetch_assoc($membersqry)){
            $id=addslashes($memberrow['id']);
            echo '<tr class="datatable"><td>'.$id.'</td><td>'.$memberrow['BankName'].'</td><td><a href="deletebank.php?id='.$id.'"><img src="images/delete.ico" width="20" height="20"></a></td></tr>';
        }
        ?>
    </table>
    </td></tr>
    </table>
    </td></tr>
</table>