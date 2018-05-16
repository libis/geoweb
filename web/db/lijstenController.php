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
class lijstenController {
    
   private $pcontroller;
   private $conn;
   
   function __construct()
   {
        $pcontroller = new parameterController();
        $this->conn = $pcontroller->getConn();
   }

    public function getGemeenten()
    {
        $result = array();
        $index = 0;

        $query="select distinct gemeente from aezelschema.oat order by gemeente";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    public function getGemeentenFilter($filter)
    {
        $result = array();
        $index = 0;

        $query="select distinct gemeente from aezelschema.oat where lower(gemeente) like lower('%".$filter."%') order by gemeente";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getVoornamen()
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    
    public function getVoornamenFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat ";
        
       if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }         
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getVoornamenBeroepFilter($filter,$gemeente,$naam,$artikelnummer,$beroep) {
        $result = array();
        $index = 0;
        
        $query="select distinct voornamen from aezelschema.oat where lower(voornamen) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    

    public function getVoornamenWoonplaatsFilter($filter,$gemeente,$naam,$artikelnummer,$woonplaats) {
        $result = array();
        $index = 0;
        
        $query="select distinct voornamen from aezelschema.oat where lower(voornamen) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getVoornamenBeroepsgroepFilter($filter,$voornaam,$naam,$artikelnummer,$beroepsgroep) {
        $result = array();
        $index = 0;
        
        $query="select distinct voornamen from aezelschema.oat where lower(voornamen) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getFamilenamenFilterEig($filter,$gemeente,$voornaam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from aezelschema.oat where lower(naam) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
    public function getFamilenamenBeroepFilter($filter,$gemeente,$voornaam,$artikelnummer,$beroep) 
    {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from aezelschema.oat where lower(naam) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getFamilenamenWoonplaatsFilter($filter,$gemeente,$voornaam,$artikelnummer,$woonplaats) 
   {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from aezelschema.oat where lower(naam) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }  
    
    public function getFamilenamenBeroepsgroepFilter($filter,$gemeente,$voornaam,$artikelnummer,$beroepsgroep) 
    {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from aezelschema.oat where lower(naam) like lower('%".$filter."%')" ;
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
            foreach ($beroep as $value) {
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
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }  

    public function getFamilenamenFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat ";
       if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }           
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
        public function getFamilenamenFilterByVoornaam($filter,$voornaam)
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."' and voornamen = '".$voornaam."'";
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
        public function getFamilenamenFilterByArtikelnummer($filter,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."' and artnr = '".$artikelnummer."'";;
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
       public function getFamilienamenStat($filter,$gemeente,$artikelnummer,$beroep,$beroepsgroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from aezelschema.oat where lower(naam) like lower('%".$filter."%')" ;
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        if (count($beroepsgroep) > 0) {
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
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    

    
    public function getVoornamenFilter($filter,$gemeente,$naam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct voornamen from aezelschema.oat where lower(voornamen) like lower('%".$filter."%')";
     
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
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
        
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    

    public function getArtikelnummers()
    {
        $result = array();
        $index = 0;
        $query="select distinct artnr from aezelschema.oat";
        $query .= " order by artnr";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    
    public function getArtikelnummersFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat ";
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }  
        
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
    public function getArtikelnummersBeroepFilter($filter,$gemeente,$familienaam,$voornaam,$beroep)    
    {
        $result = array();
        $index = 0;
        
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where lower(artnr) like lower('%".$filter."%')" ;
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }

        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        
        if (count($beroep) > 0) {
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
        
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getArtikelnummersWoonplaatsFilter($filter,$gemeente,$familienaam,$voornaam,$woonplaats)    
    {
        $result = array();
        $index = 0;
        
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where lower(artnr) like lower('%".$filter."%')" ;
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }

        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        
        if (count($woonplaats) > 0) {
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
        
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getArtikelnummersBeroepsgroepFilter($filter,$gemeente,$familienaam,$voornaam,$beroepsgroep)    
    {
        $result = array();
        $index = 0;
        
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where lower(artnr) like lower('%".$filter."%')" ;
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }

        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        
        if (count($beroepsgroep) > 0) {
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
        
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getArtikelnummersFilterEig($filter,$gemeente,$familienaam,$voornaam)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where lower(artnr) like lower('%".$filter."%')" ;
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }

        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }


    
    public function getArtikelnummersStat($filter,$gemeente,$familienaam,$beroep,$beroepsgroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        
        
        
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where lower(artnr) like lower('%".$filter."%')" ;
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    

    
    
    public function getBeroepen($filter,$gemeente,$familienaam,$voornaam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat where lower(beroep) like lower('%".$filter."%')" ;
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
    public function getBeroepsgroepen($filter,$gemeente,$familienaam,$voornaam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat where lower(beroep) like lower('%".$filter."%')" ;
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }       
    
    public function getBeroepenStat($filter,$gemeente,$familienaam,$artikelnummer,$beroepsgroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat where lower(beroep) like lower('%".$filter."%')" ;
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        if (count($beroepsgroep) > 0) {
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
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
        public function getBeroepenFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat ";
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }         
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getWoonplaatsenFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from aezelschema.oat ";
        
                if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }  
        
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getBeroepsgroepenFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from aezelschema.oat ";
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }  
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 

    public function getGrondgebruikFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct soort from aezelschema.oat where gemeente = '".$filter."'";
      if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }        
        $query .= " order by soort";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }     
    
    public function getToponiemenFilterByGemeente($gemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct toponiem from aezelschema.oat ";

       if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
        }          
        $query .= " order by toponiem";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    public function getStatBeroepen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $first = false;
        $query="select distinct beroep from aezelschema.oat where gemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
         if (count($beroep) > 0) {
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
         if (count($beroepsgroep) > 0) {
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
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getWoonplaatsen($filter,$gemeente,$familienaam,$voornaam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from aezelschema.oat where lower(woonplaats) like lower('%".$filter."%')" ;

        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if (($familienaam != NULL) || (count($familienaam)) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        if (($artikelnummer != NULL) || (count($artikelnummer)) > 0) {
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
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getWoonplaatsenStat($filter,$gemeente,$familienaam,$artikelnummer,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from aezelschema.oat where lower(woonplaats) like lower('%".$filter."%')" ;

        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
         if (($familienaam != NULL) || (count($familienaam)) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        if (($artikelnummer != NULL) || (count($artikelnummer)) > 0) {
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
         if (count($beroepsgroep) > 0) {
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
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    
    public function getStatWoonplaatsen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $first = false;
       $query="select distinct woonplaats from aezelschema.oat where gemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        }          if (count($beroep) > 0) {
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
         if (count($beroepsgroep) > 0) {
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
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getBeroepsgroepenStat($filter,$gemeente,$familienaam,$artikelnummer,$beroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from aezelschema.oat where lower(beroepsgroep) like lower('%".$filter."%')" ;
        
        if (($gemeente != NULL) || (count($gemeente)) > 0) {
            $first = true;
            foreach ($gemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (gemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or gemeente = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
        if (count($beroep) > 0) {
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
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getStatBeroepsgroepen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $first = false;
        $query="select distinct beroepsgroep from aezelschema.oat where gemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
         if (count($beroep) > 0) {
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
         if (count($beroepsgroep) > 0) {
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
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getStatFamilienamen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $first = false;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
         if (count($beroep) > 0) {
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
         if (count($beroepsgroep) > 0) {
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
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
public function getStatArtikelnummers($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $first = false;
        $query="select distinct artnr from aezelschema.oat where gemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (count($familienaam) > 0) {
            $first = true;
            foreach ($familienaam as $value) {
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
         if (count($beroep) > 0) {
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
         if (count($beroepsgroep) > 0) {
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
        $query .= " order by artnr";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
        
    
 }
