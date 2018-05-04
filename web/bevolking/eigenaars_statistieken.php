<?php 
session_start();
include 'common/header.php'; ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<div class="container-fluid control-stats">
  <div class="row">
    <div class="col-xs-12 col-md-12">
      <div class="control-form">
        <h2>% Grondbezit </h2>
        <div>
          <button id ="dem_toon_kaart" onclick="drawChart();">
              per eigenaar
          </button>
          <button id ="dem_toon_stat_beroep" onclick="drawChartBeroep();">
              per beroep
          </button>
          <button id ="dem_toon_stat_beroepsgroep" onclick="drawChartBeroepsgroep();">
              per beroepsgroep
          </button>
          <button id ="dem_toon_stat_woonplaats" onclick="drawChartWoonplaats();">
              per woonplaats
          </button>
          <button id ="dem_eig_reset" onclick="resetStatistieken();">
              Reset
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-md-3">
      <div class="control-form">
        <div>
          <label for="dem_gemeente" class="keuzelijstlabel">Gemeente:</label>
          <div id="dem_demeente" class="wrapper">
              <select id=gemeentebox class="geoselect editableEigenaarBox">
                <?php
                    if(!defined('DS'))
                        define('DS', DIRECTORY_SEPARATOR);
                    require_once (dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
                    $thelijstenController=new lijstenController();
                    foreach($thelijstenController->getGemeenten() as $key => $value)
                    {
                        echo "<option value=\"".$key."\">".$value."</option>" ;
                    }
                ?>
              </select>
          </div>
        </div>
  
<!--          
      <div>
        <label for="dem_gemeente_familienaam">Naam:</label>
        <div id="dem_gemeente_familienaam" class="wrapper">
          <select id=familienaambox class="geoselect editableFamilienaamBox">
          </select>
        </div>
      </div>
      <div>
        <label for="dem_gemeente_artikelnummer">Artikelnummer:</label>
        <div id="dem_gemeente_artikelnummer" class="wrapper">
          <select id=artikelnummerbox class="geoselect editableArtikelnummerBox">
          </select>
        </div>
      </div>
-->
    </div>
  </div>
  <div class="col-xs-12 col-md-3">
    <div id="multilijst">
      <div class="button-group">
        <input class="geotextbox naamTextBox" name="naambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamenStat(selWpl,selBgp,gem,selNm,selArt,selBrp);" maxlength="20"/>
        <button id="eig_stat_naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=naambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummersStat(selWpl,selBgp,gem,selNm,selArt,selBrp);" maxlength="20"/>
        <button id="eig_stat_artikelnummer_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Artikelnummers<span class="caret"></span></button>
        <ul id=artikelnummerbox class="dropdown-menu">
        </ul>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-md-3">
    <div id="multilijst">      
      <div class="button-group">
        <input class="geotextbox woonplaatsTextBox" name="woonplaatsbox" placeholder="Zoek thuisgemeente" onkeyup="demZoekWoonplaatsenStat(selWpl,selBgp,gem,selNm,selArt,selBrp);" maxlength="20"/>
        <button id="eig_stat_woonplaats_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Thuisgemeenten<span class="caret"></span></button>
        <ul id=woonplaatsbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox beroepTextBox" name="beroepbox" placeholder="Zoek beroep" onkeyup="demZoekBeroepenStat(selBrp,selBgp,gem,selNm,selArt,selWpl);" maxlength="20"/>
        <button id="eig_stat_beroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepen<span class="caret"></span></button>
        <ul id=beroepbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox beroepsgroepTextBox" name="beroepsgroepbox" placeholder="Zoek beroepsgroep" onkeyup="demZoekBeroepsgroepenStat(selBrp,selWpl,gem,selNm,selArt,selBgp);" maxlength="20"/>
        <button id="eig_stat_beroepsgroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepsgroepen<span class="caret"></span></button>
        <ul id=beroepsgroepbox class="dropdown-menu">
        </ul>
      </div>
    </div>
  </div>
  </div>
</div>
<div>
 <table width="100%" border="1" cellspacing="0" cellpadding="0" BORDERCOLOR="#3775BB">
    <tbody>
      <tr>
        <td>
            <div id="myPieChart" style="border: 1px solid #ccc"/>
        </td>
        <td>
            <div id="myBarChart" style="border: 1px solid #ccc"/>
        </td>
      </tr>
    </tbody>
  </table>
</div>
  <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart']});
      google.charts.load('current', {packages:['bar']});

      //  google.charts.setOnLoadCallback(drawChart);
      
    function setHeightChart() {
        var menuHeight = $('.container-fluid.control-stats').height();
        var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
        var bodyHeight = $(window).height(); 
        var barHeight = bodyHeight-headerHeight-menuHeight-10;
        $("#myPieChart").height(barHeight);
        $("#myBarChart").height(barHeight);
    }
      function drawChart() {
         setHeightChart(); 
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezitters(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezitters(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
      function drawChartBeroep() {
         setHeightChart(); 
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersBeroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezittersBeroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
      function drawChartBeroepsgroep() {
         setHeightChart(); 
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersBeroepsgroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezittersBeroepsgroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
      function drawChartWoonplaats() {
         setHeightChart(); 
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersWoonplaats(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezittersWoonplaats(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
  </script>

  <script language="javascript">
var  selNm = [];
var  selArt = [];
var  selWpl = [];
var  selBrp = [];
var  selBgp = [];
var  selNmTmp = [];
var  selArtTmp = [];
var  selWplTmp = [];
var  selBrpTmp = [];
var  selBgpTmp = [];
var gem = "";
var art ="";
var nm="";
var vnm="Alle voornamen";
var firstOpenNm = true;
var firstOpenArt = true;
var firstOpenWpl = true;
var firstOpenBrp = true;
var firstOpenBgp = true;
    $(document).ready(function(){
      $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

      $("#dem_zoek_artikelnummer").hide();
      $("#dem_zoek_familenaam").hide();
      $("#dem_zoek_voornaam").hide();
      $("#dem_toon_kaart").hide();
      $("#dem_toon_stat_beroep").hide();
      $("#dem_toon_stat_beroepsgroep").hide();
      $("#dem_toon_stat_woonplaats").hide();
      //$("#dem_eig_reset").hide();
      $(".eigenaarTextBox").val('KIES GEMEENTE');


     $('#dem_demeente').on('select.editable-select', function (e) {
        if (2 != e.eventPhase) {
            resetStat();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            gem = $inp.context.value;
            if ($(".eigenaarTextBox").val() !== "Kies een term...") {
                 resetStatistieken();
                 $("#dem_toon_kaart").show();
      $("#dem_toon_stat_beroep").show();
      $("#dem_toon_stat_beroepsgroep").show();
      $("#dem_toon_stat_woonplaats").show();
                 $("#dem_eig_reset").show();
            }
        }
    });
  });

$('#dem_demeente').editableSelect({ effects: 'default' });
$('#dem_demeente').attr("placeholder","Kies een gemeente...");
$('#dem_gemeente_familienaam').editableSelect({ effects: 'default' });
$('#dem_gemeente_artikelnummer').editableSelect({ effects: 'default' });
$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
});

function resetStatistieken()
{
    resetStat();
    $('#dem_gemeente_familienaam').attr("placeholder","Even geduld...");
    $('#dem_gemeente_artikelnummer').attr("placeholder","Even geduld..");
    $('.naamTextBox').attr("placeholder","Even geduld..");
    $('.artikelnummerTextBox').attr("placeholder","Even geduld..");
    $('.beroepTextBox').attr("placeholder","Even geduld..");
    $('.woonplaatsTextBox').attr("placeholder","Even geduld..");
    $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");


    demZoekArtikelnummersByGemeenteStat(gem);
    demZoekFamilienamenByGemeenteStat(gem);
    demZoekBeroepenByGemeenteStat(gem);
    demZoekBeroepsgroepenByGemeenteStat(gem);
    demZoekWoonplaatsenByGemeenteStat(gem);

    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selBrp.splice(0,selBrp.length);
    selWpl.splice(0,selWpl.length);
    selBgp.splice(0,selBgp.length);
    selNmTmp.splice(0,selNm.length);
    selArtTmp.splice(0,selArt.length);
    selBrpTmp.splice(0,selBrp.length);
    selWplTmp.splice(0,selWpl.length);
    selBgpTmp.splice(0,selBgp.length);
    art = "Alle artikelnummers";
    nm = "Alle namen";
}

function resetStat(){
    $('#myPieChart').empty();
    $('#myBarChart').empty();
    $("#dem_eig_legend_chk").hide();
    $("#eig_legende_spam").hide();
    $("#dem_eig_legend_chk").prop('checked', false);
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
}


function decodeHtml(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

function eigenaars() {
  window.open("./eigenaars.php","_self");
}
function eigenaars_beroep() {
  window.open("./eigenaars_beroep.php","_self");
}
function eigenaars_woonplaats() {
  window.open("./eigenaars_woonplaats.php","_self");
}
function eigenaars_beroepsgroepen() {
  window.open("./eigenaars_beroepsgroepen.php","_self");
}

$(document).on('click','#eig_stat_naam_btn',function(event){
    $('#artikelnummerbox').slideUp();
    if (firstOpenNm == false) {
        $('#naambox').slideToggle();
    }
});
$(document).on('click','#eig_stat_artikelnummers_btn',function(event){
    $('#naambox').slideUp();
    if (firstOpenArt == false) {
        $('#artikelnummerbox').slideToggle();
    }
});
$(document).on('click','#eig_stat_woonplaats_btn',function(event){
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    if (firstOpenWpl == false) {
        $('#woonplaatsbox').slideToggle();
    }
});

$(document).on('click','#eig_stat_beroep_btn',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    if (firstOpenBrp == false) {
        $('#beroepbox').slideToggle();
    }
});

$(document).on('click','#eig_stat_beroepsgroep_btn',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    if (firstOpenBgp == false) {
        $('#beroepsgroepbox').slideToggle();
    }
});



$(document).on('click','.woonplaatsTextBox',function(event){
    if (lw=selWpl.length == 0)   {
        selWpl = selWplTmp;
    }
    selWplTmp.splice(0,selWplTmp.length);

    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideToggle();
    $(".woonplaatsTextBox").val('').html();
    firstOpenWpl = false;    
});

$(document).on('click','#woonplaatsbox a',function(event){

    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selWpl.indexOf( href.trim()))  > -1 ) {
      selWpl.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle woonplaatsen') {
         selWpl.splice(0,selWpl.length)
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle woonplaatsen') {
         selWpl.splice(0,selWpl.length)
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }
      if (val > 0) {
        if ($( "#woonplaatsbox a" ).first().find('input').prop('checked')==true) {
            $( "#woonplaatsbox a" ).first().find('input').prop('checked',false);
            selWpl.splice( "Alle woonplaatsen", 1 );
        }
      }
      selWpl.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatBeroepen(gem,selNm,selArt);
   demZoekStatBeroepsgroepen(gem,selNm,selArt);
   return false;
});


$(document).on('click','.beroepTextBox',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    if (lb=selBrp.length == 0) {
        selBrp = selBrpTmp;
    }
    selBrpTmp.splice(0,selBrpTmp.length);
    $('#beroepbox').slideToggle();
    $(".beroepTextBox").val('').html();
    firstOpenBrp = false;    
});

$(document).on('click','#beroepbox a',function(event){

    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBrp.indexOf( href.trim()))  > -1 ) {
      selBrp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepen') {
          selBrp.splice(0,selBrp.length)
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepen') {
         selBrp.splice(0,selBrp.length)
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      if (val > 0) {
        if ($( "#beroepbox a" ).first().find('input').prop('checked')==true) {
            $( "#beroepbox a" ).first().find('input').prop('checked',false);
            selBrp.splice( "Alle beroepen", 1 );
        }
      }

      selBrp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatWoonplaatsen(gem,selNm,selArt);
   demZoekStatBeroepsgroepen(gem,selNm,selArt);

   return false;
});

$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    if (lg=selBgp.length == 0){
        selBgp = selBgpTmp;
    }
    selBgpTmp.splice(0,selBgpTmp.length);
    $('#beroepsgroepbox').slideToggle();
    $(".beroepsgroepTextBox").val('').html();
    firstOpenBgp = false;    
});

