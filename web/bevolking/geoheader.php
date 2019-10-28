<?php
//session_start();
$garbage_timeout = 3600; // in seconds, 3600seconds = 1hour
ini_set('session.gc_maxlifetime', $garbage_timeout);
ini_set('max_execution_time', 1800);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>LGGI - Geografisch kaartenbestand</title>

        <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/map.css" media="screen" />

        <!-- fonts -->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

        <script type="text/javascript" src="../js/globalVars.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.slim.js"></script>
        <script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="../js/jquery.livequery.js"></script>

        <script type="text/javascript" src="../js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="../js/demografie.js"></script>
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/4.3.3/ol-debug.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
        
<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapEigenaars.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>
<script type="text/javascript" src="../js/tijdslijn.js"></script>
<script type="text/javascript" src="../js/mapTijdslijn.js"></script>
<script type="text/javascript" src="../js/jquery.timeliny.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/palette.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery.timeliny.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    </head>

<body class="Titel" oncontextmenu="return false;">
  <header>
    <nav class="navbar navbar-toggleable-md navbar-default ">
        <div class="container">
          <a href="" class="navbar-brand"><img src='../img/earth_logo.png'>Aezel<span>Geografisch</span></a>
             <button class="navbar-toggler pull-xs-right navbar-text hidden-lg-up navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              &#9776;
             </button>
             <!-- Collect the nav links, forms, and other content for toggling -->
             <div class="navbar-collapse pull-xs-left navbar-toggleable-md collapse" id="navbarSupportedContent">
                 <!--
                 <ul class="nav navbar-nav">
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="eigenaars();">Eigenaars</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_beroepsgroepen();">Beroepsgroepen</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                      <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_beroep();">Beroepen</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                         <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_woonplaats();">Woonplaatsen</a>
                    </li>
                    <li class="nav-item"  role="presentation">
                         <a class="nav-header" href="javascript:void(0)" onclick="eigenaars_statistieken();">Statistieken</a>
                    </li>
                 </ul>
                 -->
             </div>
       </div><!-- /.container-fluid -->
     </nav>
  </header>


<div class="control legend">
          <div id="dem_eig_lege_chk" class="control-top legend-top">
             <button data-toggle="collapse" data-target="#legend-form"><span>Legende</span></button>
             <button data-toggle="collapse" data-target="#metadata-form"><span>Metadata</span></button>
          </div>
    
          <div id="metadata-form" class="collapse">
              <div id="infomenu"  >
    <div id="eig_prop_popup" style="display:none;z-index:1004;color:black;border:solid 2px #ddd;text-align:left;overflow-y:scroll;height:90px;background-color:white;">
</div>
            <div id="infobox" style="display:none" ></div>
              </div>
          </div>
            <div id="legend-form" class="collapse">
        </div>

</div>   
<div class="control">
  <div class="control-top">
     <button data-toggle="collapse" data-target="#control-form"><span>Menu</span></button>
 </div>
  <div id="control-form" class="collapse in">
      <div id="geo_menu_title"></div>
    <div>
        <button id ="dem_toon_kaart" onclick="getEigenaars();">
            Toon kaart
        </button>
            <button id ="dem_toon_tijdlijn" onclick="tijdsloop();">
                Toon tijdlijn
            </button>
        <button id ="dem_eig_reset" onclick="resetCurrentThema();">
              Reset
          </button>
      </div>
        <div id="multilayer">
            <div id = "dem_player" class="dem_player">
                <button id ="dem_film_fr" onclick="frSlideshow();" <i class="material-icons">skip_previous</i></button>
                <button id ="dem_film_sp" onclick="spSlideshow();" <i class="material-icons">fast_rewind</i></button>
                <button id ="dem_film_pause" onclick="pauseSlideshow();"<i class="material-icons">pause</i></button>
                <button id ="dem_film_play" onclick="playSlideshow();" <i class="material-icons">play_arrow</i></button>
                <button id ="dem_film_sn"  onclick="snSlideshow();"<i class="material-icons">fast_forward</i></button>
                <button id ="dem_film_ff"  onclick="ffSlideshow();"<i class="material-icons">skip_next</i></button>
            </div>
        </div>

      <div id="multilayer">
          <div id="geo_zoekcriteria"></div>
