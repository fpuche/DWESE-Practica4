
<?php

/**
 * Class Subir
 *
 * @version 1
 * @author Fernando Puche
 * @license license.txt
 * @copyright 2014
 * 
 * 
 * Esta clase se encarga de subir uno o más archivos de distintos tipos
 */
require_once 'clases/Configuracion.php';

class Subir {

    private $files, $input, $destino, $nombre, $accion, $maximo, $tipos, $extensiones, $crearCarpeta, $mensaje_error;
    private $errorPHP, $error;

    const IGNORAR = 0, RENOMBRAR = 2, REEMPLAZAR = 1;
    const ERROR_INPUT = -1;

    /**
     * Constructor. A partir del &input da valor a las distintas variables
     */
    function __construct($input) {
        $this->input = $input;
        $this->destino = "uploads/";
        $this->nombre = "";
        $this->accion = Subir::IGNORAR;
        $this->maximo = 2 * 1014 * 1024;
        $this->crearCarpeta = TRUE;
        $this->tipos = array();
        $this->extensiones = array("ace", "bmp", "css", "doc", "exe", "gif", 
            "html", "js", "jpg", "log", "mp3", "ogg", "pdf", "php", "ppt", 
            "pps", "ra", "rar", "rtf", "tif","txt", "wav", "wma", "xls", "zip");
        $this->errorPHP = UPLOAD_ERR_OK;
        $this->mensaje_error = "";
        $this->error = 0;
    }

    /**
     * Para obtener el código del error del archivo de $_FILES["archivo"]["error"]
     * @return int, el código del error. Si es distinto de 0 no podrá subirse el archivo
     */
    function getErrorPHP() {
        return $this->errorPHP;
    }

    /**
     * Para obtener un código de error propio de la clase
     * @return int el código del error
     */
    function getError() {
        return $this->error;
    }

    /**
     * Para dar valor a la variable booleana crearCarpeta
     */
    function setCrearCarpeta($crearCarpeta) {
        $this->crearCarpeta = $crearCarpeta;
    }

    /**
     * Para dar valor a la variable de texto destino
     */
    function setDestino($destino) {
        $caracter = substr($destino, -1);
        if ($caracter != "/")
            $destino.="/";
        $this->destino = $destino;
    }

    /**
     * Para dar valor a la variable de texto nombre
     */
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * Para dar uno de los valores constantes a la variable accion
     */
    function setAccion($accion) {
        $this->accion = $accion;
    }

    /**
     * Para dar valor a la variable entera maximo
     */
    function setMaximo($maximo) {
        $this->maximo = $maximo;
    }

    /**
     * Para añadir un valor a la variable de tipo array tipo
     */
    function addTipo($tipo) {
        if (is_array($tipo)) {
            $this->tipos = array_merge($this->tipos, $tipo);
        } else {
            $this->tipos[] = $tipo;
        }
    }

    /**
     * Para darle un/os nuevo/s valor/es a la variable tipo array 
     * extension
     */
    function setExtension($extension) {
        if (is_array($extension)) {
            $this->extensiones = $extension;
        } else {
            unset($this->extensiones);
            $this->extensiones[] = $extension;
        }
    }

    /**
     * Para añadir uno o más nuevos (o no nuevos) valores a la variable tipo 
     * array extension
     */
    function addExtension($extension) {
        if (is_array($extension)) {
            $this->extensiones = array_merge($this->extensiones, $extension);
        } else {
            $this->extensiones[] = $extension;
        }
    }

    /**
     * Comprueba si existe el archivo a subir
     * @return true o false
     */
    function isInput() {
        if (!isset($_FILES[$this->input])) {
            $this->error = -1;
            return false;
        }
        return true;
    }

    /**
     * Comprueba si el código de error permite o no que se suba el archivo
     * @return true o false
     */
    private function isError() {
        if ($this->errorPHP != UPLOAD_ERR_OK) {
            return true;
        }
        return false;
    }

    /**
     * Comprueba si el tamaño del archivo permite o no que se suba el mismo
     * @return true o false
     */
    private function isTamano() {
        if ($this->files["size"] > $this->maximo) {
            $this->error = -2;
            return false;
        }
        return true;
    }

    /**
     * Comprueba si el tamaño de un archivo perteneciente a un conjunto de 
     * archivos (array) permite o no que se suba el mismo
     * @return true o false
     */
    private function isTamanoMultiple($i) {
        if ($this->files["size"][$i] > $this->maximo) {
            $this->error = -2;
            return false;
        }
        return true;
    }

