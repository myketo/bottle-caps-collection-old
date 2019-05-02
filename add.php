<?php
    if(!isset($_SESSION['logged_in'])){
        header("Location: ".$_SERVER['PHP_SELF']);
        die();
    }

    if(isset($_GET['confirm']) && !file_exists("_caps/CONFIRM.jpg")){
        header("Location: index.php?pg=add");
        die();
    }

    if(isset($_GET['finished']) && !isset($_SESSION['Kolor'])){
        header("Location: index.php?pg=add");
        die();
    }

    $userID = $_SESSION['logged_in'];

    if(!isset($_GET['finished']) && !isset($_GET['confirm'])){
        if(isset($_SESSION['Zdjęcie'])){
            $imageTempPath = $_SESSION['Zdjęcie'];

            if(file_exists($imageTempPath)){
                unlink($imageTempPath);   
            }
        }
        
        session_unset();
        $_SESSION['logged_in'] = $userID;

    }


    $capsCount_query = "SELECT * FROM kolekcja;";
    $capsCount_result = mysqli_query($conn, $capsCount_query);
    $capsCount = mysqli_num_rows($capsCount_result);


    if(isset($_POST['submit_add'])){
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $color = mysqli_real_escape_string($conn, $_POST['color']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $unknown = isset($_POST['unknown']) ? 1 : 0;
        $image = $_FILES['image']['name'];

        $_SESSION['Marka'] = $brand;
        $_SESSION['Napis'] = $caption;
        $_SESSION['Kolor'] = $color;
        $_SESSION['Kraj'] = $country;
        $_SESSION['Nieznane'] = $unknown;

        $lastId_query = "SELECT id FROM kolekcja ORDER BY id DESC LIMIT 1;";
        $lastId_result = mysqli_query($conn, $lastId_query);
        foreach($lastId_result as $last){
            $id = $last['id']+1;
            $_SESSION['id'] = $id;
        }

        $imageNewName = "$id.jpg";
        $imageNewPath = "_caps/$id.jpg";


        $checkExists_query = "SELECT * FROM kolekcja WHERE marka='$brand' AND napis='$caption' AND kolor='$color' AND kraj='$country';";
        $checkExists_result = mysqli_query($conn, $checkExists_query);
        $checkExists = mysqli_num_rows($checkExists_result);
        
        if($checkExists != 0){
            foreach($checkExists_result as $existsInfo){
                $_SESSION['existsId'] = $existsInfo['id'];
                $_SESSION['existsImage'] = $existsInfo['zdjecie'];
                $_SESSION['image'] = $imageNewName;
            }

            $imageTempPath = "_caps/CONFIRM.jpg";
            move_uploaded_file($_FILES['image']['tmp_name'], $imageTempPath);

            $_SESSION['Zdjęcie'] = $imageTempPath;
            $_SESSION['newPath'] = $imageNewPath;

            header("Location: index.php?pg=add&confirm");

        }else{
            move_uploaded_file($_FILES['image']['tmp_name'], $imageNewPath);
    
            $addNew_query = "INSERT INTO kolekcja(marka, napis, zdjecie, kolor, kraj, uzupelnic) VALUES('$brand', '$caption', '$imageNewName', '$color', '$country', $unknown);";
            mysqli_query($conn, $addNew_query);
    
            $_SESSION['Zdjęcie'] = $imageNewPath;
            $_SESSION['capsCount'] = $capsCount;
            header("Location: index.php?pg=add&finished");
        }
    }

    if(isset($_POST['submit_addAnyway'])){
        $brand = $_SESSION['Marka'];
        $caption = $_SESSION['Napis'];
        $color = $_SESSION['Kolor'];
        $country = $_SESSION['Kraj'];
        $unknown = $_SESSION['Nieznane'];
        $image = $_SESSION['image'];
        $imageTempPath = $_SESSION['Zdjęcie'];
        $imageNewPath = $_SESSION['newPath'];

        if(file_exists($imageTempPath)) rename($imageTempPath, $imageNewPath);

        $addNew_query = "INSERT INTO kolekcja(marka, napis, zdjecie, kolor, kraj, uzupelnic) VALUES('$brand', '$caption', '$image', '$color', '$country', $unknown);";
        mysqli_query($conn, $addNew_query);

        $_SESSION['Zdjęcie'] = $imageNewPath;
        $_SESSION['capsCount'] = $capsCount;
        header("Location: index.php?pg=add&finished");
        die();
    }

    if(isset($_POST['submit_addCancel'])){
        $imageTempPath = $_SESSION['Zdjęcie'];
        if(file_exists($imageTempPath)){
            unlink($imageTempPath);   
        }

        session_unset();
        $_SESSION['logged_in'] = $userID;
        header("Location: index.php?pg=add");
        die();
    }
?>

<?php
    include "header.php";
?>

<section class='add_page'>
<?php
    if(isset($_GET['finished'])){
    $id = $_SESSION['id'];
    echo "<div class='next_action'>
        <h2>Dodano pomyślnie!</h2>
        <a href='?pg=add'>Dodaj następny</a>
        <a href='?pg=update&id=$id'>Aktualizuj</a>
    </div>";

    }else{
    echo "<form method='POST' class='add_form' enctype='multipart/form-data'>
        <h1>Dodaj nowy kapsel</h1>

        <label for='add_brand'>Marka</label>
        <input type='text' id='add_brand' name='brand' autofocus>

        <label for='add_caption'>Napis</label>
        <input type='text' id='add_caption' name='caption'>

        <label for='add_color'>Kolor</label>
        <input type='text' id='add_color' placeholder='wzór: czar-biał-złot' name='color'>

        <label for='add_country'>Kraj</label>
        <input type='text' id='add_country' name='country'>

        <label for='add_image'>Zdjęcie</label>
        <label for='add_image' class='over_file' tabindex='0'>Wybierz zdjęcie</label>
        <input type='file' id='add_image' accept='image/*' name='image'>

        <label for='add_unknown'>
        <input type='checkbox' id='add_unknown' name='unknown'>
        Nieznana marka</label>
        
        <input type='submit' value='Dodaj' name='submit_add'>
    </form>";
    }
?>
    <section class='preview'>
        <section class='image_preview'>
            <img src='<?php checkSession("Zdjęcie"); ?>' class='image'>
            <div class='cap_info'>
                <div class='container'>
                    <b><?php echo isset($_SESSION['capsCount']) ? $_SESSION['capsCount']+1 : $capsCount+1; ?> .</b>
                    <span class='brand' id='Marka'><?php checkSession("Marka"); ?></span>
                    <div class='unknown' <?php checkSession("Nieznane"); ?>>?</div>
                </div>
                <span class='caption' id='Napis'><?php checkSession("Napis"); ?></span>
                <span class='color' id='Kolor'><?php checkSession("Kolor"); ?></span>
                <span class='country' id='Kraj'><?php checkSession("Kraj"); ?></span>
            </div>
        </section>

        <?php
        if(isset($_GET['confirm'])){
            $existsImage = $_SESSION['existsImage'];
            $existsId = $_SESSION['existsId'];
            echo "<section class='image_preview'>
                <img src='_caps/$existsImage' class='image'>
                <form class='exists' method='POST'>
                    <span>id: <b>$existsId</b></span>
                    <a href='?pg=update&id=$existsId' class='update'>Aktualizuj</a>
                    <p>Kapsel o tych danych znajduje się już w bazie.<br>Dodać mimo tego?</p><br>
                    <div>
                        <input type='submit' value='Dodaj' name='submit_addAnyway'>
                        <input type='submit' value='Anuluj' name='submit_addCancel' id='cancel'>
                    </div>
                </form>
            </section>";
        }
        ?>
    </section>

    <script src='_scripts/add.js'></script>
</section>

<?php
    if(isset($_GET['finished'])){
        session_unset();
        $_SESSION['logged_in'] = $userID;
    }

    include "footer.php";