<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['beroepsgroep'];
$artikelnummer = $_POST['selArt'];
$familienaam = $_POST['selNm'];
$gemeente = $_POST['selGem'];
$voornaam = $_POST['selVnm'];
$result="";

foreach ($lijstenController->getBeroepsgroepen($filter,$gemeente,$familienaam,$voornaam,$artikelnummer) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
