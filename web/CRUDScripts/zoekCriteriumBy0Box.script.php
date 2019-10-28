<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);

$selOBox = $_POST['sel0Box'];
$criterium = $_GET['criterium'];
$result="";

foreach ($lijstenController->getCriteriumFilterBy0Box($selOBox,$criterium) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
