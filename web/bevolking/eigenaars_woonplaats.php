<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapWoonplaats.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<div class="legend">
          <div id="dem_eig_lege_chk" class="legend-top">
             <button data-toggle="collapse" data-target="#legend-form"><span>Legende</span></button>
          </div>       
          <div id="legend-form" class="collapse">
          </div>            
</div>
<div class="metadata">
          <div id="dem_eig_lege_metadata" class="metadata-top">
             <button data-toggle="collapse" data-target="#metadata-form"><span>Metadata</span></button>
          </div>       
          <div id="metadata-form" class="collapse">
            <div id="infobox" style="display:none" ></div>          
          </div>            
</div> 
<div class="control">
  <div class="control-top">
     <button data-toggle="collapse" data-target="#control-form"><span>Menu</span></button>
  </div>
  <div id="control-form" class="collapse">
    <h2>Woonplaats Eigenaar </h2>

<div>
    <button id ="dem_toon_kaart" onclick="getEigenaarsWoonplaats(gem,nm,vnm,art,wpl,selLg);">
        Toon kaart
    </button>
    <button id ="dem_eig_reset" onclick="resetEigenaarsWoonplaats();">
        Reset
    </button>
</div>
<div>
    <INPUT TYPE="checkbox" id="dem_eig_legend_chk" NAME="eig_legende" VALUE="appel"><span id="eig_legende_spam">Legende</span>
</div>
 <div>
    <label for="dem_gemeente" class="keuzelijstlabel">Gemeente:</label>
    <div id="dem_demeente" class="wrapper" >
        <select placeholder="Zoek thuisgemeente"  id=gemeentebox class="geoselect editableEigenaarBox">
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
    <div>
     <label for="dem_gemeente_woonplaats">Woonplaats:</label>
  <div id="dem_gemeente_woonplaats" class="wrapper">
      <select id=woonplaatsbox class="geoselect editableWoonplaatsBox">
      </select>
  </div>
  </div>
    <div>
     <label for="dem_gemeente_familienaam">Naam:</label>
  <div id="dem_gemeente_familienaam" class="wrapper">
      <select id=familienaambox class="geoselect editableFamilienaamBox">
      </select>
  </div>
  </div>
  <div>
     <label for="dem_gemeente_voornaam">Voornaam:</label>
  <div id="dem_gemeente_voornaam" class="wrapper">
      <select id=voornaambox class="geoselect editableVoornaamBox">
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
      <div id="multilayer">
          <div class="button-group">
              <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies lagen" onkeyup="demZoekLagenZoekString(selLg);" maxlength="25"/>
              <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">lagen<span class="caret"></span></button>
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
var wpl="";
var selLg=[];

   $(document).ready(function(){
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

     $("#dem_zoek_woonplaats").hide();
     $("#dem_zoek_artikelnummer").hide();
     $("#dem_zoek_familenaam").hide();
     $("#dem_zoek_voornaam").hide();
     $("#dem_toon_kaart").hide();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_reset").hide();
     
     demZoekLagen();
     
     var imag = '<img src="'+mapviewerIP+'/geoserver/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER=aezel:vw_minperceel0">';
     $("#legend-form").html(imag);     
     
     $('#dem_demeente').on('select.editable-select', function (e) {
        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            gem = $inp.context.value;
            if ($(".eigenaarTextBox").val() !== "Kies een term...") {
                 resetEigenaarsWoonplaats();
                 $("#dem_toon_kaart").show();
                 $("#dem_eig_reset").show();
            }
        }
    });

     $('#dem_gemeente_woonplaats').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            wpl = $inp.context.value;

            if (($('#dem_gemeente_familienaam').val() === "Alle namen") || ($('#dem_gemeente_familienaam').val() === "")) {
                    demZoekFamilienamenWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_artikelnummer').val() === "Alle artikelnummers") || ($('#dem_gemeente_artikelnummer').val() === "")) {
                    demZoekArtikelnummersWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_voornaam').val() === "Alle voornamen") || ($('#dem_gemeente_voornaam').val() === "")){
                    demZoekVoornamenWoonplaats(gem,nm,vnm,art,wpl);
            }

        }

     });
     $('#dem_gemeente_voornaam').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            vnm = $inp.context.value;

            if (($('#dem_gemeente_familienaam').val() === "Alle namen") || ($('#dem_gemeente_familienaam').val() === "")) {
                    demZoekFamilienamenWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_artikelnummer').val() === "Alle artikelnummers") || ($('#dem_gemeente_artikelnummer').val() === "")) {
                    demZoekArtikelnummersWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_woonplaats').val() === "Alle woonplaatsen") || ($('#dem_gemeente_woonplaats').val() === "")) {
                    demZoekWoonplaatsen(gem,nm,vnm,art,wpl);
            }
        }
     });

     $('#dem_gemeente_familienaam').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            nm = $inp.context.value;
            if (($('#dem_gemeente_artikelnummer').val() === "Alle artikelnummers") || ($('#dem_gemeente_artikelnummer').val() === "")) {
                    demZoekArtikelnummersWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_voornaam').val() === "Alle voornamen") || ($('#dem_gemeente_voornaam').val() === "")){
                    demZoekVoornamenWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_woonplaats').val() === "Alle woonplaatsen") || ($('#dem_gemeente_woonplaats').val() === "")) {
                    demZoekWoonplaatsen(gem,nm,vnm,art,wpl);
            }        }
     });

     $('#dem_gemeente_artikelnummer').on('select.editable-select', function (e) {
        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            art = $inp.context.value;
            if (($('#dem_gemeente_familienaam').val() === "Alle namen") || ($('#dem_gemeente_familienaam').val() === "")) {
                    demZoekFamilienamenWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_voornaam').val() === "Alle voornamen") || ($('#dem_gemeente_voornaam').val() === "")){
                    demZoekVoornamenWoonplaats(gem,nm,vnm,art,wpl);
            }
            if (($('#dem_gemeente_woonplaats').val() === "Alle woonplaatsen") || ($('#dem_gemeente_woonplaats').val() === "")) {
                    demZoekWoonplaatsen(gem,nm,vnm,art,wpl);
            }
        }
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
$('#dem_gemeente_woonplaats').editableSelect({ effects: 'default' });
$('#dem_gemeente_voornaam').editableSelect({ effects: 'default' });
$('#dem_gemeente_familienaam').editableSelect({ effects: 'default' });
$('#dem_gemeente_artikelnummer').editableSelect({ effects: 'default' });

$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
});

