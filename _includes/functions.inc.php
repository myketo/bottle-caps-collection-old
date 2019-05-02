<?php
    function checkErrors($field){
        if(isset($_SESSION["error_$field"])){
            echo "<span class='error'>" . $_SESSION["error_$field"] . "</span>";
            unset($_SESSION["error_$field"]);
        }
    }

    function checkSession($field){
        if(isset($_SESSION["$field"])){
            if($field == "Nieznane" && $_SESSION["Nieznane"] == 1){
                echo "style='display: block;'";
            }else{
                echo $_SESSION["$field"];
            }
        }else{
            if($field == 'Zdjęcie'){
                echo "_assets/preview.png";
            }else{
                echo $field;
            }
        }
    }

    function urlPage($i){
        $url = parse_url($_SERVER['REQUEST_URI']);

        if(strpos($url['query'], '&page')){
            return "?".preg_replace('/[0-9]+/', $i, $url['query']);
        }else{
            return "?".$url['query']."&page=$i";
        }
    }

    function checkISO($get){
        $plik = fopen('_assets/iso.txt','r');
    
        $i = 0;
        $j = 0;
        $e = 0;
        $countries = [];
        $iso = [];
        while(!feof($plik)){
           $linia = fgets($plik);
           if($i%2==0){
               $countries[$j] = trim(preg_replace('/\s+/', ' ', $linia));
               $j++;
           }else{
               $iso[$e] = trim($linia);
               $e++;
           }
           $i++;
        }
    
        fclose($plik);

        if($get == 'countries'){
            return $countries;
        }
        
        if($get == 'iso'){
            return $iso;
        }
    }