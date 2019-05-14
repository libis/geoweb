<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['voornaam'];
$naam = $_POST['selNm'];
$gemeente = $_POST['selGem'];
$artikelnummer = $_POST['selArt'];
$woonplaats = $_POST['selWpl'];
$result="";

foreach ($lijstenController->getVoornamenWoonplaatsFilter($filter,$gemeente,$naam,$artikelnummer,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
