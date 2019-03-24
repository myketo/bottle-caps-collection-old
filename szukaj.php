<?php
include "header.php";

echo "<section class='znalezione'>";

    if(isset($_GET['szukaj'])){
        $szukaj = $_GET['szukaj'];
        
        if(empty($szukaj)){
            echo "<p>Nic nie wpisałeś.</p>";
        }else{
            if(isset($_GET['select'])){
                $select = $_GET['select'];
                $query = "SELECT * FROM kolekcja WHERE $select LIKE '%$szukaj%' ORDER BY $select;";
            }else{
                $query = "SELECT * FROM kolekcja WHERE kraj LIKE '%$szukaj%' OR marka LIKE '%$szukaj%' 
                OR napis LIKE '%$szukaj%' OR kolor LIKE '%$szukaj%';";
            }
            
            $result = mysqli_query($connect, $query);

            $ile_znaleziono = mysqli_num_rows($result);
            echo '<p>Liczba znalezionych wyników: <b>'.$ile_znaleziono.'</b></p>';
                
    echo '<table>';
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
        if(isset($_SESSION['logged_in'])) echo "<a href='/aktualizuj/".$row['id']."'>(Aktualizuj)</a>";
        echo "</h3></td>
        </tr><tr>
        <td><h5>".$row['napis']."</h5></td>
        </tr><tr>
        <td><h5>".$row['kolor']."</h5></td>
        </tr><tr>
        <td><h5>".$row['kraj']."</h5></td>
        </tr>";
    }
    echo '</table>';
        }
    }

echo "</section>";

include "footer.php";