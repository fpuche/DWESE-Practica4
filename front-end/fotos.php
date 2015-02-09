<?php
require '../require/comun.php';
$bd = new BaseDatos();
$idplato = Leer::request("idplato");
$modelo = new ModeloPlato($bd);
$plato = $modelo->get($idplato);
$modelofoto = new ModeloFoto($bd);
$foto = $modelofoto->getFotoIdPlato($idplato);
$bd->closeConexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Imágenes plato</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../estilo/reset.css" rel="stylesheet" />
        <link href="../estilo/estilo-fotos.css" rel="stylesheet" />
    </head>
    <body>
        <div id="content">               
            <div id="menu">
                <div id="meu-content">
                    <div id="menu-content-fotos">

                        <a  href='../index.php'>back</a>
                        <br/>
                        <br/>
                        <br/>
                        <h2><?php echo $plato->getNombre() ?></h2>
                        <P><?php echo $plato->getDescripcion(); ?></P>
                        <P>Price: $<?php echo $plato->getPrecio(); ?></P>
                        <br/>
                        <br/>
                        <?php
                        foreach ($foto as $indice => $objeto) {
                            ?> 

                            <img width="250px" src="<?php echo $objeto->getUrl(); ?>"/>           
                            <br/>
                            <br/>
                            <br/>
                            <?php
                        }
                        ?>                      


                    </div>

                </div>           
            </div>                                   
        </div>

    </body>
</html>
