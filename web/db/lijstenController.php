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

    
    public function getVoornamenFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."' order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getVoornamenFilterByFamilenaam($filter,$familienaam)
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."' and naam = '".$familienaam."' order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getVoornamenFilterByArtikelnummer($filter,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."' and artnr = '".$artikelnummer."' order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    
    public function getVoornamenFilter($filter,$voornaam,$familienaam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam like '".$familienaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and lower(voornamen) like lower('%".$voornaam."%')" ;             
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getVoornamenBeroepFilter($filter,$voornaam,$familienaam,$artikelnummer,$beroep) {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and lower(voornamen) like lower('%".$voornaam."%')" ;             
        if (strncasecmp($beroep,"alle ",5) != 0) $query .=" and lower(beroep) like lower('%".$beroep."%')" ;             
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getVoornamenWoonplaatsFilter($filter,$voornaam,$familienaam,$artikelnummer,$woonplaats) {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and lower(voornamen) like lower('%".$voornaam."%')" ;             
        if (strncasecmp($woonplaats,"alle ",5) != 0) $query .=" and woonplaats = '".$woonplaats."'" ;             
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getVoornamenBeroepsgroepFilter($filter,$voornaam,$familienaam,$artikelnummer,$beroepsgroep) {
        $result = array();
        $index = 0;
        $query="select distinct voornamen from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and lower(voornamen) like lower('%".$voornaam."%')" ;             
        if (strncasecmp($beroepsgroep,"alle ",5) != 0) $query .=" and lower(beroepsgroep) like lower('%".$beroepsgroep."%')" ;             
        $query .= " order by voornamen";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
            
    
    public function getFamilienamen()
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat";
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    
    public function getFamilenamenFilter($filter,$familienaam,$voornaam,$artikelnummer)
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) like lower('%".$familienaam."%')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and lower(voornamen) like lower('%".$voornaam."%')" ;        
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getFamilenamenBeroepFilter($filter,$familienaam,$voornaam,$artikelnummer,$beroep) 
     {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) like lower('%".$familienaam."%')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen like '".$voornaam."'" ;        
        if (strncasecmp($beroep,"alle ",5) != 0) $query .=" and beroep like '".$beroep."'" ;        
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getFamilenamenWoonplaatsFilter($filter,$familienaam,$voornaam,$artikelnummer,$woonplaats) 
     {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) like lower('%".$familienaam."%')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen like '".$voornaam."'" ;        
        if (strncasecmp($woonplaats,"alle ",5) != 0) $query .=" and woonplaats like '".$woonplaats."'" ;        
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }   
    
    public function getFamilenamenBeroepsgroepFilter($filter,$familienaam,$voornaam,$artikelnummer,$beroepsgroep) 
     {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) like lower('%".$familienaam."%')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen like '".$voornaam."'" ;        
        if (strncasecmp($beroepsgroep,"alle ",5) != 0) $query .=" and beroepsgroep like '".$beroepsgroep."'" ;        
        $query .= " order by naam";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }   

    public function getFamilenamenFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct naam from aezelschema.oat where gemeente = '".$filter."'";
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

    
    public function getArtikelnummersFilter($filter,$artikelnummer,$familienaam,$voornaam)
    {
        $result = array();
        $index = 0;
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where gemeente = '".$filter."'";
        
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and lower(artnr) like lower('%".$artikelnummer."%')";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen ='".$voornaam."'";
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }   
    
        public function getArtikelnummersFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where gemeente = '".$filter."'";
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
    public function getArtikelnummersBeroepFilter($filter,$artikelnummer,$familienaam,$voornaam,$beroep)    
    {
        $result = array();
        $index = 0;
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where gemeente = '".$filter."'";
        
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and lower(artnr) = lower('%".$artikelnummer."%')";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen =('".$voornaam."')";
        if (strncasecmp($beroep,"alle ",5) != 0) $query .=" and lower(beroep) = ('".$beroep."')";
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    public function getArtikelnummersWoonplaatsFilter($filter,$artikelnummer,$familienaam,$voornaam,$woonplaats)    
    {
        $result = array();
        $index = 0;
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where gemeente = '".$filter."'";
        
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and lower(artnr) = lower('%".$artikelnummer."%')";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen =('".$voornaam."')";
        if (strncasecmp($woonplaats,"alle ",5) != 0) $query .=" and woonplaats = '".$woonplaats."'";
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    public function getArtikelnummersBeroepsgroepFilter($filter,$artikelnummer,$familienaam,$voornaam,$beroepsgroep)    
    {
        $result = array();
        $index = 0;
        $query="select distinct to_number(artnr,'9999') from aezelschema.oat where gemeente = '".$filter."'";
        
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and lower(artnr) = lower('%".$artikelnummer."%')";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'" ;
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen =('".$voornaam."')";
        if (strncasecmp($beroepsgroep,"alle ",5) != 0) $query .=" and lower(beroepsgroep) = ('".$beroepsgroep."')";
        $query .= " order by to_number(artnr,'9999')";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

        public function getArtikelnummersFilterByVoornaam($filter,$voornaam)
    {
        $result = array();
        $index = 0;
        $query="select distinct artnr naam from aezelschema.oat where gemeente = '".$filter."' and voornamen = '".$voornaam."'" ;
        $query .= " order by artnr";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }        
    public function getArtikelnummersFilterByFamiienaam($filter,$familienaam)
    {
        $result = array();
        $index = 0;
        $query="select distinct artnr naam from aezelschema.oat where gemeente = '".$filter."' and naam = '".$familienaam."'" ;
        $query .= " order by artnr";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }        
    
    public function getBeroepen($filter,$familienaam,$voornaam,$artikelnummer,$beroep)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($beroep,"alle ",5) != 0) $query .=" and lower(beroep) like lower('%".$beroep."%')" ;
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'";
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen = '".$voornaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;        
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    public function getWoonplaatsen($filter,$familienaam,$voornaam,$artikelnummer,$woonplaats)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($woonplaats,"alle ",5) != 0) $query .=" and lower(woonplaats) like lower('%".$woonplaats."%')" ;
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'";
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen = '".$voornaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;        
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getBeroepsgroepen($filter,$familienaam,$voornaam,$artikelnummer,$beroepsgroep)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($beroepsgroep,"alle ",5) != 0) $query .=" and lower(beroepsgroep) like lower('%".$beroepsgroep."%')" ;
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and naam = '".$familienaam."'";
        if (strncasecmp($voornaam,"alle ",5) != 0) $query .=" and voornamen = '".$voornaam."'";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;        
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
    public function getBeroepenStat($filter,$familienaam,$artikelnummer,$beroep,$woonplaatsen,$beroepsgroepen)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat where gemeente = '".$filter."' and lower(beroep) like lower('%".$beroep."%')" ;
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;        
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
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }    
    
        public function getBeroepenFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroep from aezelschema.oat where gemeente = '".$filter."'";
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getWoonplaatsenFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from aezelschema.oat where gemeente = '".$filter."'";
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getBeroepsgroepenFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from aezelschema.oat where gemeente = '".$filter."'";
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 

    public function getGrondgebruikFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct soort from aezelschema.oat where gemeente = '".$filter."'";
        $query .= " order by soort";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }     
    
    public function getToponiemenFilterByGemeente($filter)
    {
        $result = array();
        $index = 0;
        $query="select distinct toponiem from aezelschema.oat where gemeente = '".$filter."'";
        $query .= " order by toponiem";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    public function getStatBeroepen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroepen,$beroepsgroepen)
    {
        $result = array();
        $index = 0;
        $first = false;
        $query="select distinct beroep from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) like lower('%".$familienaam."%')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;

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
        $query .= " order by beroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    public function getWoonplaatsenStat($filter,$familienaam,$artikelnummer,$woonplaats,$beroepen,$beroepsgroepen)
    {
        $result = array();
        $index = 0;
        $query="select distinct woonplaats from aezelschema.oat where gemeente = '".$filter."' and lower(woonplaats) like lower('%".$woonplaats."%')" ;
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;    
         if (($beroepen != NULL) || (count($beroepen)) > 0) {
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
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    
    public function getStatWoonplaatsen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroepen,$beroepsgroepen)
    {
        $result = array();
        $index = 0;
        $first = false;
       $query="select distinct woonplaats from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;        
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
        $query .= " order by woonplaats";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }

    public function getBeroepsgroepenStat($filter,$familienaam,$artikelnummer,$beroepsgroep,$woonplaatsen,$beroepen)
    {
        $result = array();
        $index = 0;
        $query="select distinct beroepsgroep from aezelschema.oat where gemeente = '".$filter."' and lower(beroepsgroep) like lower('%".$beroepsgroep."%')" ;
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) = lower('".$familienaam."')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;        
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
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    } 
    
    public function getStatBeroepsgroepen($filter,$familienaam,$artikelnummer,$woonplaatsen,$beroepen,$beroepsgroepen)
    {
        $result = array();
        $index = 0;
        $first = false;
        $query="select distinct beroepsgroep from aezelschema.oat where gemeente = '".$filter."'";
        if (strncasecmp($familienaam,"alle ",5) != 0) $query .=" and lower(naam) like lower('%".$familienaam."%')";
        if (strncasecmp($artikelnummer,"alle ",5) != 0) $query .=" and artnr = '".$artikelnummer."'" ;

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
        $query .= " order by beroepsgroep";
        $s = pg_query($this->conn, $query);
        while($row = pg_fetch_row($s))
        {
            $result[$index++]= $row[0];
        }
        pg_free_result($s);
        return $result;
    }
    
    
 }
