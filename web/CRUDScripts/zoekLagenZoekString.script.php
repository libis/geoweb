<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$filter = $_GET['laag'];
$thema = $_GET['thema'];
$hoofdlaag = $_GET['hoofdlaag'];
$result="";

foreach ($lijstenController->getLagenGetString($filter,$thema,$hoofdlaag) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
