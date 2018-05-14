<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['beroep'];
$gemeente = $_POST['selGem'];
$familienaam = $_POST['selNm'];
$artikelnummer = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getBeroepenStat($filter,$gemeente,$familienaam,$artikelnummer,$beroepsgroepen,$woonplaatsen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
