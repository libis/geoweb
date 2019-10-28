<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['woonplaats'];
$familienaam = $_POST['selNm'];
$voornaam = $_POST['selVnm'];
$artikelnummer = $_POST['selArt'];
$beroep = $_POST['selBrp'];
$beroepsgroep = $_POST['selBgp'];
$woonplaats = $_POST['selWpl'];
$gemeente = $_GET['selGem'];
$vak = $_POST['selVak'];
$graf_van = $_POST['selGrf'];
$result="";

foreach ($lijstenController->getGrafVanFilter($filter,$gemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats,$vak,$graf_van) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
