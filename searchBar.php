<?php
require_once("connect.php");
mysqli_set_charset($connect, "utf8");
session_start();

$output = "";

if(isset($_POST['searchVal'])){
    $szukaj = $_POST['searchVal'];

    if(!empty($szukaj)){
        $query = "SELECT * FROM kolekcja WHERE /*kraj LIKE '%$szukaj%' OR */marka LIKE '%$szukaj%' 
        OR napis LIKE '%$szukaj%' OR kolor LIKE '%$szukaj%' LIMIT 6;";
        $result = mysqli_query($connect, $query);
    
        $ile_znaleziono = mysqli_num_rows($result);
        if($ile_znaleziono == 0){
            $output = "<div style='height: 20px'>Nie znaleziono pasujących wyników.</div>";
        }else{
            $i = 0;
            foreach($result as $row){
                if($i!=5){
                    $id = $row['id'];
        
                    $marka = preg_replace("/".preg_quote($szukaj, "/")."/i", "<u>$0</u>", $row['marka']);
                    $napis = preg_replace("/".preg_quote($szukaj, "/")."/i", "<u>$0</u>", $row['napis']);
                    $kolor = preg_replace("/".preg_quote($szukaj, "/")."/i", "<u>$0</u>", $row['kolor']);

                    isset($_SESSION['logged_in']) ? $output.= "<a href='/aktualizuj/$id'>" : "";
                    $output .= "<div class='wynik'>$marka<br>$napis<br>$kolor</div>";
                    isset($_SESSION['logged_in']) ? $output.= "</a>" : "";
                    $output .= "<hr>";

                    $i++;
                }
            }
    
            if($ile_znaleziono>5){
                $output .= "<a href='/szukaj/$szukaj'><div style='height: 20px'>Więcej wyników...</div></a>";
            }
        }
    }
}

echo $output;