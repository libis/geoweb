<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<div class="control legend">
          <div id="dem_eig_lege_chk" class="control-top legend-top">
             <button data-toggle="collapse" data-target="#metadata-form"><span>Metadata</span></button>
             <button data-toggle="collapse" data-target="#legend-form"><span>Legende</span></button>
          </div>
          <div id="metadata-form" class="collapse">
            <div id="infobox" style="display:none" ></div>
          </div>
          <div id="legend-form" class="collapse">
          </div>
</div>
<div class="control">
  <div class="control-top">
     <button data-toggle="collapse" data-target="#control-form"><span>Menu</span></button>
     <!--<button data-toggle="collapse" data-target="#control-form-tile" ><span>Achtergrond</span></button> --> 
  </div>
  <div id="control-form" class="collapse in">
    <h2>Woonplaats Eigenaar </h2>

    <div>
        <button id ="dem_toon_kaart" onclick="getEigenaarsWoonplaats();">
            Toon kaart
        </button>
        <button id ="dem_toon_tijdlijn" onclick="tijdsloop();">
            Toon tijdlijn
        </button>
        <button id ="dem_eig_reset" onclick="resetEigenaarsWoonplaats();">
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
      <div class="button-group">
        <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="demZoekGemeentenZoekString();" maxlength="20"/>
        <button id="gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Gemeenten<span class="caret"></span></button>
        <ul id=gemeentebox class="dropdown-menu">
        </ul>
       </div>
      <div class="button-group">
        <input class="geotextbox woonplaatsTextBox" name="woonplaatsbox" placeholder="Zoek woonplaats" onkeyup="demZoekWoonplaatsen();" maxlength="20"/>
        <button id="woonplaats_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Woonplaatsen<span class="caret"></span></button>
        <ul id=woonplaatsbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox familienaamTextBox" name="familienaambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamenWoonplaats();" maxlength="20"/>
        <button id="naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=familienaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox voornaamTextBox" name="voornaambox" placeholder="Zoek voornaam" onkeyup="demZoekVoornamenWoonplaats();" maxlength="20"/>
        <button id="voornaam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Voornamen<span class="caret"></span></button>
        <ul id=voornaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummersWoonplaats();" maxlength="20"/>
        <button id="artikelnummer_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Artikelnrs<span class="caret"></span></button>
        <ul id=artikelnummerbox class="dropdown-menu">
        </ul>
      </div>
        <div class="button-group">
            <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies voorgrond" onkeyup="demZoekLagenZoekString(thema);" maxlength="25"/>
            <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Voorgrond<span class="caret"></span></button>
            <ul id=lagenbox class="dropdown-menu">
            </ul>
        </div>
            <div class="button-group">
            <input class="geotextbox tilesTextBox" name="tilesbox" placeholder="Kies achtergrond" onkeyup="demZoekTilesZoekString();" maxlength="25"/>
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
     <!--
    <div id="control-form-tile" class="collapse" >
        <div id="multilayer" >
            <div class="button-group">
            <input class="geotextbox tilesTextBox" name="tilesbox" placeholder="Kies tiles" onkeyup="demZoekTilesZoekString();" maxlength="25"/>
            <button id="eig_tiles_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Tiles<span class="caret"></span></button>
            <ul id=tilesbox class="dropdown-menu">
            </ul>
            </div>
            </div>
        </div>   
     -->
</div>

    <div id ="tijdslijn_control">
<div id="dem_tijdslijn"></div>
</div>
<div id="map" class="map"></div>
<script language="javascript">

var firstOpenGem = true;
var firstOpenNm = true;
var firstOpenVnm = true;
var firstOpenArt = true;
var firstOpenWpl = true;
var firstOpenLg = true;
var firstOpenTg = true;



   $(document).ready(function(){
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

     $("#dem_toon_kaart").hide();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_reset").hide();
     
    $('.familienaamTextBox').attr("placeholder","");
    $('.artTextBox').attr("placeholder","");
    $('.voornaamTextBox').attr("placeholder","");
    $('.woonplaatsTextBox').attr("placeholder","");
    
    hideTimeItems();
    demCheckStijlen(thema);
    demZoekTiles(thema);
    demZoekLagen(thema);
    getMapStartup(thema);  
     
$(document).on('click','#gemeentebox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
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
    $('.voornaamTextBox').attr("placeholder","Even geduld..");
    $('.woonplaatsTextBox').attr("placeholder","Even geduld..");

    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    selWpl.splice(0,selWpl.length);
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);
    setCookie('selWpl',selWpl);

   demZoekArtikelnummersByGemeente();
   demZoekFamilienamenByGemeente();
   demZoekVoornamenByGemeente();
   demZoekWoonplaatsenByGemeente();
   $("#dem_toon_kaart").show();
   $("#dem_eig_reset").show();
   return false;
});

$(document).on('click','#familienaambox a',function(event){
    selNm = getCookie('selNm');
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#voornaambox').slideUp();
    $('#woonplaatsbox').slideUp();
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
   demZoekArtikelnummersWoonplaats();
   demZoekVoornamenWoonplaats();
   demZoekWoonplaatsen();
   return false;
});

