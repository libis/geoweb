<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demMapController.php');
$demMapController = new demMapController();
$laag = $_POST['hoofdlaag'];
$demMapController->setOATView($laag[1]);

$gemeente = $_GET['gemeente'];
$grondgebruik = $_GET['grondgebruik'];
$result="";

foreach ($demMapController->getGrondgebruik($gemeente,$grondgebruik) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>