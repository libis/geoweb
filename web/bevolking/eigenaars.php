<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapEigenaars.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">

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
      <h2>Kadastrale Eigenaar </h2>
      <div>
          <button id ="dem_toon_kaart" onclick="getEigenaars();">
              Toon kaart
          </button>
          <button id ="dem_eig_reset" onclick="resetEigenaars();">
              Reset
          </button>
      </div>
         
      <div id="multilayer">
      <div class="button-group">
        <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="demZoekGemeentenZoekString();" maxlength="20"/>
        <button id="eig_stat_gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id=gemeentebox class="dropdown-menu">
        </ul>
       </div>
      <div class="button-group">
        <input class="geotextbox familienaamTextBox" name="familienaambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamen();" maxlength="20"/>
        <button id="eig_stat_naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id=familienaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox voornaamTextBox" name="voornaambox" placeholder="Zoek voornaam" onkeyup="demZoekVoornamen();" maxlength="20"/>
        <button id="eig_stat_voornaam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id=voornaambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummers();" maxlength="20"/>
        <button id="eig_stat_artikelnummer_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id=artikelnummerbox class="dropdown-menu">
        </ul>
      </div>
          <div class="button-group">
              <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies lagen" onkeyup="demZoekLagenZoekString();" maxlength="25"/>
              <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
              <ul id=lagenbox class="dropdown-menu">
              </ul>
          </div>
      </div>
  </div>
</div>
<div id="map" class="map"></div>
 <script language="javascript">
var gem ="";
var art ="";
var vnm="";
var nm="";
var  selGem = [];
var  selNm = [];
var  selVnm = [];
var  selArt = [];
var  selLg = [];
var  selGemTmp = new Array();
var  selNmTmp = new Array();
var  selVnmTmp = new Array();
var  selArtTmp = new Array();
var firstOpenGem = true;
var firstOpenNm = true;
var firstOpenVnm = true;
var firstOpenArt = true;
var firstOpenLg = true;
     $(document).ready(function(){
         
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
     
     $("#dem_zoek_artikelnummer").hide();
     $("#dem_zoek_familenaam").hide();
     $("#dem_zoek_voornaam").hide();
     $("#dem_toon_kaart").hide();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_reset").hide();

     demZoekLagen();
     demZoekGemeenten();
     getMapStartup();

     var imag = '<img src="'+mapviewerIP+'/geoserver/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER=aezel:vw_minperceel0">';
     $("#legend-form").html(imag);
     
 /*    
function resetEig(){
    $("#dem_eig_legend_chk").hide();
    $("#eig_legende_spam").hide();
    $("#dem_eig_legend_chk").prop('checked', false);
}
*/     
     
     
$(document).on('click','.gemeenteTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    if (ln=selGem.length == 0) {
        selGem = selGemTmp;
    }
    selGemTmp.splice(0,selGemTmp.length);
    $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;    
});


$(document).on('click','#gemeentebox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
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
    selNmTmp.splice(0,selNm.length);
    selArtTmp.splice(0,selArt.length);
    selVnmTmp.splice(0,selVnm.length);

    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);

   demZoekArtikelnummersByGemeente(selGem);
   demZoekFamilienamenByGemeente(/*selGem*/);
   demZoekVoornamenByGemeente(selGem);
   $("#dem_toon_kaart").show();
   $("#dem_eig_reset").show();
   return false;
});

$(document).on('click','.familienaamTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#voornaambox').slideUp();
    if (ln=selNm.length == 0) {
        selNm = selNmTmp;
    }
    selNmTmp.splice(0,selNmTmp.length);
    $(".familienaamTextBox").val('').html();
    firstOpenNm = false;    
});
$(document).on('click','#familienaambox a',function(event){
    selNm = getCookie('selNm');
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#voornaambox').slideUp();
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
   demZoekArtikelnummers(selGem,selNm,selVnm,selArt);
   demZoekVoornamen(selGem,selNm,selVnm,selArt);
   return false;
});


$(document).on('click','.voornaamTextBox',function(event){
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    if (lv=selVnm.length == 0) {
        selVnm = selVnmTmp;
    }
    selVnmTmp.splice(0,selVnmTmp.length);
    $(".voornaamTextBox").val('').html();
    firstOpenVnm = false;    
});

$(document).on('click','#voornaambox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
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
   demZoekArtikelnummers(selGem,selNm,selVnm,selArt);
   demZoekFamilienamen(selGem,selNm,selVnm,selArt);
   return false;
});

