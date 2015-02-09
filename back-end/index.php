<?php
require '../require/comun.php';
$sesion->autentificado("../index.php");
$u = $sesion->getUsuario();
//var_dump($u);
echo Leer::get("r");
$ajax = true;
$error = Leer::get("error");
$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$filas = $modelo->getList($pagina);
$paginas = $modelo->getNumeroPaginas();
$total = $modelo->count();
$enlaces = Util::getEnlacesPaginacion2($pagina, $total[0]);
$actual = "ajax";
$dir = "../";
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <link rel="stylesheet" href="../estilo/reset.css">
        <link rel="stylesheet" href="../estilo/estilo-fotos.css">
        <link rel="stylesheet" href="../estilo/vendor/bootstrap.min.css">
        <link rel="stylesheet" href="../estilo/vendor/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../js/vendor/toast/toastr.css">
        <script  rel="stylesheet" src="../js/vendor/jquery-1.11.1.js"></script>
<!--        <script rel="stylesheet" src="../js/vendor/jquery-ui-1.10.2.custom.js"></script>
        <script rel="stylesheet" src="../js/vendor/jquery-ui-1.10.2.custom.min.js"></script>-->
        <script rel="stylesheet" src="../js/vendor/bootstrap.min.js"></script>
        <script rel="stylesheet" src="../js/vendor/bootstrap.js"></script>
        <script rel="stylesheet" src="../js/codigo.js"></script>
        <script rel="stylesheet" src="script/codigo.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Admin</title>
    </head>
    <body>
        <div id="dialogomodal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- dialog body -->
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <span id="contenidomodal">Contenido modal</span>
                    </div>
                    <!-- dialog buttons -->
                    <div class="modal-footer">
                        <button type="button" id="btsi" class="btn btn-success">Aceptar</button>
                        <button type="button" id="btno" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--        <h1>Admin</h1>-->

        <div id="menu">
            <div id="meu-content">
                <?php
                if ($sesion) {
                    ?>
                    <a class="edit-button1" href="phplogout.php">Cerrar sesión</a>
                    <?php
                } else {
                    ?>
                    <form class="navbar-form navbar-right">
                        <div class="form-group">
                            <input type="text" placeholder="e-mail" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="clave" class="form-control">
                        </div>
                        <button id="btlogin" type="button" class="btn btn-success">acceder</button>
                    </form>
                    <?php
                }
                ?>
<!--                 <p><a id="btverinsertar" href="#" class="btn btn-primary btn-lg" role="button">Insertar plato &raquo;</a></p>-->
                <div class="modal-footer">
                    <button class="edit-button2" type="button" id="cuadroNuevoPlato">Nuevo plato</button>
                    <!--                        <button type="button" id="no">Cancelar</button>-->

                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">Guardar plato</h4>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Nombre:</label>
                                        <input type="text" style="width: 90%;" class="form-control" id="nombreInsertar">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Descripcion:</label>
                                        <textarea class="form-control" style="width: 90%;" id="descripcionInsertar"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Precio:</label>
                                        <input type="text" class="form-control" style="width: 90%;" id="precioInsertar">
                                        <label for="recipient-name" class="control-label">Subir imágenes:</label>
                                        <input type="file" id="archivo" multiple />
                                    </div>
                                </form>
                            </div>
                            <div id="edit-fotos"></div>
                            
                            <div class="modal-footer">
                                <button type="button" id="btnoI" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                                <button type="button" id="btsiI" class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divajax">
                    <h2>Loading ...</h2>
                </div>

                <div id="menu-content-fotos">
                </div>
            </div>           
        </div>                                   
<script src="../js/vendor/jquery-1.11.1.js"></script>
<script src="../js/vendor/bootstrap.min.js"></script>
<script src="../js/vendor/toast/toastr.js"></script>
<script src="../js/ajax.js"></script>
<script src="../js/codigo.php?<?php echo "mensaje=$mensaje&tipo=$tipo";?>"></script>
<script src="../js/codigo.js"></script>
      <!--  <?php include ("../include/script.php"); ?> -->
    </body>
</html>








<!--$('#myModal').modal('show');
$('#myModal').modal('hide');-->