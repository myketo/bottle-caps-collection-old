<?php
    if(isset($_GET['iso']) && $_GET['iso'] != ""){
        $plik = fopen('_assets/iso.txt','r');
    
        $i = 0;
        $j = 0;
        $e = 0;
        $countries = [];
        $iso = [];
        while(!feof($plik)){
           $linia = fgets($plik);
           if($i%2==0){
               $countries[$j] = $linia;
               $j++;
           }else{
               $iso[$e] = $linia;
               $e++;
           }
           $i++;
        }
    
        fclose($plik);


        for($i=0; $i<390/2; $i++){
            if(strtolower(trim($iso[$i])) == $_GET['iso']){
                $country = trim(preg_replace('/\s+/', ' ', $countries[$i]));
            }
        }
    }
    

    $caps_count_query = "SELECT COUNT(id) FROM kolekcja";
    if(isset($country)) $caps_count_query .= " WHERE kraj='$country';";
    $caps_count_result = mysqli_query($conn, $caps_count_query);

    foreach($caps_count_result as $count){
        $caps_count = $count['COUNT(id)'];
    }
    
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page*10)-10;

    $main_query = "SELECT * FROM kolekcja";
    if(isset($country)) $main_query .= " WHERE kraj='$country'";
    if(isset($_GET['sort'])) $main_query .= " ORDER BY ".$_GET['sort'];
    if(isset($_GET['order'])) $main_query .= " ".$_GET['order'];
    $main_query.= " LIMIT 10 OFFSET $offset;";

    $main_result = mysqli_query($conn, $main_query);

    $i = ($page*10)-9;
    
    $limit = $page*10;
    $j = ($page*10)-9;
    $last = ceil($caps_count/10);

?>