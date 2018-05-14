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
    <div id="multilijst">
      <div class="control-form">
        <div>
          <label for="dem_gemeente" class="keuzelijstlabel">Gemeente:</label>
        <div class="button-group">
          <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="demZoekGemeentenZoekString();" maxlength="20"/>
          <button id="gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
          <ul id=gemeentebox class="dropdown-menu">
          </ul>
         </div>
        </div>
    </div>
    </div>
  </div>
  <div class="col-xs-12 col-md-3">
    <div id="multilijst">
      <div class="button-group">
        <input class="geotextbox naamTextBox" name="familienaambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamenStat();" maxlength="20"/>
        <button id="naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=familienaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummersStat();" maxlength="20"/>
        <button id="artikelnummer_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Artikelnummers<span class="caret"></span></button>
        <ul id=artikelnummerbox class="dropdown-menu">
        </ul>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-md-3">
    <div id="multilijst">      
      <div class="button-group">
        <input class="geotextbox woonplaatsTextBox" name="woonplaatsbox" placeholder="Zoek thuisgemeente" onkeyup="demZoekWoonplaatsenStat();" maxlength="20"/>
        <button id="woonplaats_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Thuisgemeenten<span class="caret"></span></button>
        <ul id=woonplaatsbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox beroepTextBox" name="beroepbox" placeholder="Zoek beroep" onkeyup="demZoekBeroepenStat();" maxlength="20"/>
        <button id="beroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepen<span class="caret"></span></button>
        <ul id=beroepbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox beroepsgroepTextBox" name="beroepsgroepbox" placeholder="Zoek beroepsgroep" onkeyup="demZoekBeroepsgroepenStat();" maxlength="20"/>
        <button id="beroepsgroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepsgroepen<span class="caret"></span></button>
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
         $('#familienaambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezitters(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezitters(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
      function drawChartBeroep() {
         setHeightChart(); 
         $('#familienaambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersBeroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezittersBeroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
      function drawChartBeroepsgroep() {
         setHeightChart(); 
         $('#familienaambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersBeroepsgroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezittersBeroepsgroep(gem,selNm,selArt,selBrp,selWpl,selBgp);
      }
      function drawChartWoonplaats() {
         setHeightChart(); 
         $('#familienaambox').slideUp();
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
var  selGem = [];
var firstOpenGem = true;
var firstOpenNm = true;
var firstOpenArt = true;
var firstOpenWpl = true;
var firstOpenBrp = true;
var firstOpenBgp = true;
    $(document).ready(function(){
      $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);


     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_reset").hide();
     
     demZoekGemeenten();
  });

function resetStatistieken()
{
    
    resetStat();
    
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
    
    $('#artikelnummerbox').empty();
    $('#gemeentebox').empty();
    $('#familienaambox').empty();
    $('#beroepbox').empty();
    $('#beroepsgroepbox').empty();
    $('#woonplaatsbox').empty();
    
    $('#infobox').empty();
    
    selGem.splice(0,selGem.length);
    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selBrp.splice(0,selBrp.length);
    selWpl.splice(0,selWpl.length);
    selBgp.splice(0,selBgp.length);
    
    setCookie('selArt',selArt);
    setCookie('selBrp',selBrp);
    setCookie('selBgp',selBgp);
    setCookie('selNm',selNm);
    setCookie('selWpl',selWpl);
    setCookie('selGem',selGem);

    $('.naamTextBox').attr("placeholder","Even geduld..");
    $('.artikelnummerTextBox').attr("placeholder","Even geduld..");
    $('.beroepTextBox').attr("placeholder","Even geduld..");
    $('.woonplaatsTextBox').attr("placeholder","Even geduld..");
    $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");

     demZoekGemeenten();
    

}

function resetStat(){
    $('#myPieChart').empty();
    $('#myBarChart').empty();
    $("#dem_eig_legend_chk").hide();
    $("#eig_legende_spam").hide();
    $("#dem_eig_legend_chk").prop('checked', false);
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
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

$(document).on('click','#gemeente_btn',function(event){
    $('#familienaambox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#beroepbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    $('#woonplaatsbox').slideUp();    
    
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});
$(document).on('click','.gemeenteTextBox',function(event){
    $('#gemeentebox').slideToggle();
    $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;
});

$(document).on('click','#naam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#beroepbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    $('#woonplaatsbox').slideUp();  
    if (firstOpenNm == false) {
        $('#familienaambox').slideToggle();
    }
});
$(document).on('click','.naamTextBox',function(event){
    $('#familienaambox').slideToggle();
    $(".naamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#artikelnummers_btn',function(event){
    $('#familienaambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#beroepbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    $('#woonplaatsbox').slideUp();     
    if (firstOpenArt == false) {
        $('#artikelnummerbox').slideToggle();
    }
});
$(document).on('click','.artTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    $(".artTextBox").val('').html();
    firstOpenArt = false;
});

$(document).on('click','#woonplaats_btn',function(event){
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#familienaambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();    
    if (firstOpenWpl == false) {
        $('#woonplaatsbox').slideToggle();
    }
});
$(document).on('click','.woonplaatsTextBox',function(event){
    $('#woonplaatsbox').slideToggle();
    $(".woonplaatsTextBox").val('').html();
    firstOpenWpl = false;
});

$(document).on('click','#beroep_btn',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#familienaambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();  
    if (firstOpenBrp == false) {
        $('#beroepbox').slideToggle();
    }
});
$(document).on('click','.beroepTextBox',function(event){
    $('#beroepbox').slideToggle();
    $(".beroepTextBox").val('').html();
    firstOpenBrp = false;
});

$(document).on('click','#beroepsgroep_btn',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    $('#familienaambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();      
    if (firstOpenBgp == false) {
        $('#beroepsgroepbox').slideToggle();
    }
});
$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#beroepsgroepbox').slideToggle();
    $(".beroepsgroepTextBox").val('').html();
    firstOpenBgp = false;
});

$(document).on('click','#gemeentebox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selGem.indexOf( href.trim()))  > -1 ) {
      selGem.splice( idx, 1 );
      setCookie('selGem',selGem);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      selGem.push(href.trim());
      setCookie('selGem',selGem);
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
    $('.familienaamTextBox').attr("placeholder","Even geduld..");
    $('.artTextBox').attr("placeholder","Even geduld..");
    $('.beroepTextBox').attr("placeholder","Even geduld..");
    $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");
    $('.woonplaatsTextBox').attr("placeholder","Even geduld..");

    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selBgp.splice(0,selBgp.length);
    selWpl.splice(0,selWpl.length);
    selBrp.splice(0,selBrp.length);
    setCookie('selArt',selArt);
    setCookie('selBgp',selBgp);
    setCookie('selNm',selNm);
    setCookie('selBrp',selBrp);
    setCookie('selWpl',selWpl);

   demZoekArtikelnummersByGemeente();
   demZoekFamilienamenByGemeente();
   demZoekBeroepsgroepenByGemeente();
   demZoekBeroepenByGemeente();
   demZoekWoonplaatsenByGemeente();
   $("#dem_toon_kaart").show();
   $("#dem_eig_reset").show();
   return false;
});


$(document).on('click','#woonplaatsbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selWpl.indexOf( href.trim()))  > -1 ) {
      selWpl.splice( idx, 1 );
      setCookie('selWpl',selWpl);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle woonplaatsen') {
          selWpl.splice(0,selWpl.length);
          setCookie('selWpl',selWpl);
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle woonplaatsen') {
           selWpl.splice(0,selWpl.length);
           setCookie('selWpl',selWpl);
           $( "#woonplaatsbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }
      selWpl.push(href.trim());
      setCookie('selWpl',selWpl);
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekFamilienamenStat();
   demZoekWoonplaatsenStat();
   demZoekBeroepenStat();
   return false;
});


$(document).on('click','.beroepTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();

    $(".beroepTextBox").val('').html();
    firstOpenBrp = false;    
});

$(document).on('click','#beroepbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBrp.indexOf( href.trim()))  > -1 ) {
      selBrp.splice( idx, 1 );
      setCookie('selBrp',selBrp);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepen') {
          selBrp.splice(0,selBrp.length);
          setCookie('selBrp',selBrp);
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepen') {
           selBrp.splice(0,selBrp.length);
           setCookie('selBrp',selBrp);
           $( "#beroepbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selBrp.push(href.trim());
      setCookie('selBrp',selBrp);

      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekFamilienamenStat();
   demZoekBeroepsgroepenStat();
   demZoekWoonplaatsenStat();
   return false;
});

$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepbox').slideUp();
    $('#woonplaatsbox').slideUp();

    $(".beroepsgroepTextBox").val('').html();
    firstOpenBgp = false;    
});

