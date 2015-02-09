<?php

require '../require/comun.php';
$bd = new BaseDatos();
$login = Leer::post("login");
$clave = Leer::post("clave");

$modelo = new ModeloUsuario($bd);
$usuario = $modelo->autentifica($login, $clave);
$usuario = $modelo->login($login, $clave);
if($usuario instanceof Usuario){

    $sesion->setUsuario($usuario);
    $modelo->fechalogin($usuario);
    $bd->closeConexion();
    header("Location:../back-end/index.php"); 

} else {
   
    $sesion->cerrar();
    $bd->closeConexion();
    header("Location:../index.php?error=Login o clave incorrectos");
}
