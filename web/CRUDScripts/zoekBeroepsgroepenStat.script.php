<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$beroepsgroep = $_GET['beroepsgroep'];
$filter = $_GET['gemeente'];
//$familienaam = $_GET['familienaam'];
//$artikelnummer = $_GET['artikelnummer'];
$familienaam = $_POST['selNm'];
$artikelnummer = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$result="";

foreach ($lijstenController->getBeroepsgroepenStat($filter,$familienaam,$artikelnummer,$beroepsgroep,$woonplaatsen,$beroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
