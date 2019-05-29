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
<!--
        <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/map.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery.timeliny.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.min.css" rel="stylesheet">

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <script type="text/javascript" src="../js/globalVars.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.slim.js"></script>
        <script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="../js/jquery.livequery.js"></script>
<script type="text/javascript" src="../js/jquery.timeliny.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/tijdslijn.js"></script>


        <script type="text/javascript" src="../js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="../js/demografie.js"></script>
        <script type="text/javascript" src="../js/mapEigenaars.js"></script>
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/4.3.3/ol-debug.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
        -->
        <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/map.css" media="screen" />

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/4.3.3/ol-debug.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
        
<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapEigenaars.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>
<script type="text/javascript" src="../js/tijdslijn.js"></script>
<script type="text/javascript" src="../js/mapTijdslijn.js"></script>
<script type="text/javascript" src="../js/jquery.timeliny.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/palette.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery.timeliny.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">




    </head>

<body class="Titel" oncontextmenu="return false;">
  <header>
    <nav class="navbar navbar-toggleable-md navbar-default ">
        <div class="container">
          <a href="" class="navbar-brand"><img src='../img/earth_logo.png'>Aezel<span>Geografisch</span></a>
             <button class="navbar-toggler pull-xs-right navbar-text hidden-lg-up navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              &#9776;
             </button>
             <!-- Collect the nav links, forms, and other content for toggling -->
             <div class="navbar-collapse pull-xs-left navbar-toggleable-md collapse" id="navbarSupportedContent">
                 <ul class="nav navbar-nav">
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="eigenaars();">Eigenaars</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_beroepsgroepen();">Beroepsgroepen</a>
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
<div id="eig_popup" style="display:none;z-index:1000;position:absolute;color:black;padding:10px;border:solid 2px #ddd;background:beige;text-align:center;">
                               <select id="eig_popup_list" name="eig_popup_list" size="2" onchange=geo_link(this); onfocus="$(this).css({'background-color': 'white'});">
                            </select>
</div>
<div id="eig_wait_popup" style="display:none;z-index:1001;position:absolute;color:black;padding:10px;border:solid 4px #3775BB;background:yellow;text-align:center;top:0.5%;left:80%;">
    <h style="font-weight:bold">Een ogenblik aub...</h>
</div>
<script>
openTijdslijn = false;
thema = getQueryVariable("thema");
omgeving = 'aezel';
hoofdlaag = null;
legendLayer = null;
keyValueLayerList = null;
keyValueTilesList = null;
geoKeyValueList = null;
geoWmsPerceel = null;

selTg = [];
selLg = [];
selTpn =[];
selGem = [];
selNm = [];
selVnm = [];
selArt = [];
selBgp = [];
selBrp = [];
selWpl = [];

 

function eigenaars() {
    if (thema.indexOf('_',5) > -1) {thema = thema.substring(0,thema.indexOf('_',5));}   
    //window.open("./eigenaars.php?thema="+thema,"_self");
    window.open("./geoheader.php?thema="+thema+'&menu=eigenaars',"_self");
}
function eigenaars_beroepsgroepen() {
    if (thema.indexOf('_',5) > -1) {thema = thema.substring(0,thema.indexOf('_',5));}   
//    window.open("./eigenaars_beroepsgroepen.php?thema="+thema+"_beroepsgroepen","_self");
    window.open("./geoheader.php?thema="+thema+'&menu=beroepsgroepen',"_self");
}
function eigenaars_beroep() {
    if (thema.indexOf('_',5) > -1) {thema = thema.substring(0,thema.indexOf('_',5));}   
//    window.open("./eigenaars_beroep.php?thema="+thema+"_beroep","_self");
    window.open("./geoheader.php?thema="+thema+'&menu=beroepen',"_self");
}
function eigenaars_statistieken() {
    if (thema.indexOf('_',5) > -1) {thema = thema.substring(0,thema.indexOf('_',5));}   
    window.open("./eigenaars_statistieken.php?thema="+thema+"&laag="+hoofdlaag[1].trim(),"_self");
}
function eigenaars_woonplaats() {
    if (thema.indexOf('_',5) > -1) {thema = thema.substring(0,thema.indexOf('_',5));}   
//    window.open("./eigenaars_woonplaats.php?thema="+thema+"_woonplaatsen","_self");
    window.open("./geoheader.php?thema="+thema+'&menu=woonplaatsen',"_self");
}

function hideTimeItems() {
    $("#dem_toon_tijdlijn").hide();
    $('#dem_tijdslijn').hide();
    $('#dem_player').hide();
    $('#tijdslijn_vanaf').hide();
    $('#tijdslijn_TotMet').hide();
    $('#dp_vanaf').hide();
    $('#dp_tot').hide();
    $('#hist_reset_vanaf').hide();
    $('#hist_reset_totMet').hide();
    $('#dem_film_pause').hide();
    
      selGem = [];
    
}

$(function() {
    van = $( "#dp_vanaf" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    }).on( "change", function() {
        tijdslijnVanaf( this.value );
    });
    tot = $( "#dp_tot" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    }).on( "change", function() {
        tijdslijnTot( this.value );
    });
    function getDate( element ) {
        var date;
        var dateFormat = "yymmdd";
        try {
          date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
          date = null;
        }
        return date;
    }
});

function hideLagenbox() {
   if (firstOpenLg == false) {
        $("#lagenbox").css('display','none');
    } else {
        $('#eig_lagen_btn').attr('aria-expanded','false');
    }
   if (firstOpenTg == false) {
        $("#tilesbox").css('display','none');
    } else {
        $('#eig_tiles_btn').attr('aria-expanded','false');
    }    
}
  
</script>