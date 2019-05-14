<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['woonplaats'];
$familienaam = $_POST['selNm'];
$artikelnummer = $_POST['selArt'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$gemeente = $_POST['selGem'];
$result="";

foreach ($lijstenController->getWoonplaatsenStat($filter,$gemeente,$familienaam,$artikelnummer,$beroepen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
