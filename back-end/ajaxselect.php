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
    $enlaces = Paginacion::getEnlacesPaginacionJSON($pagina, $modelo->count(), Configuracion::RPP);
    echo '{"paginas":'.json_encode($enlaces).',"platos":'.$modelo->getListJSON($pagina, Configuracion::RPP).'}';
    //echo '{"usuarios":'.$modelo->getListJSON($pagina, Configuracion::RPP) . "}"; //sin paginacion
    $bd->closeConexion();
//}
