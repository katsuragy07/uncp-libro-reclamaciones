<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once "../connect.php";



    $pages_size = $_GET['size'];


    $rs = $mysqli->query("SELECT COUNT(*) AS filas FROM dependencias;");
    if($row = $rs->fetch_array()) {
        $pages_total = $row['filas'];
    }
    $pages = ceil($pages_total / $pages_size); 



    $json = array();

    if($pages==0){
        $json[] = array(
            'pagina' => 1,
            'size' => 0,
            'offset' => 0
        );   
    }else{
        for($i = 0; $i < $pages; $i++){
        
            $json[] = array(
                'pagina' => $i+1,
                'size' => $pages_size,
                'offset' => $i*$pages_size
            );   
        
        }
    }
    

    echo json_encode($json);



?>