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
$tabla = 'grupos';

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["verificar"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $email = $data-> email;
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM `usuarios` WHERE email = '$email'");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data = mysqli_fetch_all($sqlPredec, MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

if (isset($_GET["listar"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM $tabla");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data = mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
if (isset($_GET["getUsuario"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM usuarios WHERE id = $id");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data = mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $celcontacto = $data-> celcontacto;
    $email = $data-> email;
    $nombre = $data-> nombre;
    $pass = $data-> pass;
    $GoogleId = $data->GoogleId;
    $premiun = $data->premiun;
    $sqlPredec = mysqli_query($conexionBD,"INSERT INTO `usuarios` (`celcontacto`, `email`, `nombre`, `pass`, `GoogleId`) VALUES ('$celcontacto', '$email', '$nombre', '$pass', '$GoogleId')");
    echo json_encode(["success"=>1]);
    exit();
}
if (isset($_GET["logad"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $data = json_decode(file_get_contents("php://input"));
    $email = $data-> email;
    $pass = $data-> pass;
    $hoy = date("Y-m-d"); 
    $sqlPredec = mysqli_query($conexionBD, "SELECT * FROM `usuarios` WHERE email = '$email' AND pass = '$pass'");
    if(mysqli_num_rows($sqlPredec) > 0){

        while($row2 = mysqli_fetch_array($sqlPredec)){
            $id = $row2[0];
            $fecha_espira =$row2[11];
        }
        if($fecha_espira>$hoy){
            //quitarPre($conexionBD, $id);
            usuario($conexionBD, $id);
        }
        if($fecha_espira<$hoy){
            quitarPre($conexionBD, $id);
        }

    }
    else{  echo json_encode(["success"=>0, "msj"=>$email.' '. $pass]); }
}

if(isset($_GET["setPre"])){
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $fecha_espira = $data->fecha_espira;
    $sqlPredec = mysqli_query($conexionBD,"UPDATE `usuarios` SET status = 'si', premiun = 1, fecha_espira = '$fecha_espira' WHERE  id = $id;");
    echo json_encode(["success"=>1, "mensaje:"=>2]);
    exit();
}

// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizarINFO"])){
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $GoogleId = $data-> GoogleId;
    $pass = $data-> pass;
    $premiun = $data->premiun;
    $sqlPredec = mysqli_query($conexionBD,"UPDATE `usuarios` SET GoogleId='$GoogleId', pass='$pass', premiun='$premiun' WHERE id = $id;");
    echo json_encode(["success"=>1, "mensaje:"=>2]);
    exit();
}
if(isset($_GET["actualizar"])){
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $celcontacto = $data-> celcontacto;
    $email = $data-> email;
    $nombre = $data-> nombre;
    $pass = $data-> pass;
    $sqlPredec = mysqli_query($conexionBD,"UPDATE `usuarios` SET celcontacto='$celcontacto', email='$email', nombre='$nombre', pass='$pass' WHERE id = $id;
    ");
    echo json_encode(["success"=>1, "mensaje:"=>2]);
    exit();
}
if(isset($_GET["UpdatePass"])){
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $pass = $data-> pass;
    $sqlPredec = mysqli_query($conexionBD,"UPDATE `usuarios` SET pass='$pass' WHERE id = $id;
    ");
    echo json_encode(["success"=>1, "mensaje:"=>2]);
    exit();
}

if (isset($_GET["contarUs"])){
    $usuarios = new stdClass();
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8"); 
    $sqlPredec = mysqli_query($conexionBD,
               "SELECT * FROM usuarios WHERE premiun = 1 AND status = 'si';");
        if(mysqli_num_rows($sqlPredec) > 0){
                $premium = mysqli_num_rows( $sqlPredec ); //mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        }else { $premium = "0";}
    $sqlPredec = mysqli_query($conexionBD,
               "SELECT * FROM usuarios WHERE premiun = 0 AND status = 'no';");
        if(mysqli_num_rows($sqlPredec) > 0){
                $libre = mysqli_num_rows( $sqlPredec ); //mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        }else { $libre = "0";}
    $sqlPredec = mysqli_query($conexionBD,
               "SELECT * FROM usuarios WHERE admin = 1;");
        if(mysqli_num_rows($sqlPredec) > 0){
                $admins = mysqli_num_rows( $sqlPredec ); //mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        }else { $admins = "0";}


        $usuarios -> premium = $premium;
        $usuarios -> libre = $libre;
        $usuarios -> admins = $admins;

    echo json_encode($usuarios);
}
if (isset($_GET["buscar"])){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM usuarios WHERE celcontacto LIKE '%".$_GET["buscar"]."%' OR email LIKE '%".$_GET["buscar"]."%'");
    if(mysqli_num_rows($sqlPredec) > 0){
        $empleaados = mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($empleaados);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

function  quitarPre($conexionBD, $id){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $sqlPredec = mysqli_query($conexionBD, "UPDATE `usuarios` SET `status` = 'no', `premiun` = 0  WHERE  `id` = $id;");

    if ($sqlPredec) {
        usuario($conexionBD, $id);
    }
}
function usuario($conexionBD, $id){
    $sqlPredec = mysqli_set_charset($conexionBD, "utf8");
    $sqlPredec = mysqli_query($conexionBD,"SELECT * FROM usuarios WHERE id = $id");
    if(mysqli_num_rows($sqlPredec) > 0){
        $data = mysqli_fetch_all($sqlPredec,MYSQLI_ASSOC);
        echo json_encode($data);
        exit();
    }
   
}
?>