$(document).on('click','#voornaambox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#woonplaatsbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selVnm.indexOf( href.trim()))  > -1 ) {
      selVnm.splice( idx, 1 );
      setCookie('selVnm',selVnm);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle voornamen') {
          selVnm.splice(0,selVnm.length);
          setCookie('selVnm',selVnm);
         $( "#voornaambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle voornamen') {
           selVnm.splice(0,selVnm.length);
           setCookie('selVnm',selVnm);
           $( "#voornaambox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }

      selVnm.push(href.trim());
      setCookie('selVnm',selVnm);

      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersWoonplaats();
   demZoekFamilienamenWoonplaats();
   demZoekWoonplaatsen();
   return false;
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();    
    $('#gemeentebox').slideUp();
    $('#woonplaatsbox').slideUp();
    

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
    demZoekFamilienamenWoonplaats();
    demZoekVoornamenWoonplaats();
    demZoekWoonplaatsen();
   return false;
});

$(document).on('click','#woonplaatsbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    
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
   demZoekArtikelnummersWoonplaats();
   demZoekFamilienamenWoonplaats();
   demZoekVoornamenWoonplaats();
   return false;
});

$(document).on('click','#lagenbox a',function(event){

   var $target = $( event.currentTarget ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selLg.indexOf( href.trim()))  > -1 ) {
      selLg.splice( idx, 1 );
      setCookie('selLg',selLg);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      selLg.push(href.trim());
      setCookie('selLg',selLg);
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

$(document).on('click','.gemeenteTextBox',function(event){
    $('#gemeentebox').slideToggle();
    $('#lagenbox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();       
    $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;
});

$(document).on('click','#gemeente_btn',function(event){
    $('#lagenbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#woonplaatsbox').slideUp();    
    
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});

$(document).on('click','.familienaamTextBox',function(event){
    $('#familienaambox').slideToggle();
    $('#lagenbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#voornaambox').slideUp();     
    $(".familienaamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#naam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#woonplaatsbox').slideUp();    
    if (firstOpenNm == false) {
        $('#familienaambox').slideToggle();
    }
});

$(document).on('click','.voornaamTextBox',function(event){
    $('#voornaambox').slideToggle();
    $('#lagenbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#familienaambox').slideUp();
    $(".voornaamTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#voornaam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#lagenbox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#woonplaatsbox').slideUp();    
    
    if (firstOpenVnm == false) {
        $('#voornaambox').slideToggle();
    }
});

$(document).on('click','.artTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    $('#lagenbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();     
    $(".artTextBox").val('').html();
    firstOpenArt = false;
});

$(document).on('click','#artikelnummer_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#lagenbox').slideUp();    
    $('#woonplaatsbox').slideUp();    
    
    if (firstOpenVnm == false) {
        $('#artikelnummerbox').slideToggle();
    }
});

$(document).on('click','.woonplaatsTextBox',function(event){
    $('#woonplaatsbox').slideToggle();
    $('#lagenbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();     
    $(".woonplaatsTextBox").val('').html();
    firstOpenWpl = false;
});

$(document).on('click','#woonplaats_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#lagenbox').slideUp();    
    if (firstOpenWpl == false) {
        $('#woonplaatsbox').slideToggle();
    }
});

$(document).on('click','.lagenTextBox',function(event){
    $('#lagenbox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();     
    $(".lagenTextBox").val('').html();
    firstOpenLg = false;
});

$(document).on('click','#eig_lagen_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#woonplaatsbox').slideUp();    
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

$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
});

function resetMap(){
     $('#map').empty();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_eig_legend_chk").prop('checked', false);
     hideLagenbox();
}

function resetEigenaarsWoonplaats()
{
    resetMap();
    $("#dem_toon_kaart").hide();
    $("#dem_eig_reset").hide();

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#woonplaatsbox').slideUp();
    $('#artikelnummerbox').empty();
    $('#gemeentebox').empty();
    $('#familienaambox').empty();
    $('#voornaambox').empty();
    $('#woonplaatsbox').empty();
    $('#infobox').empty();
    
    selGem.splice(0,selGem.length);
    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    selWpl.splice(0,selWpl.length);
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);
    setCookie('selWpl',selWpl);
    setCookie('selGem',selGem);
    setCookie('selLg',selLg);

    $('.familienaamTextBox').attr("placeholder","");
    $('.artTextBox').attr("placeholder","");
    $('.voornaamTextBox').attr("placeholder","");
    $('.woonplaatsTextBox').attr("placeholder","");

    tijdlijn = false
    demVerwijderTijdslijn();
    hideTimeItems();

    demZoekGemeenten(hoofdlaag[1].trim());
    getMapStartup(thema);
}


function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}
/*
function eigenaars() {
    window.open("./eigenaars.php?thema="+thema,"_self");
}
function eigenaars_beroepsgroepen() {
    window.open("./eigenaars_beroepsgroepen.php?thema="+thema,"_self");
}
function eigenaars_beroep() {
    window.open("./eigenaars_beroep.php?thema="+thema+"_beroep","_self");
}
function eigenaars_statistieken() {
    window.open("./eigenaars_statistieken.php?thema="+thema,"_self");
}
*/

function getEigenaarsWoonplaats() {

    $('#infobox').empty();
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();	
    $('#woonplaatsbox').slideUp();	
    
    hideLagenbox();
    var html = $('#dem_tijdslijn').html();
    if ($('#dem_tijdslijn').html().length > 10){
        rebuildTijdslijnDiv();
    }
    initTijdslijst = false;
    demGetEigenaarsWoonplaats();     
    $("#dem_eig_legend_chk").show();
    $("#eig_legende_spam").show();
    var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
    var bodyHeight = $(window).height();     
    $("#map").height(bodyHeight-headerHeight);          
}




</script>
<?php include 'common/footer.php'; ?>
