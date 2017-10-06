
function demGetGrondgebruik(gem,ggb){
    
    var keyValueList = new Array;

    if (ggb == "") ggb = 'Alle';
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanGrondgebruik.script.php";
    $('#map').html('');
    if (ggb.includes('Alle')) {
        
        keyValueList[0] = 'gemeente##'+gem;
        getMapGgb(keyValueList,gem);
    } else {
            
    argumenten = '?gemeente='+gem+'&grondgebruik='+ggb;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            getMapGgb(keyValueList,gem);
            i_count = 0;
        }
    });
    }
        
}




function getMapGgb(keyValueList,gemeente)
{
    var mywindow = null;
    var scaleLineControl = new ol.control.ScaleLine();

    var wmsWeg = new ol.source.ImageWMS({
      url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_minweg0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });
    var wmsGebouw = new ol.source.ImageWMS({
      url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_mingebouw0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });
    var wmsPerceel = new ol.source.ImageWMS({
      url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_minperceel0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });
    var wmsGemeente = new ol.source.ImageWMS({
      url: mapviewerIP+ '/geoserver/ows',
      params: {'LAYERS': 'aezel:a_2011_Gemeentegrenzen_NL_LI0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });  
    
    var params = wmsGemeente.getParams();

      var vectorSource = new ol.source.Vector();
      var vector = new ol.layer.Vector({
        source: vectorSource,
        style: new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: 'rgba(0, 255, 0, 10.0)',
            width: 50
          })
        })
      });
      var vector_layer = new ol.layer.Vector({
        source: vectorSource,
        style: new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: 'rgba(0, 255, 255, 2.0)',
            width: 4
          })
        })
      });

      var layers = [

        new ol.layer.Tile({source: new ol.source.OSM()}),
        new ol.layer.Image({source: wmsWeg,maxResolution: 60}),
        new ol.layer.Image({source: wmsPerceel, opacity: 0.5, maxResolution: 20}),
        new ol.layer.Image({source: wmsGemeente, opacity: 0.2,maxResolution: 80}),
        new ol.layer.Image({source: wmsGebouw,maxResolution: 30})
     ];
      
      var view = new ol.View({
          center: [665300, 6644430],
          zoom: 10
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

/*
    
$(function() {
  $("#draggable").draggable();
});

*/

// get feature info

      map.on('singleclick', function(evt) {
          
    if (mylegendgrondgebruikwindow !== null){
        mylegendgrondgebruikwindow.focus();  
    }
        
        var viewResolution = view.getResolution();
        var url = wmsPerceel.getGetFeatureInfoUrl(
            evt.coordinate, viewResolution, 'EPSG:3857',
            {'INFO_FORMAT': 'text/html'});
        if (url) {
            if (mywindow != null) {
                 mywindow.close();
            }
           mywindow = window.open(url, "_blank", "scrollbars=yes,menubar=no,resizable=yes,top=50,left=0,right=50,width=1500,height=150");
        }
      });




//scale

      scaleLineControl.setUnits('metric');

//show feature

    var farray = [];   
    var i_count=0;  
    var featureRequest;
    
    if (keyValueList.length == 1) {
        
        keyvaluearray=keyValueList[i_count].split("##");
        wmsPerceel.updateParams({'cql_filter': "gemeente = '"+gemeente+"'"});
        
        if (keyvaluearray[0] == 'gemeente'){

      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#aezel',
        featurePrefix: 'aezel',
        featureTypes: ['a_2011_Gemeentegrenzen_NL_LI0'],
        outputFormat: 'application/json',
        maxFeatures : 1,
        filter: ol.format.filter.equalTo('naam', keyvaluearray[1])
      });            
        } else {
        
      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#aezel',
        featurePrefix: 'aezel',
        featureTypes: ['vw_minperceel0'],
        outputFormat: 'application/json',
        maxFeatures : 1,
        filter: ol.format.filter.equalTo('objkoppel', keyvaluearray[1])
      });
    }
  } else {

          
    wmsPerceel.updateParams({'cql_filter': "gemeente = '"+gemeente+"'"});
    
    while(i_count<keyValueList.length)
    {
        keyvaluearray=keyValueList[i_count].split("##");
            farray[i_count] = ol.format.filter.equalTo('objkoppel', keyvaluearray[1]);
            i_count++;
    }

      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#aezel',
        featurePrefix: 'aezel',
        featureTypes: ['vw_minperceel0'],
        outputFormat: 'application/json',
        maxFeatures : 50,
        filter:                 ol.format.filter.or.apply(null, farray)
//          ol.format.filter.like('objkoppel', 'NL/LI/ASR00/A/A-011*'),

      });
  }

      // then post the request and add the received features to a layer
      fetch(mapviewerIP+'/geoserver/wfs', {
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
      
      
   };

