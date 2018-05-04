<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['artikelnummer'];
$familienaam = $_POST['selNm'];
$gemeente = $_POST['selGem'];
$voornaam = $_POST['selVnm'];
$result="";

foreach ($lijstenController->getArtikelnummersFilterEig($filter,$gemeente,$familienaam,$voornaam) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
