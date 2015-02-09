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
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Título</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php if ($actual == "inicio") echo 'class="active"'; ?>><a href="<?php echo $dir; ?>">Inicio</a></li>
                <li <?php if ($actual == "acerca") echo 'class="active"'; ?>><a href="<?php echo $dir; ?>acercade.php">Acerca</a></li>
                <li <?php if ($actual == "contacto") echo 'class="active"'; ?>><a href="<?php echo $dir; ?>contacto.php">Contacto</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Acciones <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li <?php if ($actual == "ajax") echo 'class="active"'; ?>><a href="<?php echo $dir; ?>ajax">Ajax</a></li>
                        <li <?php if ($actual == "usuario") echo 'class="active"'; ?>><a href="<?php echo $dir; ?>backusuario">Usuario</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Acción 3</a></li>
                        <li class="divider"></li>
                        <?php
                        if ($autentificado) {
                            ?>
                            <li><a href="#">Logout</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Registrarse</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
            if ($autentificado) {
                ?>
                Cerrar sessión
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
        </div>
    </div>
</div>