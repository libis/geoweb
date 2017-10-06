<?php
//session_start();
$garbage_timeout = 3600; // in seconds, 3600seconds = 1hour
ini_set('session.gc_maxlifetime', $garbage_timeout);
ini_set('max_execution_time', 1800);
/*
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'db'.DS.'gemeentenController.class.php');
require_once (dirname(__FILE__).DS.'db'.DS.'parametercontroller.class.php');
$lijstenController = new lijstenController();
$lijstenController = new lijstenController();

$sid = session_id();
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>LGGI - Geografisch kaartenbestand</title>

        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/map.css" media="screen" />
        <link rel="stylesheet" href="https://openlayers.org/en/v4.1.0/css/ol.css" type="text/css">

        <!-- fonts -->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

        <script type="text/javascript" src="../js/globalVars.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.slim.js"></script>
        <script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="../js/jquery.livequery.js"></script>

        <script type="text/javascript" src="../js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="../js/demografie.js"></script>
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
        <script src="https://openlayers.org/en/v4.1.0/build/ol.js"></script>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
        
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>

    </head>

<body class="Titel">
  <header>
    <nav class="navbar navbar-toggleable-md navbar-default ">
        <div class="container-fluid">
          <a href="" class="navbar-brand"><img src='../img/earth_logo.png'>LGGI</a>
             <!-- Collect the nav links, forms, and other content for toggling -->
             <div class="navbar-collapse pull-xs-left navbar-toggleable-md collapse" id="navbarSupportedContent">
                 <ul class="nav navbar-nav">
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="landschap_grondgebruik();">Grondgebruik</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="landschap_toponiemen();">Toponiemen</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_beroep();">Beroepen</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                         <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_woonplaats();">Woonplaatsen</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                         <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_statistieken();">Statistieken</a>
                    </li>
                 </ul>
             </div>
       </div><!-- /.container-fluid -->
     </nav>
  </header>