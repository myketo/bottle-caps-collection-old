<?php
    if(isset($_POST['search'])){
        $szukaj = mysqli_real_escape_string($connect, $_POST['szukaj']);
        $select = $_POST['select'];
        if($select=='wszystko'){
            header("Location: index.php?str=szukaj&szukaj=$szukaj");
        }else{
            header("Location: index.php?str=szukaj&szukaj=$szukaj&select=$select");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="_style/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <title>Kolekcja kapsli</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
  AOS.init();
</script>
    </head>
    <body>

       <section class="all">
            <nav class='navigation'>
                <div class='header'><a href="index.php"><h1>KOLEKCJA KAPSLI</h1></a></div>
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
                    <?php if(isset($_SESSION['logged_in'])) echo "<div><a href='index.php?str=dodaj'><img src='_icons/dodaj.png' alt='dodaj'><p>Dodaj</p></a></div>"; ?>
                    <div><a href="index.php?str=wyswietl">
                        <span class='count'><?php
                        $query = "SELECT COUNT(id) FROM kolekcja;";
                        $result = mysqli_query($connect, $query);
                        foreach($result as $row){
                            echo $row['COUNT(id)'];
                        }
                        ?></span>&nbsp;<i class="far fa-eye"></i>&nbsp;<p>Kapsle</p></a>
                    </div>
                    <div><a href="index.php?str=uzupelnic"><i class="far fa-question-circle"></i>&nbsp;<p>Nieznane</p></a></div>
                    <div><a href="index.php?str=kraje"><i class="far fa-flag"></i>&nbsp;<p>Kraje</p></a></div>
                    <div><a href="index.php?str=login"><i class="fas fa-sign-in-alt"></i> &nbsp;
                    <?php if(isset($_SESSION['logged_in'])) echo "class='loginImg'"; ?>
                    <p><?php echo isset($_SESSION['logged_in']) ? "Wyloguj" : "Zaloguj" ?></p></a></div>
                </section>
            </nav>
            <section class="main">
                <main>