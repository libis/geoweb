<?php

if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'/parameterController.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of statisticsController
 *
 * @author StephanP
 */
class demstatisticsController {
    
   private $pcontroller;
   private $conn;
   
   function __construct()
   {
        $pcontroller = new parameterController();
        $this->conn = $pcontroller->getConn();
   }
   
   function getAantalGrondbezit($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select aantal,naam || ' ' || voornamen from ( ";
        $query .= "select count(naam) as aantal,naam,voornamen from aezelschema.oat ";
        $query .= "where naam is not null and voornamen is not null ";
        $query .= " and gemeente = '".$gemeente."'";
        if ($naam != "Alle namen") { $query .= " and naam = '".$naam."'";  }
        if ($artikelnr != "Alle artikelnummers") { $query .= " and artnr = '".$artikelnr."'";  }
        if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($beroepen) > 0) {
            $first = true;
            foreach ($beroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }  
         if (count($beroepsgroepen) > 0) {
            $first = true;
            foreach ($beroepsgroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        $query .= "group by naam,voornamen ";
        $query .= "order by count(naam),naam desc ";
        $query .= ") as namen";

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $tssres[1]= $row[0];
            $tssres[2]= $row[1];
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }
   
   function getGrondbezit($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),naam || ' ' || voornamen from ( ";
        $query .= "select naam,voornamen,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat ";
        $query .= "inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel ";
        $query .= "where naam is not null and voornamen is not null ";
        $query .= " and oat.gemeente = '".$gemeente."'";
        if ($naam != "Alle namen") { $query .= " and naam = '".$naam."'";  }
        if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($beroepen) > 0) {
            $first = true;
            foreach ($beroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
                 if (count($beroepsgroepen) > 0) {
            $first = true;
            foreach ($beroepsgroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
       // if ($woonplaats != "Alle woonplaatsen") { $query .= " and woonplaats = '".$woonplaats."'";  }
        if ($artikelnr != "Alle artikelnummers") { $query .= " and artnr = '".$artikelnr."'";  }
        
        $query .= "group by naam,voornamen,minperceel.geom ";
        $query .= "order by naam,voornamen ";
        $query .= ") as opp ";
	$query .= "group by naam,voornamen ";
        $query .= "order by sum(sqm),naam,voornamen";        

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            
            
            $tssres[1]= $row[0];
            $tssres[2]= $row[1];
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }   
   
   function getGrondbezitBeroep($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),beroep  from ( ";
        $query .= "select beroep,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat ";
        $query .= "inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel ";
        $query .= "where beroep is not null ";
        $query .= " and oat.gemeente = '".$gemeente."'";
        if ($naam != "Alle namen") { $query .= " and naam = '".$naam."'";  }
        if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($beroepen) > 0) {
            $first = true;
            foreach ($beroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
                 if (count($beroepsgroepen) > 0) {
            $first = true;
            foreach ($beroepsgroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
       // if ($woonplaats != "Alle woonplaatsen") { $query .= " and woonplaats = '".$woonplaats."'";  }
        if ($artikelnr != "Alle artikelnummers") { $query .= " and artnr = '".$artikelnr."'";  }
        
        $query .= "group by beroep,minperceel.geom ";
        $query .= "order by beroep ";
        $query .= ") as opp ";
	$query .= "group by beroep ";
        $query .= "order by sum(sqm),beroep";        

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            
            
            $tssres[1]= $row[0];
            $tssres[2]= $row[1];
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }      
   
 function getGrondbezitBeroepsgroep($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),beroepsgroep  from ( ";
        $query .= "select beroepsgroep,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat ";
        $query .= "inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel ";
        $query .= "where beroepsgroep is not null ";
        $query .= " and oat.gemeente = '".$gemeente."'";
        if ($naam != "Alle namen") { $query .= " and naam = '".$naam."'";  }
        if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($beroepen) > 0) {
            $first = true;
            foreach ($beroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
                 if (count($beroepsgroepen) > 0) {
            $first = true;
            foreach ($beroepsgroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
       // if ($woonplaats != "Alle woonplaatsen") { $query .= " and woonplaats = '".$woonplaats."'";  }
        if ($artikelnr != "Alle artikelnummers") { $query .= " and artnr = '".$artikelnr."'";  }
        
        $query .= "group by beroepsgroep,minperceel.geom ";
        $query .= "order by beroepsgroep ";
        $query .= ") as opp ";
	$query .= "group by beroepsgroep ";
        $query .= "order by sum(sqm),beroepsgroep";        

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            
            
            $tssres[1]= $row[0];
            $tssres[2]= $row[1];
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }      

 function getGrondbezitWoonplaats($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),woonplaats  from ( ";
        $query .= "select woonplaats,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat ";
        $query .= "inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel ";
        $query .= "where woonplaats is not null ";
        $query .= " and oat.gemeente = '".$gemeente."'";
        if ($naam != "Alle namen") { $query .= " and naam = '".$naam."'";  }
        if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($beroepen) > 0) {
            $first = true;
            foreach ($beroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
                 if (count($beroepsgroepen) > 0) {
            $first = true;
            foreach ($beroepsgroepen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
       // if ($woonplaats != "Alle woonplaatsen") { $query .= " and woonplaats = '".$woonplaats."'";  }
        if ($artikelnr != "Alle artikelnummers") { $query .= " and artnr = '".$artikelnr."'";  }
        
        $query .= "group by woonplaats,minperceel.geom ";
        $query .= "order by woonplaats ";
        $query .= ") as opp ";
	$query .= "group by woonplaats ";
        $query .= "order by sum(sqm),woonplaats";        

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            
            
            $tssres[1]= $row[0];
            $tssres[2]= $row[1];
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }         
}
?>