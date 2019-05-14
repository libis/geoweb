<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);
$filter = $_GET['naam'];
$gemeente = $_POST['selGem'];
$artikelnummer = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getFamilienamenStat($filter,$gemeente,$artikelnummer,$beroepen,$beroepsgroepen,$woonplaatsen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>