function resetMap(){
     $('#map').empty();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_eig_legend_chk").prop('checked', false);
     $("#lagenbox").css('display','none');
}

function resetEigenaarsWoonplaats()
{
resetMap();
$('#dem_gemeente_woonplaats').val('');
$('#dem_gemeente_voornaam').val('');
$('#dem_gemeente_familienaam').val('');
$('#dem_gemeente_artikelnummer').val('');

        $('#dem_gemeente_woonplaats').attr("placeholder","Even geduld...");
        $('#dem_gemeente_voornaam').attr("placeholder","Even geduld...");
        $('#dem_gemeente_familienaam').attr("placeholder","Even geduld...");
        $('#dem_gemeente_artikelnummer').attr("placeholder","Even geduld..");

    demZoekWoonplaatsenByGemeente(gem);
    demZoekArtikelnummersByGemeente(gem);
    demZoekFamilienamenByGemeente(gem);
    demZoekVoornamenByGemeente(gem);
                 wpl = "Alle woonplaatsen";
                 art = "Alle artikelnummers";
                 vnm = "Alle voornamen";
                 nm = "Alle namen";
}



function decodeHtml(html) {
 var txt = document.createElement("textarea");
 txt.innerHTML = html;
 return txt.value;
}

function eigenaars() {
    window.open("./eigenaars.php","_self");
}
function eigenaars_beroepsgroepen() {
    window.open("./eigenaars_beroepsgroepen.php","_self");
}
function eigenaars_beroep() {
    window.open("./eigenaars_beroep.php","_self");
}
function eigenaars_statistieken() {
    window.open("./eigenaars_statistieken.php","_self");
}


function getEigenaarsWoonplaats(gem,nm,vnm,art,wpl,selLg) {

demGetEigenaarsWoonplaats(gem,nm,vnm,art,wpl,selLg);
    $('#metadata-form').collapse('hide');
    $('#legend-form').collapse('hide');
    $("#lagenbox").css('display','none');
     $("#dem_eig_legend_chk").show();
     $("#eig_legende_spam").show();
    var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
    var bodyHeight = $(window).height();     
    $("#map").height(bodyHeight-headerHeight);         
}




</script>
<?php include 'common/footer.php'; ?>
