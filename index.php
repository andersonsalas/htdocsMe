<?php
/*
 * htdocsMe (versión 0.3)
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

function rglob($pattern, $flags = 0) {
    // Funcion para hacer un glob() recursivo. Tomado de:
    // http://stackoverflow.com/a/17161106

    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}

if(isset($_POST['busqueda'])){
    $resultado = rglob(trim($_POST['busqueda']));
    if(!empty($resultado)){
        echo '<p class="text-muted">'.count($resultado).' concidencia(s) en total</p>';
        foreach($resultado as $res){
            echo '<a href="'.$res.'">'.$res.'</a><br>';
        }
    } else {
        echo 'No hubo resultados.<br>';
    }
    die();
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
                background: #FAFAFA;
                font-family: "Droid Sans"
            }
            .main-container{
                padding-top:30px;
            }
            .search-box, .search-box *, .carpeta, .archivo{
                border-radius: 0px;
            }
            .search-box{
                margin-bottom: 50px;
            }

            .carpeta > div, .archivo > div{
                padding: 0px;
            }

            .carpeta:hover, .archivo:hover{
                box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.3);
            }
            .carpeta:hover .icono-carpeta, .archivo:hover .icono-archivo{
                background: #5E9EE8;
            }
            .carpeta .glyphicon{
                font-size:60px;
            }
            .carpeta-href:hover, .carpeta-href:focus{
                text-decoration: none !important;
            }
            .carpeta p, .archivo p{
                margin: 0px;
                color: #363636;
            }
            .carpeta p{
                padding: 8px 0px;
            }
            .icono-archivo{
                background: #FAFAFA;
                padding: 20px;
                top: 0px;
                margin-right: 5px;
                font-size:15px
            }
            .archivo:hover .icono-archivo{
                color: white;
            }
            .icono-carpeta{
                width: 100%;
                display: block;
                padding: 40px;
                background: #C9C9C9;
                color:white;
            }
            .search-box input{
                border-top: none;
                border-left: none;
                border-right: none;
                border-bottom-width: 2px;
                padding-left: 0px;
                padding-right: 0px;
                box-shadow: none !important;
            }
            .search-res{
                display: none;
            }

        </style>
    </head>
    <body>
        <div class="container main-container">
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
                    <h4>Resultado de la búsqueda "<span class="busqueda"></span>":</h4>
                    <hr />
                    <div class="area-res">

                    </div>
                </div>
            </div>
            <div class="row folder-view">
                <div class="col-md-12">
                    <h4>Carpetas:</h4>
                    <hr />
                </div>
                <?php foreach(scandir(__DIR__) as $carpeta){ ?>
                    <?php if($carpeta == '.' || $carpeta == '..' || !is_dir($carpeta)) continue; ?>
                    <div class="col-md-3 col-xs-6">
                        <a href="/<?= $carpeta;?>" class="carpeta-href">
                            <div class="panel panel-default carpeta">
                                <div class="panel-body text-center">
                                    <div class="icono-carpeta">
                                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                    </div>
                                    <p><?= $carpeta; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="row files-view">
                <div class="col-md-12">
                    <h4>Archivos:</h4>
                    <hr />
                </div>
                <?php foreach(scandir(__DIR__) as $carpeta){ ?>
                    <?php if($carpeta == '.' || $carpeta == '..' || !is_file($carpeta)) continue; ?>
                    <div class="col-xs-4">
                        <a href="/<?= $carpeta;?>" class="carpeta-href">
                            <div class="panel panel-default archivo">
                                <div class="panel-body">

                                    <p><span class="glyphicon glyphicon-folder-open icono-archivo" aria-hidden="true"></span> <?= $carpeta; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){

                var busqueda = '';

                // Tomado de:
                // http://stackoverflow.com/a/1909508
                var delay = (function(){
                    var timer = 0;
                    return function(callback, ms){
                        clearTimeout (timer);
                        timer = setTimeout(callback, ms);
                    };
                })();

                $('.input-busqueda').keyup(function(){
                    $('.area-res').html('<br><br><br><p class="text-center">Buscando...</p>');
                    delay(function(){
                        busqueda = $('.input-busqueda').val();
                        $('.busqueda').text(busqueda);
                        if(busqueda != ''){
                            $('.search-res').show();
                            $('.search-box').css('margin-bottom','10px');
                            $('.folder-view, .files-view').hide();
                            $.post('<?= $_SERVER["REQUEST_URI"];?>', {'busqueda':busqueda}, function(data){
                                $('.area-res').html(data);
                            });
                        } else {
                            $('.search-res').hide();
                            $('.search-box').css('margin-bottom','30px');
                            $('.folder-view, .files-view').show();
                        }
                    },1000);
                });

            })
        </script>
    </body>
</html>