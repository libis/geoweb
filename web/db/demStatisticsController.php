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
   private $cookie_name;
   
   
   function __construct()
   {
        $pcontroller = new parameterController();
        $this->conn = $pcontroller->getConn();
   }
    function setOATView($mainlayer){
        $this->cookie_name = $mainlayer;
    }
   function getGemGrondbezit($kadastergemeente)
   {
          $oppgem = 0;
//        if (!isset($_SESSION[$kadastergemeente])) {
            $query = "select sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
            $query .= "where naam is not null and voornamen is not null ";
            
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
            $s = pg_query($this->conn, $query);
            while($row = pg_fetch_row($s))
            {
                //$_SESSION[$kadastergemeente] = $row[0];
                $oppgem = $row[0];
            }
            }
            pg_free_result($s);
//        }           
//       return $_SESSION[$kadastergemeente];
       return $oppgem;
    }
   
   function getAantalGrondbezit($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;    
        
        $gemOpp = $this->getGemGrondbezit($kadastergemeente);
       
        $query = "select aantal,naam || ' ' || voornamen from ( ";
        $query .= "select count(naam) as aantal,naam,voornamen from ".$this->cookie_name."   ";
        $query .= "where naam is not null and voornamen is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
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
   
   function getGrondbezit($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       

        $gemOpp = $this->getGemGrondbezit($kadastergemeente);
       
        $query = "select sum(sqm),naam || ' ' || voornamen from ( ";
        $query .= "select naam,voornamen,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
        $query .= "where naam is not null and voornamen is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by naam,voornamen,geom ";
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

   function getGrondbezitPerGem($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       

        $gemOpp = $this->getGemGrondbezit($kadastergemeente);
       
        $query = "select sum(sqm),kadastergemeente from ( 
    select kadastergemeente,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   
        where naam is not null and voornamen is not null ";       
        
        
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }

        $query .= "group by kadastergemeente,geom 
        order by kadastergemeente
        ) as opp 
	group by kadastergemeente
        order by sum(sqm),kadastergemeente";             
        
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
   
   function getGrondbezitBeroep($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),beroep  from ( ";
        $query .= "select beroep,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
        $query .= "where beroep is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by beroep,geom ";
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
      function getGrondbezitBeroepPerGem($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),beroep || ' - ' ||kadastergemeente from ( 
    select kadastergemeente,beroep,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   
        where naam is not null and voornamen is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by kadastergemeente,beroep,geom 
        order by kadastergemeente
        ) as opp 
	group by beroep,kadastergemeente
    order by sum(sqm),beroep,kadastergemeente";        

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
   
 function getGrondbezitBeroepsgroep($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),beroepsgroep  from ( ";
        $query .= "select beroepsgroep,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
        $query .= "where beroepsgroep is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by beroepsgroep,geom ";
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

function getGrondbezitBeroepsgroepPerGem($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       

        $query = "select sum(sqm),beroepsgroep || ' - ' ||kadastergemeente from ( 
        select kadastergemeente,beroepsgroep,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
        $query .= "where beroepsgroep is not null ";
        
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by kadastergemeente,beroepsgroep,geom 
        order by kadastergemeente
        ) as opp 
	group by beroepsgroep,kadastergemeente
        order by sum(sqm),beroepsgroep,kadastergemeente";   
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
   
 function getGrondbezitWoonplaats($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),woonplaats  from ( ";
        $query .= "select woonplaats,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
        $query .= "where woonplaats is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        $query .= "group by woonplaats,geom ";
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

function getGrondbezitWoonplaatsPerGem($kadastergemeente,$naam,$artikelnr,$beroepen,$woonplaatsen,$beroepsgroepen){
    
        $result = array();
        $index = 0;       
       
        $query = "select sum(sqm),woonplaats || ' - ' || kadastergemeente from ( ";
        $query .= "select  kadastergemeente,woonplaats,sum(ST_Area(ST_Transform(geom,'28992'))) As sqm from ".$this->cookie_name."   ";
        $query .= "where woonplaats is not null ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente =  '".$value."'";
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
                    $query .= " and (naam =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam =  '".$value."'";
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
                    $query .= " and (artnr =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }          if (count($woonplaatsen) > 0) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (woonplaats =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats =  '".$value."'";
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
                    $query .= " and (beroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep =  '".$value."'";
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
                    $query .= " and (beroepsgroep =  '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep =  '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        
        
        $query .= "group by kadastergemeente,woonplaats,geom 
        order by kadastergemeente
        ) as opp 
	group by woonplaats,kadastergemeente
        order by sum(sqm),woonplaats,kadastergemeente";  
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