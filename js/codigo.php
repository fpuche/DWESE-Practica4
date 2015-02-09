<?php
header('Content-Type: application/javascript');
echo 'var mensaje = "'.$_GET['mensaje'].'";';
echo 'var tipo = "'.$_GET['tipo'].'";';