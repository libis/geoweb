<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$filter = $_GET['naam'];
$voornaam = $_POST['selVnm'];
$gemeente = $_POST['selGem'];
$woonplaats = $_POST['selWpl'];
$artikelnummer = $_POST['selArt'];
$result="";

foreach ($lijstenController->getFamilenamenWoonplaatsFilter($filter,$gemeente,$voornaam,$artikelnummer,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
