<?php
header('Content-Type: text/html; charset=utf-8');
define("SERVER", "192.168.1.18");
define("USER", "username");
define("PASSWORD", "ae9a56ed87");
define("DBNAME", "uncp_tramite");

define("URI",dirname(__FILE__)."/");

$mysqli = new mysqli(
    SERVER,USER,PASSWORD,DBNAME
);


//date_default_timezone_set('America/Lima');

/* verificar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión failed: %s\n", $mysqli->connect_error);
    exit();
}

$mysqli->set_charset("utf8");
$mysqli->query("SET time_zone = '-5:00';");

//printf("Conjunto de caracteres inicial: %s\n", $mysqli->character_set_name());



?>