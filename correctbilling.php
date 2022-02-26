<?php
include 'config.php';
$qry=mysqli_query($config,"SELECT * FROM collections WHERE CollectionMonth='September 2020'");
$corrected=0;
set_time_limit(0);
while($row=mysqli_fetch_assoc($qry)){
    $mno=$row['Mno'];
    $names=$row['Names'];
    $kgs=$row['CurrentReading'];
    $date=$row['CollectionDate'];
    $month=$row['CollectionMonth'];
    if(mysqli_query($config,"INSERT INTO billing(Mno,Names,PrevReading,CurrentReading,TotalCollections,CollectionDate,CollectionMonth) VALUES('$mno','$names','0.0','$kgs','$kgs','$date','$month')")){
        $corrected=$corrected+1;
    }
}
echo 'Corrected Records: '.$corrected;
?>