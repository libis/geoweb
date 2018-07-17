<?php
session_start();
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'/parameterController.php');

/**
 * Description of statisticsController
 *
 * @author StephanP
 */
class demTijdslijnController {
    
   private $pcontroller;
   private $conn;
   
   function __construct()
   {
        $pcontroller = new parameterController();
        $this->conn = $pcontroller->getConn_geonode();
   }

function getVolgendeDatum($layer,$datum) 
{
    if (count($layer) > 0) 
    {    
        $theme = $layer[0];
        $query = "select min(begindatum) from public.".$theme." where begindatum > '".$datum."'";
        $s = pg_query($this->conn, $query);
        $row = pg_fetch_row($s);
        return $row[0];
    }
}
function getVorigeDatum($layer,$datum) 
{
    if (count($layer) > 0) 
    {    
        $theme = $layer[0];
        $query = "select max(begindatum) from public.".$theme." where begindatum < '".$datum."'";
        $s = pg_query($this->conn, $query);
        $row = pg_fetch_row($s);
        return $row[0];
    }
}
   
function getJaartallenVoorTijdslijn($layer)
{
    $result = array();
    $index = 0;
    if (count($layer) > 0) 
    {    
        $theme = $layer[0];
        $query = "select min(to_char(to_date(\"begindatum\",'YYYY-MM-DD'),'YYYY')) from public.".$theme."";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        $query = "select max(to_char(to_date(\"einddatum\",'YYYY-MM-DD'),'YYYY')) from public.".$theme."";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
    }
    return $result;
}   
    
    
function getLegendItems($layer)
{
    $result = array();
    $index = 0;
    if (count($layer) > 0) 
    {    
        $theme = $layer[0];
        $query = "select distinct \"Heerser\" from public.".$theme."";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }            
    }
    return $result;
}   
    
public function getGemeentenHist($layer)
{
        $result = array();
        $index = 0;

    if (count($layer) > 0) 
    {
        $theme = $layer[0];
        $query="select distinct \"NAAM\" from public.".$theme." order by \"NAAM\"";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
    }
    pg_free_result($s);
    return $result;
}    

public function getGemeentenHistFilter($filter,$layer)
{
        $result = array();
        $index = 0;

    if (count($layer) > 0) 
    {
        $theme = $layer[0];
        $query="select distinct \"NAAM\" from public.".$theme." where lower(\"NAAM\") like lower('%".$filter."%') order by \"NAAM\"";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
}

public function getMetadataHist($layer,$filter,$begindatum){
        $result = array();
        $index = 0;

    if (count($layer) > 0) 
    {
        $theme = $layer[0];
        $query="select distinct \"Heerser\",\"NAAM\",\"begindatum\",\"einddatum\" from public.".$theme." where lower(\"NAAM\") = lower('".$filter."') and begindatum <= '".$begindatum."' and einddatum > '".$begindatum."' order by \"NAAM\"";
 
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0].'##'.$row[1].'##'.$row[2].'##'.$row[3];
        }
        pg_free_result($s);
        return $result;
    }    
}
}
?>