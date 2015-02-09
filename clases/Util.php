<?php
class Util {
    static function getEnlacesPaginacion($pagina, $paginas, $url = "") { //pagina, los registros que hay, y los que muestra 
        $enlaces = array();
        $enlaces["inicio"] = '&Lt;';
        $enlaces["anterior"] = '&lt;';
        $enlaces["primero"] = "";
        $enlaces["segundo"] = "";
        $enlaces["actual"] = "";
        $enlaces["cuarto"] = "";
        $enlaces["quinto"] = "";
        $enlaces["siguiente"] = '&gt;';
        $enlaces["ultimo"] = '&Gt;';
        if (strpos($url, "?") !== false) {
            $url .= "&";
        } else {
            $url .= "?";
        }
        if ($pagina > 1 && $pagina < $paginas - 1) {
            $enlaces["inicio"] = "<a href='" . $url . "pagina=0'>&Lt;</a>";
            $enlaces["anterior"] = "<a href='" . $url . "pagina=" . ($pagina - 1) . "'>&lt;</a>";
            $enlaces["primero"] = "<a href='" . $url . "pagina=" . ($pagina - 2) . "'>" . ($pagina - 1) . "</a>";
            $enlaces["segundo"] = "<a href='" . $url . "pagina=" . ($pagina - 1) . "'>" . $pagina . "</a>";
            $enlaces["actual"] = ($pagina + 1);
            $enlaces["cuarto"] = "<a href='" . $url . "pagina=" . ($pagina + 1) . "'>" . ($pagina + 2) . "</a>";
            $enlaces["quinto"] = "<a href='" . $url . "pagina=" . ($pagina + 2) . "'>" . ($pagina + 3) . "</a>";
            $enlaces["siguiente"] = "<a href='" . $url . "pagina=" . ($pagina + 1) . "'>&gt;</a>";
            $enlaces["ultimo"] = "<a href='" . $url . "pagina=" . $paginas . "'>&Gt;</a>";
        } else if ($pagina == 0) {
            $enlaces["inicio"] = "&Lt;";
            $enlaces["anterior"] = "&lt;";
            $enlaces["primero"] = "1";
            if ($paginas > $pagina) {
                $enlaces["segundo"] = '<a href="' . $url . 'pagina=' . ($pagina + 1) . '">' . ($pagina + 2) . '</a>';
            }
            if ($paginas > $pagina + 1) {
                $enlaces["actual"] = '<a href="' . $url . 'pagina=' . ($pagina + 2) . '">' . ($pagina + 3) . '</a>';
            }
            if ($paginas > $pagina + 2) {
                $enlaces["cuarto"] = '<a href="' . $url . 'pagina=' . ($pagina + 3) . '">' . ($pagina + 4) . '</a>';
            }
            if ($paginas > $pagina + 3) {
                $enlaces["quinto"] = '<a href="' . $url . 'pagina=' . ($pagina + 4) . '">' . ($pagina + 5) . '</a>';
            }
            if ($paginas > $pagina) {
                $enlaces["siguiente"] = '<a href="' . $url . 'pagina=' . ($pagina + 1) . '">&gt;</a>';
            }
            if ($paginas > $pagina) {
                $enlaces["ultimo"] = '<a href="' . $url . 'pagina=' . $paginas . '">&Gt;</a>';
            }
        } else if ($pagina == 1) {
            $enlaces["inicio"] = '<a href="' . $url . 'pagina=0">&Lt;</a>';
            $enlaces["anterior"] = '<a href="' . $url . 'pagina=' . ($pagina - 1) . '">&lt;</a>';
            $enlaces["primero"] = '<a href="' . $url . 'pagina=' . ($pagina - 1 ) . '">' . ($pagina) . '</a>';
            $enlaces["segundo"] = '2';
            if ($paginas > $pagina) {
                $enlaces["actual"] = '<a href="' . $url . 'pagina=' . ($pagina + 1) . '">' . ($pagina + 2) . '</a>';
            }
            if ($paginas > $pagina + 1) {
                $enlaces["cuarto"] = '<a href="' . $url . 'pagina=' . ($pagina + 2) . '">' . ($pagina + 3) . '</a>';
            }
            if ($paginas > $pagina + 2) {
                $enlaces["quinto"] = '<a href="' . $url . 'pagina=' . ($pagina + 3) . '">' . ($pagina + 4) . '</a>';
            }
            if ($paginas > $pagina) {
                $enlaces["siguiente"] = '<a href="' . $url . 'pagina=' . ($pagina + 1) . '">&gt;</a>';
            }
            if ($paginas > $pagina) {
                $enlaces["ultimo"] = '<a href="' . $url . 'pagina=' . $paginas . '">&Gt;</a>';
            }
        } else if ($pagina == $paginas - 1) {
            $enlaces["inicio"] = '<a href="' . $url . 'pagina=0">&Lt;</a>';
            $enlaces["anterior"] = '<a href="' . $url . 'pagina=' . ($pagina - 1) . '">&lt;</a>';
            $enlaces["primero"] = '<a href="' . $url . 'pagina=' . ($pagina - 3) . '">' . ($pagina - 2) . '</a>';
            $enlaces["segundo"] = '<a href="' . $url . 'pagina=' . ($pagina - 2) . '">' . ($pagina - 1) . '</a>';
            $enlaces["actual"] = '<a href="' . $url . 'pagina=' . ($pagina - 1) . '">' . $pagina . '</a>';
            $enlaces["cuarto"] = $pagina + 1;
            $enlaces["quinto"] = '<a href="' . $url . 'pagina=' . ($pagina + 1) . '">' . ($pagina + 2) . '</a>';
            $enlaces["siguiente"] = '<a href="' . $url . 'pagina=' . ($pagina + 1) . '">&gt;</a>';
            $enlaces["ultimo"] = '<a href="' . $url . 'pagina=' . $paginas . '">&Gt;</a>';
        } else if ($pagina == $paginas) {
            $enlaces["inicio"] = '<a href="' . $url . 'pagina=0">&Lt;</a>';
            if ($paginas - 1 >= 0) {
                $enlaces["anterior"] = '<a href="' . $url . 'pagina=' . ($pagina - 1) . '">&lt;</a>';
            }
            if ($paginas - 4 >= 0) {
                $enlaces["primero"] = '<a href="' . $url . 'pagina=' . ($pagina - 4) . '">' . ($pagina - 3) . '</a>';
            }
            if ($paginas - 3 >= 0) {
                $enlaces["segundo"] = '<a href="' . $url . 'pagina=' . ($pagina - 3) . '">' . ($pagina - 2) . '</a>';
            }
            if ($paginas - 2 >= 0) {
                $enlaces["actual"] = '<a href="' . $url . 'pagina=' . ($pagina - 2) . '">' . ($pagina - 1) . '</a>';
            }
            if ($paginas - 1 >= 0) {
                $enlaces["cuarto"] = '<a href="' . $url . 'pagina=' . ($pagina - 1) . '">' . $pagina . '</a>';
            }
            $enlaces["quinto"] = $pagina + 1;
            $enlaces["siguiente"] = '&gt;';
            $enlaces["ultimo"] = '&Gt;';
        }
        return $enlaces;
    }
    static function getEnlacesPaginacion2($pagina, $total, $rpp = 5, $url = "") { //pagina, los registros que hay, y los que muestra 
        $enlaces = array();
        //echo $total . " " . $rpp;
        //echo "Total viviendas: " . $total;
        $paginas = ceil($total / $rpp) - 1;
        if ($pagina < 0) {
            $pagina = 0;
        }
        if ($pagina > $paginas) {
            $pagina = $paginas;
        }
        $inicio = 0;
        $fin = $paginas;
        
        if (strpos($url, "?") !== false) {
            $url .= "&";
        } else {
            $url .= "?";
        }
        if ($pagina > 1 && $pagina < $paginas - 1) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 2, $paginas, $url);
            $enlaces["segundo"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["actual"] = ($pagina + 1);
            $enlaces["cuarto"] = self::getEnlace($pagina + 1, $paginas, $url);
            $enlaces["quinto"] = self::getEnlace($pagina + 2, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        } else if ($pagina == 0) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($inicio, $paginas, $url, '&lt;');
            $enlaces["primero"] = ($pagina + 1);
            $enlaces["segundo"] = self::getEnlace($pagina + 1, $paginas, $url);
            $enlaces["actual"] = self::getEnlace($pagina + 2, $paginas, $url);
            $enlaces["cuarto"] = self::getEnlace($pagina + 3, $paginas, $url);
            $enlaces["quinto"] = self::getEnlace($pagina + 4, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        } else if ($pagina == 1) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["segundo"] = ($pagina + 1);
            $enlaces["actual"] = self::getEnlace($pagina + 2, $paginas, $url);
            $enlaces["cuarto"] = self::getEnlace($pagina + 3, $paginas, $url);
            $enlaces["quinto"] = self::getEnlace($pagina + 4, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        } else if ($pagina == $paginas - 1) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 3, $paginas, $url);
            $enlaces["segundo"] = self::getEnlace($pagina - 2, $paginas, $url);
            $enlaces["actual"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["cuarto"] = $pagina + 1;
            $enlaces["quinto"] = self::getEnlace($pagina + 1, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        } else if ($pagina == $paginas) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 4, $paginas, $url);
            $enlaces["segundo"] = self::getEnlace($pagina - 3, $paginas, $url);
            $enlaces["actual"] = self::getEnlace($pagina - 2, $paginas, $url);
            $enlaces["cuarto"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["quinto"] = $pagina + 1;
            $enlaces["siguiente"] = self::getEnlace($fin, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        }
        return $enlaces;
    }
    private static function getEnlace($pagina, $paginas, $url, $paginaUsuario = null) {
        if ($pagina < 0)
            return "";
        if ($pagina > $paginas+1)
            return "";
        if ($paginaUsuario == null)
            $paginaUsuario = $pagina + 1;
        return "<a href='" . $url . "pagina=$pagina'>$paginaUsuario</a>";
    }
}
