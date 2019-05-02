<?php
    $main_query = "SELECT * FROM kolekcja WHERE uzupelnic=1;";
    $main_result = mysqli_query($conn, $main_query);
    $caps_count = mysqli_num_rows($main_result);
?>

<?php
    include "header.php";
?>

<section class='unknown_page'>
    <h1>Nieznane kapsle<br><?php echo $caps_count; ?></h1>

    <div class='caps_list'>
    <?php
        $i = 1;
        foreach($main_result as $capInfo){
            $image = $capInfo['zdjecie'];
            $brand = $capInfo['marka'] ? $capInfo['marka'] : "Nieznane";
            $caption = $capInfo['napis'];
            $color = $capInfo['kolor'];
            $country = $capInfo['kraj'];
            $id = $capInfo['id'];

            echo "<div class='bottle_cap'>
                <img src='_caps/$image' id='myImg' alt='$brand' class='cap$i' onclick='showModal($i);'>
                <div id='myModal' class='modal modal$i'>
                    <span id='hideModal'>&times;</span>
                    <img class='modal-content' id='img'>
                    <div id='caption'></div>
                </div>
                <div class='cap_info'>
                    <span class='brand'><b>$i. </b>$brand";
                    if(isset($_SESSION['logged_in'])) echo " <a href='?pg=update&id=$id' class='update'>Aktualizuj</a>";
                    echo "</span>
                    <span class='caption'>$caption</span>
                    <span>$color</span>
                    <span>$country</span>
                </div>
            </div>";

            if($i != $caps_count) echo "<p class='line'></p>";

            $i++;
        }
    ?>
    </div>

    <button class='scroll_top' onclick="$(window).scrollTop(0);">Na górę</button>
</section>

<script src='_scripts/modal.js'></script>

<?php
    include "footer.php";