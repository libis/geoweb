<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
$layer = $_POST['laag'];
$scheme = $_POST['schema'];
$result="";
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$tijdslijnController = new demTijdslijnController();

if ($scheme === 'public'){
    foreach ($tijdslijnController->getJaartallenVoorTijdslijnPercelen($scheme,$layer) as $key => $value)
    {
        if($result!="")
        {
            $result .= "%%";
        }
        $result .= $key."##".$value;
    }

} else {
    foreach ($tijdslijnController->getJaartallenVoorTijdslijn($scheme,$layer) as $key => $value)
    {
        if($result!="")
        {
            $result .= "%%";
        }
        $result .= $key."##".$value;
    }

}
echo $result;
?>