<!--          
      <div class="button-group">
        <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="demZoekGemeentenZoekString();" maxlength="20"/>
        <button id="gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Gemeenten<span class="caret"></span></button>
        <ul id=gemeentebox class="dropdown-menu">
        </ul>
       </div>
      <div class="button-group">
        <input class="geotextbox beroepTextBox" name="beroepbox" placeholder="Zoek beroep" onkeyup="demZoekBeroepen();" maxlength="20"/>
        <button id="beroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepen<span class="caret"></span></button>
        <ul id=beroepbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox naamTextBox" name="naambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamenBeroep();" maxlength="20"/>
        <button id="naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=naambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox voornamenTextBox" name="voornamenbox" placeholder="Zoek voornaam" onkeyup="demZoekVoornamenBeroep();" maxlength="20"/>
        <button id="voornaam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Voornamen<span class="caret"></span></button>
        <ul id=voornamenbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artikelnummerTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummersBeroep();" maxlength="20"/>
        <button id="artikelnummer_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">artikelnrs<span class="caret"></span></button>
        <ul id=artikelnummerbox class="dropdown-menu">
        </ul>
      </div>
-->          
        <div class="button-group">
            <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies voorgrond" onkeyup="demZoekLagenZoekString(thema,actiefmenu);" maxlength="25"/>
            <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Voorgrond<span class="caret"></span></button>
            <ul id=lagenbox class="dropdown-menu">
            </ul>
        </div>
        <div class="button-group">
            <input class="geotextbox tilesTextBox" name="tilesbox" placeholder="Kies tiles" onkeyup="demZoekTilesZoekString();" maxlength="25"/>
            <button id="eig_tiles_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Achtergrond<span class="caret"></span></button>
            <ul id=tilesbox class="dropdown-menu">
            </ul>
        </div>
    <div>
        <div>
            <div class="select_tijd">
                <input type="text" id="dp_vanaf" name="dp_vanaf">
                <select style="width: 100%;"  id="tijdslijn_vanaf" naam="tijdslijn_vanaf" onChange="tijdslijnVanaf(this.selectedIndex);"size="1">
                </select>
            </div>

            <div class="reset_tijd">
                <button id ="hist_reset_vanaf" onclick="resetVanaf();">
                     Reset
                </button>
            </div>
        </div>
        <div>
            <div class="select_tijd">
                <input type="text" id="dp_tot" name = "dp_tot">
                <select style="width: 100%;"  id="tijdslijn_TotMet" naam="tijdslijn_TotMet" onChange="tijdslijnTot(this.selectedIndex);"size="1">
                </select>
            </div>
            <div class="reset_tijd">
                <button id ="hist_reset_totMet" onclick="resetTotMet();">
                    Reset
                </button>
            </div>
        </div>
      </div>              
      </div>    
  </div>
</div>

<div id ="tijdslijn_control">
<div id="dem_tijdslijn"></div>
</div>    
<div id="map" class="map"></div>



<div id="eig_popup" style="display:none;z-index:1000;position:absolute;color:black;padding:10px;border:solid 2px #ddd;background:beige;text-align:center;overflow:scroll;">
                               <select id="eig_popup_list" name="eig_popup_list" size="2" onchange=geo_link(this); onfocus="$(this).css({'background-color': 'white'});">
                            </select>
</div>

<div id="eig_wait_popup" style="display:none;z-index:1002;position:absolute;color:black;padding:10px;border:solid 4px #3775BB;background:yellow;text-align:center;top:0.5%;left:80%;">
    <h style="font-weight:bold">Een ogenblik aub...</h>
