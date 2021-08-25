<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    require_once "../connect.php";
    require_once "../validar_token.php";

    
    if(isset($_REQUEST['authorization']) && $_REQUEST['authorization']!=null && $_REQUEST['authorization']!=""){
        $token = $_REQUEST['authorization'];
        $val_token = validarToken($token);
        $parset_token = json_decode($val_token);
    }else{
        die('{"code":404}');
    }

    if($parset_token->code=="200" && $parset_token->privilegios=="1"){
        $resultadoUP = false;
        $resultadoBD = false;
        $data_csv_nombre = [];
    }else{
        die("Usuario no autorizado!");
    }


    
    
    if(!empty($_FILES["file"]["type"])){
        $fileName = uniqid();
        $valid_extensions = array("csv", "doc", "docx");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = strtolower(end($temporary));
        $fileName = $fileName.".".$file_extension;

        if((($_FILES["file"]["type"] == "application/vnd.ms-excel") || ($_FILES["file"]["type"] == "text/plain") || ($_FILES["file"]["type"] == "text/csv") || ($_FILES["file"]["type"] == "text/tsv")) && in_array($file_extension, $valid_extensions)){
            $fp = fopen ($_FILES['file']['tmp_name'],"r");
            while ($data = fgetcsv($fp, 1000, ";")){
                $num = count($data);
                array_push($data_csv_nombre, $data[0]);
                //echo $data[0].' -> '.$data[1];
            }
            fclose ($fp);
            $resultadoUP = true;
        }
        
        /*
        if((($_FILES["file"]["type"] == "application/pdf") || ($_FILES["file"]["type"] == "application/msword") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = URI."upload/resoluciones/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;
                $resultadoUP = true;
            }
        }
        */
    }
      
    $consulta = "";
    if($resultadoUP){
        for($i=1;$i< count($data_csv_nombre); $i++){
            $consulta .= "('$data_csv_nombre[$i]'),";
        }
        $consulta = substr($consulta, 0, -1);
        $query = "INSERT INTO dependencias(nombre) VALUES $consulta;"; 
        //echo json_encode($consulta);  
    }
        
   
    
    if($resultadoUP){
        $result = $mysqli->query($query);
        if(!$result){
            die("Query error " . mysqli_error($mysqli));
        }else{
            $resultadoBD = true;
        }
    }
    
    if($resultadoUP){
        if($resultadoBD){
            echo '200';
        }else{
            echo '302';
        }
    }else{
        echo '301';
    }

    
    




?>