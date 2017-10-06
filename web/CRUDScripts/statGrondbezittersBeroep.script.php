<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demStatisticsController.php');
$statController = new demStatisticsController();


$gemeente = $_GET['gemeente'];
$naam = $_GET['naam'];
$artikelnr = $_GET['artikelnr'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];

$result="";

foreach ($statController->getGrondbezitBeroep($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value[1]."##".$value[2];
}
echo $result;

?>