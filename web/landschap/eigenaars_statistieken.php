<?php include 'common/header.php'; ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="../js/jquery-editable-select.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.css" rel="stylesheet">

<div class="container-fluid" style= "display: inline-block;">
<div style="margin-top: 10px;">
   <font size="6">% Grondbezit eigenaars </font>
</div>

<div>  
  <button id ="dem_toon_kaart" onclick="drawChart();">
      Toon kaart
  </button>
  <button id ="dem_eig_reset" onclick="resetStatistieken();">
      Reset
  </button>    
</div>
    <div>
        <label for="dem_gemeente" class="keuzelijstlabel">Gemeente:</label>
<div id="dem_demeente" class="wrapper">
    <select id=gemeentebox class="geoselect editableEigenaarBox">
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
      <label for="dem_gemeente_familienaam">Naam:</label>
    <div id="dem_gemeente_familienaam" class="wrapper">
      <select id=familienaambox class="geoselect editableFamilienaamBox">
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
    
<div id="multilijst" style= "display: inline-block; padding-top:100px">

        <div class="button-group">
        <button id="eig_stat_woonplaats_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Thuisgemeenten<span class="caret"></span></button>
        <ul id=woonplaatsbox class="dropdown-menu">
        </ul>              
        <input class="geotextbox woonplaatsTextBox" name="woonplaatsbox" placeholder="Zoek thuisgemeente" onkeyup="demZoekWoonplaatsenStat(selWpl,selBgp,gem,nm,art,selBrp);" maxlength="20"/>
</div>
    <div class="button-group">
        <button id="eig_stat_beroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepen<span class="caret"></span></button>
        <ul id=beroepbox class="dropdown-menu">
        </ul>         
        <input class="geotextbox beroepTextBox" name="beroepbox" placeholder="Zoek beroep" onkeyup="demZoekBeroepenStat(selBrp,selBgp,gem,nm,art,selWpl);" maxlength="20"/>
    </div>
<div class="button-group">
        <button id="eig_stat_beroepsgroep_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Beroepsgroepen<span class="caret"></span></button>
        <ul id=beroepsgroepbox class="dropdown-menu">
        </ul>         
        <input class="geotextbox beroepsgroepTextBox" name="beroepsgroepbox" placeholder="Zoek beroepsgroep" onkeyup="demZoekBeroepsgroepenStat(selBrp,selWpl,gem,nm,art,selBgp);" maxlength="20"/>
</div>    
</div>
  <div>
 <table width="100%" border="1" cellspacing="0" cellpadding="0" BORDERCOLOR="#3775BB">
        <tbody>
          <tr>
            <td>
                <div id="myPieChart" style="border: 1px solid #ccc"/>
            </td>
            <td>
                <div id="myBarChart" style="border: 1px solid #ccc"/>
            </td>
          </tr>
        </tbody>
        </table>
</div>
  <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart']});
      google.charts.load('current', {packages:['bar']});

      //  google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
         demZoekStatGrondbezitters(gem,nm,art,selBrp,selWpl,selBgp);
         demZoekStatBarGrondbezitters(gem,nm,art,selBrp,selWpl,selBgp);
         
         // Instantiate and draw the chart.
      }
  </script>
 
  <script language="javascript">