</div>
<script>
openTijdslijn = false;
thema = getQueryVariable("thema");
actiefmenu = getQueryVariable("menu");
omgeving = 'aezel';
hoofdlaag = null;
legendLayer = null;
keyValueLayerList = null;
keyValueTilesList = null;
geoKeyValueList = null;
geoWmsPerceel = null;
feat = null;

selCrit = [];
selTg = [];
selLg = [];
selTpn =[];
selGem = [];
selNm = [];
selVnm = [];
selArt = [];
selBgp = [];
selBrp = [];
selWpl = [];
selGrf = [];
selVak = [];


flGem =false;
flTpn =false;
flNm = false;
flVnm = false;
flArt = false;
flBgp = false;
flBrp = false;
flWpl = false;
flVak = false;
flGrf = false;

var firstOpenGem = true;
var firstOpenNm = true;
var firstOpenVnm = true;
var firstOpenArt = true;
var firstOpenBrp = true;
var firstOpenBgp = true;
var firstOpenWpl = true;
var firstOpenLg = true;
var firstOpenTg = true;
var firstOpenGrf = true;
var firstOpenVak= true;


    $(document).ready(function(){
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    hideTimeItems();
    demCheckStijlen(thema);
    demZoekMenu(thema,actiefmenu);


$(document).on('click','#0box a',function(event){
    for (i=1;i<selCrit.length;i++){
        selCrit[i][1].splice(0,selCrit[i][1].length);
        if (i!=0) $('.'+i+'TextBox').attr("placeholder","");
        selCrit[i][2]=true;
    }    
handleBoxEvent(0,event);
$("#dem_toon_kaart").show();
$("#dem_eig_reset").show();
return false;
});
$(document).on('click','#1box a',function(event){
handleBoxEvent(1,event);
return false;
});
$(document).on('click','#2box a',function(event){
handleBoxEvent(2,event);
return false;
});
$(document).on('click','#3box a',function(event){
handleBoxEvent(3,event);
return false;
});
$(document).on('click','#4box a',function(event){
handleBoxEvent(4,event);
return false;
});
$(document).on('click','#5box a',function(event){
handleBoxEvent(5,event);
return false;
});
$(document).on('click','#6box a',function(event){
handleBoxEvent(6,event);
return false;
});
$(document).on('click','#7box a',function(event){
handleBoxEvent(7,event);
return false;
});





$(document).on('click','#gemeentebox a',function(event){


    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selGem.indexOf( href.trim()))  > -1 ) {
      selGem.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      selGem.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();

    if (flNm == true)selNm.splice(0,selNm.length);
    if (flArt == true) selArt.splice(0,selArt.length);
    if (flVnm == true)selVnm.splice(0,selVnm.length);
    if (flBrp == true) selBrp.splice(0,selBrp.length);
    if (flBgp == true) selBgp.splice(0,selBgp.length);
    if (flWpl == true) selWpl.splice(0,selWpl.length);
    if (flTpn == true) selTpn.splice(0,selTpn.length);
    if (flVak == true) selVak.splice(0,selVak.length);
    if (flGrf == true) selGrf.splice(0,selGrf.length);

    ZoekGerelateerdeLijstenGem();

    return false;
});

$(document).on('click','#naambox a',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selNm.indexOf( href.trim()))  > -1 ) {
      selNm.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle namen') {
            selNm.splice(0,selNm.length);
         $( "#naambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle namen') {
            selNm.splice(0,selNm.length);
         $( "#naambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      selNm.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flVnm == true) demZoekvoornamen();
   if (flBrp == true) demZoekberoep();
   if (flBgp == true) demZoekberoepsgroep();
   if (flWpl == true) demZoekwoonplaats();
   if (flGrf == true) demZoekGraf_van();
   if (flVak == true) demZoekVak();
   return false;
});

$(document).on('click','#voornamenbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selVnm.indexOf( href.trim()))  > -1 ) {
      selVnm.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle voornamen') {
          selVnm.splice(0,selVnm.length);
         $( "#voornamenbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle voornamen') {
           selVnm.splice(0,selVnm.length);
           $( "#voornamenbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selVnm.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flNm == true) demZoeknaam();
   if (flBrp == true) demZoekberoep();
   if (flBrp == true) demZoekberoepsgroep();
   if (flWpl == true) demZoekwoonplaats();
   if (flGrf == true) demZoekGraf_van();
   if (flVak == true) demZoekVak();
   return false;
});

$(document).on('click','#artikelnummerbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selArt.indexOf( href.trim()))  > -1 ) {
      selArt.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle artikelnummers') {
          selArt.splice(0,selArt.length);
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle artikelnummers') {
         selArt.splice(0,selArt.length);
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }

      selArt.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flVnm == true) demZoekvoornamen();
   if (flNm == true) demZoeknaam();
   if (flBrp == true) demZoekberoep();
   if (flBgp == true) demZoekberoepsgroep();
   if (flWpl == true) demZoekwoonplaats();
   if (flGrf == true) demZoekGraf_van();
   if (flVak == true) demZoekVak();
   
   return false;
});

