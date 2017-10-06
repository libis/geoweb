<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapBeroep.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<div class="container-fluid">
<div style="margin-top: 10px;">
    <font size="6">Beroep Eigenaar </font>
</div>
<div>
    <button id ="dem_toon_kaart" onclick="getEigenaarsBeroep(gem,nm,vnm,art,brp);">
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
  </div>


<div id="map" class="map"></div>

 <script language="javascript">

var gem ="";
var art ="";
var vnm="";
var nm="";
var brp="";
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

function resetMap(){
     $('#map').empty(); 
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_eig_legend_chk").prop('checked', false);
     sluitEigenaarsBeroep();
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

$("#dem_eig_legend_chk").click( function(){
   if( $(this).is(':checked') ) {
       getEignaarsLegende();
   } else {
       sluitEigenaarsBeroep();
   }
});

var mylegendberoepwindow = null;

function eigenaars() {
    sluitEigenaarsBeroep();
    window.open("./eigenaars.php","_self");
}
function eigenaars_beroepsgroepen() {
    sluitEigenaarsBeroep();
    window.open("./eigenaars_beroepsgroepen.php","_self");
}
function eigenaars_woonplaats() {
    sluitEigenaarsBeroep();
    window.open("./eigenaars_woonplaats.php","_self");
}
function eigenaars_statistieken() {
    sluitEigenaarsBeroep();
    window.open("./eigenaars_statistieken.php","_self");
}
function sluitEigenaarsBeroep()
{
    if (mylegendberoepwindow !== null){
    mylegendberoepwindow.close();
    mylegendberoepwindow = null;
    }
    if (mywindow != null) {
    mywindow.close();
    mywindow = null;
    }
}

function getEignaarsLegende(){

    if (mylegendberoepwindow !== null){
        mylegendberoepwindow.focus();
        return;
    }
var url =  mapviewerIP+"/geoserver/wms?Service=WMS&REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=55&HEIGHT=15&LAYER=aezel:vw_minperceel";
var viewportwidth = document.documentElement.clientWidth;
var legendwidth;
var legendheight;
    
 $("<img/>",{
     load : function(){ legendwidth = this.width;
                         legendheight = this.height;
         var winpar = "scrollbars=yes,menubar=no,resizable=yes,top=300,left="+(viewportwidth-220)+",width="+legendwidth+",height="+legendheight+"";
         mylegendberoepwindow = window.open(url,"_blank",winpar);
     },
     src  : url
 });
}
function getEigenaarsBeroep(gem,nm,vnm,art,brp) {

if (mylegendberoepwindow !== null){
 mylegendberoepwindow.close();
 mylegendberoepwindow = null;
}

//getMeta(url);
demGetEigenaarsBeroep(gem,nm,vnm,art,brp);
     $("#dem_eig_legend_chk").show();
     $("#eig_legende_spam").show();
}




</script>
<?php include 'common/footer.php'; ?>
