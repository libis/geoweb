<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$filter = $_GET['voornaam'];
$naam = $_POST['selNm'];
$gemeente = $_POST['selGem'];
$artikelnummer = $_POST['selArt'];
$beroep = $_POST['selBrp'];
$result="";

foreach ($lijstenController->getVoornamenBeroepFilter($filter,$gemeente,$naam,$artikelnummer,$beroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
