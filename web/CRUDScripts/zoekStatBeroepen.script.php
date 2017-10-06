<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$artikelnummer = $_GET['artikelnummer'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getStatBeroepen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroepen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
