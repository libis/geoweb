

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
 * Description of lijstenController
 *
 * @author StephanP
 */
class demMapController {
    
   private $pcontroller;
   private $conn;
   
   function __construct()
   {
        $pcontroller = new parameterController();
        $this->conn = $pcontroller->getConn();
   }
   
   function getEigenaars($gemeente,$naam,$voornaam,$artikelnummer){
    
        $result = array();
        $index = 0;       
       
        $query = "select objkoppel from aezelschema.oat";

        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        } 
        
        if (count($artikelnummer) > 0) {
            $first = true;
            foreach ($artikelnummer as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (artnr = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($voornaam) > 0) {
            $first = true;
            foreach ($voornaam as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }        
        
        
        
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;       
   }
   
   function getBeroepEigenaars($gemeente,$naam,$voornaam,$artikelnummer,$beroep){
     
        $result = array();
        $index = 0;       
       
        $query = "select objkoppel from aezelschema.oat";

        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        } 
        
        if (count($artikelnummer) > 0) {
            $first = true;
            foreach ($artikelnummer as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (artnr = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($voornaam) > 0) {
            $first = true;
            foreach ($voornaam as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if (($beroep != NULL) || (count($beroep)) > 0) {
            $first = true;
            foreach ($beroep as $value) {
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
        
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;       
   }
   function getBeroepsgroepEigenaars($gemeente,$naam,$voornaam,$artikelnummer,$beroepsgroep){
      
        $result = array();
        $index = 0;       
       
        $query = "select objkoppel from aezelschema.oat";

        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        } 
        
        if (count($artikelnummer) > 0) {
            $first = true;
            foreach ($artikelnummer as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (artnr = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($voornaam) > 0) {
            $first = true;
            foreach ($voornaam as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if (($beroepsgroep != NULL) || (count($beroepsgroep)) > 0) {
            $first = true;
            foreach ($beroepsgroep as $value) {
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
        
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;       
   }
   
   
   function getWoonplaatsEigenaars($gemeente,$naam,$voornaam,$artikelnummer,$woonplaats){
        $result = array();
        $index = 0;       
       
        $query = "select objkoppel from aezelschema.oat";

        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        } 
        
        if (count($artikelnummer) > 0) {
            $first = true;
            foreach ($artikelnummer as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (artnr = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artnr = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($voornaam) > 0) {
            $first = true;
            foreach ($voornaam as $value) {
            if (strncasecmp($value,"alle ",5) != 0) {

                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if (($woonplaats != NULL) || (count($woonplaats)) > 0) {
            $first = true;
            foreach ($woonplaats as $value) {
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
        
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;       
   }
   

      function getToponiemen($gemeente,$toponiemen){
    
        $result = array();
        $index = 0;       
       
        $query = "select distinct objkoppel from aezelschema.oat";
        $query .= " where gemeente = '".$gemeente."'";
        if ($naam != "Alle toponiemen") { $query .= " and toponiem = '".$toponiemen."'";  }

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;    
   }
   
      function getGrondgebruik($gemeente,$grondgebruik){
    
        $result = array();
        $index = 0;       
       
        $query = "select distinct objkoppel from aezelschema.oat";
        $query .= " where gemeente = '".$gemeente."'";
        if ($naam != "Alle grondgebruik") { $query .= " and soort = '".$grondgebruik."'";  }

        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;    
      }
}