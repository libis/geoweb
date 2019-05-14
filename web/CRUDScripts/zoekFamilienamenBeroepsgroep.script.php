<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['naam'];
$voornaam = $_POST['selVnm'];
$gemeente = $_POST['selGem'];
$beroepsgroep = $_POST['selBgp'];
$artikelnummer = $_POST['selArt'];
$result="";

foreach ($lijstenController->getFamilenamenBeroepsgroepFilter($filter,$gemeente,$voornaam,$artikelnummer,$beroepsgroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
