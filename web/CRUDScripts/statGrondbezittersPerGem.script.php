<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demStatisticsController.php');
$statController = new demStatisticsController();

$laag = $_POST['hoofdlaag'];
$statController->setOATView($laag[1]);

$gemeente = $_POST['selGem'];
$naam = $_POST['selNm'];
$artikelnr = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];

$result="";

foreach ($statController->getGrondbezitPerGem($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value[1]."##".$value[2]."##".$value[3];
}
echo $result;

?>
