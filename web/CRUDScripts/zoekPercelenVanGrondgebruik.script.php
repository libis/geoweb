<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demMapController.php');
$demMapController = new demMapController();


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