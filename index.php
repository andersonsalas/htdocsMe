<?php
/*
 * htdocsMe (versión 0.1)
 *
 * Desarrollado por Anderson Salas (contacto@andersonsalas.com.ve)
 * Mira el repositorio en GitHub: https://github.com/andersonsalas/htdocsMe
 *---------------------------------------------------------------------------------------*

    htdocsMe
    Copyright (C) 2015 Anderson Salas

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*----------------------------------------------------------------------------------------*

  Inicialización de htdocsMe!
*****************************************************************************************/
# Sesion
session_name('htdocsme_session');
session_start();
$config =& $_SESSION;

# Timeout de 15 minutos (no se para que pueda servir, pero allí está por si acaso)
if(!isset($config['timeout'])){
    $config['timeout'] = time() + 900;
} else {
    if($config['timeout'] < time()){
        unset($config['timeout']);
        header('Location: ?init');
        die;
    }
}

# Construyendo el arbol de directorios inicial
if(!isset($config['arbol_dir'])){
    $c = 0;
    foreach(scandir(__dir__) as $carpeta){
        if($carpeta != '.' && $carpeta != '..') $config['arbol_dir'][$c] = $carpeta;
        $c++;
    } unset($c);
}

# Nombre por defecto: htdocsMe!
if(!isset($config['tituloPagina'])) $config['tituloPagina'] = 'htdocsMe';

/* ------------------------------------------------------------------------------------ */

// var_dump($config);

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $config['tituloPagina'];?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script>/* ¡NO al iframe! */if(window.top !== window.self) window.top.location.replace(window.self.location.href);</script>
        <style type="text/css">
            body{
                background: #F5F5F5;
            }
            .configuracion-popover{
                width:350px !important
            }
            .carpeta-glypicon{
                color: #345479;
                font-size: 50px;
                text-align: center;
                display:block;
                padding: 20px 0px;
            }
            .archivo-glypicon{
                color: #8F8F8F;
                font-size: 50px;
                text-align: center;
                display:block;
                padding: 20px 0px;
            }


        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.configuracion').popover(
                    {
                        html : true,
                        template: '<div class="popover configuracion-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    }
                );
            })
        </script>
    </head>
    <body>
        <div class="container">
            <!-- Barra Superior [ -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default" style="margin-top:20px;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-11">
                                    <div class="input-group">
                                        <input type="text" placeholder="Buscar archivos y carpetas..." class="form-control" disabled/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span> </button>
                                        </span>
                                    </div>

                                </div>
                                <div class="col-xs-1" style="padding-left: 0px">
                                    <?php
                                    $config_html = trim(str_replace('"',"'",'
                                        <p style="font-size:16px; font-weight:bold">Configuración</p>
                                        <hr />
                                        <p class="text-center text-muted">En construcción...</p>
                                        <hr />
                                        <small class="text-muted">htdocsMe! es un launcher minimalista para darle un <em>look & feel</em> diferente al directorio raíz de xampp/lampp.<br><br>Mira el repositorio en <a href="http://github.com/andersonsalas/htdocsMe">GitHub</a> &middot; Hecho por <a href="http://github.com/andersonsalas">Anderson Salas</a</a></small>
                                    '));
                                    ?>
                                    <button type="button" class="btn btn-default btn-block configuracion" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?= $config_html; ?>"><span class="glyphicon glyphicon-cog"></span></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- ] -->
            <!-- Thumbnails [ -->
            <div class="row">
                <div class="col-md-12">
                    <?php foreach($config['arbol_dir'] as $carpeta){ ?>
                        <div class="col-xs-6 col-md-3">
                            <a href="<?= $carpeta;?>" class="thumbnail">

                                <?php if(is_dir(__dir__.'/'.$carpeta)){?>
                                    <span class="glyphicon glyphicon-folder-open carpeta-glypicon"></span>
                                <?php } else {?>
                                    <span class="glyphicon glyphicon-file archivo-glypicon"></span>
                                <?php } ?>

                                <div class="caption">
                                    <h5 class="text-center"><?= $carpeta;?></h5>
                                </div>

                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- ] -->
        </div>
    </body>
</html>