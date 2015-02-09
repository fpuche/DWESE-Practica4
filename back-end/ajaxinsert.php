<?php

require '../require/comun.php';

header("Content-Type: application/json");

$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$objeto = new Plato();
$objeto->setNombre(Leer::request("nombre"));
$objeto->setDescripcion(Leer::request("descripcion"));
$objeto->setPrecio(Leer::request("precio"));
$r = $modelo->add($objeto);


if($r === -1){
    echo '{"r": 0}';
    $bd->closeConexion();
    exit();
}

$pagina = ceil($modelo->count() / Configuracion::RPP) - 1;
$enlaces = Paginacion::getEnlacesPaginacionJSON($pagina, $modelo->count(), Configuracion::RPP);
echo '{"r": 1,"paginas":' . json_encode($enlaces) . ',"platos":' . $modelo->getListJSON($pagina, Configuracion::RPP) . '}';
$bd->closeConexion();
