<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['voornaam'];
$naam = $_POST['selNm'];
$voornaam = $_POST['selVnm'];
$gemeente = $_POST['selGem'];
$artikelnummer = $_POST['selArt'];
$result="";

foreach ($lijstenController->getVoornamenFilter($filter,$gemeente,$naam,$voornaam,$artikelnummer) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
