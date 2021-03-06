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
        <div class="button-group">
          <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="demZoekGemeente();" maxlength="20"/>
          <button id="gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Gemeente<span class="caret"></span></button>
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
        <input class="geotextbox naamTextBox" name="naambox" placeholder="Zoek naam" onkeyup="demZoekFamilienamenStat();" maxlength="20"/>
        <button id="naam_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Namen<span class="caret"></span></button>
        <ul id=naambox class="dropdown-menu">
        </ul>
      </div>
      <div class="button-group">
        <input class="geotextbox artikelnummerTextBox" name="artikelnummerbox" placeholder="Zoek artikelnummer" onkeyup="demZoekArtikelnummersStat();" maxlength="20"/>
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
            <div id="myPieGemChart" style="border: 1px solid #ccc"/>
        </td>
        <td>
            <div id="myPieChart" style="border: 1px solid #ccc"/>
        </td>
      </tr>
    </tbody>
  </table>
</div>
  <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart']});
//      google.charts.load('current', {packages:['bar']});
      
    function setHeightChart() {
        var menuHeight = $('.container-fluid.control-stats').height();
        var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
        var bodyHeight = $(window).height(); 
        var barHeight = bodyHeight-headerHeight-menuHeight-10;
        $("#myPieChart").height(barHeight);
        $("#myPieGemChart").height(barHeight);
    }
      function drawChart() {
         setHeightChart(); 
         $('#gemeentebox').slideUp();
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezitters();
         demZoekStatGrondbezittersPerGem();
//         demZoekStatBarGrondbezitters();
      }
      function drawChartBeroep() {
         setHeightChart(); 
         $('#gemeentebox').slideUp();
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersBeroep();
         demZoekStatGrondbezittersBeroepPerGem();
//         demZoekStatBarGrondbezittersBeroep();
      }
      function drawChartBeroepsgroep() {
         setHeightChart(); 
         $('#gemeentebox').slideUp();
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersBeroepsgroep();
         demZoekStatGrondbezittersBeroepsgroepPerGem();
//         demZoekStatBarGrondbezittersBeroepsgroep();
      }
      function drawChartWoonplaats() {
         setHeightChart(); 
         $('#gemeentebox').slideUp();
         $('#naambox').slideUp();
         $('#artikelnummerbox').slideUp();
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezittersWoonplaats();
         demZoekStatGrondbezittersWoonplaatsPerGem();
//         demZoekStatBarGrondbezittersWoonplaats();
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
     
         demZoekLagen(thema,'statistieken');

  });

function resetStatistieken()
{
    
    resetStat();
    
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#naambox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
    
    $('#artikelnummerbox').empty();
    $('#gemeentebox').empty();
    $('#naambox').empty();
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
    
    $('.naamTextBox').attr("placeholder","");
    $('.artikelnummerTextBox').attr("placeholder","");
    $('.beroepTextBox').attr("placeholder","");
    $('.woonplaatsTextBox').attr("placeholder","");
    $('.beroepsgroepTextBox').attr("placeholder","");

     demZoekgemeente();
    

}

function resetStat(){
    $('#myPieChart').empty();
    $('#myPieGemChart').empty();
    $("#dem_eig_legend_chk").hide();
    $("#eig_legende_spam").hide();
    $("#dem_eig_legend_chk").prop('checked', false);
    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#naambox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
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
function eigenaars_beroep() {
  window.open("./eigenaars_beroep.php?thema="+thema+"_beroep","_self");
}
function eigenaars_woonplaats() {
  window.open("./eigenaars_woonplaats.php?thema="+thema,"_self");
}
function eigenaars_beroepsgroepen() {
  window.open("./eigenaars_beroepsgroepen.php?thema="+thema,"_self");
}
*/
$(document).on('click','#gemeente_btn',function(event){
    $('#naambox').slideUp();
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
        $('#naambox').slideToggle();
    }
});
$(document).on('click','.naamTextBox',function(event){
    $('#naambox').slideToggle();
    $('#artikelnummerbox').slideUp();
    $(".naamTextBox").val('').html();
    firstOpenNm = false;
});

$(document).on('click','#artikelnummer_btn',function(event){
    $('#naambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#beroepbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    $('#woonplaatsbox').slideUp();     
    if (firstOpenArt == false) {
        $('#artikelnummerbox').slideToggle();
    }
});
$(document).on('click','.artikelnummerTextBox',function(event){
    $('#artikelnummerbox').slideToggle();
    $('#naambox').slideUp();
    $(".artikelnummerTextBox").val('').html();
    firstOpenArt = false;
});

$(document).on('click','#woonplaats_btn',function(event){
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#naambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();    
    if (firstOpenWpl == false) {
        $('#woonplaatsbox').slideToggle();
    }
});
$(document).on('click','.woonplaatsTextBox',function(event){
    $('#woonplaatsbox').slideToggle();
    $('#beroepbox').slideUp();    
    $('#beroepsgroepbox').slideUp();    
    $(".woonplaatsTextBox").val('').html();
    firstOpenWpl = false;
});

$(document).on('click','#beroep_btn',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#naambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();  
    if (firstOpenBrp == false) {
        $('#beroepbox').slideToggle();
    }
});
$(document).on('click','.beroepTextBox',function(event){
    $('#beroepbox').slideToggle();
    $('#beroepsgroepbox').slideUp();    
    $('#woonplaatsbox').slideUp();  
    $(".beroepTextBox").val('').html();
    firstOpenBrp = false;
});

