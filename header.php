<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bottle Caps Collection - Mikołaj Pięcek</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
    <link rel="stylesheet" type="text/css" href="_styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='_scripts/searchbar.js'></script>
    <script>
        function myFunction(x){
            x.classList.toggle("change");
            document.getElementById("fullscreen").classList.toggle("change");
            
            if($("body").css("overflow") == "auto"){
                $("body,html").css("overflow", "hidden");
            }else{
                $("body,html").css("overflow", "auto");
            }
        }
    </script>
</head>
<body>
    <nav>
        <a href='?pg=home' class='logo'>
            <h1>Bottle Caps Collection</h1>
            <h2>Mikołaj Pięcek</h2>
        </a>

        <div class="hamburger" onclick="myFunction(this)">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>

        <div class="toggle_full" id='fullscreen'>
            <div class='fullscreen'>
                <?php
                    if(isset($_SESSION['logged_in'])) echo 
                    "<a href='?pg=admin' class='user'>
                        ADMIN PANEL
                    </a>";
                ?>
                <a href='?pg=login' class='first'>
                <?php echo isset($_SESSION['logged_in']) ? "Wyloguj" : "Zaloguj"; ?>
                </a>
                <form class='search'>
                        <input type='text' placeholder='Szukaj...'>
                        <input type='image' value='submit' src='_assets/search.png'>
                    </form>
                <?php
                    if(isset($_SESSION['logged_in'])) echo
                    "<a href='?pg=add'>Dodaj</a>";
                ?>
                <a href='?pg=collection'>Kolekcja</a>
                <a href='?pg=unknown'>Nieznane</a>
                <a href='?pg=countries'>Kraje</a>
            </div>
        </div>
        
        <section class='nav_le'>
            <a href='?pg=collection' class='wszystkie 
            <?php if(isset($activePage) && $activePage == 'collection') echo "active_page"; ?>
            '>
                <h3>Kolekcja</h3>
            </a>

            <a href='?pg=unknown' class='nieznane 
            <?php if(isset($activePage) && $activePage == 'unknown') echo "active_page"; ?>
            '>
                <h3>Nieznane</h3>
            </a>

            <a href='?pg=countries' class='kraje 
            <?php if(isset($activePage) && $activePage == 'countries') echo "active_page"; ?>
            '>
                <h3>Kraje</h3>
            </a>
        </section>

        <section class='nav_ri'>
            <?php
                if(isset($_SESSION['logged_in'])){
                    echo 
                    "<a href='?pg=add' class='dodaj ";
                    if(isset($activePage) && $activePage == 'add') echo "active_page";
                    echo "'>
                        <h3>Dodaj</h3>
                    </a>
                    <a href='?pg=admin' class='user ";
                    if(isset($activePage) && $activePage == 'admin') echo "active_page";
                    echo "'>
                        <h3>Admin Panel</h3>
                    </a>";
                }
            ?>

            <a href='?pg=login' class="login 
            <?php if(isset($activePage) && $activePage == 'login') echo "active_page"; ?>
            ">
                <h3>
                <?php echo isset($_SESSION['logged_in']) ? "Wyloguj" : "Zaloguj"; ?>
                </h3>
            </a>
        </section>
    </nav>

    <main>