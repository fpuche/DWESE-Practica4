<?php
require '../require/comun.php';
header('Content-Type: application/json');
$id = Leer::request("id");
$bd = new BaseDatos();
$modelo = new ModeloFoto($bd);
echo '{';
echo '"fotos":'.$modelo->getListJSONdesdePlato($id);
echo '}';
