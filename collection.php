<?php
    if(isset($_POST['submit_sort'])){
        $sort = $_POST['sort'];
        $order = $_POST['order'];
        header("Location: ?pg=collection&sort=$sort&order=$order");
    }
    
    if(isset($_GET['iso']) && $_GET['iso'] != ""){
        $countries = checkISO('countries');
        $iso = checkISO('iso');

        for($i=0; $i<390/2; $i++){
            if(strtolower($iso[$i]) == $_GET['iso']) $country = $countries[$i];
        }
    }


    $caps_count_query = "SELECT COUNT(id) FROM kolekcja";
    if(isset($country)) $caps_count_query .= " WHERE kraj='$country';";
    $caps_count_result = mysqli_query($conn, $caps_count_query);
    foreach($caps_count_result as $count) $caps_count = $count['COUNT(id)'];

    if(isset($_GET['sort'])) $sort = $_GET['sort'];
    if(isset($_GET['order'])) $order = $_GET['order'];


    $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
    $offset = ($page*10)-10;
    $lastPage = ceil($caps_count/10);
    // $capNr = ($page*10)-9; // first cap of page
    // $lastCap = $page*10;


    $main_query = "SELECT * FROM kolekcja";
    if(isset($country)) $main_query .= " WHERE kraj='$country'";
    if(isset($sort)) $main_query .= " ORDER BY $sort";
    if(isset($order)) $main_query .= " $order";
    $main_query .= " LIMIT 10 OFFSET $offset;";

    $main_result = mysqli_query($conn, $main_query);
?>

<?php
    include 'header.php';
?>

<section class='collection_page'>
    <h1><?php echo isset($country) ? $country : "Kolekcja kapsli"; ?><br><?php echo $caps_count; ?></h1>
    <div class='sorting'>
        <button class='show_sort'>Sortowanie <img src='_assets/arrow.png' class='sort_arrow'></button>
        
        <form class='hidden_sort_div' method='POST'>
            <div class='sort'>
                <span>Sortuj według: </span>
                <select class='sort_by' name='sort'>
                    <option value="id"
                    <?php if(!isset($sort) || $sort == 'id') echo "selected";?>
                    >Data</option>
                    <option value="marka"
                    <?php if(isset($sort) && $sort == 'marka') echo "selected"; ?>
                    >Marka</option>
                    <option value="napis"
                    <?php if(isset($sort) && $sort == 'napis') echo "selected"; ?>
                    >Napis</option>
                    <option value="kolor"
                    <?php if(isset($sort) && $sort == 'kolor') echo "selected"; ?>
                    >Kolor</option>
                    <option value="kraj"
                    <?php if(isset($sort) && $sort == 'kraj') echo "selected"; ?>
                    >Kraj</option>
                </select>
            </div>
            <br>
            <div class='order'>
                <span>Kolejność: </span>
                <div class='order_by'>
                    <label>
                        <input type='radio' name='order' value='asc'
                        <?php if(isset($order) && $order == 'asc') echo "checked"; ?>>
                        <span class='radio1'>Najstarsze</span>
                    </label>
                    <label>
                        <input type='radio' name='order' value='desc'
                        <?php if(!isset($order) || $order == 'desc') echo "checked"; ?>>
                        <span class='radio2'>Najnowsze</span>
                    </label>
                </div>
            </div>
            <br>
            <input type='submit' value='Sortuj' name='submit_sort'>
        </form>
    </div>

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

<script src='_scripts/collection.js'></script>
<script src='_scripts/modal.js'></script>

<?php
    include 'footer.php';