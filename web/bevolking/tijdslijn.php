<?php include 'common/header_time.php'; ?>

<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<script type="text/javascript" src="../js/mapEigenaars.js"></script>
<script type="text/javascript" src="../js/mapStartup.js"></script>
<script type="text/javascript" src="../js/tijdslijn.js"></script>
<script type="text/javascript" src="../js/mapTijdslijn.js"></script>
<script type="text/javascript" src="../js/jquery.timeliny.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/palette.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery.timeliny.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://openlayers.org/en/v4.3.2/css/ol.css" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
        <div>
            <button id ="dem_toon_kaart" onclick="tijdsloop();">
                Toon tijdlijn
            </button>
            <button id ="dem_eig_reset" onclick="resetTijdslijn();">
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
      <div id="multilayer">
          <div class="button-group">
              <input class="geotextbox lagenTextBox" name="lagenbox" placeholder="Kies lagen" onkeyup="histZoekLagenZoekString();" maxlength="25"/>
              <button id="eig_lagen_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Lagen<span class="caret"></span></button>
              <ul id=lagenbox class="dropdown-menu">
              </ul>
          </div>
            <div class="button-group">
                <input class="geotextbox gemeenteTextBox" name="gemeentebox" placeholder="Zoek gemeente" onkeyup="histZoekGemeentenZoekString();" maxlength="20"/>
                <button id="gemeente_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Gemeenten<span class="caret"></span></button>
                <ul id=gemeentebox class="dropdown-menu">
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

    google.charts.load('current', {packages: ['corechart']});
    google.charts.load('current', {packages:['bar']});

    $(document).ready(function(){
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

    selLg = [];
    selGem = [];
    firstOpenLg = true;
    firstOpenGem = true;


    demZoekTijdslijnLagen();

    //getMapStartup();
    $('#dem_tijdslijn').hide();
    $('#dem_toon_kaart').hide();
    $('#dem_eig_reset').hide();
    $('#dem_player').hide();
    $('#tijdslijn_vanaf').hide();
    $('#tijdslijn_TotMet').hide();
    $('#dp_vanaf').hide();
    $('#dp_tot').hide();
    $('#hist_reset_vanaf').hide();
    $('#hist_reset_totMet').hide();
    $('.gemeenteTextBox').hide();
    $('#gemeente_btn').hide();
    $('#dem_film_pause').hide();



 $(document).on('click','.lagenTextbox',function(event){
    $(".lagenTextbox").val('').html();
    });


$(document).on('click','#gemeentebox a',function(event){

    $('#lagenbox').slideUp();

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
   if (selGem.length == 0) {
       $('.gemeenteTextBox').attr("placeholder","Alle gemeenten");
   } else {
       $('.gemeenteTextBox').attr("placeholder","");
   }
   histGetLayerInTime(selGem,minCurrDayDate,maxCurrDayDate);
   return false;
});

$(document).on('click','.gemeenteTextBox',function(event){
    $('#gemeentebox').slideToggle();
    $('#lagenbox').slideUp();
    $(".gemeenteTextBox").val('').html();
    firstOpenGem = false;
});

$(document).on('click','#gemeente_btn',function(event){
    $('#lagenbox').slideUp();
    if (firstOpenGem == false) {
        $('#gemeentebox').slideToggle();
    }
});

$(function() {
    van = $( "#dp_vanaf" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    }).on( "change", function() {
        tijdslijnVanaf( this.value );
    });
    tot = $( "#dp_tot" ).datepicker({
        defaultDate: "+1w",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    }).on( "change", function() {
        tijdslijnTot( this.value );
    });
    function getDate( element ) {
        var date;
        var dateFormat = "yy-mm-dd";
        try {
          date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
          date = null;
        }
        return date;
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
       selLg.splice(0,selLg.length)
       selLg.push(href.trim());
       $('#dem_tijdslijn').show();
       $('#dem_toon_kaart').show();
       $('#dem_eig_reset').show();
       $('#dem_player').show();
       setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
    }
    if (selLg.length > 0) {

    $('.gemeenteTextBox').show();
    $('#gemeente_btn').show();
    $('#dp_vanaf').show();
    $('#dp_tot').show();

    $( event.target ).blur();
    $('#hist_reset_vanaf').show();
    $('#hist_reset_totMet').show();
    $('.lagenTextBox').attr("placeholder",selLg[0]);
    $('#lagenbox').slideUp();
    histZoekGemeenten();
    histInitMap(selLg);
    demBerekenTijdsinterval();
    } else {
        histFullReset();
    }
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
    firstOpenLg = false;
});

});

function hideLagenbox() {
   if (firstOpenLg == false) {
        $("#lagenbox").css('display','none');
    } else {
        $('#eig_lagen_btn').attr('aria-expanded','false');
    }
}


function resetTijdslijn()
{
    stopSlideshow();
//    $('#hist_reset_vanaf').hide();
//    $('#hist_reset_totMet').hide();
    $('#dem_film_pause').hide();
    $('#dem_film_play').show();
    resetVanaf();
    resetTotMet();

    selGem.splice(0,selGem.length);
    histZoekGemeenten();
    rebuildTijdslijnDiv();
    initTijdslijst = false;
    demBerekenTijdsinterval();

}


function histFullReset() {

    $('#dem_tijdslijn').hide();
    $('#dem_toon_kaart').hide();
    $('#dem_eig_reset').hide();
    $('#dem_player').hide();
    $('#tijdslijn_vanaf').hide();
    $('#tijdslijn_TotMet').hide();
    $('#dp_vanaf').hide();
    $('#dp_tot').hide();
    $('#hist_reset_vanaf').hide();
    $('#hist_reset_totMet').hide();
    $('.gemeenteTextBox').hide();
    $('#gemeente_btn').hide();
    $('#dem_film_pause').hide();
    selGem.splice( idx, 1 );

    demZoekTijdslijnLagen();
    rebuildTijdslijnDiv();
    
    initTijdslijst = false;
    $('#map').empty();

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