$(document).on('click','#beroepsgroepbox a',function(event){

    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBgp.indexOf( href.trim()))  > -1 ) {
      selBgp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepsgroepen') {
          selBgp.splice(0,selBgp.length)
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepsgroepen') {
         selBgp.splice(0,selBgp.length)
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      if (val > 0) {
        if ($( "#beroepsgroepbox a" ).first().find('input').prop('checked')==true) {
            $( "#beroepsgroepbox a" ).first().find('input').prop('checked',false);
            selBgp.splice( "Alle beroepsgroepen", 1 );
        }
      }

      selBgp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatWoonplaatsen(gem,selNm,selArt);
   demZoekStatBeroepen(gem,selNm,selArt);

   return false;
});

$(document).on('click','.naamTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    if (ln=selNm.length == 0) {
        selNm = selNmTmp;
    }
    selNmTmp.splice(0,selNmTmp.length);
    $('#naambox').slideToggle();
    $(".naamTextBox").val('').html();
    firstOpenNm = false;    
});

$(document).on('click','#naambox a',function(event){

    $('#artikelnummerbox').slideUp();
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selNm.indexOf( href.trim()))  > -1 ) {
      selNm.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle namen') {
          selNm.splice(0,selNm.length)
         $( "#naambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle namen') {
         selNm.splice(0,selNm.length)
         $( "#naambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      if (val > 0) {
        if ($( "#naambox a" ).first().find('input').prop('checked')==true) {
            $( "#naambox a" ).first().find('input').prop('checked',false);
            selNm.splice( "Alle namen", 1 );
        }
      }

      selNm.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatArtikelnummers(gem,selNm,selArt);
   demZoekStatWoonplaatsen(gem,selNm,selArt);
   demZoekStatBeroepsgroepen(gem,selNm,selArt);
   demZoekStatBeroepen(gem,selNm,selArt);   

   return false;
});


