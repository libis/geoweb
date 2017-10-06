<?php
session_start();
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
    <link rel="stylesheet" type="text/css" href="./css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="./css/layout.css" media="screen" />
    
    <title><?php echo $labellist["geavanceerd_zoeken"]; ?></title>
    <?php include 'js2include.inc.php';  ?>
    
    <script language="javascript">
      $(document).ready(function(){
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
 
     });
      
 
 


     </script>

    </head>
    
    <body class="jquery">
        <div id="wrapper">
            <div id="logo">
                <?php include './logoBody.php'; ?>
            </div>
            <div id="main">
                <table><tbody><tr>
                      <td><table width="900" border="0" cellspacing="5">
                        <tbody>
                            <tr>
                                <td><div class="imgWrap"><a href="bevolking/demografie.php"><img src="../images/eigenaar_bezit.png" width="125" alt="Eigenaar en zijn bezit"><p class="imgDescription">Demografie</p></a></div></td>
                                <td><div class="imgWrap"><a href="./thema/landschap.php"><img src="../images/eigenaar_beroep.png" width="125" alt="Eigenaar en zijn beroep"><p class="imgDescription">Landschap</p></a></div></td>
                                <td><div class="imgWrap"><a href="./thema/statistiek.php"><img src="../images/eigenaar_beroepsgroep.png" width="125" alt="Eigenaar en zijn beroepsgroep"><p class="imgDescription">Statistiek</p></a></div></td>
                            </tr>
                            <tr>
                                <td><div class="imgWrap"><a href="./thema/tijdlijn.php"><img src="../images/eigenaar_woonplaats.png" width="125" alt="Eigenaar en zijn woonplaats"><p class="imgDescription">Tijdlijn</p></a></div></td>
                                <td><div class="imgWrap"><a href="./thema/historie.php"><img src="../images/eigenaar_gemeente.png" width="125" alt="Eigenaar en zijn gemeente"><p class="imgDescription">Historie</p></a></div></td>
                                <td><div class="imgWrap"><a href="./thema/aezelstatus.php"><img src="../images/eigenaar_beroep.png" width="125" alt="?????"><p class="imgDescription">Aezel status</p></a></div></td>
                           </tr>
                        </tbody>
                    </table></td>
                </tr></tbody></table>
            </div>
    </body>
</html>    
