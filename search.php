<?php
    if(isset($_GET['s'])){
        $search = $_GET['s'];

        $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
        $offset = ($page*10)-10;

        $main_query = "SELECT * FROM kolekcja WHERE ";
        if(isset($_GET['sort'])){
            $sort = $_GET['sort'];
            $main_query .= "$sort LIKE '%$search%' ORDER BY $sort";
        }else{
            $main_query .= "marka LIKE '%$search%' OR napis LIKE '%$search%' OR kolor LIKE '%$search%' OR kraj LIKE '%$search%'";
        }

        $capsCount_result = mysqli_query($conn, $main_query);
        $caps_count = mysqli_num_rows($capsCount_result);

        $main_query .= " LIMIT 10 OFFSET $offset;";
        $main_result = mysqli_query($conn, $main_query);

        $lastPage = ceil($caps_count/10);
    }
?>

<?php
    include "header.php";
?>

<section class='search_page'>
    <?php
        if($caps_count){
            echo "<h1>Znaleziono <u>$caps_count</u> wyników dla <br>";
            if(isset($sort)) echo "$sort: ";
            echo "<i>'$search'</i></h1>";
        }else{
            echo "<h1>Brak pasujących wyników dla <br>";
            if(isset($sort)) echo "$sort: ";
            echo "<i>'$search'</i></h1>";
        }
    ?>

    <div class='page_nav_top'>
    <?php
        $i = 1;
        if ($page > 6) $i += $page-6;

        $buttonsLimit = $page <= 6 ? 5+$page : 11;
        if($page > 6 && $page < $lastPage-5) $buttonsLimit += $page-6;
        if($page >= $lastPage-5) $buttonsLimit = $lastPage;

        $shownCapNr = 1;
        for($i; $i <= $buttonsLimit; $i++){
            // if all caps fit in one page
            if($caps_count <= 10) break;
            
            if($shownCapNr == 1){
                if($page == 1){
                    echo "<b>Pierwsza</b><b><img src='_assets/arrow_side.png' class='back'></b>";
                }else{
                    echo "<a href='".urlPage(1)."'>Pierwsza</a><a href='".urlPage($page-1)."'><img src='_assets/arrow_side.png' class='back'></a>";
                }
            }

            echo $i == $page ? "<b>$i</b>" : "<a href='".urlPage($i)."'>$i</a>";

            if($i == $buttonsLimit){
                if($page == $lastPage){
                    echo "<b><img src='_assets/arrow_side.png'></b><b>Ostatnia</b>";
                }else{
                    echo "<a href='".urlPage($page+1)."'><img src='_assets/arrow_side.png'></a><a href='".urlPage($lastPage)."'>Ostatnia</a>";
                }
            }

            $shownCapNr++;
        }
    ?>
    </div>

    <div class='caps_list'>
    <?php
        $capNr = ($page*10)-9;
        foreach($main_result as $capInfo){
            $image = $capInfo['zdjecie'];
            $brand = $capInfo['marka'] ? $capInfo['marka'] : "Nieznane";
            $caption = $capInfo['napis'];
            $color = $capInfo['kolor'];
            $country = $capInfo['kraj'];
            $id = $capInfo['id'];

            echo "<div class='bottle_cap'>
                <img src='_caps/$image' id='myImg' alt='$brand' class='cap$capNr' onclick='showModal($capNr);'>
                <div id='myModal' class='modal modal$capNr'>
                    <span id='hideModal'>&times;</span>
                    <img class='modal-content' id='img'>
                    <div id='caption'></div>
                </div>

                <div class='cap_info'>
                    <span class='brand'><b>$capNr. </b>$brand";
                    if(isset($_SESSION['logged_in'])) echo " <a href='?pg=update&id=$id' class='update'>Aktualizuj</a>";
                    echo "</span>
                    <span class='caption'>$caption</span>
                    <span>$color</span>
                    <span>$country</span>
                </div>
            </div>";

            if($capNr != 10) echo "<p class='line'></p>";

            $capNr++;
        }
    ?>
    </div>

    <div class='page_nav_bot'>
    <?php
        $i = 1;
        if ($page > 6) $i += $page-6;

        $buttonsLimit = $page <= 6 ? 5+$page : 11;
        if($page > 6 && $page < $lastPage-5) $buttonsLimit += $page-6;
        if($page >= $lastPage-5) $buttonsLimit = $lastPage;

        $shownCapNr = 1;
        for($i; $i <= $buttonsLimit; $i++){
            // if all caps fit in one page
            if($caps_count <= 10) break;
            
            if($shownCapNr == 1){
                if($page == 1){
                    echo "<b>Pierwsza</b><b><img src='_assets/arrow_side.png' class='back'></b>";
                }else{
                    echo "<a href='".urlPage(1)."'>Pierwsza</a><a href='".urlPage($page-1)."'><img src='_assets/arrow_side.png' class='back'></a>";
                }
            }

            echo $i == $page ? "<b>$i</b>" : "<a href='".urlPage($i)."'>$i</a>";

            if($i == $buttonsLimit){
                if($page == $lastPage){
                    echo "<b><img src='_assets/arrow_side.png'></b><b>Ostatnia</b>";
                }else{
                    echo "<a href='".urlPage($page+1)."'><img src='_assets/arrow_side.png'></a><a href='".urlPage($lastPage)."'>Ostatnia</a>";
                }
            }

            $shownCapNr++;
        }
    ?>
    </div>

    <?php
        if($caps_count >= 10) echo "<button class='scroll_top' onclick='$(window).scrollTop(0);'>Na górę</button>";
    ?>
</section>

<script src='_scripts/modal.js'></script>

<?php
    include "footer.php";