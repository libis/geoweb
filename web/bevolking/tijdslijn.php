<?php include 'common/header.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapEigenaars.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>
<script type="text/javascript" src="../js/tijdslijn.js"></script>
<script type="text/javascript" src="../js/mapTijdslijn.js"></script>
<script type="text/javascript" src="../js/jquery.timeliny.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery.timeliny.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="control">
  <div class="control-top">
     <button data-toggle="collapse" data-target="#control-form" ><span>Menu</span></button>
  </div>
  <div id="control-form" class="collapse in" >
      <h2>Kadastrale Eigenaar </h2>
      <div>
          <div>
            <button id ="dem_toon_kaart" onclick="tijdsloop();">
                Toon tijdlijn
            </button>
          </div>
          <div id = "dem_player" class="dem_player">
            <button id ="dem_film_fr" onclick="frSlideshow();" <i class="material-icons">
fast_rewind
</i>                                        
          </button>                   
<!--              
            <button id ="dem_film" class='button'>
            </button>
-->
<button id ="dem_film_stop" onclick="stopSlideshow();" <i class="material-icons">stop</i>                                        
          </button>              
<button id ="dem_film_pause" onclick="pauseSlideshow();"<i class="material-icons">pause</i>                                        
          </button>              
            </button>
            <button id ="dem_film_play" onclick="playSlideshow();" <i class="material-icons">
play_arrow
</i>                                        
          </button>              
            <button id ="dem_film_ff"  onclick="ffSlideshow();"<i class="material-icons">
fast_forward
</i>                                        
          </button>             
          </div>
          <div id ="play" class="play" onclick="tijdFilm();"></div>          
      </div>
      <div>
        <div>
            <div class="select_tijd">
                <select style="width: 100%;"  id="tijdslijn_vanaf" naam="tijdslijn_vanaf" onChange="tijdslijnVanaf(this.selectedIndex);"size="1">
                </select>
            </div>
            <div class="reset_tijd">
                <button id ="dem_reset_vanaf" onclick="resetVanaf();">
                     Vanaf Reset 
                </button>            
            </div>
        </div>              
        <div>
            <div class="select_tijd">
                <select style="width: 100%;"  id="tijdslijn_TotMet" naam="tijdslijn_TotMet" onChange="tijdslijnTot(this.selectedIndex);"size="1">
                </select>
            </div>
            <div class="reset_tijd">
                <button id ="dem_reset_vanaf" onclick="resetTotMet();">
                    Tot/Met Reset
                </button>            
            </div>
        </div>
      </div>
      <div id="multilayer">
          <div class="button-group">
              <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies lagen" onkeyup="demZoekLagenZoekString();" maxlength="25"/>
              <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Lagen<span class="caret"></span></button>
              <ul id=lagenbox class="dropdown-menu">
              </ul>
          </div>
      </div>
  </div>
</div>
<div id ="tijdslijn_control">
<div id="dem_tijdslijn"></div>
</div>
<div id="map" class="map"></div>

 <script language="javascript">
var  selLg = [];
var firstOpenLg = true;
var tijdlijn = false;

     $(document).ready(function(){
        
     $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
     
  var btn = $("#dem_film");
  btn.click(function() {
    if (btn.hasClass("paused")){
       pauseSlideshow();
    }  else {
       playSlideshow(); 
    }
    btn.toggleClass("paused");
    return false;
  });
  
     demZoekTijdslijnLagen();
     getMapStartup();
     $('#dem_tijdslijn').hide();
     $('#dem_toon_kaart').hide();
     
     var imag = '<img src="'+mapviewerIP+'/geoserver/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER=aezel:vw_minperceel0">';
     $("#legend-form").html(imag);
     
     

$(document).on('click','.lagenTextbox',function(event){
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
      selLg.splice(0,selLg.length)
      selLg.push(href.trim());
      setCookie('selLg',selLg);
      $('#dem_tijdslijn').show();
      $('#dem_toon_kaart').show();
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }
   
   $( event.target ).blur();
   demBerekenTijdsinterval();
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

function hideLagenbox() {
   if (firstOpenLg == false) {
        $("#lagenbox").css('display','none');
    } else {
        $('#eig_lagen_btn').attr('aria-expanded','false');
    }
}

function resetMap(){
     $('#map').empty();
}

function resetTijdslijn()
{
    resetMap();
    getMapStartup();
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

function tijdsloop() {

    if (tijdlijn==false){
        tijdlijn = true;
        hideLagenbox();
        demToonTijdslijn();
    } else {
        tijdlijn = false
        hideLagenbox();
        demVerwijderTijdslijn();
    }
    
}

</script>
<?php include 'common/footer.php'; ?>
