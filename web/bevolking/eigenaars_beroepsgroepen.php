<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<div class="control legend">
          <div id="dem_eig_lege_chk" class="control-top legend-top">
             <button data-toggle="collapse" data-target="#legend-form"><span>Legende</span></button>
             <button data-toggle="collapse" data-target="#metadata-form"><span>Metadata</span></button>
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
<!--     <button data-toggle="collapse" data-target="#control-form-tile" ><span>Achtergrond</span></button>  -->
</div>
  <div id="control-form" class="collapse in">
    <h2>Beroepsgroep Eigenaar </h2>

    <div>
        <button id ="dem_toon_kaart" onclick="getEigenaarsBeroepsgroep();">
            Toon kaart
        </button>
            <button id ="dem_toon_tijdlijn" onclick="tijdsloop();">
                Toon tijdlijn
            </button>
        <button id ="dem_eig_reset" onclick="resetEigenaarsBeroepsgroep();">
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
          <input class="geotextbox beroepsgroepTextBox" name="beroepsgroepbox" placeholder="Zoek beroep" onkeyup="demZoekBeroepsgroepen();" maxlength="20"/>
        <button id="beroepsgroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepsgroep<span class="caret"></span></button>
        <ul id=beroepsgroepbox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox familienaamTextBox" name="familienaambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamenBeroep();" maxlength="20"/>
        <button id="naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=familienaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox voornaamTextBox" name="voornaambox" placeholder="Zoek voornaam" onkeyup="demZoekVoornamenBeroep();" maxlength="20"/>
        <button id="voornaam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Voornamen<span class="caret"></span></button>
        <ul id=voornaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummersBeroep();" maxlength="20"/>
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


setCookie('selLg',selLg);
var firstOpenGem = true;
var firstOpenNm = true;
var firstOpenVnm = true;
var firstOpenArt = true;
var firstOpenBgp = true;
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
    $('.beroepsgroepTextBox').attr("placeholder","");
    
    hideTimeItems();
    demCheckStijlen(thema);
    demZoekLagen(thema);
    demZoekTiles(thema);
    getMapStartup(thema);  
     

$(document).on('click','#gemeentebox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#beroepsgroepbox').slideUp();
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
    $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");

    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    selBgp.splice(0,selBgp.length);
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);
    setCookie('selBgp',selBgp);

   demZoekArtikelnummersByGemeente();
   demZoekFamilienamenByGemeente();
   demZoekVoornamenByGemeente();
   demZoekBeroepsgroepenByGemeente();
   $("#dem_toon_kaart").show();
   $("#dem_eig_reset").show();
   return false;
});

$(document).on('click','#familienaambox a',function(event){
    selNm = getCookie('selNm');
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#voornaambox').slideUp();
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
   demZoekArtikelnummersBeroepsgroep();
   demZoekVoornamenBeroepsgroep();
   demZoekBeroepsgroepen();
   return false;
});

$(document).on('click','#voornaambox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#beroepsgroepbox').slideUp();
    
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
   demZoekArtikelnummersBeroepsgroep();
   demZoekFamilienamenBeroepsgroep();
   demZoekBeroepsgroepen();
   return false;
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();    
    $('#gemeentebox').slideUp();
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
    demZoekFamilienamenBeroepsgroep();
    demZoekVoornamenBeroepsgroep();
    demZoekBeroepsgroepen();
   return false;
});