var  selWpl = [];
var  selBrp = [];
var  selBgp = [];
var gem = "";
var art ="";
var nm="";
var vnm="Alle voornamen";
var firstOpenWpl = true;
var firstOpenBrp = true;
var firstOpenBgp = true;
    $(document).ready(function(){
      $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

      $("#dem_zoek_artikelnummer").hide();
      $("#dem_zoek_familenaam").hide();
      $("#dem_zoek_voornaam").hide();
      $("#dem_toon_kaart").hide();
      //$("#dem_eig_reset").hide();
      $(".eigenaarTextBox").val('KIES GEMEENTE');
      
      
     $('#dem_demeente').on('select.editable-select', function (e) {          
        if (2 != e.eventPhase) {
            resetStat();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            gem = $inp.context.value;
            if ($(".eigenaarTextBox").val() !== "Kies een term...") {
                 resetStatistieken();
                 $("#dem_toon_kaart").show();
                 $("#dem_eig_reset").show();
            }
        }
    });

    $('#dem_gemeente_familienaam').on('select.editable-select', function (e) {

        if (2 != e.eventPhase) {
            resetStat();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            nm = $inp.context.value;
            if (($('#dem_gemeente_artikelnummer').val() === "Alle artikelnummers") || ($('#dem_gemeente_artikelnummer').val() === "")) {
                    demZoekArtikelnummers(gem,nm,vnm,art);
            }            
            demZoekStatWoonplaatsen(gem,nm,art,selWpl,selBrp,selBgp);
            demZoekStatBeroepen(gem,nm,art,selWpl,selBrp,selBgp);            
            demZoekStatBeroepsgroepen(gem,nm,art,selWpl,selBrp,selBgp);            
        }
     });

     $('#dem_gemeente_artikelnummer').on('select.editable-select', function (e) {
        if (2 != e.eventPhase) {
            resetStat();
            var $target = $( e.currentTarget );
            var $inp = $target.find( 'input' );
            art = $inp.context.value;
            if (($('#dem_gemeente_familienaam').val() === "Alle namen") || ($('#dem_gemeente_familienaam').val() === "")) {
                    demZoekFamilienamen(gem,nm,vnm,art);
            }
            demZoekStatWoonplaatsen(gem,nm,art,selWpl,selBrp,selBgp);
            demZoekStatBeroepen(gem,nm,art,selWpl,selBrp,selBgp);
            demZoekStatBeroepsgroepen(gem,nm,art,selWpl,selBrp,selBgp);            
        }
     });
  });

$('#dem_demeente').editableSelect({ effects: 'default' });  
$('#dem_demeente').attr("placeholder","Kies een gemeente...");
$('#dem_gemeente_familienaam').editableSelect({ effects: 'default' });  
$('#dem_gemeente_artikelnummer').editableSelect({ effects: 'default' });  
$('#dem_demeente').click(function () {
    $('#dem_demeente').val('');
});

function resetStatistieken() 
{
    resetStat();
    $('#dem_gemeente_familienaam').val('');
    $('#dem_gemeente_artikelnummer').val('');
    $('#dem_gemeente_familienaam').attr("placeholder","Even geduld...");
    $('#dem_gemeente_artikelnummer').attr("placeholder","Even geduld..");
    $('.beroepTextBox').attr("placeholder","Even geduld..");
    $('.woonplaatsTextBox').attr("placeholder","Even geduld..");
    $('.beroepsgroepTextBox').attr("placeholder","Even geduld..");
    

    demZoekArtikelnummersByGemeente(gem);
    demZoekFamilienamenByGemeente(gem);
    demZoekBeroepenByGemeenteStat(gem);
    demZoekBeroepsgroepenByGemeenteStat(gem);
    demZoekWoonplaatsenByGemeenteStat(gem);    
    
    selBrp.splice(0,selBrp.length);
    selWpl.splice(0,selWpl.length);
    selBgp.splice(0,selBgp.length);
    art = "Alle artikelnummers";
    nm = "Alle namen";
}
  
