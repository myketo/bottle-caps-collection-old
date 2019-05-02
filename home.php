<?php
    if(isset($_POST['submit_search'])){
        $search = mysqli_real_escape_string($conn, $_POST['searchVal']);
        $sort = mysqli_real_escape_string($conn, strtolower($_POST['sortVal']));
        
        if(empty($search)){
            $searchError = "<span class='error'>Nic nie wpisałeś.</span>";
        }else{
            $location = empty($sort) ? "?pg=search&s=$search" : "?pg=search&s=$search&sort=$sort";
            header("Location: $location");
        }
    }


    $latest_query = "SELECT * FROM kolekcja ORDER BY id DESC LIMIT 6;";
    $latest_result = mysqli_query($conn, $latest_query);

    $caps_count_query = "SELECT COUNT(id) FROM kolekcja;";
    $caps_count_result = mysqli_query($conn, $caps_count_query);
    foreach($caps_count_result as $count) $caps_count = $count['COUNT(id)'];
?>

<?php
    include "header.php";
?>

<div class='searchDiv'>
    <form class="search_bar large" method='POST'>
        <div class="search_dropdown" style="width: 16px;">
            <span>Sortuj</span>
            <ul>
            <li class="selected">Wszystko</li>
            <li>Marka</li>
            <li>Napis</li>
            <li>Kolor</li>
            <li>Kraj</li>
            </ul>
        </div>
        <input type='hidden' value='' class='sort' name='sortVal'>
        <input type="text" placeholder="Wyszukaj spośród <?php echo $caps_count; ?> kapsli!" name='searchVal' />
        
        <button type="submit" name='submit_search'>Szukaj</button>
    </form>
    <?php if(isset($searchError)) echo $searchError; ?>
</div>

<section class='home_page'>
    <h1>Ostatnio dodane:</h1>

    <table>
    <?php
        $i = 1;
        foreach($latest_result as $latest){
            $image = $latest['zdjecie'];
            $brand = $latest['marka'] ? $latest['marka'] : "Nieznane";
            $caption = $latest['napis'];
            $id = $latest['id'];

            if($i == 1 || $i == 4) echo "<tr>";

            echo 
            "<td>
                <img src='_caps/$image' id='myImg' alt='$brand' class='cap$i' onclick='showModal($i);'><br>
                <i>$brand</i>";
                if(isset($_SESSION['logged_in'])) echo 
                "<a href='?pg=update&id=$id' class='update'>Aktualizuj</a>";
                echo "<br><span title='$caption' class='caption'>$caption</span>
                <div id='myModal' class='modal modal$i'>
                    <span id='hideModal'>&times;</span>
                    <img class='modal-content' id='img'>
                    <div id='caption'></div>
                </div>
            </td>";

            if($i == 3 || $i == 6) echo "</tr>";

            $i++;
        }
    ?>
    </table>

    <p style='text-align: right;'><a href='?pg=collection&sort=id&order=desc' class='show_more'>Zobacz więcej...</a></p>
</section>

<script src='_scripts/modal.js'></script>

<?php
    include "footer.php";