<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['gemeente'];
//$familienaam = $_GET['familienaam'];
//$artikelnummer = $_GET['artikelnummer'];
$familienaam = $_POST['selNm'];
$artikelnummer = $_POST['selArt'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$woonplaatsen = $_POST['selWpl'];
$result="";

foreach ($lijstenController->getStatWoonplaatsen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroepen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>