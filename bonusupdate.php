<?php
include 'config.php';
$pmtqry=mysqli_query($config,"SELECT * FROM payments WHERE PaymentMonth='November 2020'");
$updated=0;
set_time_limit(0);
while($pmtrow=mysqli_fetch_assoc($pmtqry)){
    $mno=$pmtrow['Mno'];
    $newbonus=$pmtrow['bonus'];
    //check cummulative bonus
    $bonusqry=mysqli_query($config,"SELECT * FROM bonus WHERE `period`='2020' AND Mno='$mno'");
    $totalbonus=0;
    while($bonusrow=mysqli_fetch_assoc($bonusqry)){
        $bonus=$bonusrow['Amount'];
        $totalbonus=$totalbonus+$bonus;
    }
    //update payments total bonus

    if(mysqli_query($config,"UPDATE payments SET cummbonus='$totalbonus' Where Mno='$mno' and PaymentMonth='November 2020'")){
        mysqli_query($config,"UPDATE statements SET cummbonus='$totalbonus' WHERE Mno='$mno' AND PaymentMonth='November 2020'");
        $updated=$updated+1;
    }
}
echo 'Operation was successful.<br>';
echo 'Updated records: '.$updated;
?>