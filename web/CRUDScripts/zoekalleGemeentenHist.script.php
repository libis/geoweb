<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$demTijdslijnController = new demTijdslijnController();


$lg = $_POST['selLg'];
$result="";

foreach ($demTijdslijnController->getGemeentenHist($lg) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
