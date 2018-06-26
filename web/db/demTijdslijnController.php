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
    
   
   
}
?>