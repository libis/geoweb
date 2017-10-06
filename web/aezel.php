<?php

/*
$appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$connStr = "host=libis-p-aezel-3.lnx.icts.kuleuven.be port=5432 dbname=postgres user=postgres password=postgres options='--application_name=$appName'";

//simple check
$conn = pg_connect($connStr);
$result = pg_query($conn, "SELECT tekst FROM aezelschema.vw_mingebouw0 where tekst = 'C-390'
ORDER BY fid
ASC; ");
var_dump(pg_fetch_all($result));
*/

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tiled WMS</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v4.1.0/css/ol.css" type="text/css">
    <style type="text/css">
    .ol-scale-line {
      background:black;
      padding: 5px;
    }
    .scale-line {
      position: absolute;
      top: 350px;
    }
    .ol-scale-line {
      position: relative;
      bottom: 0px;
      left: 0px;
    }
    </style>

    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.1.0/build/ol.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



  </head>
  <body>
    <div id="map" class="map"></div>


<!--
    <select id="units">
    <option value="degrees">degrees</option>
    <option value="imperial">imperial inch</option>
    <option value="us">us inch</option>
    <option value="nautical">nautical mile</option>
    <option value="metric" selected>metric</option>
  </select>
-->
    <script>

    var scaleLineControl = new ol.control.ScaleLine();

    var wmsWeg = new ol.source.ImageWMS({
      url: 'http://libis-p-aezel-3.lnx.icts.kuleuven.be:8080/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_minweg0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });
    var wmsGebouw = new ol.source.ImageWMS({
      url: 'http://libis-p-aezel-3.lnx.icts.kuleuven.be:8080/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_mingebouw0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });
    var wmsPerceel = new ol.source.ImageWMS({
      url: 'http://libis-p-aezel-3.lnx.icts.kuleuven.be:8080/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_minperceel0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });


      var vectorSource = new ol.source.Vector();
      var vector = new ol.layer.Vector({
        source: vectorSource,
        style: new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: 'rgba(0, 0, 255, 2.0)',
            width: 10
          })
        })
      });
      var vector_layer = new ol.layer.Vector({
        source: vectorSource
      });

      var layers = [

        new ol.layer.Tile({source: new ol.source.OSM()}),
        new ol.layer.Image({source: wmsWeg,maxResolution: 60}),
        new ol.layer.Image({source: wmsPerceel, opacity: 0.6, maxResolution: 2}),
        new ol.layer.Image({source: wmsGebouw,maxResolution: 30})


      ];
      var map = new ol.Map({
        controls: ol.control.defaults({
        attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
          collapsible: false
        })
        }).extend([
          scaleLineControl
        ]),
        layers: layers,
        target: 'map',
        view: new ol.View({
          center: [665300, 6644430],
          zoom: 10
        })
      });

      scaleLineControl.setUnits('metric');
      /*
      var unitsSelect = document.getElementById('units');
      function onChange() {
        scaleLineControl.setUnits(unitsSelect.value);
      }
      unitsSelect.addEventListener('change', onChange);
      onChange();
      */
/*
      $(function() {
        $("#draggable").draggable();
      });
*/

var f = ol.format.filter;
var farray = [];
var filter2 = ol.format.filter;

farray[0] = ol.format.filter.equalTo('objkoppel','NL/LI/ASR00/A/A-0013');
farray[1]= ol.format.filter.equalTo('objkoppel','NL/LI/ASR00/A/A-0010');

    f.or(
          ol.format.filter.equalTo('objkoppel', 'NL/LI/ASR00/A/A-0013'),
          ol.format.filter.equalTo('objkoppel', 'NL/LI/ASR00/A/A-0010')
          );
  f.or(
          ol.format.filter.equalTo('objkoppel', 'NL/LI/ASR00/A/A-0009'),
          ol.format.filter.equalTo('objkoppel', 'NL/LI/ASR00/A/A-0008')          
          )

      // generate a GetFeature request
      var featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#aezel',
        featurePrefix: 'aezel',
        featureTypes: ['vw_minperceel0'],
        outputFormat: 'application/json',
        maxFeatures : 50,
//        filter: ol.format.filter.equalTo('naam', 'De hommerder gatz')


          filter : ol.format.filter.or.apply(null, farray)

/*
        filter: ol.format.filter.or(
          //ol.format.filter.equalTo('soort', 'weg')
          ol.format.filter.equalTo('objkoppel', 'NL/LI/ASR00/A/A-0013'),
          ol.format.filter.equalTo('objkoppel', 'NL/LI/ASR00/A/A-0010')
        )
*/
      });

      // then post the request and add the received features to a layer
      fetch('http://libis-p-aezel-3.lnx.icts.kuleuven.be:8080/geoserver/wfs', {
        method: 'POST',
        body: new XMLSerializer().serializeToString(featureRequest)
      }).then(function(response) {
        return response.json();
      }).then(function(json) {
        var features = new ol.format.GeoJSON().readFeatures(json);
        vectorSource.addFeatures(features);
        map.addLayer(vector_layer);
        map.getView().fit(vectorSource.getExtent());

      });

    </script>
  </body>
</html>