$(document).on('click','.artTextBox',function(event){
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    if (la=selArt.length == 0) {
        selArt = selArtTmp;
    }
    selArtTmp.splice(0,selArtTmp.length);
    $(".artTextBox").val('').html();
    firstOpenArt = false;    
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();    
    $('#gemeentebox').slideUp();
    

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
    demZoekFamilienamen(selGem,selNm,selVnm,selArt);
    demZoekVoornamen(selGem,selNm,selVnm,selArt);
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


$(document).on('click','.gemeenteTextBox',function(event){
    $('#gemeentebox').slideToggle();
    $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;
});

$(document).on('click','#eig_stat_gemeente_btn',function(event){
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});

$(document).on('click','.familienaamTextBox',function(event){
    $('#familienaambox').slideToggle();
    $(".familienaamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#eig_stat_naam_btn',function(event){
    if (firstOpenNm == false) {
        $('#familienaambox').slideToggle();
    }
});

$(document).on('click','.voornaamTextBox',function(event){
    $('#voornaambox').slideToggle();
    $(".voornaamTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#eig_stat_voornaam_btn',function(event){
    if (firstOpenVnm == false) {
        $('#voornaambox').slideToggle();
    }
});

$(document).on('click','.artTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    $(".artTextBox").val('').html();
    firstOpenVnm = false;
});

$(document).on('click','#eig_stat_artikelnummer_btn',function(event){
    if (firstOpenVnm == false) {
        $('#artikelnummerbox').slideToggle();
    }
});

$(document).on('click','.lagenTextBox',function(event){
    $('#lagenbox').slideToggle();
    $(".lagenTextBox").val('').html();
    firstOpenLg = false;
});

$(document).on('click','#eig_lagen_btn',function(event){
    if (firstOpenLg == false) {
        $('#lagenbox').slideToggle();
    }
});

});



$('#dem_demeente').editableSelect({ effects: 'default' });
$('#dem_demeente').attr("placeholder","Kies een gemeente...");
$('#dem_gemeente_voornaam').editableSelect({ effects: 'default' });
$('#dem_gemeente_familienaam').editableSelect({ effects: 'default' });
$('#dem_gemeente_artikelnummer').editableSelect({ effects: 'default' });

$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
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
     $("#dem_eig_reset").hide();

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#familienaambox').slideUp();
    $('#voornaambox').slideUp();
    $('#artikelnummerbox').empty();
    $('#gemeentebox').empty();
    $('#familienaambox').empty();
    $('#voornaambox').empty();

    selGem.splice(0,selGem.length);
    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selVnm.splice(0,selVnm.length);
    selGemTmp.splice(0,selGem.length);
    selNmTmp.splice(0,selNm.length);
    selArtTmp.splice(0,selArt.length);
    selVnmTmp.splice(0,selVnm.length);
    
    setCookie('selArt',selArt);
    setCookie('selVnm',selVnm);
    setCookie('selNm',selNm);
    setCookie('selGem',selGem);

    $('.naamTextBox').attr("placeholder","Even geduld..");
    $('.artikelnummerTextBox').attr("placeholder","Even geduld..");
    $('.voornaamBox').attr("placeholder","Even geduld..");

     demZoekGemeenten();
     getMapStartup();

     var imag = '<img src="'+mapviewerIP+'/geoserver/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER=aezel:vw_minperceel0">';
     $("#legend-form").html(imag);
   
}



function decodeHtml(html) {
 var txt = document.createElement("textarea");
 txt.innerHTML = html;
 return txt.value;
}

var mylegendeigenaarwindow = null;

function eigenaars_beroep() {
 window.open("./eigenaars_beroep.php","_self");
}
function eigenaars_beroepsgroepen() {
 window.open("./eigenaars_beroepsgroepen.php","_self");
}
function eigenaars_woonplaats() {
 window.open("./eigenaars_woonplaats.php","_self");
}
function eigenaars_statistieken() {
 window.open("./eigenaars_statistieken.php","_self");
}

function getEigenaars(/*gem,nm,vnm,art,selLg*/) {


    $('#metadata-form').collapse('hide');
    $('#legend-form').collapse('hide');
    hideLagenbox();
    demGetEigenaars();
     $("#dem_eig_legend_chk").show();
     $("#eig_legende_spam").show();
    var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
    var bodyHeight = $(window).height();
    $("#map").height(bodyHeight-headerHeight);
}

</script>
<?php include 'common/footer.php'; ?>
