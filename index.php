<?php
require 'require/comun.php';
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
$enlaces = Paginacion::getEnlacesPaginacion($pagina, $total[0],5);
$modelofoto = new ModeloFoto($bd);
$foto = array();
?>

<!DOCTYPE html>
<html>

    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="estilo/reset.css" rel="stylesheet" />
        <link href="estilo/estilo.css" rel="stylesheet" />
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    </head>

    <body>
        <div id="logo"></div>
        <div id="content">

            <section id="home">
                <aside id="homeSpSup"></aside>
                <header id="homeheader">
                    <aside id="home-header-left">
                        <hr class="home-Header-ln1" />
                        <hr class="home-Header-ln2" />
                    </aside>
                    <nav id="home-header-nav">
                        <hr class="home-Header-ln1-nav" />
                        <ul id="navigation">
                            <li><a href="#home">HOME</a>
                            </li>
                            <li><a href="#menu">MENU</a>
                            </li>
                            <li><a href="#chef">OUR&nbsp;CHEF</a>
                            </li>
                            <li><a href="#location">LOCATION</a>
                            </li>
                            <li><a href="#contact">CONTACT&nbsp;US</a>
                            </li>
                        </ul>
                        <hr class="home-Header-ln2-nav" />
                    </nav>
                    <aside id="home-header-right">
                        <hr class="home-Header-ln1" />
                        <hr class="home-Header-ln2" />
                    </aside>
                </header>
                <aside id="homeSpInf"></aside>
            </section>
            <section id="menu">
                <aside id="menu-content">
                    <div id="img-promo"></div>
                    <div id="menu-premium">
                        <div id="menu-premium-img"></div>
                    </div>

                    <!--        Acceso administradores-->
                    <div id="menu-admin">
                        <?php echo $error; ?>
                        Login for admins:<br/>
                        <form action="front-end/phpLogin.php" method="POST">            
                            <input type="text" name="login" value="" id="login" placeholder="login" required/>
                            <input type="password" name="clave" value="" id="clave" placeholder="password" required/>
                            <input type="submit" value="Login" />
                        </form>        
                    </div>

                    <br/>

                    <div class="type-food">
                        <?php
                        foreach ($filas as $indice => $objeto) {
                            $foto = $modelofoto->getFotoIdPlato($objeto->getIdplato());
                            ?>  
                            <section class="menu-cont-options">
                                <div class="menu-cont-brunch-text">
                                    <h3><?php echo$objeto->getNombre(); ?></h3>
                                    <P><?php echo$objeto->getDescripcion(); ?></P>

                                </div>
                                <div class="menu-cont-img">
                                    <p><a data-idplato='<?php echo $objeto->getIdplato(); ?>'
                                          href='front-end/fotos.php?idplato=<?php echo $objeto->getIdplato(); ?>' target="_blank">ver más</a></p> <br>
                                    <?php
                                    if ($foto) {
                                        $ruta = $foto[0]->getUrl();
                                        $longitud = strlen($ruta);
                                        $ruta = substr($ruta, 3, $longitud - 3);
                                        ?>                        
                                        <p><img width="32%" src="<?php echo $ruta ?>"/> </p>
                                    <?php } ?>

                                    <!--        <?php if ($foto == true) { ?>
                                                    <p><img width="32%" src="<?php echo$foto[0]->getUrl(); ?>"/></p>
            
                                    <?php } ?> -->
                                </div>
                            </section>
                            <?php
                        }
                        ?>
                    </div> 

                    <div class="paginacion" colspan="7">
                        <?php echo $enlaces["inicio"]; ?>
                        <?php echo $enlaces["anterior"]; ?>
                        <?php echo $enlaces["primero"]; ?>
                        <?php echo $enlaces["segundo"]; ?>
                        <?php echo $enlaces["actual"]; ?>
                        <?php echo $enlaces["cuarto"]; ?>
                        <?php echo $enlaces["quinto"]; ?>
                        <?php echo $enlaces["siguiente"]; ?>
                        <?php echo $enlaces["ultimo"]; ?>
                    </div>




                    <div id="menu-p">
                        <p>Order your lumberman's food when you have chosen it. We will attend you with great pleasure.</p>
                    </div>
                    <div id="menu-girl">

                        <div id="menu-girl-img"></div>

                    </div>
                </aside>
            </section>
            <section id="chef">
                <aside id="chef-content">
                    <div id="chef-flag">
                        <div id="chef-flag-img"></div>

                    </div>
                    <div id="chef-cheftxt">
                        <p>Our chef comes from a long-lived family of cooks lumbermans and ranchers, who were supplied with meat cattle, cooked with the best firewood in Texas. Soon the fame of his delicious dishes spread throughout the country and important personalities came to taste so familiar foods. Today, Chef Joseph Lumberman delights us with rich roasted and crispy fried all meats.</p>

                    </div>
                    <div id="chef-chefimg">
                        <div id="chef-chefimg-img"></div>
                    </div>
                    <div id="delights-cheftxt">
                        <p>The specialties that have delighted our customers from yesteryear are made with the freshest and naturally raised meat on our own farms. Our beef, pork or chicken is prepared meticulously to provide the best amburguesas, hot dogs, pancakes and fritters accompanied by vegetables from the garden and dipped in our homemade sauces. This may be accompanied by familiar and refreshing beers and fine wine.</p>
                    </div>
                </aside>
            </section>
            <section id="location">
                <nav id="location-header">
                    <div id="location-header-direction">
                        <p>THE LUMBERMAN'S BREWERY
                            <br/>5 STECK AVE. AUSTIN, TX 78704</p>
                    </div>
                    <div id="location-header-state"></div>
                    <div id="location-header-img"></div>
                </nav>
                <div id="location-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3442.3588095728064!2d-97.74450259999999!3d30.369167599999994!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8644cb71823bf56d%3A0xe91a17f14f44a64a!2sSteck+Ave%2C+Austin%2C+TX%2C+EE.+UU.!5e0!3m2!1ses!2ses!4v1422524640944" frameborder="0" style="border:0"></iframe>
                </div>
            </section>
            <section id="contact">
                <div id="contact-spsup"></div>
                <div id="contact-form">
                    <form name="contact" id="contact" action="enviar" method="post">
                        <textarea name="mensage" id="mensagem" placeholder="Menssage:" rows="16" cols="40" required></textarea>
                        <input type="email" name="email" id="email" value="" placeholder="Mail" required autocomplete="on">
                    </form>

                </div>
                <div id="contact-tlf">
                    <p><span>+1 512-472-9355,</span> the Lumberman book your table!</p>
                </div>
                <div id="contact-company">
                    <p>&copy;The Lumberman's Brewery Co.
                        <br/>
                        <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
                    </p>
                </div>
                <div id="contact-img"></div>
            </section>
        </div>
    </body>

</html>
