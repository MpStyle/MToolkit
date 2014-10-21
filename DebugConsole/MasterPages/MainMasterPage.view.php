<?php
namespace MToolkit\DebugConsole;

use MToolkit\DebugConsole\Languages\Languages;

/* @var $this MainMasterPage */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title></title>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="Index.php"><?php echo Languages::getString( "mtoolkit" ) ?></a>
                    </div>

                    <ul class="nav navbar-nav">
                        <li><a href="Log.php"><span class="glyphicon glyphicon-th-list"></span> <?php echo Languages::getString( "menu_item_log" ) ?></a></li>
                        <li><a href="QuickStart.php"><span class="glyphicon glyphicon-road"></span> <?php echo Languages::getString( "menu_item_quick_start" ) ?></a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Languages::getCurrentLanguage() ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach( Languages::getAvailableLanguages() as $key => $language ): ?>
                                    <li><a href="?language=<?php echo $language ?>"><?php echo $language ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div id="Content">

            </div>
        </div>
    </body>
</html>