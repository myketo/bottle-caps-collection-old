<?php 
include "header.php";

echo "<div class='tabelka'>
    <h2>Niepełne dane: </h2>";

    $query = "SELECT * FROM kolekcja WHERE uzupelnic=1;";
    $result = mysqli_query($connect, $query);
    
    echo "<table>";
    foreach($result as $row){
        if($row['napis']!=""){
            $row['napis']="'".$row['napis']."'";
        }else{
            $row['napis']="&nbsp";
        }
        if($row['kraj']==""){
            $row['kraj']="&nbsp";
        }
        if($row['uzupelnic']=="1" && $row['marka']==""){
            $row['marka']="NIEZNANE";
        }

        echo "<tr>
        <td rowspan='4' width='20%'><img src='images/".$row['zdjecie']."' alt='BRAK ZDJĘCIA'></td>
        <td><h3>".$row['marka']; 
        if(isset($_SESSION['logged_in'])) echo "<a href='index.php?str=aktualizuj&id=".$row['id']."'>(Aktualizuj)</a>";
        echo "</h3></td>
        </tr><tr>
        <td><h5>".$row['napis']."</h5></td>
        </tr><tr>
        <td><h5>".$row['kolor']."</h5></td>
        </tr><tr>
        <td><h5>".$row['kraj']."</h5></td>
        </tr>";
    }
    echo "</table>
</div>";

include "footer.php";