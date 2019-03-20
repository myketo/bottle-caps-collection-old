<?php
    if(isset($_POST['submit'])){
        $sort = $_POST['select'];
        header("Location: index.php?str=wyswietl&page=1&sort=$sort");
    }

    include "header.php";
?>
<div class="tabelka">
  <div class="wyswietl__top">
      <h2>Wszystkie kapsle: </h2>
      <form method="POST">
          <label>Sortuj według: </label>
          <select name="select">
              <option value="marka" <?php if(isset($_GET['sort']) && $_GET['sort']=='marka'){echo "selected='selected'";}; ?>
              >Marka</option>
              <option value="napis" <?php if(isset($_GET['sort']) && $_GET['sort']=='napis'){echo "selected='selected'";}; ?>
              >Napis</option>
              <option value="kolor" <?php if(isset($_GET['sort']) && $_GET['sort']=='kolor'){echo "selected='selected'";}; ?>
              >Kolor</option>
              <option value="kraj" <?php if(isset($_GET['sort']) && $_GET['sort']=='kraj'){echo "selected='selected'";}; ?>
              >Kraj</option>
              <option value="id" <?php if(isset($_GET['sort']) && $_GET['sort']=='id'){echo "selected='selected'";}; ?>
              >Dodanie</option>
          </select>
          <input type="submit" name="submit" value="SORTUJ">
      </form>
  </div>
  
<?php
    unset($kraj);
    unset($sort);
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    if(isset($_GET['sort'])){
        $sort = $_GET['sort'];
    }

    if(isset($_GET['kraj'])){
        $kraj = $_GET['kraj'];
    }
    
    $offset = ($page*20)-20;
    
    $query1 = "SELECT * FROM kolekcja;";
    $result1 = mysqli_query($connect, $query1);
    $all = mysqli_num_rows($result1);
    
    if(isset($sort)){
        $query = "SELECT * FROM kolekcja ORDER BY $sort LIMIT 20 OFFSET $offset;";
    }elseif(isset($kraj)){
        $kraj = str_replace('_', ' ', $kraj);
        $checkq = "SELECT * FROM kolekcja WHERE kraj='$kraj';";
        $checkr = mysqli_query($connect, $checkq);
        $all = mysqli_num_rows($checkr);
        $query = "SELECT * FROM kolekcja WHERE kraj='$kraj' LIMIT 20 OFFSET $offset;";
    }else{
        $query = "SELECT * FROM kolekcja LIMIT 20 OFFSET $offset;";   
    }
    
    $result = mysqli_query($connect, $query);
    
    $i = ($page*20)-19;
    
    $limit = $page*20;
    $j = ($page*20)-19;
    $last = ceil($all/20);
    
    for($j; $j<=$limit; $j++){
        if($all<=20){
            echo "<center>Strona $page </center>";
            break;
        }elseif($page==1){
            echo "<center>
                <span>Strona $page</span>
                <a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+1)."</a>
                <a href='index.php?str=wyswietl&page=".($page+2);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+2)."</a>
                <a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>--></a>
                <a href='index.php?str=wyswietl&page=$last";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Ostatnia</a>
            </center>";
            break;
        }else if($page==$last){
            echo "<center>
                <a href='index.php?str=wyswietl&page=1";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Pierwsza</a>
                <a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'><--</a>";
        if($page>2){
            echo "<a href='index.php?str=wyswietl&page=".($page-2);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-2)."</a>";
        }
            echo "<a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-1)."</a>
                <span>Strona $page</span>
            </center>";
            break;
        }else if($page<$last){
            echo "<center>
                <a href='index.php?str=wyswietl&page=1";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Pierwsza</a>
                <a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'><--</a>
                "; if(($page-2)>=1){echo "<a href='index.php?str=wyswietl&page=".($page-2);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-2)."</a>";};
            echo "<a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-1)."</a>
                <span>Strona $page</span>
                <a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+1)."</a>
                "; if(($page+2)<=$last){echo "<a href='index.php?str=wyswietl&page=".($page+2);
                if(isset($sort)){echo '&sort='.$sort;};    
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+2)."</a>";};
            echo "<a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>--></a>
                <a href='index.php?str=wyswietl&page=$last";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Ostatnia</a>
            </center>";
            break;
        }
    }
    
    echo "<table class='content'>";
    foreach($result as $row){
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
        <td><h3>".$i++.". ".$row['marka'];
        if(isset($logged)) echo "<a href='index.php?str=aktualizuj&id=".$row['id']."'>(Aktualizuj)</a>";
        
        echo "</h3></td>
        </tr><tr>
        <td><h5>".$row['napis']."</h5></td>
        </tr><tr>
        <td><h5>".$row['kolor']."</h5></td>
        </tr><tr>
        <td><h5>".$row['kraj']."</h5></td>
        </tr>";
    }
    echo '</table>';
    
    for($j; $j<=$limit; $j++){
        if($all<=20){
            echo "<center>Strona $page </center>";
            break;
        }elseif($page==1){
            echo "<center>
                <span>Strona $page</span>
                <a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+1)."</a>
                <a href='index.php?str=wyswietl&page=".($page+2);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+2)."</a>
                <a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>--></a>
                <a href='index.php?str=wyswietl&page=$last";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Ostatnia</a>
            </center>";
            break;
        }else if($page==$last){
            echo "<center>
                <a href='index.php?str=wyswietl&page=1";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Pierwsza</a>
                <a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'><--</a>";
        if($page>2){
            echo "<a href='index.php?str=wyswietl&page=".($page-2);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-2)."</a>";
        }
            echo "<a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-1)."</a>
                <span>Strona $page</span>
            </center>";
            break;
        }else if($page<$last){
            echo "<center>
                <a href='index.php?str=wyswietl&page=1";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Pierwsza</a>
                <a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'><--</a>
                "; if(($page-2)>=1){echo "<a href='index.php?str=wyswietl&page=".($page-2);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-2)."</a>";};
            echo "<a href='index.php?str=wyswietl&page=".($page-1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page-1)."</a>
                <span>Strona $page</span>
                <a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+1)."</a>
                "; if(($page+2)<=$last){echo "<a href='index.php?str=wyswietl&page=".($page+2);
                if(isset($sort)){echo '&sort='.$sort;};    
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>".($page+2)."</a>";};
            echo "<a href='index.php?str=wyswietl&page=".($page+1);
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>--></a>
                <a href='index.php?str=wyswietl&page=$last";
                if(isset($sort)){echo '&sort='.$sort;};
                if(isset($kraj)){echo '&kraj='.$kraj;};
            echo "'>Ostatnia</a>
            </center>";
            break;
        }
    }
echo "</div>";

include "footer.php";