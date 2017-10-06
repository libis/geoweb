<?php include 'common/header.php'; ?>
<?php include 'common/footer.php'; ?>


<div id="map" class="map"></div>
<script type="text/javascript" src="../js/mapStartup.js"></script>

<script>
$(document).ready(function(){
    getMapStartup();
         var canvasheight=$('#map').parent().css('height');
         var canvaswidth=$('#map').parent().css('width');

         $('#map').css("height", canvasheight);
         $('#map').css("width", canvaswidth);

    });
function landschap_grondgebruik() {
 window.open("./landschap_grondgebruik.php","_self");
}
function landschap_toponiemen() {
 window.open("./landschap_toponiemen.php","_self");
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

</script>