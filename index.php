<?php
include 'headers.php';
$memberqry=mysqli_query($config,"SELECT * FROM members");
$members=mysqli_num_rows($memberqry);
$maleqry=mysqli_query($config,"SELECT * FROM members WHERE Gender='Male'");
$male=mysqli_num_rows($maleqry);
$femaleqry=mysqli_query($config,"SELECT * FROM members WHERE Gender='Female'");
$female=mysqli_num_rows($femaleqry);
?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr><td>
           Welcome to eDairy Version 2.0
       </td>
       
    </tr></table>
    <table width="78%" align="right">
        <tr><td>
        <table id="reports" width="10%" align="left">
            <tr><th>Members: <?php echo $members ?></th></tr>
            <tr><td>Men: <?php echo $male ?></td></tr>
            <tr><td>Women: <?php echo $female ?></td></tr>
        </table>
        <table id="reports" width="10%" align="right">
            <tr><th>Members: <?php echo $members ?></th></tr>
            <tr><td>Men: <?php echo $male ?></td></tr>
            <tr><td>Women: <?php echo $female ?></td></tr>
        </table>
        <table id="reports" width="10%" align="left">
            <tr><th>Members: <?php echo $members ?></th></tr>
            <tr><td>Men: <?php echo $male ?></td></tr>
            <tr><td>Women: <?php echo $female ?></td></tr>
        </table>
        </td></tr>
    </table>
    </td></tr>
</table>