<?php
include "header.php";

echo "<div class='kraje'>";

$query = "SELECT kraj, COUNT(kraj) FROM kolekcja WHERE kraj!='' GROUP BY kraj;";
$result = mysqli_query($connect, $query);

echo "<div class='alpha'>";
    foreach($result as $row){
        $kraj = preg_replace('/\s+/', '_', $row['kraj']);

        echo "<span class='all'><a href='index.php?str=wyswietl&kraj=$kraj'><img src='_icons/flags/".$kraj.".png'></img>".
        $row['kraj']." (".$row['COUNT(kraj)'].")</a></span><br>";
    }
echo "</div>";


$query1 = "SELECT kraj, COUNT(kraj) FROM kolekcja WHERE kraj!='' GROUP BY kraj ORDER BY COUNT(kraj) DESC;";
$result1 = mysqli_query($connect, $query1);
$i=0;
echo "<div class='top'>";
foreach($result1 as $row){
    $i++;
    $kraj = preg_replace('/\s+/', '_', $row['kraj']);

    if($i==1){
        echo "<span class='first'><a href='index.php?str=wyswietl&kraj=$kraj'>$i. ".
        $row['kraj']." (".$row['COUNT(kraj)'].")</a></span><br>";
    }elseif($i==2){
        echo "<span class='second'><a href='index.php?str=wyswietl&kraj=$kraj'>$i. ".
        $row['kraj']." (".$row['COUNT(kraj)'].")</a></span><br>";
    }elseif($i==3){
        echo "<span class='third'><a href='index.php?str=wyswietl&kraj=$kraj'>$i. ".
        $row['kraj']." (".$row['COUNT(kraj)'].")</a></span><br>";
    }else{
        echo "<span class='all'><a href='index.php?str=wyswietl&kraj=$kraj'>$i. ".
        $row['kraj']." (".$row['COUNT(kraj)'].")</a></span><br>";
    }
}
echo "</div>
</div>";

include "footer.php";