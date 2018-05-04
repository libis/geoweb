<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$artikelnummer = $_GET['artikelnummer'];
$filter = $_GET['gemeente'];
$familienaam = $_POST['selNm'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getArtikelnummersStat($filter,$familienaam,$artikelnummer,$beroepsgroepen,$woonplaatsen,$beroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>


