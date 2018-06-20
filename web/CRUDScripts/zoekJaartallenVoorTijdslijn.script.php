<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
$layer = $_POST['selLg'];
$result="";
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$tijdslijnController = new demTijdslijnController();

foreach ($tijdslijnController->getJaartallenVoorTijdslijn($layer) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;