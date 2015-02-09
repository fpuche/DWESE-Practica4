
<?php

class Sesion {

    private $nombre;
    private $valor;

 //Constructor    
    function __construct($nombre = "") {

        if ($nombre != "") {
            session_name($nombre);
        } 
        if(!self::SesionIniciada){
             session_start();          
        }

        
    }

    //Métodos
    public static function set($nombre, $valor) {
        if (isset($_SESSION ['$nombre'] )){
            $_SESSION ['$nombre'] = $valor;
            return true;
        }
        return false;
    }

    public static function add($nombre, $valor) {
        $this->nombre = $nombre;
        $this->valor = $valor;
    }

    public static function get($nombre, $valor) {
        
    }

    public static function getNombres() {
        $variables = array();
        foreach ($_SESSION ['$nombre'] as $nom=>$value) {
            if ($nombre == $nom) {
                $variables[] =$nom;
            }
        }
        return $variables;
    }

    public static function deleteNombre($nombre="") {
               if($nombre){
           unset($_SESSION[$nombre]);
           return true;
               }
               if (isset($_SESSION[$nombre])){
                   
               }

    }

    public static function delete() {
 
        foreach ($_SESSION ['$nombre'] as $nom) {
            if ($nombre == $nom) {
                unset($_SESSION[$nombre]);
            }
        }
    }

    public static function isSesion() {
        foreach ($_SESSION ['$valor'] as $val) {
            if ($valor == $val) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public static function destroy (){
        session_destroy();
    }

}
?>

