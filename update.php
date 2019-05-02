<?php
    if(!isset($_SESSION['logged_in']) || !isset($_GET['id'])){
        header("Location: ".$_SERVER['PHP_SELF']);
        die();
    }

    $userID = $_SESSION['logged_in'];

    $id = $_GET['id'];

    $capNr_query = "SELECT COUNT(*) FROM kolekcja WHERE id<$id;";
    $capNr_result = mysqli_query($conn, $capNr_query);
    foreach($capNr_result as $capNrCount){
        $capNr = $capNrCount['COUNT(*)']+1;
    }


    $current_query = "SELECT * FROM kolekcja WHERE id=$id";
    $current_result = mysqli_query($conn, $current_query);

    if(mysqli_num_rows($current_result)){
        foreach($current_result as $currInfo){
            $currBrand = $currInfo['marka'];
            $currCaption = $currInfo['napis'];
            $currColor = $currInfo['kolor'];
            $currCountry = $currInfo['kraj'];
            $currImage = $currInfo['zdjecie'];
            $currUnknown = $currInfo['uzupelnic'];
        }
    }


    if(isset($_POST['submit_update'])){
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $color = mysqli_real_escape_string($conn, $_POST['color']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $unknown = isset($_POST['unknown']) ? 1 : 0;

        if(!empty($_FILES['image']['name'])){
            $imagePath = "_caps/$id.jpg";
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $image = "$id.jpg";
        }else{
            $image = $currImage;
        }

        $update_query = "UPDATE kolekcja SET marka='$brand', napis='$caption', kolor='$color', kraj='$country', zdjecie='$image', uzupelnic='$unknown' WHERE id=$id;";
        mysqli_query($conn, $update_query);

        $_SESSION['finished'] = true;

        $currBrand = $brand;
        $currCaption = $caption;
        $currColor = $color;
        $currCountry = $country;
        $currUnknown = $unknown;
        $currImage = $image;
    }
?>

<?php
    include "header.php";
?>

<?php
    if(!mysqli_num_rows($current_result)){
        echo "Kapsel o id $id nie istnieje w bazie.";
        die();
    }
?>

<section class='upd_page'>
    <?php
        if(isset($_SESSION['finished'])){
        echo "<div class='next_action'>
            <h2>Zaktualizowano pomyślnie!</h2>
            <a href='?pg=home'>Strona główna</a>
            <a href='".$_SERVER['HTTP_REFERER']."'>Popraw błędy</a>
        </div>";

        }else{
        echo "<form method='POST' class='upd_form' enctype='multipart/form-data'>
            <h1>Aktualizuj informacje</h1>

            <label for='upd_brand'>Marka</label>
            <input type='text' id='upd_brand' autofocus name='brand'>

            <label for='upd_caption'>Napis</label>
            <input type='text' id='upd_caption' name='caption'>

            <label for='upd_color'>Kolor</label>
            <input type='text' id='upd_color' placeholder='wzór: czar-biał-złot' name='color'>

            <label for='upd_country'>Kraj</label>
            <input type='text' id='upd_country' name='country'>

            <label for='upd_image'>Zdjęcie</label>
            <label for='upd_image' class='over_file' tabindex='0'>Zmień zdjęcie</label>
            <input type='file' id='upd_image' accept='image/*' name='image'>

            <label for='upd_unknown'>
            <input type='checkbox' id='upd_unknown' name='unknown'";
            if($currUnknown) echo " checked";
            echo ">
            Nieznana marka</label>
            
            <input type='submit' value='Aktualizuj' name='submit_update'>
        </form>";
        }
    ?>

    <section class='preview'>
        <section class='image_preview'>
            <img src='_caps/<?php echo $currImage."?".rand(1, 10); ?>' class='image'>
            <div class='cap_info'>
                <div class='container'>
                    <b><?php echo $capNr; ?>. </b>
                    <span class='brand' id='Marka'><?php echo $currBrand; ?></span>
                    <div class='unknown' <?php if($currUnknown) echo "style='display: block'"; ?>>?</div>
                </div>
                <span class='caption' id='Napis'><?php echo $currCaption; ?></span>
                <span class='color' id='Kolor'><?php echo $currColor; ?></span>
                <span class='country' id='Kraj'><?php echo $currCountry; ?></span>
            </div>
        </section>
    </section>
</section>

<script src='_scripts/update.js'></script>

<?php
    if(isset($_SESSION['finished'])){
        session_unset();
        $_SESSION['logged_in'] = $userID;
    }

    include "footer.php";