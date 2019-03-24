<?php
if(!isset($_SESSION['logged_in'])){
    header("Location: index.php");
}

$id = $_GET['id'];

if(isset($_POST["submit"])){
        
    $marka = mysqli_real_escape_string($connect, $_POST['marka']);
    $napis = mysqli_real_escape_string($connect, $_POST['napis']);
    $kolor = mysqli_real_escape_string($connect, $_POST['kolor']);
    $kraj = mysqli_real_escape_string($connect, $_POST['kraj']);
    if(isset($_POST['uzupelnic'])){
        $uzupelnic = 1;   
    }else{
        $uzupelnic = 0;
    }
    $zdjecie = $_FILES['zdjecie']['name'];

    $id2 = $id.".";
    $id3 = "images/";
    $target = $id3.$id2.'jpg';
    $img = $id2.'jpg';

    $query = "SELECT * FROM kolekcja WHERE id=$id;";
    $result = mysqli_query($connect, $query);
    foreach($result as $row){
        if($marka==""){
            $marka=$row['marka'];
        }
        if($napis==""){
            $napis=$row['napis'];
        }
        if($kolor==""){
            $kolor=$row['kolor'];
        }
        if($kraj==""){
            $kraj=$row['kraj'];
        }
    }

    $update = "UPDATE kolekcja SET marka='$marka', napis='$napis', kolor='$kolor', kraj='$kraj', zdjecie='$img', uzupelnic='$uzupelnic' WHERE id=$id;";
    mysqli_query($connect, $update);
    move_uploaded_file($_FILES['zdjecie']['tmp_name'], $target);
    $msg = 'Zaktualizowano pomyślnie!';
}


$query = "SELECT * FROM kolekcja WHERE id=$id;";
$result = mysqli_query($connect, $query);

foreach($result as $row){
    if($row['uzupelnic']==1){
        $checked = true;
    }
}


include "header.php";
?>
<div class="dodaj">
    <h2>Aktualizuj: </h2>
   <form method="POST" enctype="multipart/form-data">
        <label for="marka">Marka: </label><input type="text" name="marka" id="marka"><br>
        <label for="napis">Napis: </label><input type="text" name="napis" id="napis"><br>
        <label for="kolor">Kolor: </label><input type="text" name="kolor" id="kolor" placeholder= "e.g. czar-biał-złot"><br>
        <label for="kraj">Kraj pochodzenia: </label><input type="text" name="kraj" id="kraj"><br>
        <label for="zdjecie">Wybierz zdjęcie: </label><input type="file" name="zdjecie" id="zdjecie"><br>
        <input type='checkbox' name='uzupelnic' id='uzupelnic' <?php if(isset($checked)) echo "checked"; ?>>
        <label for='uzupelnic'>Do uzupełnienia</label><br>
        <input type="submit" name="submit" value="Aktualizuj">
    </form>
    <br>
<?php
    if(isset($msg)) echo $msg; unset($msg);

    $query1 = "SELECT * FROM kolekcja WHERE id=$id;";
    $result1 = mysqli_query($connect, $query1);
    
    echo "<div class='tabelka'>
        <table>";
    foreach($result1 as $row){
            if($row['napis']!=""){
                $row['napis']="'".$row['napis']."'";
            }else{
                $row['napis']="&nbsp";
            }
            if($row['kraj']==""){
                $row['kraj']="&nbsp";
            }
            if($row['uzupelnic']=="1" && $row['marka']==""){
                $row['marka']="NIEZNANE";
            }

            echo "<tr>
                <td rowspan='4' width='20%'><img src='images/".$row['zdjecie']."' alt='BRAK ZDJĘCIA'></td>
                <td><h3>".$row['marka']."</h3></td>
                </tr><tr>
                <td><h5>".$row['napis']."</h5></td>
                </tr><tr>
                <td><h5>".$row['kolor']."</h5></td>
                </tr><tr>
                <td><h5>".$row['kraj']."</h5></td>
            </tr>";
    }
        echo "</table>
    </div>
</div>";

include "footer.php";