<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapGrondgebruik.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<div class="container-fluid">
<div style="margin-top: 10px;">
    <font size="6">Grondgebruik</font>
</div>
<div>
    <button id ="dem_toon_kaart" onclick="getGrondgebruik(gem,ggb);">
        Toon kaart
    </button>
    <button id ="dem_ggb_reset" onclick="resetGrondgebruik();">
        Reset
    </button>    
</div>
<div>
    <INPUT TYPE="checkbox" id="dem_ggb_legend_chk" NAME="eig_legende" VALUE="appel"><span id="eig_legende_spam">Legende</span>
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
     <label for="dem_gemeente_grondgebruik">Beroep:</label>
  <div id="dem_gemeente_grondgebruik" class="wrapper">
      <select id=grondgebruikbox class="geoselect editableGrondgebruikBox">
      </select>
  </div>
     </div>
<div id="map" style= "height:600px; width:100%"></div>

 <script language="javascript">

var gem ="";
var ggb ="";
   $(document).ready(function(){
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

     $("#dem_zoek_ggb").hide();
     $("#dem_toon_kaart").hide();
     $("#dem_ggb_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_ggb_reset").hide();
     $('#dem_demeente').on('select.editable-select', function (e) {          
        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            gem = $inp.context.value;
            if ($(".grondgebruikTextBox").val() !== "Kies een term...") {
                 resetGrondgebruik();
                 $("#dem_toon_kaart").show();
                 $("#dem_ggb_reset").show();
            }
        }
    });

     $('#dem_gemeente_grondgebruik').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetMap();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            ggb = $inp.context.value;
            getGrondgebruik(gem,ggb)
        }
     });

 });



$('#dem_demeente').editableSelect({ effects: 'default' });  
$('#dem_demeente').attr("placeholder","Kies een gemeente...");
$('#dem_gemeente_grondgebruik').editableSelect({ effects: 'default' });  

$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
});

function resetMap(){
     $('#map').empty(); 
     $("#dem_ggb_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $( "#dem_ggb_legend_chk").prop('checked', false);
     sluitGrondgebruik();
}

function resetGrondgebruik() 
{
resetMap();
    $('#dem_gemeente_grondgebruik').val('');
    $('#dem_gemeente_grondgebruik').attr("placeholder","Even geduld...");

    demZoekGrondgebruikByGemeente(gem);
    ggb = "Alle grondgebruik";
}



function decodeHtml(html) {
 var txt = document.createElement("textarea");
 txt.innerHTML = html;
 return txt.value;
}

$("#dem_ggb_legend_chk").click( function(){
   if( $(this).is(':checked') ) {
       getGrondgebruikLegende();
   } else {
       sluitGrondgebruik();
   }
});

var mylegendgrondgebruikwindow = null;

function landschap_toponiemen() {
 sluitGrondgebruik();
 window.open("./landschap_toponiemen.php","_self");
}
function landschap_secties() {
 sluitGrondgebruik();
 window.open("./landschap_beroepsgroepen.php","_self");
}
function landschap_klasse() {
 sluitGrondgebruik();
 window.open("./landschap_woonplaats.php","_self");
}
function landschap_statistieken() {
 sluitGrondgebruik();
 window.open("./landschap_statistieken.php","_self");
}
function sluitGrondgebruik()
{
 if (mylegendgrondgebruikwindow !== null){
 mylegendgrondgebruikwindow.close();
 mylegendgrondgebruikwindow = null;

 }
}

function getGrondgebruikLegende(){

    if (mylegendgrondgebruikwindow !== null){
        mylegendgrondgebruikwindow.focus();
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
         mylegendgrondgebruikwindow = window.open(url,"_blank",winpar);
     },
     src  : url
 });
}
function getGrondgebruik(gem,ggb) {

if (mylegendgrondgebruikwindow !== null){
 mylegendgrondgebruikwindow.close();
 mylegendgrondgebruikwindow = null;
}

//getMeta(url);
demGetGrondgebruik(gem,ggb);
     $("#dem_ggb_legend_chk").show();
     $("#eig_legende_spam").show();
}




</script>
<?php include 'common/footer.php'; ?>
