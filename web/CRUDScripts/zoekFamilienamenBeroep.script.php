<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$filter = $_GET['naam'];
$voornaam = $_POST['selVnm'];
$gemeente = $_POST['selGem'];
$beroep = $_POST['selBrp'];
$artikelnummer = $_POST['selArt'];
$result="";

foreach ($lijstenController->getFamilenamenBeroepFilter($filter,$gemeente,$voornaam,$artikelnummer,$beroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
