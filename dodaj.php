<?php
    if(!isset($_SESSION['logged_in'])){
        header("Location: /home");
    }else{
        $loggedUser = $_SESSION['logged_in'];
    }

    include "header.php";
?>
<div class="dodaj">
  <h2>Dodaj nowy kapsel: </h2>
   <form method="POST" enctype="multipart/form-data" onsubmit="return check()">
        <label for="marka">Marka: </label><input type="text" name="marka" id="marka"><br>
        <label for="napis">Napis: </label><input type="text" name="napis" id="napis"><br>
        <label for="kolor">Kolor: </label> <input type="text" name="kolor" id="kolor" placeholder= "e.g. czar-biał-złot"><br>
        <label for="kraj">Kraj pochodzenia: </label> <input type="text" name="kraj" id="kraj"><br>
        <input type="hidden" name="size" value="1000000">
        <label for="zdjecie">Wybierz zdjęcie: </label><input type="file" name="zdjecie" id="zdjecie"><br>
        <input type='checkbox' name='uzupelnic' id='uzupelnic'>
        <label for='uzupelnic'>Do uzupełnienia</label><br>
        <input type="submit" name="submit" value="Dodaj">
    </form>
    <br>
    
    <script src="check.js"></script>
<?php
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
        
        $query1 = "SELECT id FROM kolekcja ORDER BY id DESC LIMIT 1";
        $result1 = mysqli_query($connect, $query1);
        foreach($result1 as $row){
            $id = $row['id']+1;
        }
        
        $id2 = $id.".";
        $id3 = "images/";
        $target = $id3.$id2.'jpg';
        $img = $id2.'jpg';
        
        $exists = "images/CONFIRM.jpg";
        
        $_SESSION['marka'] = $marka;
        $_SESSION['napis'] = $napis;
        $_SESSION['kolor'] = $kolor;
        $_SESSION['kraj'] = $kraj;
        $_SESSION['zdjecie'] = $zdjecie;
        $_SESSION['id'] = $id;
        $_SESSION['target'] = $target;
        $_SESSION['img'] = $img;
        $_SESSION['exists'] = $exists;
        $_SESSION['uzupelnic'] = $uzupelnic;
        
        $query2 = "SELECT * FROM kolekcja WHERE marka='$marka' AND napis='$napis' AND kolor='$kolor';";
        $result2 = mysqli_query($connect, $query2);
        
        if(mysqli_num_rows($result2)>0){
            echo 'Kapsel o podanych danych znajduje się już w bazie: <br>';
            echo '<div class="tabelka"><table>';
            
            foreach($result2 as $row1){
                if($row1['napis']!=""){
                    $row1['napis']="'".$row1['napis']."'";
                }else{
                    $row1['napis']="&nbsp";
                }
                if($row1['kraj']==""){
                    $row1['kraj']="&nbsp";
                }
                if($row1['uzupelnic']=="1" && $row1['marka']==""){
                    $row1['marka']="NIEZNANE";
                }

                echo "<tr>
                <td rowspan='4' width='20%'><img src='images/".$row1['zdjecie']."' alt='BRAK ZDJĘCIA'></td>
                <td><h3>".$row1['marka']."<a href='index.php?str=aktualizuj&id=".$row1['id']."'>(Aktualizuj)</a></h3></td>
                </tr><tr>
                <td><h5>".$row1['napis']."</h5></td>
                </tr><tr>
                <td><h5>".$row1['kolor']."</h5></td>
                </tr><tr>
                <td><h5>".$row1['kraj']."</h5></td>
                </tr>";   
            }
            echo '</table></div>';
            
            if(isset($zdjecie)){
                move_uploaded_file($_FILES['zdjecie']['tmp_name'], $exists);   
            }
            
            $_SESSION['add_anyway'] = true;
        
        }else{
            move_uploaded_file($_FILES['zdjecie']['tmp_name'], $target);
            $add = "INSERT INTO kolekcja(marka, napis, zdjecie, kolor, kraj, uzupelnic) VALUES('$marka', '$napis', '$img', '$kolor', '$kraj', $uzupelnic);";
            mysqli_query($connect, $add);
            echo "Dodano! (id: $id)";

            session_unset();
            $_SESSION['logged_in'] = $loggedUser;
  	     }
    }

    if(isset($_SESSION['add_anyway'])){
        unset($_SESSION['add_anyway']);
        echo "<form method='POST'>
            Czy nadal chcesz dodać kapsel do bazy?<br>
            <input type='submit' name='add' value='DODAJ'> 
            <input type='submit' name='reset' value='ANULUJ'>
        </form>";
    }
    
    if(isset($_POST['add'])){
            $marka = $_SESSION['marka'];
            $napis = $_SESSION['napis'];
            $kolor = $_SESSION['kolor'];
            $kraj = $_SESSION['kraj'];
            $id = $_SESSION['id'];
            $target = $_SESSION['target'];
            $img = $_SESSION['img'];
            $exists = $_SESSION['exists'];
            $uzupelnic = $_SESSION['uzupelnic'];
        
            if(file_exists($exists)){
                rename($exists, $target);   
            }
        
            $add = "INSERT INTO kolekcja(marka, napis, zdjecie, kolor, kraj, uzupelnic) VALUES('$marka', '$napis', '$img', '$kolor', '$kraj', $uzupelnic);";
            mysqli_query($connect, $add);
            echo "Dodano! (id: $id)";

            session_unset();
            $_SESSION['logged_in'] = $loggedUser;
    }
    
    if(isset($_POST['reset'])){
        $exists = $_SESSION['exists'];

        if(file_exists($exists)){
            unlink($exists);   
        }
        
        session_unset();
        $_SESSION['logged_in'] = $loggedUser;
        
        header("Location: /dodaj");
    }
    
echo "</div>";

include "footer.php";