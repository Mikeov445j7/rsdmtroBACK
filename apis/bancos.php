<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
//$servidor = "localhost:3306"; $usuario = "boliviad_bduser1"; $contrasenia = "Prede02082016"; $nombreBaseDatos = "boliviad_predeconst";
//$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "recidenciometro";

$servidor = "localhost"; $usuario = "c2061842_recide"; $contrasenia = "ma94vonuZI"; $nombreBaseDatos = "c2061842_recide";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $id_grupo=$data->id_grupo;
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM banco_preguntas WHERE id_grupo = $id_grupo");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data= mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0, "id"=>$id_grupo]); }