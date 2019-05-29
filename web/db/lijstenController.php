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
   private $conn_geonode;
   private $cookie_name;
   
   function __construct()
   {
        $pcontroller = new parameterController();
        $this->conn = $pcontroller->getConn();
        $this->conn_geonode = $pcontroller->getConn_geonode();
   }
  
   function setOATView($mainlayer){
        $this->cookie_name = $mainlayer;
   }

public function    zoekExterneLinks() {
        $result = array();
        $index = 0;

        $query="select distinct entiteit,tabelnaam,url from public.externe_links  order by entiteit";
        
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$row[0]]=$row[1]."##".$row[2];
        }
        
        pg_free_result($s);
        return $result;    
}
    public function getGemeenten()
    {
        $result = array();
        $index = 0;

        $query="select distinct kadastergemeente from ".$this->cookie_name."   order by kadastergemeente";
        
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

        $query="select distinct kadastergemeente from ".$this->cookie_name."   where lower(kadastergemeente) like lower('%".$filter."%') order by kadastergemeente";
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
        $query="select distinct voornamen from ".$this->cookie_name."   order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    
    public function getVoornamenFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from ".$this->cookie_name."   ";
        
       if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
    
    
    public function getFamilenamenFilterEig($filter,$kadastergemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from ".$this->cookie_name."   where lower(naam) like lower('%".$filter."%')" ;
     
          if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }         
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($voornaam != NULL)  {
 
            $first = true;
            foreach ($voornaam as $value) {
                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
         if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
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
    

    public function getFamilenamenFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from ".$this->cookie_name."   ";
       if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
        $query="select distinct naam from ".$this->cookie_name."   where kadastergemeente = '".$filter."' and voornamen = '".$voornaam."'";
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
        $query="select distinct naam from ".$this->cookie_name."   where kadastergemeente = '".$filter."' and artikelnummer = '".$artikelnummer."'";;
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
       public function getFamilienamenStat($filter,$kadastergemeente,$artikelnummer,$beroep,$beroepsgroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct naam from ".$this->cookie_name."   where lower(naam) like lower('%".$filter."%')" ;
        if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
         if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
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

    
    public function getVoornamenFilter($filter,$kadastergemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct voornamen from ".$this->cookie_name."   where lower(voornamen) like lower('%".$filter."%')";
     
          if ($kadastergemeente != NULL)  {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }         
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($voornaam != NULL)  {
 
            $first = true;
            foreach ($voornaam as $value) {
                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
         if ($beroep != NULL)  {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($woonplaats != NULL) {
            $first = true;
            foreach ($woonplaats as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
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
        $query="select distinct artikelnummer from ".$this->cookie_name."  ";
        $query .= " order by artikelnummer";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    
    public function getArtikelnummersFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct artikelnummer from ".$this->cookie_name."   ";
        
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
                }
            }
        }  
        
        $query .= " order by artikelnummer";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    

    public function getArtikelnummersFilterEig($filter,$kadastergemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct artikelnummer from ".$this->cookie_name."   where lower(artikelnummer::text) like lower('%".$filter."%')" ;
        
         if ($kadastergemeente != NULL)  {
            $first = true;
            foreach ($kadastergemeente as $value) {
               if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }         
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($voornaam != NULL) {
 
            $first = true;
            foreach ($voornaam as $value) {
                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
         if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        $query .= " order by artikelnummer";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }


    
    public function getArtikelnummersStat($filter,$kadastergemeente,$familienaam,$beroep,$beroepsgroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        
        $query="select distinct artikelnummer from ".$this->cookie_name."   where lower(artikelnummer::text) like lower('%".$filter."%')" ;
        if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }           
        if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }         
        $query .= " order by artikelnummer";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    

    
    
    public function getBeroepen($filter,$kadastergemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from ".$this->cookie_name."   where lower(beroep) like lower('%".$filter."%')" ;
          if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }         
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($voornaam != NULL) {
 
            $first = true;
            foreach ($voornaam as $value) {
                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
         if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
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
    
    public function getBeroepsgroepen($filter,$kadastergemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from ".$this->cookie_name."   where lower(beroepsgroep) like lower('%".$filter."%')" ;
          if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }         
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($voornaam != NULL) {
 
            $first = true;
            foreach ($voornaam as $value) {
                if ($first == true){
                    $query .= " and (voornamen = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or voornamen = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
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
    
    public function getBeroepenStat($filter,$kadastergemeente,$familienaam,$artikelnummer,$beroepsgroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from ".$this->cookie_name."   where lower(beroep) like lower('%".$filter."%')" ;
        if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
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
    
        public function getBeroepenFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from ".$this->cookie_name."   ";
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
    
    public function getWoonplaatsenFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from ".$this->cookie_name."   ";
        
                if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
    
    public function getBeroepsgroepenFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from ".$this->cookie_name."   ";
        
        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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

    public function getGrondgebruikFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct soort from ".$this->cookie_name."   where kadastergemeente = '".$filter."'";
      if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
    
    public function getToponiemenFilterByGemeente($kadastergemeente)
    {
        $result = array();
        $index = 0;
        $query="select distinct toponiem from ".$this->cookie_name."   ";

       if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " where kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
        $query="select distinct beroep from ".$this->cookie_name."   where kadastergemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artikelnummer = '".$artikelnummer."'" ;
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
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
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

    public function getWoonplaatsen($filter,$kadastergemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from ".$this->cookie_name."   where lower(woonplaats) like lower('%".$filter."%')" ;

        if (($kadastergemeente != NULL) || (count($kadastergemeente)) > 0) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if (strncasecmp($value,"alle ",5) != 0) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
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
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if (($voornaam != NULL) || (count($voornaam) > 0)) {
 
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
         if (($beroepsgroep != NULL) || (count($beroepsgroep) > 0)) {
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
        if (($woonplaatsen != NULL) || (count($woonplaatsen) > 0)) {
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
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getWoonplaatsenStat($filter,$kadastergemeente,$familienaam,$artikelnummer,$beroep,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from ".$this->cookie_name."   where lower(woonplaats) like lower('%".$filter."%')" ;

        if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        } 
         if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
         if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }  
         if ($beroepsgroep != NULL) {
            $first = true;
            foreach ($beroepsgroep as $value) {
                if ($first == true){
                    $query .= " and (beroepsgroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroepsgroep = '".$value."'";
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
       $query="select distinct woonplaats from ".$this->cookie_name."   where kadastergemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artikelnummer = '".$artikelnummer."'" ;
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
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
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

    public function getBeroepsgroepenStat($filter,$kadastergemeente,$familienaam,$artikelnummer,$beroep,$woonplaatsen)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from ".$this->cookie_name."   where lower(beroepsgroep) like lower('%".$filter."%')" ;
        
        if ($kadastergemeente != NULL) {
            $first = true;
            foreach ($kadastergemeente as $value) {
                if ($first == true){
                    $query .= " and (kadastergemeente = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or kadastergemeente = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($familienaam != NULL) {
            $first = true;
            foreach ($familienaam as $value) {
                if ($first == true){
                    $query .= " and (naam = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or naam = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($artikelnummer != NULL) {
            $first = true;
            foreach ($artikelnummer as $value) {
                if ($first == true){
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($woonplaatsen != NULL) {
            $first = true;
            foreach ($woonplaatsen as $value) {
                if ($first == true){
                    $query .= " and (woonplaats = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or woonplaats = '".$value."'";
                }
            }
            if ($first == false){ $query .= ")"; }
        }        
        if ($beroep != NULL) {
            $first = true;
            foreach ($beroep as $value) {
                if ($first == true){
                    $query .= " and (beroep = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or beroep = '".$value."'";
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
        $query="select distinct beroepsgroep from ".$this->cookie_name."   where kadastergemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artikelnummer = '".$artikelnummer."'" ;
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
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
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
        $query="select distinct naam from ".$this->cookie_name."   where kadastergemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artikelnummer = '".$artikelnummer."'" ;
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
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
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
        $query="select distinct artikelnummer from ".$this->cookie_name."   where kadastergemeente = '".$filter."'";
//        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
//        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artikelnummer = '".$artikelnummer."'" ;
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
                    $query .= " and (artikelnummer = '".$value."'"; 
                    $first = false;
                } else {
                    $query .= " or artikelnummer = '".$value."'";
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
        $query .= " order by artikelnummer";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
        
    
    public function zoekMenu($thema){
     
        $result = array();
        $index = 0;
        
        $query="select menutabs.naam
            from themas.thema_menutabs 
            inner join themas.thema on thema.thema_id = thema_menutabs.thema_id
            inner join themas.menutabs on menutabs.menutab_id = thema_menutabs.menutab_id
            where lower(thema.naam) = lower('".$thema."')
            order by thema_menutabs.rangorde";
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++] = $row[0];
        }
        pg_free_result($s);
        return $result;        
    }

    public function zoekCriteria($thema,$menu){
     
        $result = array();
        $index = 0;
        
        $query="select zoekcriteria.tabelnaam,menu_zoekcriteria.inhoud
            from themas.menutabs 
            inner join themas.menu_zoekcriteria on menu_zoekcriteria.menutab_id = menutabs.menutab_id
            inner join themas.thema_menutabs on thema_menutabs.menutab_id = menutabs.menutab_id
            inner join themas.zoekcriteria on zoekcriteria.criterium_id = menu_zoekcriteria.criterium_id
            inner join themas.thema on thema.thema_id = thema_menutabs.thema_id
            where lower(thema.naam) = lower('".$thema."')
            and lower(menutabs.naam) = lower('".$menu."')
            order by menu_zoekcriteria.rangorde";
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++] = $row[0]."##".$row[1];
        }
        pg_free_result($s);
        return $result;        
    }    
    
    
    public function getLagen($filter,$menu)
    {
        $result = array();
        $index = 0;

        $query="select lagen.invoernaam,lagen.omgeving,stijlen.naam,menu_lagen.actief 
from themas.lagen 
inner join themas.menu_lagen on menu_lagen.laag_id = lagen.laag_id
inner join themas.stijlen on stijlen.stijl_id = menu_lagen.stijl_id
inner join themas.menutabs on menutabs.menutab_id = menu_lagen.menutab_id
inner join themas.thema_menutabs on thema_menutabs.menutab_id = menutabs.menutab_id
inner join themas.thema on thema.thema_id = thema_menutabs.thema_id
where lower(thema.naam) = lower('".$filter."') and lower(menutabs.naam) = lower('".$menu."')
order by menu_lagen.rangorde";
        
        
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++] = $row[0]."##".$row[1]."##".$row[2]."##".$row[3];
        }
        pg_free_result($s);
        return $result;
    }   
    
    public function getLagenGetString($filter,$thema,$menu,$hoofdlaag){
        
        $result = array();
        $index = 0;

        $query="select lagen.invoernaam,lagen.omgeving,stijlen.naam,menu_lagen.actief 
from themas.lagen 
inner join themas.menu_lagen on menu_lagen.laag_id = lagen.laag_id
inner join themas.stijlen on stijlen.stijl_id = menu_lagen.stijl_id
inner join themas.menutabs on menutabs.menutab_id = menu_lagen.menutab_id
inner join themas.thema_menutabs on thema_menutabs.menutab_id = menutabs.menutab_id
inner join themas.thema on thema.thema_id = thema_menutabs.thema_id
where lower(thema.naam) = lower('".$thema."') and lower(menutabs.naam) = lower('".$menu."')
    and lower(lagen.invoernaam) like lower('%".$filter."%')
                        and lagen.invoernaam != '".$hoofdlaag."'
order by menu_lagen.rangorde";
        
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++] = $row[0]."##".$row[1]."##".$row[2];
        }
        pg_free_result($s);
        return $result;
    }   
    
    public function getTiles($filter)
    {
        $result = array();
        $index = 0;

        $query="select tiles.naam,tiles.invoernaam from themas.tiles inner join themas.thema_tiles on tiles.tile_id = themas.tiles.tile_id
                inner JOIN themas.thema on thema_tiles.thema_id = thema.thema_id
                where themas.thema.naam = lower('".$filter."')
                order by thema_tiles.rangorde";
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++] = $row[0]."##".$row[1];
        }
        pg_free_result($s);
        return $result;
    }    
    
    public function getTilesGetString($filter,$thema)
    {
        $result = array();
        $index = 0;

        $query="select tiles.naam,tiles.invoernaam from themas.tiles inner join themas.thema_tiles on tiles.tile_id = themas.tiles.tile_id
                inner JOIN themas.thema on thema_tiles.thema_id = thema.thema_id
                where lower(themas.thema.naam) = lower('".$thema."')
                    and lower(tiles.naam) like lower('%".$filter."%')
                order by thema_tiles.rangorde";
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++] = $row[0]."##".$row[1];
        }
        pg_free_result($s);
        return $result;
    } 

    public function isTijdAanwezig($omgeving,$laag){
        if ($omgeving === 'aezel') $schema = 'public';
        else $schema = 'themas';
        $query = "select einddatum from ".$schema.".".$laag." limit 1";
        $result = false;
        $s = pg_query($this->conn_geonode, $query);
            while($row = pg_fetch_row($s))
            {
                if ($row[0] == null) {
                    $result = false;
                } else {
                    $result = true;
                }
            }
        return $result;
    }

    
 
    public function checkStijlen($filter)
    {
        $result = array();
        $index = 0;

        
        $query="select stijlen.stijl_id,stijlen.naam,stijlen.sld from themas.stijlen 
		inner join themas.thema_lagen on thema_lagen.stijl_id = stijlen.stijl_id
                inner JOIN themas.thema on thema_lagen.thema_id = thema.thema_id
                where themas.thema.naam = lower('".$filter."')
                and stijlen.in_geoserver = false";
        
        $s = pg_query($this->conn_geonode, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$row[0]]= $row[1];
            
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
            curl_setopt($ch, CURLOPT_URL, "http://libis-p-aezel-3.lnx.icts.kuleuven.be:8080/geoserver/rest/styles"); 
            curl_setopt($ch, CURLOPT_HTTPAUTH,CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD,"admin:geoserver");    
            curl_setopt($ch, CURLOPT_POST,1 );
            $data .= "<style><name>".$row[1]."</name><filename>".$row[1].".sld</filename></style>";
            $data = preg_replace('/\s+/','',$data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);             
            $output = curl_exec($ch); 

            if (!(curl_errno($ch))) {
                $filename = $row[1];
                $filename .= ".sld";
                $filename = preg_replace('/\s+/','',$filename);

                $file = fopen($filename,"w");
                $xml = trim($row[2]);
                fwrite($file, $xml);     
                fclose($file);

                $stijl = "http://libis-p-aezel-3.lnx.icts.kuleuven.be:8080/geoserver/rest/styles/";
                $stijl .= $row[1];
                $stijl = preg_replace('/\s+/','',$stijl);

                $headers = array(
                   "Content-type: application/vnd.ogc.sld+xml",
                   "Connection: close",
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$stijl);

                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                curl_setopt($ch, CURLOPT_PUT, true);
                $myfile = fopen($filename,"r");
                curl_setopt($ch, CURLOPT_INFILE, $myfile);
                curl_setopt($ch, CURLOPT_INFILESIZE, strlen($xml));  
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $data = curl_exec($ch);
                if(curl_errno($ch))
                   $err = curl_error($ch);
                else{
                   unlink($filename);
                   $response_info = curl_getinfo($ch);
                   //print_r($response_info);
                   curl_close($ch);
                   $updquery="update themas.stijlen set in_geoserver = true where stijl_id = ".$row[0];
                   $supd = pg_query($this->conn_geonode, $updquery);
                }
    /*     
    $cmd = "curl -u admin:geoserver -XPUT -H \"Content-type: application/vnd.ogc.sld+xml\" -d \"@".$filename."\" ".$stijl;
     $result = shell_exec ( $cmd );
    */
            }
            pg_free_result($s);
        }      
        return $result;
    }
    
 }

 