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
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/map.css" media="screen" />
    <link rel="stylesheet" href="https://openlayers.org/en/v4.1.0/css/ol.css" type="text/css">
    
        <script type="text/javascript" src="./js/globalVars.js"></script>
        <script type="text/javascript" src="./js/jquery.js"></script>
        <script type="text/javascript" src="./js/jquery.slim.js"></script>
        <script type="text/javascript" src="./js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="./js/jquery.livequery.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" src="./js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="./js/demografie.js"></script>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.1.0/build/ol.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>        
        <script type="text/javascript" src="./js/mapEigenaars.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script language="javascript">
      $(document).ready(function(){
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        
       
    });

function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}


function eigenaars_beroep() {
     window.open("./thema/eigenaars_beroep.php","_self");
}
function eigenaars_beroepsgroepen() {
    window.open("./thema/eigenaars_beroepsgroepen.php","_self");
}
function eigenaars_woonplaats() {
    window.open("./thema/eigenaars_woonplaats.php","_self");
}
function eigenaars_statistieken() {
    window.open("./thema/eigenaars_statistieken.php","_self");
}
function eigenaars_beroep() {
     window.open("./thema/eigenaars_beroep.php","_self");
 }
     </script>

    </head>
    
<body class="Titel">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="4" align="center" valign="top">  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td width="20%" height="10" align="center" bgcolor="#3775BB"><span class="Titel"><img src="./../images/Aezel_logo_02_80x80.gif" width="80" height="81" alt=""/></span></td>
              <td width="20%" bgcolor="#3775BB"><strong style="font-size: 20px">Aezel projek</strong></td>
              <td width="40%" bgcolor="#3775BB" style="font-size: 42px">Thema Demografie</td>
              <td width="20%" align="center" bgcolor="#3775BB" style="font-size: 20px"><a href="Menu_kadaster_01.html">MENU</a></td>
            </tr>
          </tbody>
      </table></td>           
    </tr>
    <tr>
      <td colspan="4" align="center" valign="top"> 
      <table width="100%" border="1" cellspacing="0" cellpadding="0" BORDERCOLOR="#3775BB">
        <tbody>
          <tr>
            <td width="20%" align="center" bgcolor="#3775BB" style="font-size: 20px; color: #FFFFFF;"><a href="javascript:void(0)" onclick="eigenaars();">Eigenaars</a></td>
            <td width="20%" align="center" bgcolor="#3775BB" style="font-size: 20px; color: #FFFFFF;"><a href="javascript:void(0)" onclick="eigenaars_beroepsgroepen();">Beroepsgroepen</a></td>
            <td width="20%" align="center" bgcolor="#3775BB" style="font-size: 20px; color: #FFFFFF;"><a href="javascript:void(0)" onclick="eigenaars_beroep();">Beroepen</a></td>
            <td width="20%" align="center" bgcolor="#3775BB" style="font-size: 20px; color: #FFFFFF;"><a href="javascript:void(0)" onclick="eigenaars_woonplaats();">Woonplaatsen</a></td>
            <td width="20%" align="center" bgcolor="#3775BB" style="font-size: 20px; color: #FFFFFF;"><a href="javascript:void(0)" onclick="eigenaars_statistieken();">Statistieken</a></td>
          </tr>
        </tbody>
        </table>
          
          
          
      </td>
    </tr>
   </tbody>
</table>
    

    </body>
</html>    