$(document).on('click','#beroepsgroepbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBgp.indexOf( href.trim()))  > -1 ) {
      selBgp.splice( idx, 1 );
      setCookie('selBgp',selBgp);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepsgroepen') {
          selBgp.splice(0,selBgp.length);
          setCookie('selBgp',selBgp);
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepspsgroepen') {
           selBgp.splice(0,selBgp.length);
           setCookie('selBgp',selBgp);
           $( "#beroepsgroepbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selBgp.push(href.trim());
      setCookie('selBgp',selBgp);

      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekFamilienamenStat();
   demZoekBeroepenStat();
   demZoekWoonplaatsenStat();
   return false;
});


$(document).on('click','.familienaamTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
	
    $(".familienaamTextBox").val('').html();
    firstOpenNm = false;    
});
$(document).on('click','#familienaambox a',function(event){
    selNm = getCookie('selNm');
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selNm.indexOf( href.trim()))  > -1 ) {
      selNm.splice( idx, 1 );
      setCookie('selNm',selNm);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle namen') {
            selNm.splice(0,selNm.length);
            setCookie('selNm',selNm);
         $( "#familienaambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle namen') {
            selNm.splice(0,selNm.length);
            setCookie('selNm',selNm);
         $( "#familienaambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      selNm.push(href.trim());
      setCookie('selNm',selNm);
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekWoonplaatsenStat();
   demZoekBeroepenStat();
   demZoekBeroepsgroepenStat();
   return false;
});

$(document).on('click','.artTextBox',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voorfamilienaambox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();

    $(".artTextBox").val('').html();
    firstOpenArt = false;    
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#familienaambox').slideUp();
    $('#voorfamilienaambox').slideUp();    
    $('#gemeentebox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selArt.indexOf( href.trim()))  > -1 ) {
      selArt.splice( idx, 1 );
      setCookie('selArt',selArt);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle artikelnummers') {
          selArt.splice(0,selArt.length);
          setCookie('selArt',selArt);
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle artikelnummers') {
         selArt.splice(0,selArt.length);
         setCookie('selArt',selArt);
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      selArt.push(href.trim());
      setCookie('selArt',selArt);

      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
    demZoekFamilienamenStat();
    demZoekBeroepenStat();
    demZoekBeroepsgroepenStat();
    demZoekWoonplaatsenStat();
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
        $('#familienaambox').html('');
        $('#familienaambox').html(poutput.join(''));
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