$(document).on('click','#beroepbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();    
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBrp.indexOf( href.trim()))  > -1 ) {
      selBrp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepen') {
          selBrp.splice(0,selBrp.length);
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepen') {
           selBrp.splice(0,selBrp.length);
           $( "#beroepbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selBrp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flVnm == true) demZoekvoornamen();
   if (flNm == true) demZoeknaam();
   if (flBgp == true) demZoekberoepsgroep();
   if (flWpl == true) demZoekwoonplaats();
   if (flGrf == true) demZoekGraf_van();
   if (flVak == true) demZoekVak();
   
   return false;
});

$(document).on('click','#woonplaatsbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selWpl.indexOf( href.trim()))  > -1 ) {
      selWpl.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle woonplaatsen') {
          selWpl.splice(0,selWpl.length);
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle woonplaatsen') {
           selWpl.splice(0,selWpl.length);
           $( "#woonplaatsbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selWpl.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flVnm == true) demZoekvoornamen();
   if (flNm == true) demZoeknaam();
   if (flBrp == true) demZoekberoep();
   if (flBgp == true) demZoekberoepsgroep();
   if (flGrf == true) demZoekGraf_van();
   if (flVak == true) demZoekVak();   
   return false;
});

$(document).on('click','#beroepsgroepbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBgp.indexOf( href.trim()))  > -1 ) {
      selBgp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepsgroepen') {
          selBgp.splice(0,selBgp.length);
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepsgroepen') {
           selBgp.splice(0,selBgp.length);
           $( "#beroepsgroepbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selBgp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flVnm == true) demZoekvoornamen();
   if (flNm == true) demZoeknaam();
   if (flBrp == true) demZoekberoep();
   if (flWpl == true) demZoekwoonplaats();
   if (flGrf == true) demZoekGraf_van();
   if (flVak == true) demZoekVak();   
   return false;
});


$(document).on('click','#graf_vanbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selGrf.indexOf( href.trim()))  > -1 ) {
      selGrf.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle graven') {
          selGrf.splice(0,selGrf.length);
         $( "#graf_vanbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle graven') {
           selGrf.splice(0,selGrf.length);
           $( "#graf_vanbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selGrf.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flVnm == true) demZoekvoornamen();
   if (flNm == true) demZoeknaam();
   if (flBrp == true) demZoekberoep();
   if (flBgp == true) demZoekberoepsgroep();
   if (flWpl == true) demZoekwoonplaats();
    if (flGrf == true) demZoekGraf_van();
   return false;
});

$(document).on('click','#vakbox a',function(event){

    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selVak.indexOf( href.trim()))  > -1 ) {
      selVak.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle vakken') {
          selVak.splice(0,selVak.length);
         $( "#vakbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle vakken') {
           selVak.splice(0,selVak.length);
           $( "#vakbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selVak.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   if (flArt == true) demZoekartikelnummer();
   if (flVnm == true) demZoekvoornamen();
   if (flNm == true) demZoeknaam();
   if (flBrp == true) demZoekberoep();
   if (flBgp == true) demZoekberoepsgroep();
   if (flWpl == true) demZoekwoonplaats();
   if (flVak == true) demZoekVak();   
   return false;
});


$(document).on('click','#lagenbox a',function(event){

   var $target = $( event.currentTarget ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selLg.indexOf( href.trim()))  > -1 ) {
      selLg.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      selLg.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }
   $( event.target ).blur();
   return false;
});

$(document).on('click','#tilesbox a',function(event){

   var $target = $( event.currentTarget ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selTg.indexOf( href.trim()))  > -1 ) {
      selTg.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      if (selTg == "") selTg = [];
      selTg.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }
   $( event.target ).blur();
   return false;
});

