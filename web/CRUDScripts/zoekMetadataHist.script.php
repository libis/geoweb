<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$demTijdslijnController = new demTijdslijnController();


$layer = $_POST['selLg'];
$metadataId = $_GET['metadataId'];
$begindatum = $_GET['begindatum'];
$result="";

foreach ($demTijdslijnController->getMetadataHist($layer,$metadataId,$begindatum) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
