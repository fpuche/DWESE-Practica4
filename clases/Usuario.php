<?php

class Usuario {

    private $login, $clave, $nombre, $apellidos, $email, $fechaalta, $isactivo, $isroot, $rol, $fechalogin;

    function __construct($login = null, $clave = null, $nombre = null, $apellidos = null, $email = null, $fechaalta = null, $isactivo = 0, $isroot = 0, $rol = 'usuario', $fechalogin = null) {
        $this->login = $login;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->fechaalta = $fechaalta;
        $this->isactivo = $isactivo;
        $this->isroot = $isroot;
        $this->rol = $rol;
        $this->fechalogin = $fechalogin;
    }

    /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->login = $datos[0 + $inicio];
        $this->clave = $datos[1 + $inicio];
        $this->nombre = $datos[2 + $inicio];
        $this->apellidos = $datos[3 + $inicio];
        $this->email = $datos[4 + $inicio];
        $this->fechaalta = $datos[5 + $inicio];
        $this->isactivo = $datos[6 + $inicio];
        $this->isroot = $datos[7 + $inicio];
        $this->rol = $datos[8 + $inicio];
        $this->fechalogin = $datos[9 + $inicio];
    }

    public function getLogin() {
        return $this->login;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFechaalta() {
        return $this->fechaalta;
    }

    public function getIsactivo() {
        return $this->isactivo;
    }

    public function getIsroot() {
        return $this->isroot;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getFechalogin() {
        return $this->fechalogin;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setFechaalta($fechaalta) {
        $this->fechaalta = $fechaalta;
    }

    public function setIsactivo($isactivo) {
        $this->isactivo = $isactivo;
    }

    public function setIsroot($isroot) {
        $this->isroot = $isroot;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setFechalogin($fechalogin) {
        $this->fechalogin = $fechalogin;
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

   
                /**
     * Comprueba si un usuario es administrador y no usuario
     * @access public
     * @return true / false
     */
    function isAdmin() {

        if ($this->rol != 'usuario') {
            return true;
        }
        return false;
    }

}
