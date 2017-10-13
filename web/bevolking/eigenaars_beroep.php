<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapBeroep.js"></script>
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
     <button data-toggle="collapse" data-target="#control-form"><span>Menu</span></button>
  </div>
  <div id="control-form" class="collapse in">
    <h2>Beroep Eigenaar </h2>
    <div>
        <button id ="dem_toon_kaart" onclick="getEigenaarsBeroep(gem,nm,vnm,art,brp,selLg);">
            Toon kaart
        </button>
        <button id ="dem_eig_reset" onclick="resetEigenaarsBeroep();">
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
    <label for="dem_gemeente_beroep">Beroep:</label>
    <div id="dem_gemeente_beroep" class="wrapper">
        <select id=beroepbox class="geoselect editableBeroepBox">
        </select>
    </div>
    <div>
      <label for="dem_gemeente_familienaam">Naam:</label>
      <div id="dem_gemeente_familienaam" class="wrapper">
          <select id=familienaambox class="geoselect editableFamilienaamBox">
          </select>
      </div>
    </div>
    <div>
      <div>
         <label for="dem_gemeente_voornaam">Voornaam:</label>
         <div id="dem_gemeente_voornaam" class="wrapper">
            <select id=voornaambox class="geoselect editableVoornaamBox">
            </select>
          </div>
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
var brp="";
var selLg=[];
var firstOpenLg = true;

   $(document).ready(function(){
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

     $("#dem_zoek_beroep").hide();
     $("#dem_zoek_artikelnummer").hide();
     $("#dem_zoek_familenaam").hide();
     $("#dem_zoek_voornaam").hide();
     $("#dem_toon_kaart").hide();
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_reset").hide();
     
     demZoekLagen();
     
     var imag = '<img src="'+mapviewerIP+'/geoserver/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER=aezel:vw_minperceel">';
     $("#legend-form").html(imag);
     
     $('#dem_demeente').on('select.editable-select', function (e) {
        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            gem = $inp.context.value;
            if ($(".eigenaarTextBox").val() !== "Kies een term...") {
                 resetEigenaarsBeroep();
                 $("#dem_toon_kaart").show();
                 $("#dem_eig_reset").show();
            }
        }
    });

     $('#dem_gemeente_beroep').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            brp = $inp.context.value;

            if (($('#dem_gemeente_familienaam').val() === "Alle namen") || ($('#dem_gemeente_familienaam').val() === "")) {
                    demZoekFamilienamenBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_artikelnummer').val() === "Alle artikelnummers") || ($('#dem_gemeente_artikelnummer').val() === "")) {
                    demZoekArtikelnummersBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_voornaam').val() === "Alle voornamen") || ($('#dem_gemeente_voornaam').val() === "")){
                    demZoekVoornamenBeroep(gem,nm,vnm,art,brp);
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
                    demZoekFamilienamenBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_artikelnummer').val() === "Alle artikelnummers") || ($('#dem_gemeente_artikelnummer').val() === "")) {
                    demZoekArtikelnummersBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_beroep').val() === "Alle beroepen") || ($('#dem_gemeente_beroep').val() === "")) {
                    demZoekBeroepen(gem,nm,vnm,art,brp);
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
                    demZoekArtikelnummersBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_voornaam').val() === "Alle voornamen") || ($('#dem_gemeente_voornaam').val() === "")){
                    demZoekVoornamenBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_beroep').val() === "Alle beroepen") || ($('#dem_gemeente_beroep').val() === "")) {
                    demZoekBeroepen(gem,nm,vnm,art,brp);
            }        }
     });

     $('#dem_gemeente_artikelnummer').on('select.editable-select', function (e) {
        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            art = $inp.context.value;
            if (($('#dem_gemeente_familienaam').val() === "Alle namen") || ($('#dem_gemeente_familienaam').val() === "")) {
                    demZoekFamilienamenBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_voornaam').val() === "Alle voornamen") || ($('#dem_gemeente_voornaam').val() === "")){
                    demZoekVoornamenBeroep(gem,nm,vnm,art,brp);
            }
            if (($('#dem_gemeente_beroep').val() === "Alle beroepen") || ($('#dem_gemeente_beroep').val() === "")) {
                    demZoekBeroepen(gem,nm,vnm,art,brp);
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
$('#dem_gemeente_beroep').editableSelect({ effects: 'default' });
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

function resetEigenaarsBeroep()
{
    resetMap();
    $('#dem_gemeente_beroep').val('');
    $('#dem_gemeente_voornaam').val('');
    $('#dem_gemeente_familienaam').val('');
    $('#dem_gemeente_artikelnummer').val('');

    $('#dem_gemeente_beroep').attr("placeholder","Even geduld...");
    $('#dem_gemeente_voornaam').attr("placeholder","Even geduld...");
    $('#dem_gemeente_familienaam').attr("placeholder","Even geduld...");
    $('#dem_gemeente_artikelnummer').attr("placeholder","Even geduld..");

    demZoekBeroepenByGemeente(gem);
    demZoekArtikelnummersByGemeente(gem);
    demZoekFamilienamenByGemeente(gem);
    demZoekVoornamenByGemeente(gem);

    brp = "Alle beroepen";
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
function eigenaars_woonplaats() {
    window.open("./eigenaars_woonplaats.php","_self");
}
function eigenaars_statistieken() {
    window.open("./eigenaars_statistieken.php","_self");
}

function getEigenaarsBeroep(gem,nm,vnm,art,brp,selLg) {

demGetEigenaarsBeroep(gem,nm,vnm,art,brp,selLg);
    $('#metadata-form').collapse('hide');
    $('#legend-form').collapse('hide');
    hideLagenbox();
    $("#dem_eig_legend_chk").show();
    $("#eig_legende_spam").show();
    var headerHeight = $('nav.navbar.navbar-toggleable-md.navbar-default').height();
    var bodyHeight = $(window).height();     
    $("#map").height(bodyHeight-headerHeight);    
}

</script>
<?php include 'common/footer.php'; ?>
