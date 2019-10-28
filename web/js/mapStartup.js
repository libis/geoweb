

function getMapStartup(thema)
{
    var mywindow = null;
    var scaleLineControl = new ol.control.ScaleLine();
    var wmsGemeente = null;
    var view = null;
    if (thema.indexOf('geo_percelen') !== -1) {
    
        wmsGemeente = new ol.source.ImageWMS({
        url: mapviewerIP+'/ows',
        params: {'LAYERS': 'aezel:a_2015_Gemeentegrenzen_NL_LI0','STYLES':'gemeentegrenzen_2015','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
        serverType: 'geoserver'
        });
        view = new ol.View({
          center: [665300, 6660430],
          zoom: 9
        });
    } else if (thema.indexOf('geo_begraaf') !== -1) {
    
        wmsGemeente = new ol.source.ImageWMS({
        url: mapviewerIP+'/ows',
        params: {'LAYERS': 'geonode:indeling_oude_kerkhof','STYLES':'indeling Oude Kerkhof','VERSION':'1.1.1','serverType':'geoserver','BBOX':'656172.135625,6614807.4240625,656672.89410156,6615807.4240625'},
        serverType: 'geoserver'
        });
        view = new ol.View({
          center:[668100,6653450],
          zoom: 18
      });
    }
    
    var params = wmsGemeente.getParams();
    var layers = [];
    
    for (var i=0;i<selTg.length;i++)  {
        if (selTg[0]= 'Open Street Map') {
        layers.push(new ol.layer.Tile({source: new ol.source.OSM()}));
        }
    } 
    
    layers.push(new ol.layer.Image({source: wmsGemeente}));
      map = new ol.Map({
        controls: ol.control.defaults({
        attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
          collapsible: false
        })
        }).extend([
          scaleLineControl
        ]),
        layers: layers,
        target: 'map',
        view: view
      });


//scale

      scaleLineControl.setUnits('metric');
};

