<?php
include 'headers.php';


?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><img src="images/view.png" width="23" height="23" align="left"><a href="clinicallist.php">Clinical List</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr><td>
           Bonus
       </td>
       
    </tr></table>
    <table width="78%" align="right">
        <tr><td>
            <form action="" method="POST">
            <table id="reportsheader" width="100%"><tr><th>
                Bonus Manual Entry
            </th></tr></table>
            </form>
        <form method="POST"><table>
            <tr><td>
                <img src="images/error.png" width="23" height="23" align="left">This module is currently inactive due to time expiry! Please contact your system admin.
            </td></tr>
    </table></form>
        <?php echo $form ?>
        </td></tr>
    </table>
    </td></tr>
</table>