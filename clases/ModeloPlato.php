<?php

class ModeloPlato {
private $bd;
    private $tabla = "plato";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

        /**
     * Añade un objeto a la tabla plato
     * @access public
     * @return int
     */
    function add(Plato $objeto) {
        $sql = "insert into $this->tabla values(null, :nombre, :descripcion, :precio);";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico();
    }

    function getTabla() {
        return $this->tabla;
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

    /**
     * Borra elementos de la base de datos casas
     * @access public
     * @return int
     */
    function delete(Plato $objeto) {
        $sql = "delete from $this->tabla where idplato = :idplato;";
        $parametros["idplato"] = $objeto->getIdplato();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Borra elementos de la tabla plato por su id
     * @access public
     * @return int
     */
    function deletePorId($idplato) {
        return $this->delete(new Plato($idplato));
    }

    /**
     * Edita elementos de la tabla plato
     * @access public
     * @return int
     */
    function edit(Plato $objeto) {
        $sql = "update $this->tabla  set nombre = :nombre, descripcion = :descripcion, precio = :precio where idplato = :idplato";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["idplato"] = $objeto->getIdplato();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Edita elementos de la tabla plato por su id
     * @access public
     * @return int
     */
    function editPK(Plato $objetoOriginal, Plato $objetoNuevo) {
        $sql = "update $this->tabla  set nombre = :nombre, descripcion = :descripcion, precio = :precio where idplato = :idplatopk";
        $parametros["nombre"] = $objetoNuevo->getNombre();
        $parametros["descripcion"] = $objetoNuevo->getDescripcion();
        $parametros["precio"] = $objetoNuevo->getPrecio();
        $parametros["idplato"] = $objetoNuevo->getIdplato();
        $parametros["idplatopk"] = $objetoOriginal->getIdplato();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Retorna un objeto plato de la base de datos restaurante por su id
     * @access public
     * @return una casa o null
     */
    function get($idplato) {
        $sql = "select * from $this->tabla where idplato = :idplato";
        $parametros["idplato"] = $idplato;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $plato = new Plato();
            $plato->set($this->bd->getFila());
            return $plato;
        }
        return null;
    }

    /**
     * El número de platos que coinciden con una condición
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
     * Crea la lista de platos según requisitos de paginación
     * @access public
     * @return array o null
     */
    function getList($pagina = 0, $rpp = 5, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $principio = $pagina * $rpp; // si empezaramos por 1 en vez de por cero sería $pagina -1 * $rpp
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $principio, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $plato = new Plato();
                $plato->set($fila);
                $list[] = $plato;
            }
        } else {
            return null;
        }
        return $list;
    }
    
    
        function getListPagina($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from "
                . $this->tabla .
                " where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    /**
     * Crea selects html con los valores de de la tabla plato
     * @access public
     * @return string
     */
    function selectHtml($idplato, $name, $condicion, $parametros, $orderby = 1, $valorSeleccionado = "", $blanco = true, $textoBlanco = "&nbsp;") {
        $select = "<select name='$name' idplato='$idplato'>";
        $select .="</select>";
        if ($blanco) {
            $select .="<option value=''>$textoBlanco</option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getId() == $valorSeleccionado) {
                $selected = "selected";
            }
            $select .="<option $selected value='" . $objeto->getIdplato() . "'>" . $objeto->getNombre() . ", " . $objeto->getDescripcion() . ", " . $objeto->getPrecio() . "</option>";
        }
        $select .= "</select>";
        return $select;
    }
    
        /**
     * crea un conjunto de objetos plato a partir de unas condiciones
     * @access public
     * @return cadena con los objetos usuario
     */
    function getListJSON($pagina = 0, $rpp = 5, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Plato();
            $objeto->set($fila);
            $r .=$objeto->getJSON() . ",";
        }

        $r = substr($r, 0, -1) . "]";
        return $r;
    }
    
        function getJSON($id) {
        return $this->get($id)->getJSON();
    }


}

?>
