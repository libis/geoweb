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

function getVolgendeDatum($layer,$datum,$scheme) 
{
        $query = "select min(begindatum) from ".$scheme.".".$layer." where begindatum > '".$datum."'";
        $s = pg_query($this->conn, $query);
        $row = pg_fetch_row($s);
        return $row[0];
}
function getVolgendeDatumPercelen($layer,$datum,$scheme) 
{
        $query = "select min(to_date(substr(to_char(begindatum::integer,'999999999'),1,9),'YYYYMMDD')) from ".$scheme.".".$layer." where begindatum > '".$datum."'";
        $s = pg_query($this->conn, $query);
        $row = pg_fetch_row($s);
        return $row[0];
}
function getVorigeDatum($layer,$datum,$scheme) 
{
        $query = "select max(begindatum) from ".$scheme.".".$layer." where begindatum < '".$datum."'";
        $s = pg_query($this->conn, $query);
        $row = pg_fetch_row($s);
        return $row[0];
}
function getVorigeDatumPercelen($layer,$datum,$scheme) 
{
        $query = "select max(to_date(substr(to_char(begindatum::integer,'999999999'),1,9),'YYYYMMDD')) from ".$scheme.".".$layer." where begindatum < '".$datum."'";
        $s = pg_query($this->conn, $query);
        $row = pg_fetch_row($s);
        return $row[0];
}
   
function getJaartallenVoorTijdslijn($scheme,$theme)
{
    $result = array();
    $index = 0;
        $query = "select min(to_char(to_date(\"begindatum\",'YYYY-MM-DD'),'YYYY')) from ".$scheme.".".$theme."";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        $query = "select max(to_char(to_date(\"einddatum\",'YYYY-MM-DD'),'YYYY')) from ".$scheme.".".$theme."";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
    return $result;
}   
    
/*
function getJaartallenVoorTijdslijnPercelen($scheme,$theme,$selGem)
{
    $result = array();
    $index = 0;
        //$query = "select min(\"begindatum\") from ".$scheme.".".$theme."";
        $query= "select min(to_char(to_date(substr(to_char(begindatum::integer,'999999999'),1,9),'YYYYMMDD'),'YYYY')) from ".$scheme.".".$theme."";
        $query .= " where ";

            $first = true;
            foreach ($selGem as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    
                    $query .= " (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
                }
                }
            }
            $query .= ")";

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $begindatum = $row[0];
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        $query= "select max(to_char(to_date(substr(to_char(einddatum::integer,'999999999'),1,9),'YYYYMMDD'),'YYYY')) from ".$scheme.".".$theme."";
        $query .= " where ";

            $first = true;
            foreach ($selGem as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
                }
                }
            }
            $query .= ")";

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $eindatum = $row[0];
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
    return $result;
}   
    
*/
function getJaartallenVoorTijdslijnPercelen($scheme,$theme,$selCrit0)
{
    $result = array();
    $index = 0;
        //$query = "select min(\"begindatum\") from ".$scheme.".".$theme."";
        $query= "select min(to_char(to_date(substr(to_char(begindatum::integer,'999999999'),1,9),'YYYYMMDD'),'YYYY')) from ".$scheme.".".$theme."";
            $first = true;
            if (sizeof($selCrit0[1]) > 0){
                $query .= " where ";
                
            foreach ($selCrit0[1] as $value) {
                if ($first == true){
                    
                    $query .= " (".$selCrit0[0]." =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or ".$selCrit0[0]." =  '".$value."'";
                }
            }
            $query .= ")";
            }

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $begindatum = $row[0];
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        $query= "select max(to_char(to_date(substr(to_char(einddatum::integer,'999999999'),1,9),'YYYYMMDD'),'YYYY')) from ".$scheme.".".$theme."";
            $first = true;
            if (sizeof($selCrit0[1]) > 0){
                $query .= " where ";
                
            foreach ($selGem as $value) {
                if ($first == true){
                    
                    $query .= " (".selCrit0[0]." =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or ".selCrit0[0]." =  '".$value."'";
                }
            }
            $query .= ")";
            }

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $eindatum = $row[0];
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
    return $result;
}   

function getLegendItems($layer)
{
    $result = array();
    $index = 0;
    if (count($layer) > 0) 
    {    
        $theme = $layer[0];
        $query = "select distinct \"Heerser\" from themas.".$theme."";
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
        $query="select distinct \"NAAM\" from themas.".$theme." order by \"NAAM\"";
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
        $query="select distinct \"NAAM\" from themas.".$theme." where lower(\"NAAM\") like lower('%".$filter."%') order by \"NAAM\"";
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
        $query="select distinct \"Heerser\",\"NAAM\",\"begindatum\",\"einddatum\" from themas.".$theme." where lower(\"NAAM\") = lower('".$filter."') and begindatum <= '".$begindatum."' and einddatum > '".$begindatum."' order by \"NAAM\"";
 
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0].'##'.$row[1].'##'.$row[2].'##'.$row[3];
        }
        pg_free_result($s);
        return $result;
    }    
}

public function getMetadataGeo($schema,$laag,$filter,$begindatum){
        $result = array();
        $index = 0;

        
        
        $query="select distinct \"kadastergemeente\",\"artikelnummer\",\"voornamen\",\"naam\",\"woonplaats\",\"beroep\",\"tekst\",\"toponiem\" from ".$schema.".".$laag." where \"artikelnummer\" = '".$filter."' and begindatum <= '".$begindatum."' and einddatum > '".$begindatum."' order by \"artikelnummer\"";
 
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0].'##'.$row[1].'##'.$row[2].'##'.$row[3].'##'.$row[4].'##'.$row[5].'##'.$row[6].'##'.$row[7];
        }
        pg_free_result($s);
        return $result;
}
}
?>