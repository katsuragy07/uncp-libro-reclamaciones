<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once "../connect.php";

    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $nro_doc = $_POST['nro_doc'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $adulto = $_POST['adulto'];
    $incidencia = $_POST['incidencia'];
    $dependencia = $_POST['dependencia'];
    $detalle = $_POST['detalle'];


    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    } 
    $detalle = saltoLinea($detalle);
    if($incidencia==0){
        $detalle = "Libro de Reclamaciones - Registro de Queja:<br> DNI/CE: $nro_doc <br> Dirección: $direccion <br> Teléfono: $telefono <br> Dependencia Involucrada: $dependencia <br>".$detalle;
    }else{
        $detalle = "Libro de Reclamaciones - Registro de Reclamo:<br> DNI/CE: $nro_doc <br> Dirección: $direccion <br> Teléfono: $telefono <br> Dependencia Involucrada: $dependencia <br>".$detalle;
    }
    
    
    
    $resultadoBD1 = false;
    $resultadoBD2 = false;

    $sql_nuevoid0="SELECT exp FROM `folioext` ORDER BY id DESC limit 1";
	$resultado0=$mysqli->query($sql_nuevoid0);
	$fila0 = $resultado0->fetch_array();
	$resultadonumeroexp=$fila0[0]+1;

    $query1 = "INSERT INTO `folioext` (`exp`, `asunto`, `firma`, `nfolios`, `fecha`, `user`, `empid`, `c_oficina`, `obs`, `file`, `ext`, `size`, `cabecera`, `td_tipos_id`, `pago`, `numerorecibo`, `urgente`) VALUES 
                        ('$resultadonumeroexp','$detalle','$nombre','1',now(),'vecino','532','113','$email','','','',CONCAT('Reclamo/Queja ',DATE_FORMAT(now(),'%d/%m/%y')),'36','0','','0');";


    $result1 = $mysqli->query($query1);
    if(!$result1){
        die("Query error " . mysqli_error($mysqli));
    }else{
        $resultadoBD1 = true;

        $sql_nuevoid="SELECT id FROM `folioext` ORDER BY id DESC limit 1";
		$resultado=$mysqli->query($sql_nuevoid);
		$fila = $resultado->fetch_array();
		$resultadonumero=$fila[0];

        $query2 = "INSERT INTO `log_derivar`(`id`, `tipo`, `forma`, `obs`, `fecha`, `user`, `empid`, `d_oficina`, `atendido`, `recibido`, `file`, `ext`, `size`, `provei`, `c_oficina`, `folioext_id`) VALUES 
                                    (null,0,0,'$email',now(),'vecino',532,'113',null,null,null,null,null,null,'113','$resultadonumero')";
        $result2 = $mysqli->query($query2);
    }

    if(!$result2){
        die("Query error " . mysqli_error($mysqli));
    }else{
        $resultadoBD2 = true;
    }


    $json = array();
    if($resultadoBD2){
        $json = array(
            'res' => 200,
            'id' => $resultadonumero
        );   
    }else{
        $json = array(
            'res' => 301
        );   
    }

    echo json_encode($json);

?>