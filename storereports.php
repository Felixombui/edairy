<?php
include 'headers.php';
if ( $_POST['search'] ) {
    $stext = $_POST['searchtext'];
    $smonth = $_POST['smonth'];
    $syear = $_POST['syear'];
    $month = $smonth.' '.$syear;
    if ( empty( $stext ) ) {
        $storeqry = mysqli_query( $config, "SELECT * FROM store WHERE SalesMonth='$month'" );
    } else {
        $storeqry = mysqli_query( $config, "SELECT * FROM store WHERE Mno='$stext' and SalesMonth='$month'" );
    }
}
if ( isset( $_POST['export'] ) ) {
    require_once( 'includes/tcpdf.php' );
    $obj_pdf = new TCPDF( 'P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );
    $obj_pdf->SetCreator( PDF_CREATOR );
    $obj_pdf->SetTitle( 'Store Reports '.$month );
    $obj_pdf->SetHeaderData( '', '', PDF_HEADER_TITLE, PDF_HEADER_STRING );
    $obj_pdf->SetHeaderFont( Array( PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN ) );
    $obj_pdf->SetFooterFont( Array( PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN ) );
    $obj_pdf->SetDefaultMonospacedFont( 'helvetica' );
    $obj_pdf->SetFooterMargin( PDF_MARGIN_FOOTER );
    $obj_pdf->SetMargins( PDF_MARGIN_LEFT, '10', PDF_MMARGN_RIGHT );
    $obj_pdf->SetPrintHeader( false );
    $obj_pdf->SetPrintFooter( false );
    $obj_pdf->SetAutoPageBreak( TRUE, 10 );
    $obj_pdf->SetFont( 'helvetica', '', 11 );
    $obj_pdf->AddPage();
    $content = '';
    $content .= '<h4 align="Center">Store Reports '.$month.'';
    $content = '<table border="1" cellspacing="0" cellpadding="3">
    <tr>
        <th>Mno</th><th>Names</th><th>Item</th><th>Balance</th>
        </tr>';
    while( @$storerow = mysqli_fetch_assoc( $storeqry ) ) {
        $mno = $storerow['Mno'];
        $names = $storerow['Names'];
        $item = $storerow['ItemName'];
        $balance = $storerow['balance'];
        $totalbalance = $totalbalance+$balance;
        $content = '<tr><td>'.$mno.'</td><td>'.$names.'</td><td>'.$item.'</td><td align="right">'.number_format( $balance, 2 ).'</td></tr>';
    }
    $content = '</table>';
    $obj_pdf->writeHTML( $content );
    $obj_pdf->OutPut( 'Store_Reports'.$smonth.'_'.$syear.'.pdf' );
}
?>
<table width = '90%' align = 'center'>
<tr><td>
<table width = '20%' align = 'left' bgcolor = 'cyan'>
<tr><td align = 'center'><img src = 'images/logo.png' width = '100' height = '100'><div class = 'creator'>Version 2.0<br> By Macra Systems</div>
<hr color = 'cadetblue'>
</td></tr>
</table>
<table width = '78%' align = 'right' bgcolor = 'cyan'><tr><td>
<form method = 'post'>
<input type = 'text' name = 'searchtext' value = "<?php echo $_POST['searchtext'] ?>" placeholder = 'Search Member Number'>
Select Month: <select name = 'smonth'>
<option selected><?php echo $_POST['smonth'] ?></option>
<option>January</option>
<option>February</option>
<option>March</option>
<option>April</option>
<option>May</option>
<option>June</option>
<option>July</option>
<option>August</option>
<option>September</option>
<option>October</option>
<option>November</option>
<option>December</option>
</select>
<select name = 'syear'>
<option selected><?php echo $_POST['syear'] ?></option>
<option>2017</option>
<option>2018</option>
<option>2019</option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
</select>
<input type = 'submit' name = 'search' value = 'Search' id = 'smallbutton'>

</form>

<?php
echo '<a href="downloadstore.php?smonth='.$_POST['smonth'].'&syear='.$_POST['syear'].'"><button id="smallbutton">Download</button>';
?>
</td>

</tr></table>
<div id = 'areaToPrint'>
<table width = '78%' align = 'right'>
<tr><td>
<table id = 'widereports' width = '10%' align = 'left'>
<tr><th>Mno</th><th>Names</th><th>Item</th><th>Balance</th></tr>
<?php
$totalbalance = 0;
while( @$storerow = mysqli_fetch_assoc( $storeqry ) ) {
    $mno = $storerow['Mno'];
    $names = $storerow['Names'];
    $item = $storerow['ItemName'];
    $balance = $storerow['balance'];
    $totalbalance = $totalbalance+$balance;
    echo '<tr><td>'.$mno.'</td><td>'.$names.'</td><td>'.$item.'</td><td align="right">'.number_format( $balance, 2 ).'</td></tr>';
}
echo '<tr><td></td><td></td><td>Total</td><td align="right">'.number_format( $totalbalance, 2 ).'</td></tr>';
?>

</table>
<?php
echo '<a href="downloadstore.php?smonth='.$_POST['smonth'].'&syear='.$_POST['syear'].' target="_new"><button id="smallbutton">Download</button>';
?>
</td></tr>
</table></div>

</td></tr>
</table>