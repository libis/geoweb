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
$gemeente = $_GET['selGem'];
$result="";

foreach ($lijstenController->getWoonplaatsen($filter,$gemeente,$familienaam,$voornaam,$artikelnummer) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