    /**
     * Comprueba si la extensión del archivo es válida
     * @return true o false
     */
    private function isExtension($extension) {
        if (sizeof($this->extensiones) > 0 && !in_array($extension, $this->extensiones)) {
            $this->error = -3;
            return false;
        }
        return true;
    }

    /**
     * Comprueba si la carpeta de destino es válida
     * @return true o false
     */
    private function isCarpeta() {
        if (!file_exists($this->destino) && !is_dir($this->destino)) {
            $this->error = -4;
            return false;
        }
        return true;
    }

    /**
     * Crea una carpeta de destino en una ubicación y con unos permisos 
     * indicados
     * @return int La suma de todos los argumentos
     */
    private function crearCarpeta() {
        return mkdir($this->destino, Configuracion::PERMISOS, true);
    }

    /**
     * A partir del valor de la variable error, se obtiene el mensaje de 
     * error correspondiente
     * @return cadena de texto
     */
    function getMensaje_Error() {
//        if (!is_array($this->files)) {
        switch ($this->getError()) {
            case -1:
                return "Error en el input. Revise el tamaño de archivo.";
            case -2:
                return "El tamaño del archivo esobrepasa el máximo.";
            case -3:
                return "Extension no permitida o mal escrita.";
            case -4:
                return "No existía la carpeta de destino pero 
                    se creó correctamente.";
            case -5:
                return "El archivo a subir ya existe en la carpeta de destino.";
            case -6:
                return "Fallo al renombrar el archivo a subir.";
            case -7:
                return "Fallo al crear la carpeta de destino.";
            case -8:
                return "No se ha creado la carpeta de destino.";
        }
    }

    /**
     * A partir del código del error del archivo de $_FILES["archivo"]["error"] 
     * proporciona un texto a la variable mensaje_error
     * @return cadena de texto con la descripción del error
     */
    private function setMensaje_error() {
        switch ($this->errorPHP) {
            case UPLOAD_ERR_OK:
                $this->mensaje_error = "Archivo Subido Correctamente";
                break;
            case UPLOAD_ERR_INI_SIZE:
                $this->mensaje_error = "Error de tamaño ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->mensaje_error = "Error de tamaño del formulario";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->mensaje_error = "Error Parcial";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->mensaje_error = "Error. No hay archivo";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->mensaje_error = "Error en arvhivo temporal";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->mensaje_error = "Error escritura";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->mensaje_error = "Error de extension";
                break;
            default:
        }
    }

    /**
     * Llamando a otros métodos, comprueba que archivo existe y la carpeta de 
     * destino. Si no es así da el correspondiente valor a error.
     * Distingue si el archivo a subir es único o un conjunto de archivos 
     * (array) para dirigirse al correspondiente método de subida.
     */
    function subir() {
        $this->error = 0;
        if (!$this->isInput()) {
            $this->error = -1;
            return false;
        }
        $this->files = $_FILES[$this->input];
        if (!$this->isCarpeta()) {
            if ($this->crearCarpeta) {
                $this->error = 0; //
                if (!$this->crearCarpeta()) {
                    $this->error = -7;
                    return false;
                }
            } else {
                $this->error = -8;
                return false;
            }
        }
        if (is_array($this->files)) {
            $this->subirMultiple();
        } else {
            $this->subirUnico();
        }
    }

    /**
     * Si el archivo de subida es único, este método se encarga de subirlo 
     * teniendo en cuenta la acción correspondiente o, en caso de error, 
     * asigna el valor correspondiente a error.
     */
    private function subirUnico() {
        $this->errorPHP = $this->files["error"];
        if ($this->isError()) {
            return $this->mensaje_error;
        }
        if (!$this->isTamano()) {
            $this->error = -2;
            return false;
        }
        $extension = $this->extArUnico();
        $nombreOriginal = $this->nomOrUnico();
        if (!$this->isExtension($extension)) {
            $this->error = -3;
            return false;
        }
        if ($this->nombre === "") {
            $this->nombre = $nombreOriginal;
        }
        $origen = $this->files["tmp_name"];
        if ($this->accion == Subir::REEMPLAZAR) {
            $this->reemplazar($nombreOriginal, $extension, $origen);
        } elseif ($this->accion == Subir::IGNORAR) {
            $this->ignorar($nombreOriginal, $extension, $origen);
        } elseif ($this->accion == Subir::RENOMBRAR) {
            $this->renombrar($extension, $origen);
        } else {
            $this->error = -6;
            return false;
        }
    }

