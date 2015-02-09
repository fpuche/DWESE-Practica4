<?php

class ModeloFoto {

    private $bd;
    private $tabla = "foto";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Añade un objeto a la tabla foto
     * @access public
     * @return int
     */
    function add(Foto $objeto) {
        $sql = "insert into $this->tabla values(null, :idplato, :url);";
        $parametros["idplato"] = $objeto->getIdplato();
        $parametros["url"] = $objeto->getUrl();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico();
    }

    /**
     * Borra elementos de la tabla foto
     * @access public
     * @return int
     */
    function delete(Foto $objeto) {
        $sql = "delete from $this->tabla where idfoto = :idfoto";
        $parametros["idfoto"] = $objeto->getIdfoto();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Borra elementos de la tabla foto por su id
     * @access public
     * @return int
     */
    function deletePorIdFoto($idfoto) {
        return $this->delete(new Foto($idfoto));
    }

    /**
     * Edita elementos de la tabla foto
     * @access public
     * @return int
     */
    function edit(Foto $objeto) {
        $sql = "update $this->tabla  set idplato = :idplato, url = :url where idfoto = :idfoto";
        $parametros["idplato"] = $objeto->getIdplato();
        $parametros["url"] = $objeto->getUrl();
        $parametros["idfoto"] = $objeto->getIdfoto();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Edita elementos de la tabla foto por su id
     * @access public
     * @return int
     */
    function editPK(Foto $objetoOriginal, Foto $objetoNuevo) {
        $sql = "update $this->tabla  set idplato = :idplato,url = :url where idfoto = :idfotopk";
        $parametros["idplato"] = $objetoNuevo->getIdplato();
        $parametros["url"] = $objetoNuevo->getUrl();
        $parametros["idfoto"] = $objetoNuevo->getIdfoto();
        $parametros["idfotopk"] = $objetoOriginal->getIdfoto();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Retorna un objeto foto de la base de datos fotos por su id
     * @access public
     * @return una casa o null
     */
    function get($idfoto) {
        $sql = "select * from $this->tabla where idfoto = :idfoto";
        $parametros["idfoto"] = $idfoto;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $foto = new Foto();
            $foto->set($this->bd->getFila());
            return $foto;
        }
        return null;
    }

    /**
     * El número de fotos que coinciden con una condición
     * @access public
     * @return int
     */
    function count($condicion = "1=1", $parametros = array()) {
        $sql = "select count(*) from $this->tabla where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            return $numero = $this->bd->getFila(0);
        } else {
            return -1;
        }
    }

    /**
     * Crea la lista de fotos según requisitos de paginación
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
                $foto = new Foto();
                $foto->set($fila);
                $list[] = $foto;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Crea selects html con los valores de de la tabla foto
     * @access public
     * @return string
     */
    function selectHtml($idfoto, $name, $condicion, $parametros, $orderby = 1, $valorSeleccionado = "", $blanco = true, $textoBlanco = "&nbsp;") {
        $select = "<select name='$name' idfoto='$idfoto'>";
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
            $select .="<option $selected value='" . $objeto->getIdfoto() . "'>" . $objeto->getIdplato() . ", " . $objeto->getUrl() . "</option>";
        }
        $select .= "</select>";
        return $select;
    }

    /**
     * Obtiene las fotos que tiene un plato por su id
     * @access public
     * @return array o null
     */
    function getFotoIdPlato($idplato) {
        $sql = "select * from $this->tabla where idplato= :idplato";
        $parametros["idplato"] = $idplato;
        $r = $this->bd->setConsulta($sql, $parametros);
        $arrayFotos = array();
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $foto = new Foto();
                $foto->set($fila);
                $arrayFotos[] = $foto;
            }
            return $arrayFotos;
        }
        return null;
    }

    /**
     * crea un conjunto de objetos foto a partir de unas condiciones
     * @access public
     * @return cadena con los objetos foto
     */
    function getListJSON($pagina = 0, $rpp = 5, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Foto();
            $objeto->set($fila);
            $r .=$objeto->getJSON() . ",";
        }

        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    /**
     * crea un conjunto de objetos foto a partir del id de un plato al que se asocian
     * @access public
     * @return cadena con los objetos foto
     */
    function getListJSONdesdePlato($idplato) {
        $sql = "select * from $this->tabla where idplato=:idplato";
        $parametros["idplato"] = $idplato;
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($datos = $this->bd->getFila()) {
            $foto = new Foto();
            $foto->set($datos);
            $r .= $foto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    /**
     * crea un objeto foto a partir de su id
     * @access public
     * @return cadena con un objeto foto
     */
    function getJSON($id) {
        return $this->get($id)->getJSON();
    }

    /**
     * borra las fotos de un plato, a partir de su id, alojadas en la carpeta de subida
     * @access public
     */
    function borrarFotoCarpeta($idPlato) {
        $fotos = $this->getFotoIdPlato($idPlato);
        foreach ($fotos as $key => $foto) {
            unlink($foto->getUrl());
        }
    }

    /**
     * borra una foto, a partir de su id, alojada en la carpeta de subida
     * @access public
     */
    function borrarFotoCarpetaPorId($foto) {
        unlink($foto->getUrl());
    }

}

?>
