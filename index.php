<?php
/*
 * htdocsMe (versión 0.3.1)
 *
 * Desarrollado por Anderson Salas (contacto@andersonsalas.com.ve)
 * Repositorio en GitHub: https://github.com/andersonsalas/htdocsMe
 *
 * -------------------------------------------------------------------------------------
 *
 *   htdocsMe
 *   Copyright (C) 2015 Anderson Salas
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License along
 *   with this program; if not, write to the Free Software Foundation, Inc.,
 *   51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

    function rglob($pattern, $flags = 0)
    {
        // Funcion para hacer un glob() recursivo. Tomado de:
        // http://stackoverflow.com/a/17161106

        $files = glob($pattern, $flags);
        //foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        foreach (glob(dirname($pattern).'/*') as $dir){
            $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }

    function human_filesize($bytes, $decimals = 2)
    {
        // Funcion para convertir el tamaño de los archivos a un numero más amigable
        // http://php.net/manual/es/function.filesize.php#106569

        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    if(isset($_POST['busqueda'],$_POST['url']))
    {
        $url = trim(strip_tags($_POST['url']));
        $busqueda = trim(strip_tags($_POST['busqueda']));
        $url = $url.DIRECTORY_SEPARATOR;
        $resultado = rglob($url.$busqueda);

        if(!empty($resultado)){
            echo '<p class="text-muted">'.count($resultado).' concidencia(s) en total</p>';
            foreach($resultado as $res){
                if(substr($res,0,2) == './') $res = substr($res,2);
                if(substr($res,0,3) == '.\\\\') $res = substr($res,3);
                ?>
                    <span class="glyphicon glyphicon-<?php echo is_file($res) ? 'file' : 'folder-open' ; ?>" aria-hidden="true" style="color: #B2B2B2"></span>&nbsp;&nbsp;<a href="<?php echo $res;?>" target="_blank"><?php echo $res;?></a>
                    <span class="text-muted"><?php echo is_file($res) ? '&nbsp;('.human_filesize(filesize($res)).' bytes)' : '' ; ?></span>
                    <br />
                <?php
            }
        } else {
            echo '<p class="text-center text-muted">Sin resultados</p>';
        }
        die();
    }

    if(isset($_GET['url'])){
        $url = $i_url = strip_tags($_GET['url']);
        if(substr($url,0,1) != '.'.DIRECTORY_SEPARATOR){
            $url = '.'.DIRECTORY_SEPARATOR.$url;
        }
    } else {
        $url = $i_url = __dir__;
    }

?><!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>htdocsMe!</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <style>
            body{
                font-family: "Droid Sans"
            }
            .main-container{
                padding-top:30px;
                padding-bottom: 30px;
                background: #FAFAFA;
            }
            .search-box, .search-box *, .carpeta, .archivo{
                border-radius: 0;
            }
            .search-box{
                margin-bottom: 50px;
            }

            .carpeta > div, .archivo > div{
                padding: 0;
            }

            .carpeta:hover, .archivo:hover{
                box-shadow: 0 0 15px 0 rgba(0,0,0,0.3);
                transition: all 0.2s;
            }
            .carpeta:hover .icono-carpeta, .archivo:hover .icono-archivo{
                background: #5E9EE8;
                transition: all 0.2s;
            }

            .carpeta .glyphicon{
                font-size:60px;
            }
            .carpeta-href:hover, .carpeta-href:focus{
                text-decoration: none !important;
            }
            .carpeta p, .archivo p{
                margin: 0;
                color: #363636;
            }
            .carpeta p{
                padding: 8px 0;
            }
            .icono-archivo{
                background: #FAFAFA;
                padding: 20px;
                top: 0;
                margin-right: 5px;
                font-size:15px
                transition: all 0.5s;
            }
            .archivo:hover .icono-archivo{
                color: white;
            }
            .icono-carpeta{
                width: 100%;
                display: block;
                padding: 40px;
                background: #E2E2E2;
                color:white;
                transition: all 0.5s;
            }
            .search-box input{
                border-top: none;
                border-left: none;
                border-right: none;
                border-bottom-width: 2px;
                padding-left: 0;
                padding-right: 0;
                box-shadow: none !important;
            }
            .search-res{
                display: none;
            }
            .footer{
                padding: 20px 0;
            }
            .footer p{
                margin: 0;
            }
            .boton-abrir-externo{
                width: 35px;
                height: 35px;
                color: #424242;
                background: none;
                position: absolute;
                border-radius: 50%;
                right: 25px;
                top: 10px;
                opacity:0.2;
            }
            .boton-abrir-externo .glyphicon{
                font-size:14px;
                padding: 8px 12px;
            }
            .boton-abrir-externo:hover{
                opacity:1;
                background: #363636;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid  main-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-box panel panel-default">
                            <div class="panel-body">
                                <input type="text" class="form-control input-lg input-busqueda" placeholder="Buscar archivos o carpetas..." />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row search-res" style="display:none">
                    <div class="col-md-12">
                        <h4>Resultado de la búsqueda:</h4>
                        <hr />
                        <div class="area-res">

                        </div>
                    </div>
                </div>
                <div class="row folder-view">
                    <div class="col-md-12">
                        <h4>Carpetas: <span class="pull-right text-muted"><?php echo $url;?></span></h4>
                        <hr />
                    </div>
                    <?php foreach(scandir($url) as $carpeta){ ?>

                        <?php

                            if(($url == __dir__) == $_SERVER['DOCUMENT_ROOT'])
                            {
                                $link = $e_link = DIRECTORY_SEPARATOR.$carpeta;
                            }
                            else
                            {
                                $link = $i_url.DIRECTORY_SEPARATOR.$carpeta;

                            }

                            if($carpeta == '.' && isset($_GET['url']) && (dirname($link) != DIRECTORY_SEPARATOR)){
                                ?>
                                    <div class="col-md-3 col-xs-6">
                                        <a href="?url=<?php echo dirname(dirname($link));?>" class="carpeta-href">
                                            <div class="panel panel-default carpeta">
                                                <div class="panel-body text-center">
                                                    <div class="icono-carpeta" style="background: #BFBFBF">
                                                        <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                                    </div>
                                                    <p>(Subir un nivel)</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                            }

                            if($carpeta == '.' || $carpeta == '..' || !is_dir($url.DIRECTORY_SEPARATOR.$carpeta))
                            {
                                continue;
                            }

                        ?>

                        <div class="col-md-3 col-xs-6">
                            <a href="?url=<?php echo $link ;?>" class="carpeta-href">
                                <div class="panel panel-default carpeta">
                                    <div class="panel-body text-center">
                                        <div class="icono-carpeta">
                                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                        </div>
                                        <p><?php echo $carpeta; ?></p>
                                    </div>
                                </div>
                            </a>
                            <a href="http://<?php echo $_SERVER['HTTP_HOST'].$link;?>" target="_blank" class="boton-abrir-externo"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></a>
                        </div>
                    <?php } ?>
                </div>
                <div class="row files-view">
                    <div class="col-md-12">
                        <h4>Archivos:</h4>
                        <hr />
                    </div>
                    <?php foreach(scandir($url) as $archivo){ ?>

                        <?php
                            if($archivo == '.' || $archivo == '..' || !is_file($url.DIRECTORY_SEPARATOR.$archivo))
                            {
                                continue;
                            }
                            if(($url == __dir__) == $_SERVER['DOCUMENT_ROOT'])
                            {
                                $link = DIRECTORY_SEPARATOR.$archivo;
                            }
                            else
                            {
                                $link = $url.DIRECTORY_SEPARATOR.$archivo;
                            }
                        ?>

                        <div class="col-xs-6 col-sm-4">
                            <a href="<?php echo $link;?>" class="carpeta-href">
                                <div class="panel panel-default archivo">
                                    <div class="panel-body">

                                        <p><span class="glyphicon glyphicon-file icono-archivo" aria-hidden="true"></span> <?php echo $archivo; ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="container-fluid footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted">htdocsMe! 0.3.1 - Hecho por <a href="http://github.com/andersonsalas">Anderson Salas</a></p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                var busqueda = '';
                var globalTimeout = null;
                $('.input-busqueda').keyup(function() {
                    busqueda = $('.input-busqueda').val();
                    if (globalTimeout != null) {
                        clearTimeout(globalTimeout);
                    }
                    globalTimeout = setTimeout(function() {
                        globalTimeout = null;
                        if(busqueda != ''){
                            $('.area-res').html('<p class="text-center text-muted">Buscando...</p>');
                            $('.search-res').show();
                            $('.search-box').css('margin-bottom','10px');
                            $('.folder-view, .files-view').hide();
                            $.post('?', {'busqueda':busqueda, 'url':'<?php echo $url;?>'}, function(data){
                                $('.area-res').html(data);
                            });
                        } else {
                            $('.search-res').hide();
                            $('.search-box').css('margin-bottom','30px');
                            $('.folder-view, .files-view').show();
                        }
                    }, 350);
                });
            });
        </script>
    </body>
</html>
