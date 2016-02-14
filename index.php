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
        $factor = (int) floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    function setCookieLongTime($name, $value)
    {
        setcookie ( $name, $value, time () + ( 60 * 60 * 24 * 365 * 10 ) ); // 10 anos
    }

    session_start();

    $langAllow = array (
        'pt-BR' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wCEAAYEBAQFBAYFBQYJBgUGCQsIBgYICwwKCgsKCgwQDAwMDAwMEAwODxAPDgwTExQUExMcGxsbHCAgICAgICAgICABBwcHDQwNGBAQGBoVERUaICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIP/AABEIAB4AMgMBEQACEQEDEQH/xACRAAACAwEBAAAAAAAAAAAAAAAABAUGBwEDEAABAwIEAggEBwAAAAAAAAABAgMEAAUGERIhEzEHFCIyQWFxgUJRgpEVIyRDUlSxAQACAwEBAAAAAAAAAAAAAAAABQMEBgEHEQABAwEFBQcDBQAAAAAAAAABAAIDBAUREiExBiJBUaEyYYGRseHwExQjM1JiwdH/2gAMAwEAAhEDEQA/AKbSVYxFCFM2XCl2uo4qECPD8Zb3ZR9I2KqoVVoRw5dp/IaprQWPNUZgYWfuP9c0/d8B3CKlT1vcTcY6e/wsuKn6Rsfaq9Na7HZSAxu79FcrtnpYt6P8jevlxVYIIJB5g5EfI/I03WeRQhFCE7abNPu0rq0JAUvLNSlKCUpHzPj9qr1NUyFuJ+it0dFJUPwx6+i0OxYAtcDS9M/XShuNQyaSfJHj6msrWW1JJkzdb181tqDZ6GHN++/oPBZtjjEOCMSXR1mdfryzEjFTYiRoiDFb0HSrUj4+0OZr02xLK+ziGFrS9wvLj2jf6KCqqHSO/iOChrHhqTFm9bwBidmfcG1E/hpSq3S1JTuM47x4b2x3G3kaZ1bY52YKhl7T49dQq7Jiw3jJbG1ZYGKbHDuNxhLt10fZSp8BJbdad+NCgoDPJWeyhXkc88lBUPhacTGu48uHRN57NgrGB7hc4jUa+6pOIcJXKy/mOlL0RR0okJ23PIKQdwfSn1FaUdRkMncljLSseWlzNzmc/wDQoSmCUrra1tuJcbUUOI3QtJIUD5EVwgEXHRda4tN4yIVysfSPMY0s3VHWWv7CNnR6jkr/AGkNZYTHZx7p5cPZamg2le3dm3hzGvv8yVTxh0cSru5IumEuFc4UhZeTGC+HIjOrVrXpCskqSoqJ0qy39q1Fk7SshaIqu+N7RdfduuA08U0+k2f8kBDmnzCQs/RbimZPE29RE2qOyoKXIluIKEgfwbSpZJ581Der1XtTRxtuid9V50DQepXBRP1dutHErR7n0hRocZEK0a5i2UJa69JKlZ6Bpz37Th25msK2ypJ5DLObi433D5kqtXtHHG3BTjFdxOnv6d6pE+4TbhI6xNeU+74KVyHkkcgKfQwsjGFguCydRUyTOxSHEfmiXqVQLlCEUIXvEmy4b4kRXVMPD9xByPv4H3qOSJrxc4XhSwzvidiYS13cmLrfbpdVhU58ugd1vutj0QNvvUVPSRw9gXKerr5aj9Q393DySO9WVTRQhFCF/9k=',
        'pt-PT' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wCEAAYEBAQFBAYFBQYJBgUGCQsIBgYICwwKCgsKCgwQDAwMDAwMEAwODxAPDgwTExQUExMcGxsbHCAgICAgICAgICABBwcHDQwNGBAQGBoVERUaICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIP/AABEIAB4AMgMBEQACEQEDEQH/xACNAAEAAwADAAAAAAAAAAAAAAAABQYHAQIDEAAABAQEBQMFAAAAAAAAAAAAAQIDBAUREgYTFCEHMUFCYRUjcTIzNIHCAQEAAgMBAQAAAAAAAAAAAAAABAUBBgcIAhEAAQMCAgYHCQEAAAAAAAAAAAECAwQREjEFIVFhcYEHEyIyQZHBBhQzQlJiobHR8P/aAAwDAQACEQMRAD8Ayca2agAMk5L5XMlQanChH8ut+Zku2W2862iFLK3Fmnmh2HozckaTI/VdW2vqvnlc6GRkdDGTrZwBkAAAIgTDyCaHwlw7K4t+Mm8ybzkQFEQbSt0alSDWlSy6kVCp5OvQVNfUOSRkTfmXXw2GwaEo2vdidtRP96GpJw5ZJNcmZvFGm36icNcWXnZX4l9Pop3/ALFquiIvduus34f0JxvtN0gq4YqlYms7K9i+tVz7+Hb9vIzviRI4dlTE2h2Ew2rUaH20GRoNxKCVmJIuV293kqikp5rSvi8G5cNn8N/9m65zkWFzsWFLoq52vay8PAoosDawAAAhxMPIJZsEYohpNFraj2jel0Tablu62nEEZIeSnkqhLMlJ6l8CBW0z32fGtpG5b9ylpo2u6l2vL9L4KalC46gnpeqDObwXoSWtJoiP3dJZ9u6hKpXtsr5psPl+k5kh6rDJfl5Yr5b87HR9E2rVWSNirOiouNFvrVb3VNVl58ilY+xe1P49KYRnTwEPs0W5GtVCSbik9NkkSfHyIdBSOju563e7P+HRNBaJWlj7a3kdnu3fm67yqCxL8AAAIcTDyCABJwClaZW/f/IjS5nY+i3uz8W+p6j4OtgAAAAH/9k=',
        'en'    => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wCEAAYEBAQFBAYFBQYJBgUGCQsIBgYICwwKCgsKCgwQDAwMDAwMEAwODxAPDgwTExQUExMcGxsbHCAgICAgICAgICABBwcHDQwNGBAQGBoVERUaICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIP/AABEIAB4AMgMBEQACEQEDEQH/xACZAAACAwEBAAAAAAAAAAAAAAAGBwQFCAIDEAACAQIFAQYCBwkAAAAAAAABAgMEBQAGBxESIQgTFDFBYSJRIzJCUnFylBUWN1dkgZGz0gEAAwEBAQEAAAAAAAAAAAAAAwQFBgIBBxEAAQIDAwgJAwUAAAAAAAAAAQACAwQRBRIhBhYxQVFTcaETFBUiYWORwfAzQ7E0QlLR4f/aAAwDAQACEQMRAD8AbWQNbcjZ+pltNcqUF2qV4S2at4sk3T4hA7AJMPbbl8wMPTElEhY6Rt+aENkQOQXqT2WqCrElxyO60VT9ZrNOx8M253PcyfE0Psp3T0HHzw1LWqRhExG3WhxIAKDMjWC9WHTbUy3XijloK5Dby0E68W25EBhturKduhUkYBbsVr2tLcRT3VrJhtJxg8fZdWKGWfR3UWCFDJNL4BI41BZmZpQAABuSSfIDE6xTSMD4q7lj9vgfypGm3Zhvl3aO45vZ7RbTs60CEeNlHyfzWAf5f8pxoJm1AMGYnl8+YrCw5fWU77lftMNI8vx0f0Nth4k01upx3lXUsvm3HrJI33nc/icSmsizDq6fwmCQ1Keftf1vfSdxlSMwcj3RkrmV+O/TkFp3UHbz2Yj3xRFjj+XL/UHrIQ8t50aQ7ppuFI6giukHUeXriGbaj7Stxmb5g9EdW7tGUdvooqOny7UmCEcY++rjO+w9DJKHc/3OFXTldS6zRO8HoVV5410jzNlevsgsb0jVqqniTOr8eLhvIKCfLA3zF4UonrOyc6vHbEvg3dVFRaYanJklbkrWxrh49onG0gj4d0CPUHfzxxCi3E7bFj9cu967drqR0e03GQR+7kvX+pX/AJwXrXgouaJ3g9CgW5Zs0rulZLW3PIMldWTnlNUVFymlkY+7OSenoPTDTbXitwGC4zO8wehUX9raL/y1T9bJjvtuPtK9zO8wehUnLObci5nui2yx6Uy1tY23JUrjxjB+1K+3GNfdiN/TfD0WxIcMVc4c1BblJOHQ88k7bfoxp/JRxPcMt0tNVsN5YIZ5pkU/ISHu+X48RiWZeHqRu353eFBGfsraSR5SzK+Waana8WNYfES07yOIXmk2CluRTlsDuPT1xzMStxl6lKqlY1szMaaYx7yWk4oZ0ls2Qai0Zhu2cqeN6C2yUqiolMnGITnjueB8uRG59MClYHSGlKlVMpLRjS9zo3Xa1qnBTaP6T1dKlTR2emqIJV5wzRyyMjA+RDK5BGDmWYNSzPb85vDySp1AOVci1G140u7ygYkQ3Smr3elbr0DOVXu2P3X29t8Py9lQouhwrs1obsop0fvPJB51X0mHQ6an9fhrN5u0c0POib3hWn4LblXT7KVQ1st4pbXbommlhpwDK/AdWZnILufmzYRLnRX4nEqdoWWNSe0Pm7N6NR24tZLFKPhp6dyKiZCehnnXiRuPNE2HzLDGglbNZDxPeckoswdAXvpT/CTUgDoA1v2A6AdfQYm5Q6Bw91fyW/Vw+Psp1oJGi+pJHnxof9gxMsT644q9lj9vgUDZA1Uzhkes3s9VyoXfea1T7vSv19E3+iY/fTb35Y1sxJsijHTtXz6HHIWuNNdQLTqVlWWsa3GBQxpbhRVHCWIuPrhT9tPzKPwxmpmAYL6VVBrrwVVN2b9H5ZnlNldDIxbhHV1caDc77KiyhVA9ABsMFFpR9vIf0ueiav/Z',
        'es-ES' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wCEAAYEBAQFBAYFBQYJBgUGCQsIBgYICwwKCgsKCgwQDAwMDAwMEAwODxAPDgwTExQUExMcGxsbHCAgICAgICAgICABBwcHDQwNGBAQGBoVERUaICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIP/AABEIAB4AMgMBEQACEQEDEQH/xACLAAEAAgIDAAAAAAAAAAAAAAAAAQQDBQYHCBAAAQMCAwQJBQAAAAAAAAAAAQIDBAAFBxESBhcxkRMUFiFBU1SU0hUiQmGCAQEAAwEAAwAAAAAAAAAAAAAAAgMGAQQHCBEAAQIDBAkEAwAAAAAAAAAAAAECBREWAwYxUxIVIUFhYpGhoiIzQ5JysdH/2gAMAwEAAhEDEQA/AO3K9CyNeRSQFJAUkCaSApIEUkDzRvuxE9ez7VPzr6EoaF5Xkpj9c2oON+IYBJns5AZk9VT4f3ShoXleShIzanJt4+2doejp2tu3U3i+kS7RGiNKmCG4wXG5Ta9bjRBXknTxrxqNhj/bsp8dJZTnhuLtZ2qYqV2cXb3MZaai34xZ4jSHHky4TZbflBYEaNG0FJzdSTmpZyBFdW5MObjY7NmDlw3qpFsVtV39jWXTFnFW03B+3XKQ1GnRVaJDCozRKFZBWRKXFJ4KB7jVzLlQlyTSz2fkv8Ivi1s1SpvuxE9ez7VPzqVDQvK8lI66tRvuxE9ez7VPzpQ0LyvJRrq1NH2cZ81XIVbUfJ3NdQ7MxeiFm22tFvuEacjo5C4yw4mPKbDjCyPB1HdqT+qi+8GkktDHiSbcliL7i/VDHKswkyHX3HiC6tS9CR9qdRz0pBzySngkeAo28MklodzjrktX5F6GIbPNDg8rkKlUfJ3OUQzNXohduUP6g1CbdDTaoLPVw8y3pcfGefSSVEnpHM/yqtkf0Z+jHj+ib7lMX5PEpdnGfNVyFWVHydyFDszF+qDs4z5quQpUfJ3FDszF6IbesybsUAoBQCgFAKA//9k=' );
    $lang = 'es-ES';
    if ( isset( $_COOKIE[ 'htdocsMe-lang' ] ) )
        $lang = $_COOKIE[ 'htdocsMe-lang' ];
    else {
        $langs = explode ( ',', $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] );
        foreach ( $langs as $_lang ) {
            if ( isset( $langAllow[ $_lang ] ) ) {
                $lang = $_lang;
                setCookieLongTime ( 'htdocsMe-lang', $lang );
                break;
            }
        }
    }
    if ( isset( $_GET[ 'lang' ] ) ) {
        $_lang = strip_tags ( $_GET[ 'lang' ] );
        if ( isset( $langAllow[ $_lang ] ) ) {
            $lang = $_lang;
            setCookieLongTime ( 'htdocsMe-lang', $lang );
        }
    }

    switch( $lang ){
        case 'pt-BR':
            $langString = array(
                'buscar'   => 'Buscar arquivos e pastas...',
                'subir'    => '(Subir um nível)',
                'Carpetas' => 'Pastas',
                'Archivos' => 'Arquivos'
            );
            break;
        case 'pt-PT':
            $langString = array(
                'buscar'   => 'Buscar Ficheiros e Diretorios...',
                'subir'    => '(Subir um nível)',
                'Carpetas' => 'Diretorios',
                'Archivos' => 'Ficheiros'
            );
            break;
        case 'en':
            $langString = array(
                'buscar'   => 'Find files or folders ...',
                'subir'    => '(Up one level)',
                'Carpetas' => 'Folders',
                'Archivos' => 'Files'
            );
            break;
        default:
            $langString = array(
                'buscar'   => 'Buscar archivos o carpetas...',
                'subir'    => '(Subir un nivel)',
                'Carpetas' => 'Carpetas',
                'Archivos' => 'Archivos'
            );
    }


    if ( isset( $_GET[ 'url' ] ) ) {
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
            body {
                font-family : "Droid Sans"
            }

            .main-container {
                padding-top    : 30px;
                padding-bottom : 30px;
                background     : #FAFAFA;
            }

            .search-box, .search-box *, .carpeta, .archivo {
                border-radius : 0;
            }

            .search-box {
                margin-bottom : 50px;
            }

            .carpeta > div, .archivo > div {
                padding : 0;
            }

            .carpeta:hover, .archivo:hover {
                box-shadow : 0 0 15px 0 rgba(0, 0, 0, 0.3);
                transition : all 0.2s;
            }

            .carpeta:hover .icono-carpeta, .archivo:hover .icono-archivo {
                background : #5E9EE8;
                transition : all 0.2s;
            }

            .carpeta .glyphicon {
                font-size : 60px;
            }

            .carpeta-href:hover, .carpeta-href:focus {
                text-decoration : none !important;
            }

            .carpeta p, .archivo p {
                margin : 0;
                color  : #363636;
            }

            .carpeta p {
                padding : 8px 0;
            }

            .icono-archivo {
                background   : #FAFAFA;
                padding      : 20px;
                top          : 0;
                margin-right : 5px;
                font-size    : 15px transition : all 0.5 s;
            }

            .archivo:hover .icono-archivo {
                color : white;
            }

            .icono-carpeta {
                width      : 100%;
                display    : block;
                padding    : 40px;
                background : #E2E2E2;
                color      : white;
                transition : all 0.5s;
            }

            .search-box input {
                border-top          : none;
                border-left         : none;
                border-right        : none;
                border-bottom-width : 2px;
                padding-left        : 0;
                padding-right       : 0;
                box-shadow          : none !important;
            }

            .name-search {
                display : none;
            }

            .footer {
                padding : 20px 0;
            }

            .footer p {
                margin : 0;
            }

            .footer .lang-list {
                text-align : right;
            }

            .footer .lang-list img {
                padding-left : 6px;

            }
            .footer .lang-list img.selected {
                opacity: 0.3;
            }

            .boton-abrir-externo {
                width         : 35px;
                height        : 35px;
                color         : #424242;
                background    : none;
                position      : absolute;
                border-radius : 50%;
                right         : 25px;
                top           : 10px;
                opacity       : 0.2;
            }

            .boton-abrir-externo .glyphicon {
                font-size : 14px;
                padding   : 8px 12px;
            }

            .boton-abrir-externo:hover {
                opacity    : 1;
                background : #363636;
                color      : white;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid main-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-box panel panel-default">
                            <div class="panel-body">
                                <input type="text" class="form-control input-lg input-busqueda"
                                       placeholder="<?php echo $langString[ 'buscar' ] ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row folder-view">
                    <div class="col-md-12">
                        <h4><?php echo $langString[ 'Carpetas' ] ?>: <span class="pull-right text-muted"><?php echo $url;?></span></h4>
                        <hr />
                    </div>
                    <?php foreach(scandir($url) as $carpeta){

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
                                        <span class="name-search">..</span>
                                        <a href="?url=<?php echo dirname(dirname($link));?>" class="carpeta-href">
                                            <div class="panel panel-default carpeta">
                                                <div class="panel-body text-center">
                                                    <div class="icono-carpeta" style="background: #BFBFBF">
                                                        <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                                    </div>
                                                    <p><?php echo $langString['subir'];?></p>
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
                            <span class="name-search"><?php echo strtoupper( $carpeta ); ?></span>
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
                        <h4><?php echo $langString['Archivos'];?>:</h4>
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
                            <span class="name-search"><?php echo strtoupper( $archivo ); ?></span>
                            <a href="<?php echo $link;?>" class="carpeta-href">
                                <div class="panel panel-default archivo">
                                    <div class="panel-body">
                                        <p>
                                            <span class="glyphicon glyphicon-file icono-archivo" aria-hidden="true"></span>
                                            <?php echo $archivo; ?>
                                        </p>
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
                        <div class="col-xs-6">
                            <p class="text-muted">htdocsMe! 0.3.1 - Hecho por <a href="http://github.com/andersonsalas">Anderson Salas</a></p>
                        </div>
                        <div class="col-xs-6 lang-list">
                            <?php
                            foreach ( $langAllow as $key => $_lang ) {
                                if ( $key != $lang )
                                    echo '<a href="?url=' . $_GET[ 'url' ] . '&lang=' . $key . '"><img src="' . $_lang . '"/></a>';
                                else
                                    echo '<img class="selected" src="' . $_lang . '"/>';
                             }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                var busqueda = '';
                $('.input-busqueda').keyup(function () {
                    busqueda = $('.input-busqueda').val();
                    if(busqueda != ''){

                        jQuery('.name-search').parent().hide();
                        var pesquisa = '.name-search:contains(\'' + busqueda.toUpperCase() + '\')';
                        jQuery('body').find( pesquisa ).parent().show();
                    } else {
                        jQuery('.name-search').parent().show();
                    }
                });
            });
        </script>
    </body>
</html>
