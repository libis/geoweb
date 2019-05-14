<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);
$gemeente = $_POST['selGem'];
$filter = $_GET['beroepsgroep'];
$familienaam = $_POST['selNm'];
$artikelnummer = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$result="";

foreach ($lijstenController->getBeroepsgroepenStat($filter,$gemeente,$familienaam,$artikelnummer,$beroepen,$woonplaatsen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
