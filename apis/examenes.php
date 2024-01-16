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

if (isset($_GET["examen"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $id_grupo=$data->id_grupo;
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM preguntas_examenes ORDER BY RAND() LIMIT 100;");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data= mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
if (isset($_GET["past"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $id_grupo=$data->id_grupo;
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM examenes ORDER BY anio ASC");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data= mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
if (isset($_GET["ExPast"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $examen=$data->examen;
    $sqlPredec = mysqli_query($conexionBD,"SELECT * from preguntas_examenes WHERE nro_examen = $examen ORDER BY numero");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data= mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

?>
