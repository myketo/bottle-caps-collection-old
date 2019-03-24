<?php
session_start();
include "connect.php";

mysqli_set_charset($connect, "utf8");

if(isset($_GET['str'])){
    $strona = $_GET['str'];

    switch($strona){
        case "aktualizuj":
            include "aktualizuj.php";
            break;
             
        case "dodaj":
            include "dodaj.php";
            break;

        case "kraje":
            include "kraje.php";
            break;
        
        case "login":
            include "login.php";
            break;

        case "szukaj":
            include "szukaj.php";
            break;
        
        case "nieznane":
            include "nieznane.php";
            break;

        case "wyswietl":
            include "wyswietl.php";
            break;

        default:
            include "home.php";
    }

}else{
    include "home.php";
}