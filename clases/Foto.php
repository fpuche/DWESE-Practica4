<?php

class Foto {
 private $idfoto, $idplato, $url;

    function __construct($idfoto = null, $idplato = null, $url = "") {
        $this->idfoto = $idfoto;
        $this->idplato = $idplato;
        $this->url = $url;
    }

    /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->idfoto = $datos[0 + $inicio];
        $this->idplato = $datos[1 + $inicio];
        $this->url = $datos[2 + $inicio];
    }

    public function getIdfoto() {
        return $this->idfoto;
    }

    public function setIdfoto($idfoto) {
        $this->idfoto = $idfoto;
    }

    public function getIdplato() {
        return $this->idplato;
    }

    public function setIdplato($idplato) {
        $this->idplato = $idplato;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }
            /**
     * Presenta al usuario en modo JSON
     * @access public
     * @return cadena
     */
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = "{ ";
        foreach ($prop as $key => $value) {
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }

}

?>
