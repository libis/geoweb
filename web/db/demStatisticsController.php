<?php
session_start();
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
   
   function getGemGrondbezit($gemeente)
   {
          $oppgem = 0;
//        if (!isset($_SESSION[$gemeente])) {
            $query = "select sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat ";
            $query .= "inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel ";
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
            $s = pg_query($this->conn, $query);
            while($row = pg_fetch_row($s))
            {
                //$_SESSION[$gemeente] = $row[0];
                $oppgem = $row[0];
            }
            }
            pg_free_result($s);
//        }           
//       return $_SESSION[$gemeente];
       return $oppgem;
    }
   
   function getAantalGrondbezit($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;    
        
        $gemOpp = $this->getGemGrondbezit($gemeente);
       
        $query = "select aantal,naam || ' ' || voornamen from ( ";
        $query .= "select count(naam) as aantal,naam,voornamen from aezelschema.oat ";
        $query .= "where naam is not null and voornamen is not null ";
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
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
            $tssres[3]= $gemOpp;
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }
   
   function getGrondbezit($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       

        $gemOpp = $this->getGemGrondbezit($gemeente);
       
        $query = "select sum(sqm),naam || ' ' || voornamen from ( ";
        $query .= "select naam,voornamen,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat ";
        $query .= "inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel ";
        $query .= "where naam is not null and voornamen is not null ";
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
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
            $tssres[3]= $gemOpp;
            $result[$index++]= $tssres;
        }
        pg_free_result($s);
        return $result;       
   }   

   function getGrondbezitPerGem($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       

        $gemOpp = $this->getGemGrondbezit($gemeente);
       
        $query = "select sum(sqm),gemeente from ( 
    select oat.gemeente,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat 
        inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel
        where naam is not null and voornamen is not null ";       
        
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }

        $query .= "group by oat.gemeente,minperceel.geom 
        order by gemeente
        ) as opp 
	group by gemeente
        order by sum(sqm),gemeente";             
        
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            
            
            $tssres[1]= $row[0];
            $tssres[2]= $row[1];
            $tssres[3]= $gemOpp;
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
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
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
      function getGrondbezitBeroepPerGem($gemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),beroep || ' - ' ||gemeente from ( 
    select oat.gemeente,oat.beroep,sum(ST_Area(ST_Transform(minperceel.geom,'28992'))) As sqm from aezelschema.oat 
        inner join aezelschema.minperceel on oat.objkoppel = minperceel.objkoppel
        where naam is not null and voornamen is not null ";
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by oat.gemeente,oat.beroep,minperceel.geom 
        order by gemeente
        ) as opp 
	group by beroep,gemeente
    order by sum(sqm),beroep,gemeente";        

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
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
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
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.gemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.gemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
        if (count($naam) > 0) {
            $first = true;
            foreach ($naam as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.naam =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($artikelnr) > 0) {
            $first = true;
            foreach ($artikelnr as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (oat.woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.woonplaats =  '".$value."'";
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
                    $query .= " and (oat.beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroep =  '".$value."'";
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
                    $query .= " and (oat.beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or oat.beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
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