<?php
require '../require/comun.php';
$subir = new SubirArchivos("archivo");
$subir->subir();
$nombres = $subir->getExtensiones();
$idPlato = Leer::get("id");
$bd = new BaseDatos();
$modelo = new ModeloFoto($bd);

foreach ($nombres as $key => $url) 
{
    $foto = new Foto(null, $idPlato, $url);
    $modelo->add($foto);
}
$bd->closeConexion();