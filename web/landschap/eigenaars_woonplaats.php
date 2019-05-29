<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapWoonplaats.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<div class="container-fluid">
<div style="margin-top: 10px;">
    <font size="6">Woonplaats Eigenaar </font>
</div>
<div>
    <button id ="dem_toon_kaart" onclick="getEigenaarsWoonplaats(gem,nm,vnm,art,wpl);">
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
</div>
<div id="map" style= "height:600px; width:100%"></div>

 <script language="javascript">

var gem ="";
var art ="";
var vnm="";
var nm="";
var wpl="";
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
     sluitEigenaarsWoonplaats();
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

    demZoekWoonplaatsenByGemeente();
    demZoekArtikelnummersByGemeente();
    demZoekFamilienamenByGemeente();
    demZoekVoornamenByGemeente();
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

$("#dem_eig_legend_chk").click( function(){
   if( $(this).is(':checked') ) {
       getEignaarsLegende();
   } else {
       sluitEigenaarsWoonplaats();
   }
});

var mylegendwoonplaatswindow = null;

function eigenaars() {
    sluitEigenaarsWoonplaats();
    window.open("./eigenaars.php","_self");
}
function eigenaars_beroepsgroepen() {
    sluitEigenaarsWoonplaats();
    window.open("./eigenaars_beroepsgroepen.php","_self");
}
function eigenaars_beroep() {
    sluitEigenaarsWoonplaats();
    window.open("./eigenaars_beroep.php","_self");
}
function eigenaars_statistieken() {
    sluitEigenaarsWoonplaats();
    window.open("./eigenaars_statistieken.php","_self");
}
function sluitEigenaarsWoonplaats()
{
    if (mylegendwoonplaatswindow !== null){
    mylegendwoonplaatswindow.close();
    mylegendwoonplaatswindow = null;
   
    }
}

function getEignaarsLegende(){

    if (mylegendwoonplaatswindow !== null){
        mylegendwoonplaatswindow.focus();
        return;
    }
var url =  mapviewerIP+"/geoserver/wms?Service=WMS&REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=55&HEIGHT=15&LAYER=aezel:vw_minperceel0";
var viewportwidth = document.documentElement.clientWidth;
var legendwidth;
var legendheight;
    
 $("<img/>",{
     load : function(){ legendwidth = this.width;
                         legendheight = this.height;
         var winpar = "scrollbars=yes,menubar=no,resizable=yes,top=300,left="+(viewportwidth-220)+",width="+legendwidth+",height="+legendheight+"";
         mylegendwoonplaatswindow = window.open(url,"_blank",winpar);
     },
     src  : url
 });
}
function getEigenaarsWoonplaats(gem,nm,vnm,art,wpl) {

if (mylegendwoonplaatswindow !== null){
 mylegendwoonplaatswindow.close();
 mylegendwoonplaatswindow = null;
}
demGetEigenaarsWoonplaats(gem,nm,vnm,art,wpl);
     $("#dem_eig_legend_chk").show();
     $("#eig_legende_spam").show();
}




</script>
<?php include 'common/footer.php'; ?>
