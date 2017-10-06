<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'..'.DS.'..'.DS.'ControleObjects'.DS.'displayPreferencesController.class.php');
include_once(dirname(__FILE__).DS.'..'.DS.'..'.DS.'..'.DS.'controllers'.DS.'labelcontroller.class.php');
$theLabelcontroller = labelController::getInstance();
$prefController = new displayPreferencesController();


$userid=$_GET['userid'];
$taalcode = $_GET['taalcode'];

$labels = $theLabelcontroller->getAllLabels($taalcode);

foreach ($prefController->getAEPreferences($userid) as $pref)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $pref."##".$labels[$pref];
}
echo $result;

?>