$(document).on('click','#beroepsgroepbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBgp.indexOf( href.trim()))  > -1 ) {
      selBgp.splice( idx, 1 );
      setCookie('selBgp',selBgp);
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepen') {
          selBgp.splice(0,selBgp.length);
          setCookie('selBgp',selBgp);
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
   } else {
      if (href.trim() == 'Alle beroepen') {
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
   demZoekArtikelnummersBeroepsgroep();
   demZoekFamilienamenBeroepsgroep();
   demZoekVoornamenBeroepsgroep();
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
    $('#artikelnummerbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();    
    $('#lagenbox').slideUp();      
    $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;
});

$(document).on('click','#gemeente_btn',function(event){
    $('#lagenbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});

$(document).on('click','.familienaamTextBox',function(event){
    $('#familienaambox').slideToggle();
    $('#artikelnummerbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#voornaambox').slideUp();    
    $('#lagenbox').slideUp();      
    
    $(".familienaamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#naam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    if (firstOpenNm == false) {
        $('#familienaambox').slideToggle();
    }
});

$(document).on('click','.voornaamTextBox',function(event){
    $('#voornaambox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#familienaambox').slideUp();
    $('#lagenbox').slideUp();  
    
    $(".voornaamTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#voornaam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#lagenbox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    
    if (firstOpenVnm == false) {
        $('#voornaambox').slideToggle();
    }
});

$(document).on('click','.artTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();       
    $('#lagenbox').slideUp();    
    
    $(".artTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#artikelnummer_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#lagenbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    
    if (firstOpenVnm == false) {
        $('#artikelnummerbox').slideToggle();
    }
});

$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#beroepsgroepbox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();       
    $('#lagenbox').slideUp();    
    
    $(".beroepsgroepTextBox").val('').html();
    firstOpenBgp = false;
});

$(document).on('click','#beroepsgroep_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    $('#lagenbox').slideUp();    
    if (firstOpenBgp == false) {
        $('#beroepsgroepbox').slideToggle();
    }
});

$(document).on('click','.lagenTextBox',function(event){
    $('#lagenbox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();
    $('#beroepsgroepbox').slideUp();
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
    $('#beroepsgroepbox').slideUp();    
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

function resetMap(){
     $('#map').empty();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_eig_legend_chk").prop('checked', false);
     hideLagenbox();

 }

function resetEigenaarsBeroepsgroep()
{
    resetMap();
    $("#dem_toon_kaart").hide();
    $("#dem_eig_reset").hide();

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#artikelnummerbox').empty();
    $('#gemeentebox').empty();
    $('#familienaambox').empty();
    $('#voornaambox').empty();
    $('#beroepsgroepbox').empty();
    $('#infobox').empty();
    
    selGem.splice(0,selGem.length);
    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    selBgp.splice(0,selBgp.length);
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);
    setCookie('selBgp',selBgp);
    setCookie('selGem',selGem);
    setCookie('selLg',selLg);

    $('.familienaamTextBox').attr("placeholder","");
    $('.artTextBox').attr("placeholder","");
    $('.voornaamTextBox').attr("placeholder","");
    $('.beroepsgroepTextBox').attr("placeholder","");

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


var mylegendberoepsgroepwindow = null;
/*
function eigenaars() {
    window.open("./eigenaars.php?thema="+thema,"_self");
}
function eigenaars_beroep() {
    window.open("./eigenaars_beroep.php?thema="+thema+"_beroep","_self");
}
function eigenaars_woonplaats() {
    window.open("./eigenaars_woonplaats.php?thema="+thema,"_self");
}
function eigenaars_statistieken() {
    window.open("./eigenaars_statistieken.php?thema="+thema,"_self");
}
*/
function getEigenaarsBeroepsgroep() {

    $('#infobox').empty();
    $('#infobox').empty();
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();	
    $('#beroepsgroepbox').slideUp();    
    hideLagenbox();
    var html = $('#dem_tijdslijn').html();
    if ($('#dem_tijdslijn').html().length > 10){
        rebuildTijdslijnDiv();
    }
    initTijdslijst = false;
    demGetEigenaarsBeroepsgroep();    
    $("#dem_eig_legend_chk").show();
    $("#eig_legende_spam").show();
    var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
    var bodyHeight = $(window).height();     
    $("#map").height(bodyHeight-headerHeight);  
}




</script>
<?php include 'common/footer.php'; ?>
