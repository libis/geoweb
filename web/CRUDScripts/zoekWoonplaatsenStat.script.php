<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$artikelnummer = $_GET['artikelnummer'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$woonplaats = $_GET['woonplaats'];
$result="";

foreach ($lijstenController->getWoonplaatsenStat($filter,$familienaam,$artikelnummer,$woonplaats,$beroepen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
