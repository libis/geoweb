<?php include 'common/header.php'; ?>



<div class="control legend">
        <div id="dem_eig_lege_chk" class="control-top legend-top">
           <button data-toggle="collapse" data-target="#legend-form"><span>Legende</span></button>
           <button data-toggle="collapse" data-target="#metadata-form"><span>Metadata</span></button>
        </div>
        <div id="legend-form" class="collapse">
        </div>
        <div id="metadata-form" class="collapse">
          <div id="infobox" style="display:none" ></div>
        </div>
</div>
<div class="control">
  <div class="control-top">
     <button data-toggle="collapse" data-target="#control-form" ><span>Menu</span></button>
  </div>
    
  <div id="control-form" class="collapse in" >
      <div>
      <h2>Kadastrale Eigenaar</h2>
      <div>
          <button id ="dem_toon_kaart" onclick="getEigenaars();">
              Toon kaart
          </button>
            <button id ="dem_toon_tijdlijn" onclick="tijdsloop();">
                Toon tijdlijn
            </button>
          <button id ="dem_eig_reset" onclick="resetEigenaars();">
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
  </div>
      <div id="multilayer">
      <div class="button-group">
        <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="demZoekGemeentenZoekString();" maxlength="20"/>
        <button id="gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Gemeenten<span class="caret"></span></button>
        <ul id=gemeentebox class="dropdown-menu">
        </ul>
       </div>
      <div class="button-group">
        <input class="geotextbox familienaamTextBox" name="familienaambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamen();" maxlength="20"/>
        <button id="naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=familienaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox voornaamTextBox" name="voornaambox" placeholder="Zoek voornaam" onkeyup="demZoekVoornamen();" maxlength="20"/>
        <button id="voornaam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Voornamen<span class="caret"></span></button>
        <ul id=voornaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummers();" maxlength="20"/>
        <button id="artikelnummer_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Artikelnrs<span class="caret"></span></button>
        <ul id=artikelnummerbox class="dropdown-menu">
        </ul>
      </div>
        <div class="button-group">
            <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies lagen" onkeyup="demZoekLagenZoekString();" maxlength="25"/>
            <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Lagen<span class="caret"></span></button>
            <ul id=lagenbox class="dropdown-menu">
            </ul>
        </div>
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
<div id="eig_popup" style="display:none;z-index:1000;position:absolute;color:black;padding:10px;border:solid 2px #ddd;background:beige;text-align:center;">
                               <select id="eig_popup_list" name="eig_popup_list" size="2" onchange=geo_link(this); onfocus="$(this).css({'background-color': 'white'});">
                            </select>
</div>
<div id="eig_wait_popup" style="display:none;z-index:1001;position:absolute;color:black;padding:10px;border:solid 4px #3775BB;background:yellow;text-align:center;top:0.5%;left:80%;">
    <h style="font-weight:bold">Een ogenblik aub...</h>
</div>
<div id ="tijdslijn_control">
<div id="dem_tijdslijn"></div>
</div>
<div id="map" class="map">
</div>
<script language="javascript">
var  selGem = [];
var  selNm = [];
var  selVnm = [];
var  selArt = [];
var  selLg = [];

var firstOpenGem = true;
var firstOpenNm = true;
var firstOpenVnm = true;
var firstOpenArt = true;
var firstOpenLg = true;


     $(document).ready(function(){



     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
     
     $("#dem_toon_kaart").hide();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_reset").hide();
     $("#dem_toon_tijdlijn").hide();

    $('.familienaamTextBox').attr("placeholder","");
    $('.artTextBox').attr("placeholder","");
    $('.voornaamTextBox').attr("placeholder","");
    $('.woonplaatsTextBox').attr("placeholder","");

    hideTimeItems();
    demCheckStijlen(thema);
    demZoekLagen(thema);
    demZoekGemeenten();
    getMapStartup(thema);
    
  
    

//legende wordt ingevuld in demZoekLagen!!

$(document).on('click','#gemeentebox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#lagenbox').slideUp();
    
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

    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);

   demZoekArtikelnummersByGemeente();
   demZoekFamilienamenByGemeente();
   demZoekVoornamenByGemeente();
   $("#dem_toon_kaart").show();
   $("#dem_eig_reset").show();
   
   

        
   return false;
});

