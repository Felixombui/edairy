<?php
session_start();

if ( isset( $_SESSION['active'] ) ) {
    //Do nothing
} else {
    header( 'location:login.php' );
}
$thisMonth = date( 'F Y' );
include 'config.php';
include 'styles.html';
?>
<script>

function printData()
 {
    var divToPrint = document.getElementById( 'printTable' );
    newWin = window.open( '' );
    newWin.document.write( divToPrint.outerHTML );
    newWin.print();
    newWin.close();
}
</script>
<table width = '90%' align = 'center' class = 'heading'>
<tr><td><a href = 'index.php'><img src = 'images/home.png' width = '20' height = '20' align = 'left'>Home</a></td>
<td><div class = 'tooltip'><img src = 'images/products.png' align = 'left' height = '20' width = '20'>New<span class = 'profiletiptext'>
<p><a href = 'newmember.php'><img src = 'images/personnel.png' width = '20' height = '20' align = 'left'> Member</a></p><p>
<img src = 'images/bank.png' width = '23' height = '23' align = 'left'><a href = 'newbank.php'>Bank</a></p>
<p><img src = 'images/orders.png' width = '20' height = '20' align = 'left'><a href = 'collections.php'>Collections</a></p>
<p><img src = 'images/newuser.png' width = '25' height = '20' align = 'left'><a href = 'users.php'>User</a></p></span></div></td>
<td><div class = 'tooltip'><img src = 'images/store.png' align = 'left' height = '20' width = '20'>Store<span class = 'profiletiptext'>
<p><a href = 'issueitems.php'><img src = 'images/emptycart.png' width = '20' height = '20' align = 'left'> Issue Items</a></p>
<p><a href = 'stockcard.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Stock Card </a></p>
</span></div></td>
<td><a href = 'advance.php'><img src = 'images/pay.png' align = 'left' height = '20' width = '20'>Advance</a></td>
<td><a href = 'ai.php'><img src = 'images/ai.png' align = 'left' height = '20' width = '20'>A.I & Clinicals</a></td>
<td><div class = 'tooltip'><img src = 'images/bonus.png' align = 'left' height = '20' width = '20'>Bonus<span class = 'profiletiptext'>
<p><a href = 'manualbonus.php'><img src = 'images/edit.png' width = '20' height = '20' align = 'left'>Manual Entry</a></p>
<p><a href = 'bonusstatements.php'><img src = 'images/view.png' width = '20' height = '20' align = 'left'>Statements</a></p>
<p><a href = 'paybonus.php'><img src = 'images/success.png' width = '20' height = '20' align = 'left'>Pay Bonus</a></p>
</span></div> </td>
<td><div class = 'tooltip'><img src = 'images/tools.png' align = 'left' height = '20' width = '20'>Tools<span class = 'profiletiptext'>
<p><img src = 'images/key.png' width = '20' height = '20' align = 'left'>Change Rate</p>
<p><a href = 'payfarmers.php'><img src = 'images/pay.png' width = '20' height = '20' align = 'left'> Process Payments</a></p>

</span></td>
<td><div class = 'tooltip'><img src = 'images/projects.png' align = 'left' height = '20' width = '20'>Reports<span class = 'profiletiptext'>
<p><a href = 'collectionslist.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Collection Reports</a></p>
<p><a href = 'storereports.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Store Reports</a></p>
<p><a href = 'advancereports.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Advance Reports</a></p>
<p><a href = 'clinicalreports.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> A.I & Clinical Reports</a></p>
<p><a href="bonuspaymentreport.php"><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Bonus Payment Reports</a></p>
<p><a href = 'memberpayments.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Member Payments</a></p>
<p><a href = 'bankanalysis.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'>Bank Analysis</a></p>
<p><a href = 'memberstatements.php'><img src = 'images/db.png' width = '20' height = '20' align = 'left'> Member statements</a></p>
</span></div>
</td>
<td><a href = 'help.php'><img src = 'images/help.png' align = 'left' height = '20' width = '20'>Help & About</a></td>
<td width = '30%'><div class = 'tooltip'><img src = 'images/user.png' width = '20' height = '20' align = 'left'><?php echo $_SESSION['fullnames'] ?><span class = 'profiletiptext'>

<p><a href = 'changepass.php'><img src = 'images/key.png' width = '23' height = '23' align = 'left'>Change Password</a></p>
<p><a href = 'logout.php'><img src = 'images/signout.png' width = '23' height = '23' align = 'left'>Logout</a></p>

</span></div></td></tr>
</table>