<?php
    if(isset($_POST['search'])){
        $szukaj = $_POST['szukaj'];
        $select = $_POST['select'];
        if($select=='wszystko'){
            header("Location: /szukaj/$szukaj");
        }else{
            header("Location: /szukaj/$select/$szukaj");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <base href='http://mikolajpiecek.000webhostapp.com/'/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="_style/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
        <title>Kolekcja kapsli</title>
    </head>
    <body>

       <section class="all">
            <nav>
                <div class='header'><a href="/home"><h1>KOLEKCJA KAPSLI</h1></a></div>
                <div class='search'>
                    <form method="POST">
                        <select name="select">
                            <option value="wszystko" <?php if(isset($_GET['select']) && $_GET['select']=='wszystko'){echo "selected='selected'";}; ?>
                            >Wszystko</option>
                            <option value="marka" <?php if(isset($_GET['select']) && $_GET['select']=='marka'){echo "selected='selected'";}; ?>
                            >Marka</option>
                            <option value="napis" <?php if(isset($_GET['select']) && $_GET['select']=='napis'){echo "selected='selected'";}; ?>
                            >Napis</option>
                            <option value="kolor" <?php if(isset($_GET['select']) && $_GET['select']=='kolor'){echo "selected='selected'";}; ?>
                            >Kolor</option>
                            <option value="kraj" <?php if(isset($_GET['select']) && $_GET['select']=='kraj'){echo "selected='selected'";}; ?>
                            >Kraj</option>
                        </select>
                        <input type="text" name="szukaj">
                        <input type="submit" name="search" value="SZUKAJ">
                    </form>
                </div>
                <section class='nav'>
                    <?php if(isset($_SESSION['logged_in'])) echo "<div><a href='/dodaj'><img src='_icons/dodaj.png' alt='dodaj'><p>Dodaj</p></a></div>"; ?>
                    <div><a href="/wyswietl">
                        <span class='count'><?php
                        $query = "SELECT COUNT(id) FROM kolekcja;";
                        $result = mysqli_query($connect, $query);
                        foreach($result as $row){
                            echo $row['COUNT(id)'];
                        }
                        ?></span><img src='_icons/kapsle.png' alt='kapsle'><p>Kapsle</p></a>
                    </div>
                    <div><a href="/nieznane"><img src='_icons/nieznane.png' alt='nieznane'><p>Nieznane</p></a></div>
                    <div><a href="/kraje"><img src='_icons/kraje.png' alt='kraje'><p>Kraje</p></a></div>
                    <div><a href="/login"><img src='_icons/login.png' alt='login' 
                    <?php if(isset($_SESSION['logged_in'])) echo "class='loginImg'"; ?>>
                    <p><?php echo isset($_SESSION['logged_in']) ? "Wyloguj" : "Zaloguj" ?></p></a></div>
                </section>
            </nav>
            <section class="main">
                <main>