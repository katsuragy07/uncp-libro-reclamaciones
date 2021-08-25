<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    require_once "../connect.php";
    


    $key = $_GET['index'];
    $type = $_GET['type'];

    switch ($type) {
        case 'nombre':
            $query = "SELECT * FROM dependencias LEFT JOIN registros ON dependencias.iddependencia = registros.dependencias_iddependencia WHERE nombre LIKE '%$key%' GROUP BY iddependencia ORDER BY iddependencia DESC LIMIT 20;";
            break;
        
        case 'email':
            $query = "SELECT * FROM dependencias LEFT JOIN registros ON dependencias.iddependencia = registros.dependencias_iddependencia WHERE email LIKE '%$key%' GROUP BY iddependencia ORDER BY iddependencia DESC LIMIT 20;";
            break;
    }


    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }

    $json = array();

    while($row = $result->fetch_array()){
        
        $json[] = array(
            'id' => $row['iddependencia'],
            'idregistro' => $row['idregistro'],
            'nombre' => $row['nombre']
        ); 
    
    }

    echo json_encode($json);


    function br2nl($string){
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }

?>