$(document).on('click','.0TextBox',function(event){
    handleTextBoxEvent(0);
});
$(document).on('click','#0_btn',function(event){
    handleBoxClickEvent(0);
});
$(document).on('click','.1TextBox',function(event){
    handleTextBoxEvent(1);
});
$(document).on('click','#1_btn',function(event){
    handleBoxClickEvent(1);
});
$(document).on('click','.2TextBox',function(event){
    handleTextBoxEvent(2);
});
$(document).on('click','#2_btn',function(event){
    handleBoxClickEvent(2);
});
$(document).on('click','.3TextBox',function(event){
    handleTextBoxEvent(3);
});
$(document).on('click','#3_btn',function(event){
    handleBoxClickEvent(3);
});
$(document).on('click','.4TextBox',function(event){
    handleTextBoxEvent(4);
});
$(document).on('click','#4_btn',function(event){
    handleBoxClickEvent(4);
});
$(document).on('click','.5TextBox',function(event){
    handleTextBoxEvent(5);
});
$(document).on('click','#5_btn',function(event){
    handleBoxClickEvent(5);
});
$(document).on('click','.6TextBox',function(event){
    handleTextBoxEvent(6);
});
$(document).on('click','#6_btn',function(event){
    handleBoxClickEvent(6);
});
$(document).on('click','.7TextBox',function(event){
    handleTextBoxEvent(7);
});
$(document).on('click','#7_btn',function(event){
    handleBoxClickEvent(7);
});




$(document).on('click','.gemeenteTextBox',function(event){
    $('#gemeentebox').slideToggle();
    $('#lagenbox').slideUp();
    $(".gemeenteTextBox").val('').html();

    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    firstOpenGem = false;
});

$(document).on('click','#gemeente_btn',function(event){
    $('#lagenbox').slideUp();

    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});

$(document).on('click','.naamTextBox',function(event){
   
    $('#naambox').slideToggle();
    
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    
    $(".naamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#naam_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    if (firstOpenNm == false) {
        $('#naambox').slideToggle();
    }
});

$(document).on('click','.voornamenTextBox',function(event){
    $('#voornamenbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".voornamenTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#voornamen_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();    
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    if (firstOpenVnm == false) {
        $('#voornamenbox').slideToggle();
    }
});

$(document).on('click','.artikelnummerTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();    
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".artikelnummerTextBox").val('').html();
    firstOpenArt = false;
});

$(document).on('click','#artikelnummer_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();    
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    if (firstOpenVnm == false) {
        $('#artikelnummerbox').slideToggle();
    }
});

$(document).on('click','.beroepTextBox',function(event){
    $('#beroepbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();    
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".beroepTextBox").val('').html();
    firstOpenBrp = false;
});

$(document).on('click','#beroep_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $('#lagenbox').slideUp();    
    if (firstOpenBrp == false) {
        $('#beroepbox').slideToggle();
    }
});

$(document).on('click','.beroepTextBox',function(event){
    $('#beroepbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();   
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".beroepTextBox").val('').html();
    firstOpenBrp = false;
});

$(document).on('click','#beroep_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $('#lagenbox').slideUp();    
    if (firstOpenBrp == false) {
        $('#beroepbox').slideToggle();
    }
});

