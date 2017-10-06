<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'db'.DS.'parametercontroller.class.php');
?>

/**
 * Description of demografie
 *
 * @author StephanP
 */
class demografie {
    private $db;
    private $login ;
    private $paswd;

    function __construct()
    {
        $pcontroller = new parameterController();

    }

    function getBronnen($orgid, $taalcode)
    {
        $result="";
        $conn = oci_connect($this->login, $this->paswd, $this->db, 'AL32UTF8');
        $query="SELECT t1.BRONNEN
            FROM HERC_ORG_CONC t1
            INNER JOIN HERC_TALEN t2 ON t1.TALEN_ID=t2.ID
            WHERE t1.ORG_ID=".$orgid." AND t2.CODE='".$taalcode."'";
        $s = oci_parse($conn, $query);
        oci_execute($s, OCI_DEFAULT);
        while ( OCIFetch($s))
        {
            $lob = OCIResult($s,1);
            if(!empty($lob))
            {
                $result = $lob->load();
            }
        }
        oci_free_statement($s);
        return $result;
    }    //put your code here
}
