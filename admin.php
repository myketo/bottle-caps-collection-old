<?php
    include "header.php";

    $limit = 1;
    $offset = $limit - 1;

    $last_dates_query = "SELECT created_at as `date` FROM kolekcja UNION SELECT updated_at FROM kolekcja ORDER BY `date` DESC LIMIT $limit;";
    $dates = mysqli_query($conn, $last_dates_query);

    $latest_changes_query = "SELECT id, marka, created_at, updated_at FROM kolekcja WHERE created_at >= (SELECT created_at FROM kolekcja UNION SELECT updated_at FROM kolekcja ORDER BY created_at DESC LIMIT 1 OFFSET $offset) OR updated_at >= (SELECT created_at FROM kolekcja UNION SELECT updated_at FROM kolekcja ORDER BY created_at DESC LIMIT 1 OFFSET $offset);";
    $changes = mysqli_query($conn, $latest_changes_query);

    $i = 0;
    foreach($dates as $row){
        $date[$i] = $row['date'];
        $i++;
    }
?>

<section class='admin_page'>
    <h1>Admin Panel</h1>
    <br>
    <h3>Ostatnia aktywność:</h3>
    <ul>
    <?php
        for($i=0; $i<=$offset; $i++){
            echo "<p class='date'><u>".$date[$i]."</u></p>";
            foreach($changes as $row){
                $marka = $row['marka'];
                $id = $row['id'];

                if($date[$i] == $row['created_at']){
                    echo "<li>Dodano nowy kapsel - 
                    <a href='?pg=update&id=$id'>$marka($id)</a>.</li>";
                }
                
                if($date[$i] == $row['updated_at']){
                    echo "<li>Zaktualizowano informacje - 
                    <a href='?pg=update&id=$id'>$marka($id)</a>.</li>";
                }
            }
        }
    ?>
    </ul>
</section>

<?php
    include "footer.php";