$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#beroepsgroepbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();   
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".beroepsgroepTextBox").val('').html();
    firstOpenBgp = false;
});

$(document).on('click','#beroepsgroep_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $('#lagenbox').slideUp();    
    if (firstOpenBgp == false) {
        $('#beroepsgroepbox').slideToggle();
    }
});


$(document).on('click','.woonplaatsTextBox',function(event){
    $('#woonplaatsbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flBgp == true) $('#beroepsgroep').slideUp();   
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".woonplaatsTextBox").val('').html();
    firstOpenWpl = false;
});

$(document).on('click','#woonplaats_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $('#lagenbox').slideUp();    
    if (firstOpenWpl == false) {
        $('#woonplaatsbox').slideToggle();
    }
});


$(document).on('click','.graf_vanTextBox',function(event){
    $('#graf_vanbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flBgp == true) $('#beroepsgroep').slideUp();   
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".graf_vanTextBox").val('').html();
    firstOpenGrf = false;
});

$(document).on('click','#graf_van_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $('#lagenbox').slideUp();    
    if (firstOpenGrf == false) {
        $('#graf_vanbox').slideToggle();
    }
});


$(document).on('click','.vakTextBox',function(event){
    $('#vakbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flBgp == true) $('#beroepsgroep').slideUp();   
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    
    $(".vakTextBox").val('').html();
    firstOpenVak = false;
});

$(document).on('click','#vak_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    
    $('#lagenbox').slideUp();    
    if (firstOpenVak == false) {
        $('#vakbox').slideToggle();
    }
});


$(document).on('click','.lagenTextBox',function(event){
    $('#lagenbox').slideToggle();
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();    
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    $(".lagenTextBox").val('').html();
    firstOpenLg = false;
});

$(document).on('click','#eig_lagen_btn',function(event){
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
    
    if (firstOpenLg == false) {
        $('#lagenbox').slideToggle();
    }
});

$(document).on('click','.tilesTextBox',function(event){
    $('#tilesbox').slideToggle();
    $(".tilesTextBox").val('').html();
    firstOpenTg = false;
});

$(document).on('click','#eig_tiles_btn',function(event){
    if (firstOpenTg == false) {
        $('#tilesbox').slideToggle();
    }
});


$('#map').contextmenu(function(evt) {
  openLinkMenu(evt);
});
   
});

function handleBoxClickEvent(boxNr) {
    $('#lagenbox').slideUp();

    for (i=0;i<selCrit.length;i++){
        if (i!=boxNr){
        $('#'+i+'box').slideUp();
        }
    }
    if (selCrit[boxNr][2] == false) {
        $('#'+boxNr+'box').slideToggle();
    }
}


function handleTextBoxEvent(boxNr) {
    $('#'+boxNr+'box').slideToggle();
    $('#lagenbox').slideUp();
    $("."+boxNr+"TextBox").val('').html();

    for (i=0;i<selCrit.length;i++){
        if (i!=boxNr){
        $('#'+i+'box').slideUp();
        }
    }
    selCrit[boxNr][2]=false;
    }

function handleBoxEvent(boxNr,event) {
for (i=0;i<selCrit.length;i++){
    if (i!=boxNr){
    $('#'+i+'box').slideUp();
    }}
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selCrit[boxNr][1].indexOf( href.trim()))  > -1 ) {
      selCrit[boxNr][1].splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      selCrit[boxNr][1].push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   
   for (i=1;i<selCrit.length;i++){
    if (i!=boxNr){
        demZoek(i);
    }}
}

