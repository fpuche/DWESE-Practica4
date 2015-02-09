<?php

class Plato {

    private $idplato, $nombre, $descripcion, $precio;

    function __construct($idplato = null, $nombre = "", $descripcion = "", $precio = 0) {
        $this->idplato = $idplato;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->idplato = $datos[0 + $inicio];
        $this->nombre = $datos[1 + $inicio];
        $this->descripcion = $datos[2 + $inicio];
        $this->precio = $datos[3 + $inicio];
    }

    public function getIdplato() {
        return $this->idplato;
    }

    public function setIdplato($idplato) {
        $this->idplato = $idplato;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = '{ ';
        foreach ($prop as $key => $value) {
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }

}

?>
