

function getMapStartup()
{
    var mywindow = null;
    var scaleLineControl = new ol.control.ScaleLine();

    var wmsGemeente = new ol.source.ImageWMS({
      url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': 'aezel:a_2015_Gemeentegrenzen_NL_LI0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });
    
    var params = wmsGemeente.getParams();

      var layers = [
        //new ol.layer.Tile({source: new ol.source.OSM()}),
        new ol.layer.Image({source: wmsGemeente}),
     ];
      
      var view = new ol.View({
          center: [665300, 6660430],
          zoom: 9
        });
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
        view: view
      });


//scale

      scaleLineControl.setUnits('metric');
};

