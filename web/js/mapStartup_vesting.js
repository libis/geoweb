

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




      var laag = "geonode:vestigingen Roermond"
      var thema =  new ol.source.ImageWMS({
          url: mapviewerIP+'/geoserver/ows',
//          params: {'LAYERS':laag,'VERSION':'1.1.1','serverType':'geoserver','BBOX':'178300.1875,312,667.875,203591.78125,362804.15625','SRS':'EPSG:28992'},
          params: {'LAYERS':laag,'VERSION':'1.1.1','serverType':'geoserver','BBOX':'657192.8976875033,6650359.4215234285,678700.3665212448,6661117.933254567','SRS':'EPSG:28992'},
          
          serverType: 'geoserver'
        })      
      var themalaag = new ol.layer.Image({source: thema,maxResolution: 50})
      
      var layers = [
        //new ol.layer.Image({source: wmsGemeente}),
        new ol.layer.Tile({source: new ol.source.OSM()}),        
     ];
     layers.push(themalaag);
      
      var view = new ol.View({
//          center: [665300, 6660430],
//          zoom: 9
          center: [667100, 6655550],
          zoom: 16
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

