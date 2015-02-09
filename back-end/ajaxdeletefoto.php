<?php
require '../require/comun.php';
header('Content-Type: application/json');
//if ($sesion->isAdministrador()) {
$bd = new BaseDatos();
$modelo = new ModeloFoto($bd);

$idfoto = Leer::request("idfoto");
$foto=$modelo->get($idfoto);
$modelo->borrarFotoCarpetaPorId($foto);
$r = $modelo->deletePorIdFoto($idfoto);
if ($r == 1) {
    echo '{"r":1}';
    $bd->closeConexion();
    exit();
}
$bd->closeConexion();
echo '{"r":0}';
//}