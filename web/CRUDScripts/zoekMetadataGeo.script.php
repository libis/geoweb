<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$demTijdslijnController = new demTijdslijnController();


$laag = $_POST['laag'];
$schema = $_POST['schema'];
$metadataId = $_GET['metadataId'];
$begindatum = $_GET['begindatum'];
$result="";

foreach ($demTijdslijnController->getMetadataGeo($schema,$laag,$metadataId,$begindatum) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