$(document).on('click','#beroepsgroep_btn',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    $('#naambox').slideUp();
    $('#gemeentebox').slideUp();
    $('#artikelnummerbox').slideUp();      
    if (firstOpenBgp == false) {
        $('#beroepsgroepbox').slideToggle();
    }
});

$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#beroepsgroepbox').slideToggle();
    $('#beroepbox').slideUp();
    $('#woonplaatsbox').slideUp();

    $(".beroepsgroepTextBox").val('').html();
    firstOpenBgp = false;    
});

$(document).on('click','#gemeentebox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#naambox').slideUp();
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
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      selGem.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
    $('.naamTextBox').attr("placeholder","Even geduld..");
    $('.artikelnummerTextBox').attr("placeholder","Even geduld..");
    $('.beroepTextBox').attr("placeholder","Even geduld..");
    $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");
    $('.woonplaatsTextBox').attr("placeholder","Even geduld..");

    selNm.splice(0,selNm.length);
    selArt.splice(0,selArt.length);
    selBgp.splice(0,selBgp.length);
    selWpl.splice(0,selWpl.length);
    selBrp.splice(0,selBrp.length);

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
    $('#naambox').slideUp();
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
      /*
      if (href.trim() == 'Alle woonplaatsen') {
          selWpl.splice(0,selWpl.length);
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
      */
   } else {
       /*
      if (href.trim() == 'Alle woonplaatsen') {
           selWpl.splice(0,selWpl.length);
           $( "#woonplaatsbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }
     */
      selWpl.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekFamilienamenStat();
   demZoekBeroepsgroepenStat();
   demZoekBeroepenStat();
   return false;
});

$(document).on('click','#beroepbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#naambox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBrp.indexOf( href.trim()))  > -1 ) {
      selBrp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      /*
      if (href.trim() == 'Alle beroepen') {
          selBrp.splice(0,selBrp.length);
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
      */
   } else {
       /*
      if (href.trim() == 'Alle beroepen') {
           selBrp.splice(0,selBrp.length);
           $( "#beroepbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }
*/
      selBrp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekFamilienamenStat();
   demZoekBeroepsgroepenStat();
   demZoekWoonplaatsenStat();
   return false;
});

$(document).on('click','#beroepsgroepbox a',function(event){

    $('#artikelnummerbox').slideUp();
    $('#gemeentebox').slideUp();
    $('#naambox').slideUp();
    $('#beroepbox').slideUp();
    $('#woonplaatsbox').slideUp();
    
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBgp.indexOf( href.trim()))  > -1 ) {
      selBgp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      /*
      if (href.trim() == 'Alle beroepsgroepen') {
          selBgp.splice(0,selBgp.length);
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
      */
   } else {
       /*
      if (href.trim() == 'Alle beroepspsgroepen') {
           selBgp.splice(0,selBgp.length);
           $( "#beroepsgroepbox a" ).each(function( index ) {
           $(this).find('input').prop('checked',false);
         });
     }
*/
      selBgp.push(href.trim());

      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekFamilienamenStat();
   demZoekBeroepenStat();
   demZoekWoonplaatsenStat();
   return false;
});

$(document).on('click','#naambox a',function(event){
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
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      /*
      if (href.trim() == 'Alle namen') {
            selNm.splice(0,selNm.length);
         $( "#naambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
      */
   } else {
       /*
      if (href.trim() == 'Alle namen') {
            selNm.splice(0,selNm.length);
         $( "#naambox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }
     */

      selNm.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekArtikelnummersStat();
   demZoekWoonplaatsenStat();
   demZoekBeroepenStat();
   demZoekBeroepsgroepenStat();
   return false;
});

$(document).on('click','#artikelnummerbox a',function(event){

    $('#naambox').slideUp();
    $('#woonplaatsbox').slideUp();
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
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      /*
      if (href.trim() == 'Alle artikelnummers') {
          selArt.splice(0,selArt.length);
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
      }
      */
   } else {
       /*
      if (href.trim() == 'Alle artikelnummers') {
         selArt.splice(0,selArt.length);
         $( "#artikelnummerbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });
     }
    */
    selArt.push(href.trim());
    setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
    demZoekFamilienamenStat();
    demZoekBeroepenStat();
    demZoekBeroepsgroepenStat();
    demZoekWoonplaatsenStat();
   return false;
});
</script>

<?php include 'common/footer.php'; ?>