function ZoekGerelateerdeLijsten0Box() {
    
    for (i=1;i<selCrit.length;i++){
        $('.'+i+'Textbox').attr("placeholder","Even geduld..");
        demZoekCriteriumBy0Box(i);
    }
    /*
    if (flNm == true) $('.naamTextBox').attr("placeholder","Even geduld..");
    if (flArt == true) $('.artikelnummerTextBox').attr("placeholder","Even geduld..");
    if (flVnm == true) $('.voornamenTextBox').attr("placeholder","Even geduld..");
    if (flBrp == true) $('.beroepTextBox').attr("placeholder","Even geduld..");
    if (flBgp == true) $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");
    if (flWpl == true) $('.woonplaatsTextBox').attr("placeholder","Even geduld..");
    if (flGrf == true) $('.graf_vanTextBox').attr("placeholder","Even geduld..");
    if (flVak == true) $('.vakTextBox').attr("placeholder","Even geduld..");
    
    if (flArt == true) demZoekArtikelnummersByGemeente();
    if (flNm == true) demZoekFamilienamenByGemeente();
    if (flVnm == true) demZoekVoornamenByGemeente();
    if (flBrp == true) demZoekBeroepenByGemeente();
    if (flBgp == true) demZoekBeroepsgroepenByGemeente();
    if (flWpl == true) demZoekWoonplaatsenByGemeente();
    if (flGrf == true) demZoekGraf_vanByGemeente();
    if (flVak == true) demZoekVakByGemeente();   
    */
    $("#dem_toon_kaart").show();
    $("#dem_eig_reset").show();
    
}


function resetMap(){
    $('#map').empty();
    $("#dem_eig_legend_chk").hide();
    $("#eig_legende_spam").hide();
    $( "#dem_eig_legend_chk").prop('checked', false);
    hideLagenbox();
}

function resetGeo(){
    
    resetMap();
    $("#dem_toon_kaart").hide();
    $("#dem_eig_reset").hide();

    for (i=0;i<selCrit.length;i++){
        if (selCrit[i][3]==false) {
            $('#0box').slideUp(); 
        }
        $('#'+i+'box').empty();
        if (!((i==0)&&(selCrit[i][3]==true))) {
            selCrit[i][1].splice(0,selCrit[i][1].length);
        }
        if (i!=0) {
            $('.'+i+'TextBox').attr("placeholder","");
        }
        selCrit[i][2]=true;
    }
/*
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flGem == true) $('#gemeentebox').empty();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroep').slideUp();
    if (flBgp == true) $('#beroepsgroep').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();  
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
        
    if (flArt == true) $('#artikelnummerbox').empty();
    if (flVnm == true) $('#voornamenbox').empty();
    if (flBrp == true) $('#beroep').empty();
    if (flBgp == true) $('#beroepsgroep').empty();
    if (flNm == true) $('#naambox').empty();    
    if (flWpl == true) $('#woonplaatsbox').empty();    
    if (flGrf == true) $('#graf_vanbox').empty();
    if (flVak == true) $('#vakbox').empty();
        
    $('#infobox').empty();
    
    firstOpenGem = true;
    firstOpenNm = true;
    firstOpenVnm = true;
    firstOpenArt = true;
    firstOpenBrp = true;
    firstOpenBgp = true;
    firstOpenWpl = true;
    firstOpenLg = true;
    firstOpenTg = true;
    firstOpenGrf = true;
    firstOpenVak= true;
    
    if (flGem == true) selGem.splice(0,selGem.length);
    if (flNm == true)selNm.splice(0,selNm.length);
    if (flArt == true) selArt.splice(0,selArt.length);
    if (flVnm == true)selVnm.splice(0,selVnm.length);
    if (flBrp == true) selBrp.splice(0,selBrp.length);
    if (flBgp == true) selBgp.splice(0,selBgp.length);
    if (flWpl == true) selWpl.splice(0,selWpl.length);
    if (flTpn == true) selTpn.splice(0,selTpn.length);
    if (flVak == true) selVak.splice(0,selVak.length);
    if (flGrf == true) selGrf.splice(0,selGrf.length);
    
    
    if (flNm == true) $('.naamTextBox').attr("placeholder","");
    if (flArt == true) $('.artikelnummerTextBox').attr("placeholder","");
    if (flVnm == true) $('.voornamenTextBox').attr("placeholder","");
    if (flBrp == true) $('.beroepTextBox').attr("placeholder","");
    if (flBgp == true) $('.beroepsgroepTextBox').attr("placeholder","");
    if (flWpl == true) $('.woonplaatsTextBox').attr("placeholder","");
    if (flGrf == true) $('.graf_vanTextBox').attr("placeholder","");
    if (flVak == true) $('.vakTextBox').attr("placeholder","");    
*/    
    tijdlijn = false
    demVerwijderTijdslijn();
    hideTimeItems();    
    
    if (selCrit[0][1].length ==1) {
        // in geval van vaste gemeentenaam
        ZoekGerelateerdeLijsten0Box();
    }        
    /*
    if ((selGem.length > 0) && (flGem == false)) {
        // in geval van vaste gemeentenaam
        ZoekGerelateerdeLijstenGem();
    }
    */

}

