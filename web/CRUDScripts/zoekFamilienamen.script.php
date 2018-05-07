<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['naam'];
$voornaam = $_POST['selVnm'];
$naam = $_POST['selNm'];
$gemeente = $_POST['selGem'];
$artikelnummer = $_POST['selArt'];
$result="";

foreach ($lijstenController->getFamilenamenFilterEig($filter,$gemeente,$naam,$voornaam,$artikelnummer) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