$(document).on('click','.artikelnummerTextBox',function(event){
    $('#naambox').slideUp();
    if (la=selArt.length == 0) {
        selArt = selArtTmp;
    }
    selArtTmp.splice(0,selArtTmp.length);
    $('#artikelnummerbox').slideToggle();
    $(".artikelnummerTextBox").val('').html();
    firstOpenArt = false;    
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#naambox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selArt.indexOf( href.trim()))  > -1 ) {
      selArt.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle artikelnummers') {
          selArt.splice(0,selArt.length)
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle artikelnummers') {
         selArt.splice(0,selArt.length)
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      if (val > 0) {
        if ($( "#artikelnummerbox a" ).first().find('input').prop('checked')==true) {
            $( "#artikelnummerbox a" ).first().find('input').prop('checked',false);
            selArt.splice( "Alle artikelnummers", 1 );
        }
      }

      selArt.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatFamilienamen(gem,selNm,selArt);
   demZoekStatWoonplaatsen(gem,selNm,selArt);
   demZoekStatBeroepsgroepen(gem,selNm,selArt);
   demZoekStatBeroepen(gem,selNm,selArt);

   return false;
});

function demZoekStatWoonplaatsen(gem,nm,art){

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekStatWoonplaatsen.script.php";
    argumenten = '?gemeente='+gem;//+'&artikelnummer='+art+'&familienaam='+nm;
    var ln,la,lb,lw,lg;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selNm,selArt,selWpl,selBrp,selBgp}, function(data) {
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle woonplaatsen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            var targetToPush = '';
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle woonplaatsen</a></li>';
             while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1; ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" />&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';
                selWplTmp.push(keyvaluearray[1]);
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#woonplaatsbox').html('');
        $('#woonplaatsbox').html(poutput.join(''));
        //$(".woonplaatsTextBox").val(selectedValue).html();
        });
}
function demZoekStatArtikelnummers(gem,nm,art){

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekStatArtikelnummers.script.php";
    argumenten = '?gemeente='+gem;//+'&artikelnummer='+art+'&familienaam='+nm;
    var ln,la,lb,lw,lg;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selNm,selArt,selWpl,selBrp,selBgp}, function(data) {
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle artikelnummers";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            var targetToPush = '';
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle artikelnummers</a></li>';
             while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1; ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" />&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';
                selWplTmp.push(keyvaluearray[1]);
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#artikelnummerbox').html('');
        $('#artikelnummerbox').html(poutput.join(''));
        });
}