$(document).on('click','#familienaambox a',function(event){
    selNm = getCookie('selNm');
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#voornaambox').slideUp();
    $('#lagenbox').slideUp();
    
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
   demZoekArtikelnummers();
   demZoekVoornamen();
   return false;
});

$(document).on('click','#voornaambox a',function(event)
{
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#lagenbox').slideUp();
    
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
   demZoekArtikelnummers();
   demZoekFamilienamen();
   return false;
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();    
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    

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
    demZoekFamilienamen();
    demZoekVoornamen();
   return false;
});

$(document).on('click','.lagenTextbox',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();

    $(".lagenTextbox").val('').html();
    firstOpenLg = false;    
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


$(document).on('click','.gemeenteTextBox',function(event){
    $('#gemeentebox').slideToggle();
    $('#lagenbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();

        $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;
});

$(document).on('click','#gemeente_btn',function(event){
    $('#lagenbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});

$(document).on('click','.familienaamTextBox',function(event){
    $('#familienaambox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();
    $(".familienaamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#naam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();
    if (firstOpenNm == false) {
        $('#familienaambox').slideToggle();
    }
});

$(document).on('click','.voornaamTextBox',function(event){
    $('#voornaambox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
    $('#familienaambox').slideUp();
    $('#artikelnummerbox').slideUp();
    $(".voornaamTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#voornaam_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#lagenbox').slideUp();
    $('#artikelnummerbox').slideUp();    
    if (firstOpenVnm == false) {
        $('#voornaambox').slideToggle();
    }
});

$(document).on('click','.artTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#lagenbox').slideUp();
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
    if (firstOpenArt == false) {
        $('#artikelnummerbox').slideToggle();
    }
});

$(document).on('click','.lagenTextBox',function(event){
    $('#lagenbox').slideToggle();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp(); 
    $(".lagenTextBox").val('').html();
    firstOpenLg = false;
});

$(document).on('click','#eig_lagen_btn',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').slideUp();    
    if (firstOpenLg == false) {
        $('#lagenbox').slideToggle();
    }
});

$('#map').contextmenu(function(evt) {
  openLinkMenu(evt);
});
        
});

function hideLagenbox() {
   if (firstOpenLg == false) {
        $("#lagenbox").css('display','none');
    } else {
        $('#eig_lagen_btn').attr('aria-expanded','false');
    }
}

function resetMap(){
     $('#map').empty();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_eig_legend_chk").prop('checked', false);
    hideLagenbox();
}

function resetEigenaars()
{
resetMap();
     $("#dem_toon_kaart").hide();
     $("#dem_toon_tijdlijn").hide();
     $("#dem_eig_reset").hide();

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').empty();
    $('#gemeentebox').empty();
    $('#familienaambox').empty();
    $('#voornaambox').empty();
    $('#infobox').empty();
    
    selGem.splice(0,selGem.length);
    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);
    setCookie('selGem',selGem);
    setCookie('selLg',selLg);

    $('.familienaamTextBox').attr("placeholder","");
    $('.artTextBox').attr("placeholder","");
    $('.voornaamTextBox').attr("placeholder","");
    $('.woonplaatsTextBox').attr("placeholder","");

    tijdlijn = false
    demVerwijderTijdslijn();

     demZoekGemeenten();
     getMapStartup(thema);
}



function decodeHtml(html) {
 var txt = document.createElement("textarea");
 txt.innerHTML = html;
 return txt.value;
}

var mylegendeigenaarwindow = null;
/*
function eigenaars_beroep() {
 window.open("./eigenaars_beroep.php?thema="+thema+"_beroep","_self");
}
function eigenaars_beroepsgroepen() {
 window.open("./eigenaars_beroepsgroepen.php?thema="+thema,"_self");
}
function eigenaars_woonplaats() {
 window.open("./eigenaars_woonplaats.php?thema="+thema,"_self");
}
function eigenaars_statistieken() {
 window.open("./eigenaars_statistieken.php?thema="+thema,"_self");
}
*/


function getEigenaars() {

    $('#infobox').empty();
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();	
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


</script>
<?php include 'common/footer.php'; ?>
