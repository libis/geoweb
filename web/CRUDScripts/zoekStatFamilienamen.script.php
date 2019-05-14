<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();
$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$filter = $_GET['gemeente'];
$familienaam = $_POST['selNm'];
$artikelnummer = $_POST['selArt'];
$woonplaatsen = $_POST['selWpl'];
$beroepen = $_POST['selBrp'];
$beroepsgroepen = $_POST['selBgp'];
$result="";

foreach ($lijstenController->getStatFamilienamen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroepen,$beroepsgroepen) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
