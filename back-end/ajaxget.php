<?php
require '../require/comun.php';
header('Content-Type: application/json');
//if ($sesion->isAdministrador()) {
$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$idplato = Leer::get("idplato");
$aux = $modelo->get($idplato);
$r = null;
if ($aux !== null) {
    $r = $modelo->getJSON($idplato);
}
$bd->closeConexion();
if ($r === null) {
    echo '{"r": 0}';
    exit();
} else {
    echo '{"r": 1,' . '"plato": ' . $r.'}';
}
//}
