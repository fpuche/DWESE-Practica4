<?php

class ModeloUsuario {

    private $bd = null;
    private $tabla = "usuario";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Añade un objeto a la tabla usuario
     * @access public
     * @return int
     */
    function add(Usuario $objeto) {
        $sql = "insert into $this->tabla values(:login, :clave, :nombre, :apellidos, :email, curdate(),:isactivo, :isroot, :rol, null);";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        //$parametros["fechaalta"] = $objeto->getFechaalta();
        $parametros["isactivo"] = $objeto->getIsactivo();
        $parametros["isroot"] = $objeto->getIsroot();
        $parametros["rol"] = $objeto->getRol();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $r;
    }

    /**
     * Añade un objeto a la tabla usuario con el valor de algunos atributos asignado
     * @access public
     * @return int
     */
    function alta(Usuario $objeto) {
        $sql = "insert into $this->tabla values (:login, :clave, :nombre, "
                . ":apellidos, :email, curdate(), :isactivo, :isroot, :rol,"
                . "null );";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = $objeto->getClave();
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        $parametros["isactivo"] = 0;
        $parametros["isroot"] = 0;
        $parametros["rol"] = "usuario";
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        //mandar correo
        return $r; //return 1 si se ha insertado     
    }

    /**
     * Borra elementos de la base de datos usuario
     * @access public
     * @return int
     */
    function delete(Usuario $objeto) {
        $sql = "delete from $this->tabla where login=:login;";
        $parametros["login"] = $objeto->getLogin();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Borra elementos de la base de datos usuario con un id dado
     * @access public
     * @return 
     */
    function deletePorId($id) {
        return $this->delete(new Usuario($id));
    }

    /**
     * Borra elementos de la base de datos usuario con un login dado
     * @access public
     * @return 
     */
    function deletePorLogin($login) {
        return $this->delete(new Usuario($login));
    }

    /**
     * Edita elementos de la base de datos usuario
     * @access public
     * @return int
     */
    function edit(Usuario $objeto) {
        $sql = "update into $this->tabla  set login = :login, clave = :clave, "
                . "nombre = :nombre, apellidos = :apellidos, email= :email, "
                . " isactivo= :isactivo, isroot = :isroot,"
                . " rol = :rol  where login = :login";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = $objeto->getClave();
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        $parametros["fechaalta"] = $objeto->getFechaalta();
        $parametros["isactivo"] = $objeto->getIsactivo();
        $parametros["isroot"] = $objeto->getIsroot();
        $parametros["rol"] = $objeto->getRol();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Edita elementos de la base de datos usuario por su login
     * @access public
     * @return int
     */
    function editPK(Usuario $objeto, $loginpk) {
        $sql = "update $this->tabla set login=:login, clave=:clave, nombre=:nombre, "
                . "apellidos=:apellidos, email=:email, "
                //. "fechalta=:fechaalta "
                . "isactivo=:isactivo, isroot=:isroot, rol=:rol "
                //. "fechalogin=:fechalogin "
                . "where login=:loginpk;";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        //$parametros["fechaalta"] = $objeto->getFechaalta();
        $parametros["isactivo"] = $objeto->getIsactivo();
        $parametros["isroot"] = $objeto->getIsroot();
        $parametros["rol"] = $objeto->getRol();
        //$parametros["fechalogin"] = $objeto->getFechalogin();
        //$parametros["loginpk"] = $objetoOriginal->getLogin();        
        $parametros["loginpk"] = $loginpk;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Retorna un objeto usuario de la base de datos casas por su login
     * @access public
     * @return una casa o null
     */
    function get($login) {
        $sql = "select * from $this->tabla where login = :login";
        $parametros["login"] = $login;
        $r = $this->bd->setConsulta($sql, $parametros);

        if ($r) {
            $usuario = new Usuario();
            $usuario->set($this->bd->getFila());
            return $usuario;
        }
        return null;
    }

    /**
     * El número de usuarios que coinciden con una condición
     * @access public
     * @return int
     */
    function count($condicion = "1=1", $parametros = array()) {
        $sql = "select count(*) from $this->tabla where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            //return $numero = $this->bd->getFila(0);
                        $aux = $this->bd->getFila();
            return $aux[0];
        } else {
            return -1;
        }
    }

    /**
     * Crea la lista de usuarios según requisitos de paginación
     * @access public
     * @return array o null
     */
    function getList($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $principio = $pagina * $rpp; // si empezaramos por 1 en vez de por cero sería $pagina -1 * $rpp
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $principio, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $list[] = $usuario;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Crea la lista de usuarios según requisitos y condiciones
     * @access public
     * @return array o null
     */
    function getListBas($condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $sql = "select * from $this->tabla where $condicion order by $orderBy";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $list[] = $usuario;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Crea selects html con los valores de de la tabla usuario
     * @access public
     * @return string
     */
    function selectHtml($login, $name, $condicion, $parametros, $orderby = 1, $valorSeleccionado = "", $blanco = true, $textoBlanco = "&nbsp;") {
        $select = "<select name='$name' login='$login'>";
        // $select .="</select>";
        if ($blanco) {
            $select .="<option value=''>$textoBlanco</option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getLogin() == $valorSeleccionado) {
                $selected = "selected";
            }
            $select .="<option $selected value='" . $objeto->getLogin() . "'>" .
                    $objeto->getClave() . ", " . $objeto->getApellidos() . ", " .
                    $objeto->getNombre() . ", " . $objeto->getEmail() . ", " .
                    $objeto->getFechaalta() . ", " . $objeto->getIsactivo() . ", " .
                    $objeto->getIsroot() . ", " . $objeto->getRol() . ", " .
                    $objeto->getFechalogin() . "</option>";
        }
        $select .= "</select>";
        return $select;
    }

    /**
     * Da valor de 1 a isActivo para los usuarios con un id dado
     * @access public
     * @return int
     */
    function activa($id) {
        $sql = 'update usuario
                set isactivo=1
                where isactivo=0
                and md5(concat(email, "' . Configuracion::PEZARANA . '", login))= :id';
        //si quiero poner al usuario desactivado, pongo -1, no 0 si no se podria volver a dar de alta
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * actualiza el valor fechaLogin con la fecha y hora actuales
     * @access public
     * @return resultado de editConsulta (número de usuarios a los que le 
     * realiza una asignación, dados una condición y un parámetro)
     */
    function actualiza($login) {
        $condicion = "login= :login";
        $parametros["login"] = $login;
        $asignacion = "fechalogin = now()";

        return $this->editConsulta($asignacion, $condicion, $parametros);
    }

    /**
     * Crea la lista de casas según una condición y un parámetro
     * @access public
     * @return array o null
     */
    function getConsulta($condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $sql = "select * from $this->tabla where $condicion order by $orderby";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $list[] = $usuario;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * actualiza los valores de un usuario a partir de su login y su clave
     * @access public
     * @return resultado de editConsulta (número de usuarios a los que le 
     * realiza una asignación, dados una condición y un parámetro)
     */
    function editConClave(Usuario $objeto, $loginpk, $claveold) {
        $asignacion = "login=:login, clave=:clave, "
                . "nombre=:nombre, apellidos=:apellidos, "
                . "email=:email";
        $condicion = "login=:loginpk and clave=:claveold";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        $parametros["loginpk"] = $loginpk;
        $parametros["claveold"] = $claveold;
        return $this->editConsulta($asignacion, $condicion, $parametros);
    }

    /**
     * actualiza los valores de un usuario a partir de su login
     * @access public
     * @return resultado de editConsulta (número de usuarios a los que le 
     * realiza una asignación, dados una condición y un parámetro)
     */
    function editSinClave(Usuario $objeto, $login) {
        $asignacion = "login = :login, "
                . "nombre = :nombre, "
                . "apellidos = :apellidos, "
                . "email= :email";
        $condicion = "login = :loginpk";
        $parametros["login"] = $objeto->getLogin();
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        $parametros["loginpk"] = $login;
        return $this->editConsulta($asignacion, $condicion, $parametros);
    }

    /**
     * realiza una asignación dados una condición y un parámetro
     * @access public
     * @return int
     */
    function editConsulta($asignacion, $condicion = "1=1", $parametros = array()) {
        $sql = "update $this->tabla  set $asignacion where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Da valor de 0 a isActivo para los usuarios con un id dado
     * @access public
     * @return int
     */
    function desactivar($id) {
        $sql = 'update usuario
                set isactivo=1
                where isactivo=0
                and md5(concat(email, "' . Configuracion::PEZARANA . '", login))= :id';

        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Da valor de 0 a isActivo para los usuarios con un login dado
     * @access public
     * @return int
     */
    function desactivarPorLogin($loginpk) {
        $sql = "update $this->tabla set isactivo=0 where login=:login;";
        $parametros["login"] = $loginpk;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Actualiza la fechaLogin de un usuario con un login dado
     * @access public
     * @return int
     */
    function fechalogin(Usuario $objeto) {
        $sql = "update $this->tabla set fechalogin=:fechalogin where login=:login";
        $parametros["fechalogin"] = "now()";
        $parametros["login"] = $objeto->getLogin();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * da el número de usuarios con un login y un id dados
     * @access public
     * @return int
     */
    function cambiarClave($login, $id) {
        $sql = "select * from $this->tabla "
                . "where login=:login and md5(concat(login,'" . Configuracion::PEZARANA . "',email))=:id;";
        $parametros["login"] = $login;
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * loguea a un usuario a partir de un login y una clave
     * @access public
     * @return el login / falso
     */
    function login($login, $clave) {
        $sql = "select login from usuario where clave=:clave and isactivo=1;";
        $parametros["clave"] = sha1($clave);
        $r = $this->bd->setConsulta($sql, $parametros);
        $resultado = $this->bd->getFila();
        $loginEncontrado = $resultado[0];
        if ($login == $loginEncontrado) {
            return $this->get($loginEncontrado);
        }

        return false;
    }

    /**
     * loguea a un usuario a partir de un login y una clave
     * @access public
     * @return el login / falso
     */
    function autentifica($login, $clave) {
        $condicion = "login = :login and clave= :clave and isactivo = 1";
        $parametros["login"] = $login;
        $parametros["clave"] = sha1($clave);
        $r = $this->getConsulta($condicion, $parametros);

        if (sizeof($r) == 1) {
            $this->actualiza($login);
            return $r[0];
        }
        return false;
    }

    /**
     * crea un conjunto de objetos usuario a partir de unas condiciones
     * @access public
     * @return cadena con los objetos usuario
     */
    function getListJSON($pagina = 0, $rpp = 3, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $r .=$objeto->getJSON() . ",";
        }

        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    /**
     * Devuelve el total de páginas
     * @access public
     * @return int
     */
    function getNumeroPaginas($rpp = Configuracion::RPP) {
        $lista = $this->count();
        return (ceil($lista[0] / $rpp) - 1);
    }

}
