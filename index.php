<?php
    session_start();
    include "_includes/connect.inc.php";
    include "_includes/functions.inc.php";
    mysqli_set_charset($conn, "utf8");

    if(isset($_GET['pg'])){
        $activePage = $_GET['pg'];

        switch ($activePage){
            case 'home':
                include "home.php";
                break;

            case 'login':
                include "login.php";
                break;

            case 'collection':
                include "collection.php";
                break;

            case 'countries':
                include "countries.php";
                break;

            case 'add':
                include "add.php";
                break;

            case 'update':
                include "update.php";
                break;

            case 'unknown':
                include "unknown.php";
                break;

            case 'search':
                include "search.php";
                break;

            default:
                include "home.php";
        }
    }else{
        include "home.php";
    }