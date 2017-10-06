<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapToponiemen.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<div class="container-fluid">
<div style="margin-top: 10px;">
    <font size="6">Toponiemenen </font>
</div>
<div>
    <button id ="dem_toon_kaart" onclick="getToponiemen(gem,tpn);">
        Toon kaart
    </button>
    <button id ="dem_top_reset" onclick="resetToponiemen();">
        Reset
    </button>    
</div>
<div>
    <INPUT TYPE="checkbox" id="dem_top_legend_chk" NAME="eig_legende" VALUE="appel"><span id="eig_legende_spam">Legende</span>
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
     <label for="dem_gemeente_toponiemen">Beroep:</label>
  <div id="dem_gemeente_toponiemen" class="wrapper">
      <select id=toponiemenbox class="geoselect editableToponiemenBox">
      </select>
  </div>
     </div>
<div id="map" style= "height:600px; width:100%"></div>

 <script language="javascript">

var gem ="";
var tpn ="";
   $(document).ready(function(){
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

     $("#dem_zoek_top").hide();
     $("#dem_toon_kaart").hide();
     $("#dem_top_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_top_reset").hide();
     $('#dem_demeente').on('select.editable-select', function (e) {          
        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            gem = $inp.context.value;
            if ($(".toponiemenTextBox").val() !== "Kies een term...") {
                 resetToponiemen();
                 $("#dem_toon_kaart").show();
                 $("#dem_top_reset").show();
            }
        }
    });

     $('#dem_gemeente_toponiemen').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            tpn = $inp.context.value;
            getToponiemen(gem,tpn)
        }
     });

 });



$('#dem_demeente').editableSelect({ effects: 'default' });  
$('#dem_demeente').attr("placeholder","Kies een gemeente...");
$('#dem_gemeente_toponiemen').editableSelect({ effects: 'default' });  

$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
});

function resetMap(){
     $('#map').empty(); 
     $("#dem_top_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_top_legend_chk").prop('checked', false);
     sluitToponiemen();
}

function resetToponiemen() 
{
resetMap();
    $('#dem_gemeente_toponiemen').val('');
    $('#dem_gemeente_toponiemen').attr("placeholder","Even geduld...");

    demZoekToponiemenByGemeente(gem);
    tpn = "Alle toponiemen";
}



function decodeHtml(html) {
 var txt = document.createElement("textarea");
 txt.innerHTML = html;
 return txt.value;
}

$("#dem_top_legend_chk").click( function(){
   if( $(this).is(':checked') ) {
       getToponiemenLegende();
   } else {
       sluitToponiemen();
   }
});

var mylegendtoponiemenwindow = null;

function landschap_grondgebruik() {
 sluitToponiemen();
 window.open("./landschap_grondgebruik.php","_self");
}
function landschap_secties() {
 sluitToponiemen();
 window.open("./landschap_beroepsgroepen.php","_self");
}
function landschap_klasse() {
 sluitToponiemen();
 window.open("./landschap_woonplaats.php","_self");
}
function landschap_statistieken() {
 sluitToponiemen();
 window.open("./landschap_statistieken.php","_self");
}
function sluitToponiemen()
{
 if (mylegendtoponiemenwindow !== null){
 mylegendtoponiemenwindow.close();
 mylegendtoponiemenwindow = null;

 }
}

function getToponiemenLegende(){

    if (mylegendtoponiemenwindow !== null){
        mylegendtoponiemenwindow.focus();
        return;
    }
var url = mapviewerIP+"/geoserver/wms?Service=WMS&REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=50&HEIGHT=10&LAYER=aezel:vw_minperceel0";
var viewportwidth = document.documentElement.clientWidth;
var legendwidth;
var legendheight;
    
 $("<img/>",{
     load : function(){ legendwidth = this.width;
                         legendheight = this.height;
         var winpar = "scrollbars=yes,menubar=no,resizable=yes,top=300,left="+(viewportwidth-220)+",width="+legendwidth+",height="+legendheight+"";
         mylegendtoponiemenwindow = window.open(url,"_blank",winpar);
     },
     src  : url
 });
}
function getToponiemen(gem,tpn) {

if (mylegendtoponiemenwindow !== null){
 mylegendtoponiemenwindow.close();
 mylegendtoponiemenwindow = null;
}

//getMeta(url);
demGetToponiemen(gem,tpn);
     $("#dem_top_legend_chk").show();
     $("#eig_legende_spam").show();
}




</script>
<?php include 'common/footer.php'; ?>
