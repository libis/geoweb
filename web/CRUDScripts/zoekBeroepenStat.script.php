<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$beroep = $_GET['beroep'];
$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$artikelnummer = $_GET['artikelnummer'];
$woonplaatsen = $_POST['selWpl'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getBeroepenStat($filter,$familienaam,$artikelnummer,$beroep,$woonplaatsen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
