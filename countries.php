<?php
    if(isset($_GET['order']) && $_GET['sort'] == 'kraj'){
        if($_GET['order'] == 'desc'){
            $kOrder = 'asc';
        }else{
            $kOrder = 'desc';
        }
    }else{
        $kOrder = 'desc';
    }

    if(isset($_GET['order']) && $_GET['sort'] == 'count(kraj)'){
        if($_GET['order'] == 'desc'){
            $cOrder = 'asc';
        }else{
            $cOrder = 'desc';
        }
    }else{
        $cOrder = 'desc';
    }

    $countries = checkISO('countries');
    $iso = checkISO('iso');


    $topCountr_query = "SELECT kraj FROM kolekcja WHERE kraj != '' GROUP BY kraj ORDER BY COUNT(kraj) DESC LIMIT 3;";
    $topCountr_result = mysqli_query($conn, $topCountr_query);

    $i = 0;
    foreach($topCountr_result as $topCountrInfo){
        $topCountr[$i] = $topCountrInfo['kraj'];
        $i++;
    }

    for($i=0; $i<390/2; $i++){
        if($topCountr[0] == $countries[$i]) $topCoutrIso[0] = $iso[$i];
        if($topCountr[1] == $countries[$i]) $topCoutrIso[1] = $iso[$i];
        if($topCountr[2] == $countries[$i]) $topCoutrIso[2] = $iso[$i];
    }


    $countr_query = "SELECT kraj, COUNT(kraj) FROM kolekcja WHERE kraj != '' GROUP BY kraj";
    if(isset($_GET['sort'])){
        $countr_query .= " ORDER BY ".$_GET['sort'];
    }else{
        $countr_query .= " ORDER BY COUNT(kraj)";
    }
    if(isset($_GET['order'])){
        $countr_query .= " ".$_GET['order'];
    }else{
        $countr_query .= " DESC";
    }
    $countr_result = mysqli_query($conn, $countr_query);

    $i = 0;
    foreach($countr_result as $countrInfo){
        $countrName[$i] = $countrInfo['kraj'];
        $i++;
    }

    $u = 0;
    for($j = 0; $j < $i; $j++){
        for($k=0; $k<390/2; $k++){
            if($countrName[$j] == $countries[$k]){
                $countrIso[$u] = $iso[$k];
                $u++;
                break;
            }
        }
    }
?>

<?php
    include "header.php";
?>

<section class='countries_page'>
    <div class='podium'>
        <div class='first_place podium_place'>
            <img src='_assets/flags-iso/shiny/64/<?php echo $topCoutrIso[0]; ?>.png'>
            <span><?php echo $topCountr[0]; ?></span>
        </div>

        <div class='second_place podium_place'>
        <img src='_assets/flags-iso/shiny/64/<?php echo $topCoutrIso[1]; ?>.png'>
            <span><?php echo $topCountr[1]; ?></span>
        </div>

        <div class='third_place podium_place'>
        <img src='_assets/flags-iso/shiny/64/<?php echo $topCoutrIso[2]; ?>.png'>
            <span><?php echo $topCountr[2]; ?></span>
        </div>
    </div>

    <div class='countries_list'>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Flaga</th>
                    <th>Państwo <a href='?pg=countries&sort=kraj&order=<?php echo $kOrder; ?>'><img src='_assets/sort.png'></a></th>
                    <th>Kolekcja <a href='?pg=countries&sort=count(kraj)&order=<?php echo $cOrder; ?>'><img src='_assets/sort.png'></a></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                foreach($countr_result as $countrInfo){
                    $kraj = $countrInfo['kraj'];
                    $count = $countrInfo['COUNT(kraj)'];
                    echo "<tr>
                        <td>$i</td>
                        <td><img src='_assets/flags-iso/flat/32/".$countrIso[$i-1].".png'></td>
                        <td><a href='?pg=collection&iso=".strtolower($countrIso[$i-1])."'>$kraj</a></td>
                        <td>$count</td>
                    </tr>";
                    $i++;
                }
            ?>
            </tbody>
        </table>
    </div>
</section>

<?php
    include "footer.php";