    /**
     * Si el archivo de subida es único o existen varios (encontrándose en un 
     * array), este método se encarga de recorrer el array y,teniendo en cuenta
     * la acción correspondiente, enviar a un método determinado para realizar
     * el tipo de subida adecuado. En caso de error, 
     * asigna el valor correspondiente a error.
     */
    private function subirMultiple() {
        foreach ($this->files["name"] as $key => $value) {
            $this->errorPHP = $this->files["error"][$key];
            if (!$this->isError()) {
                if ($this->isTamanoMultiple($key)) {
                    $extension = $this->extArMultiple($key);
                    $nombreOriginal = $this->nomOrMultiple($key);
                    if ($this->isExtension($extension)) {
                        $origen = $this->files["tmp_name"][$key];
                        if ($this->accion == Subir::REEMPLAZAR) {
                            $this->reemplazar($nombreOriginal, $extension, $origen);
                        } elseif ($this->accion == Subir::IGNORAR) {
                            $this->ignorar($nombreOriginal, $extension, $origen);
                        } elseif ($this->accion == Subir::RENOMBRAR) {
                            $this->renombrar($extension, $origen);
                        } else {
                            $this->error = -6;
                        }
                    } else {
                        $this->error = -3;
                    }
                } else {
                    $this->error = -2;
                }
            } else {
                return $this->mensaje_error;
            }
        }
    }

    /**
     * Si al fichero no se le ha dado nombre conserva su nombre de origen.
     * Sube el fichero a la carpeta de destino. Si ya existe un fichero con 
     * el mismo nombre, previamente lo borra. Así reemplaza un fichero 
     * si tienen el mismo nombre
     */
    private function reemplazar($no, $ext, $or) {
        if ($this->nombre == "") {
            $this->nombre = $no;
        }
        $destino = $this->destino . $this->nombre . "." . $ext;
        if (file_exists($destino)) {
            unlink($destino);
            move_uploaded_file($or, $destino);
        } else {
            move_uploaded_file($or, $destino);
        }
    }

    /**
     * Si al fichero no se le ha dado nombre conserva su nombre de origen.
     * Sube el fichero a la carpeta de destino si no existe en la misma 
     * otro fichero con el mismo nombre.
     */
    private function ignorar($no, $ext, $or) {
        if ($this->nombre == "") {
            $this->nombre = $no;
        }
        $destino = $this->destino . $this->nombre . "." . $ext;
        if (file_exists($destino)) {
            $this->error = -5;
        } else {
            move_uploaded_file($or, $destino);
        }
    }

    /**
     * Si al fichero no se le ha dado nombre se le asigna el nombre "file"; 
     * file, file_1, file_2, file_3, ... si el nombre pertenece ya a otro 
     * archivo del directorio. Sube el fichero a la carpeta de destino si no 
     * existe en la misma otro fichero con el mismo nombre.
     */
    private function renombrar($ext, $or) {
        if ($this->nombre == "") {
            $this->nombre = "file";
        }
        $i = 1;
        $destino = $this->destino . $this->nombre . "." . $ext;
        while (file_exists($destino)) {
            $destino = $destino = $this->destino . $this->nombre . "_$i." . $ext;
            $i++;
        }
        move_uploaded_file($or, $destino);
    }

    /**
     * Obtiene información del archivo a subir contenido en el array
     * @return cadena de texto, la extensión del archivo a subir
     */
    private function extArMultiple($key) {
        $partes = pathinfo($this->files["name"][$key]);
        $ext = $partes['extension'];
        return $ext;
    }

    /**
     * Obtiene información del archivo a subir contenido en el array
     * @return cadena de texto, del nombre original del archivo a subir
     */
    private function nomOrMultiple($key) {
        $partes = pathinfo($this->files["name"][$key]);
        $nombre = $partes['filename'];
        return $nombre;
    }

    /**
     * Obtiene información del archivo a subir
     * @return cadena de texto, la extensión del archivo a subir
     */
    private function extArUnico() {
        $partes = pathinfo($this->files["name"]);
        $ext = $partes['extension'];
        return $ext;
    }

    /**
     * Obtiene información del archivo a subir
     * @return cadena de texto, del nombre original del archivo a subir
     */
    private function nomOrUnico() {
        $partes = pathinfo($this->files["name"]);
        $nombre = $partes['filename'];
        return $nombre;
    }

}