function demZoekStatFamilienamen(gem,nm,art){

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekStatFamilienamen.script.php";
    argumenten = '?gemeente='+gem;//+'&artikelnummer='+art+'&familienaam='+nm;
    var ln,la,lb,lw,lg;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selNm,selArt,selWpl,selBrp,selBgp}, function(data) {
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle namen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            var targetToPush = '';
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle namen</a></li>';
             while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1; ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" />&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';
                selWplTmp.push(keyvaluearray[1]);
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#naambox').html('');
        $('#naambox').html(poutput.join(''));
        });
}


function demZoekStatBeroepen(gem,nm,art){
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekStatBeroepen.script.php";
    argumenten = '?gemeente='+gem;//+'&artikelnummer='+art+'&familienaam='+nm;
    var lb,lw,lg,la,ln;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selNm,selArt,selWpl,selBrp,selBgp}, function(data) {
       if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
         if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle beroepen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            var targetToPush = '';
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle beroepen</a></li>';
             while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" />&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';
                selBrpTmp.push(keyvaluearray[1]);

                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#beroepbox').html('');
        $('#beroepbox').html(poutput.join(''));
        //$(".beroepTextBox").val(selectedValue).html();
        });
}


function demZoekStatBeroepsgroepen(gem,nm,art){
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekStatBeroepsgroepen.script.php";
    argumenten = '?gemeente='+gem;//+'&artikelnummer='+art+'&familienaam='+nm;
   var lb,lw,lg,la,ln;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selNm,selArt,selWpl,selBrp,selBgp}, function(data) {
       if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle beroepsgroepen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            var targetToPush = '';
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle beroepsgroepen</a></li>';
             while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';
                selBgpTmp.push(keyvaluearray[1]);
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#beroepsgroepbox').html('');
        $('#beroepsgroepbox').html(poutput.join(''));
        //$(".beroepTextBox").val(selectedValue).html();
        });
}

</script>

<?php include 'common/footer.php'; ?>
