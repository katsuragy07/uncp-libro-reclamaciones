<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once "../connect.php";

    if(isset($_GET['size']) && isset($_GET['offset'])){
        $size = $_GET['size'];
        $offset = $_GET['offset'];
        $query = "SELECT * FROM dependencias LEFT JOIN registros ON dependencias.iddependencia = registros.dependencias_iddependencia GROUP BY iddependencia ORDER BY iddependencia DESC LIMIT $size OFFSET $offset;"; 
    }else{
        $query = "SELECT * FROM oficinas ORDER BY nombre ASC;";
    }
    

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }

    $json = array();

    while($row = $result->fetch_array()){

        $json[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre']
        );   
    
    }

    echo json_encode($json);



?>