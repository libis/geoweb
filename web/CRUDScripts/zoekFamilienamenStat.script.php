<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$naam = $_GET['naam'];
$gemeente = $_GET['gemeente'];
$artikelnummer = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getFamilienamenStat($gemeente,$naam,$artikelnummer,$beroepsgroepen,$woonplaatsen,$beroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>


