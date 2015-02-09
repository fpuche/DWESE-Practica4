<?php
require '../require/comun.php';
header('Content-Type: application/json');
//if ($sesion->isAdministrador()) {
$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$idPlato = Leer::request("idplato");
$modeloFoto = new ModeloFoto($bd);
$modeloFoto->borrarFotoCarpeta($idPlato);
$r = $modelo->deletePorId($idPlato);
if ($r == 1) {
    $paginas = ceil($modelo->count() / Configuracion::RPP) - 1;
    if ($pagina > $paginas) {
        $pagina = $paginas;
    }
    $enlaces = Paginacion::getEnlacesPaginacionJSON($pagina, $modelo->count(), Configuracion::RPP);
    echo '{"r":"1","paginas":' . json_encode($enlaces) . ',"platos":' . $modelo->getListJSON($pagina, Configuracion::RPP) . '}';
    $bd->closeConexion();
    exit();
}
$bd->closeConexion();
echo '{"r":0}';
//}