function resetStat(){
     $('#myPieChart').empty(); 
     $('#myBarChart').empty(); 
     $("#dem_eig_legend_chk").hide();
     $("#eig_legende_spam").hide();
     $("#dem_eig_legend_chk").prop('checked', false);
         $('#beroepbox').slideUp();
         $('#beroepsgroepbox').slideUp();
         $('#woonplaatsbox').slideUp();
}
    
  
function decodeHtml(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

function eigenaars() {
  window.open("./eigenaars.php","_self");
}
function eigenaars_beroep() {
  window.open("./eigenaars_beroep.php","_self");
}
function eigenaars_woonplaats() {
  window.open("./eigenaars_woonplaats.php","_self");
}
function eigenaars_beroepsgroepen() {
  window.open("./eigenaars_beroepsgroepen.php","_self");
}

$(document).on('click','#eig_stat_woonplaats_btn',function(event){ 
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    if (firstOpenWpl == true) {
        firstOpenWpl = false;
        $('#woonplaatsbox').slideToggle();
    }
    $('#woonplaatsbox').slideToggle();
});

$(document).on('click','#eig_stat_beroep_btn',function(event){ 
    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    if (firstOpenBrp == true) {
        firstOpenBrp = false;
        $('#beroepbox').slideToggle();
    }
    $('#beroepbox').slideToggle();
});

$(document).on('click','#eig_stat_beroepsgroep_btn',function(event){ 
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    if (firstOpenBgp == true) {
        firstOpenBgp = false;
        $('#beroepsgroepbox').slideToggle();
    }
    $('#beroepsgroepbox').slideToggle();
});
$(document).on('click','.woonplaatsTextBox',function(event){
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#woonplaatsbox').slideDown();
    $(".woonplaatsTextBox").val('').html();
});

$(document).on('click','#woonplaatsbox a',function(event){ 

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
      if (href.trim() == 'Alle woonplaatsen') {
         selWpl.splice(0,selWpl.length)
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });          
      }
   } else {
      if (href.trim() == 'Alle woonplaatsen') {
         selWpl.splice(0,selWpl.length)
         $( "#woonplaatsbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });   
     }       
      if (val > 0) {
        if ($( "#woonplaatsbox a" ).first().find('input').prop('checked')==true) {
            $( "#woonplaatsbox a" ).first().find('input').prop('checked',false);
            selWpl.splice( "Alle woonplaatsen", 1 );
        }
      }
      selWpl.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatBeroepen(gem,nm,art,selWpl,selBrp,selBgp);      
   demZoekStatBeroepsgroepen(gem,nm,art,selWpl,selBrp,selBgp);      
   return false;
}); 


$(document).on('click','.beroepTextBox',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();
    $('#beroepbox').slideDown();
    $(".beroepTextBox").val('').html();
});

$(document).on('click','#beroepbox a',function(event){ 

    $('#woonplaatsbox').slideUp();
    $('#beroepsgroepbox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBrp.indexOf( href.trim()))  > -1 ) {
      selBrp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepen') {
          selBrp.splice(0,selBrp.length)
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });          
      }
   } else {
      if (href.trim() == 'Alle beroepen') {
         selBrp.splice(0,selBrp.length)
         $( "#beroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });   
     }
 
      if (val > 0) {
        if ($( "#beroepbox a" ).first().find('input').prop('checked')==true) {
            $( "#beroepbox a" ).first().find('input').prop('checked',false);
            selBrp.splice( "Alle beroepen", 1 );
        }
      } 
     
      selBrp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatWoonplaatsen(gem,nm,art,selWpl,selBrp,selBgp);
   demZoekStatBeroepsgroepen(gem,nm,art,selWpl,selBrp,selBgp);      

   return false;
});

$(document).on('click','.beroepsgroepTextBox',function(event){
    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();
    $('#beroepsgroepbox').slideDown();
    $(".beroepsgroepTextBox").val('').html();
});

$(document).on('click','#beroepsgroepbox a',function(event){ 

    $('#woonplaatsbox').slideUp();
    $('#beroepbox').slideUp();

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       href = $target.text(),
       $inp = $target.find( 'input' ),
       idx;

   if (( idx = selBgp.indexOf( href.trim()))  > -1 ) {
      selBgp.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
      if (href.trim() == 'Alle beroepsgroepen') {
          selBgp.splice(0,selBgp.length)
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });          
      }
   } else {
      if (href.trim() == 'Alle beroepsgroepen') {
         selBgp.splice(0,selBgp.length)
         $( "#beroepsgroepbox a" ).each(function( index ) {
            $(this).find('input').prop('checked',false);
         });   
     }
 
      if (val > 0) {
        if ($( "#beroepsgroepbox a" ).first().find('input').prop('checked')==true) {
            $( "#beroepsgroepbox a" ).first().find('input').prop('checked',false);
            selBgp.splice( "Alle beroepsgroepen", 1 );
        }
      } 
     
      selBgp.push(href.trim());
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
   demZoekStatWoonplaatsen(gem,nm,art,selWpl,selBrp,selBgp);
   demZoekStatBeroepen(gem,nm,art,selWpl,selBrp,selBgp);      

   return false;
});

</script>

<?php include 'common/footer.php'; ?>