function resetCurrentThema()
{
    resetGeo();
    demZoek(0);
    getMapStartup(thema);
 }



function decodeHtml(html) {
 var txt = document.createElement("textarea");
 txt.innerHTML = html;
 return txt.value;
}

function getEigenaars() {

    $('#infobox').empty();
    $('#eig_prop_popup').empty();
    $('#metadata-form').collapse('hide');
    
    
    for (i=0;i<selCrit.length;i++){
        if (selCrit[i][1].length>0){
            $('#'+i+'box').slideUp();
        }
    }    

/*    
    if (flGem == true) $('#gemeentebox').slideUp();
    if (flArt == true) $('#artikelnummerbox').slideUp();
    if (flVnm == true) $('#voornamenbox').slideUp();
    if (flBrp == true) $('#beroepbox').slideUp();
    if (flBgp == true) $('#beroepsgroepenbox').slideUp();
    if (flNm == true) $('#naambox').slideUp();    
    if (flWpl == true) $('#woonplaatsbox').slideUp();     
    if (flGrf == true) $('#graf_vanbox').slideUp();
    if (flVak == true) $('#vakbox').slideUp();
  */  
    
    hideLagenbox();
    
    var html = $('#dem_tijdslijn').html();
    if ($('#dem_tijdslijn').html().length > 10){
        rebuildTijdslijnDiv();
    }
    initTijdslijst = false;
    demGetEigenaars();
    
    $("#dem_eig_legend_chk").show();
    $("#eig_legende_spam").show();
    var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
    var bodyHeight = $(window).height();     
    $("#map").height(bodyHeight-headerHeight);    
}


function hideTimeItems() {
    $("#dem_toon_tijdlijn").hide();
    $('#dem_tijdslijn').hide();
    $('#dem_player').hide();
    $('#tijdslijn_vanaf').hide();
    $('#tijdslijn_TotMet').hide();
    $('#dp_vanaf').hide();
    $('#dp_tot').hide();
    $('#hist_reset_vanaf').hide();
    $('#hist_reset_totMet').hide();
    $('#dem_film_pause').hide();
    
    if (flGem == true) selGem = [];
}

$(function() {
    van = $( "#dp_vanaf" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    }).on( "change", function() {
        tijdslijnVanaf( this.value );
    });
    tot = $( "#dp_tot" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    }).on( "change", function() {
        tijdslijnTot( this.value );
    });
    function getDate( element ) {
        var date;
        var dateFormat = "yymmdd";
        try {
          date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
          date = null;
        }
        return date;
    }
});

function hideLagenbox() {
   if (firstOpenLg == false) {
        $("#lagenbox").css('display','none');
    } else {
        $('#eig_lagen_btn').attr('aria-expanded','false');
    }
   if (firstOpenTg == false) {
        $("#tilesbox").css('display','none');
    } else {
        $('#eig_tiles_btn').attr('aria-expanded','false');
    }    
}
  
function eigenaars_statistieken() {
    window.open("./eigenaars_statistieken.php?thema="+thema+"&laag="+hoofdlaag[1].trim(),"_self");
}  
</script>
  </body>
</html>
