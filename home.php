<?php
include "header.php";

echo "<section class='ostatnie'>
    <h2>Ostatnio dodane:</h2>
        <table>";

$query = "SELECT * FROM kolekcja ORDER BY id DESC LIMIT 9;";
$result = mysqli_query($connect, $query);

$i=0;
foreach($result as $row){
    $i++;
    if($row['napis']!=""){
        $title=$row['napis'];
        $row['napis']="'".$row['napis']."'";

        if(preg_match('/\s+/', $title)){
            $title=preg_replace('/\s+/', '&nbsp;', $title);
        }

    }else{
        $row['napis']="&nbsp";
    }
    if($row['uzupelnic']=="1" && $row['marka']==""){
        $row['marka']="NIEZNANE";
    }


    if($i==1 || $i==4 || $i==7){
        echo "<tr>
        <td><img src='images/".$row['zdjecie']."' alt='BRAK ZDJĘCIA'><br>
        <p class='diff'><i>".$row['marka']; 
        if(isset($_SESSION['logged_in'])) echo "<a href='index.php?str=aktualizuj&id=".$row['id']."'>(Aktualizuj)</a>";
        echo "</i></p><p title=";
        if(isset($title))echo $title;
        echo ">".$row['napis']."</p></td>";
    }else if($i==2 || $i==5 || $i==8){
        echo "<td><img src='images/".$row['zdjecie']."' alt='BRAK ZDJĘCIA'><br>
        <p class='diff'><i>".$row['marka'];
        if(isset($_SESSION['logged_in'])) echo "<a href='index.php?str=aktualizuj&id=".$row['id']."'>(Aktualizuj)</a>";
        echo "</i></p><p title=";
        if(isset($title))echo $title;
        echo ">".$row['napis']."</p></td>";
    }else{
        echo "<td><img src='images/".$row['zdjecie']."' alt='BRAK ZDJĘCIA'><br>
        <p class='diff'><i>".$row['marka'];
        if(isset($_SESSION['logged_in'])) echo "<a href='index.php?str=aktualizuj&id=".$row['id']."'>(Aktualizuj)</a>";
        echo "</i></p><p title=";
        if(isset($title))echo $title;
        echo ">".$row['napis']."</p></td>";
    }
}

echo "</table>
</section>";

include "footer.php";