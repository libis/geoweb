function demGetEigenaarsBeroep(gem,nm,vnm,art,brp,selLg){
    

    var keyValueList = new Array;

    if (nm == "") nm = 'Alle';
    if (vnm == "") vnm = 'Alle';
    if (art == "") art = 'Alle';
    if (brp == "") art = 'Alle';
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanEigenaarsBeroep.script.php";
    $('#map').html('');
    if ((vnm.includes('Alle')) &&
            (nm.includes('Alle')) &&
            (brp.includes('Alle')) &&
            (art.includes('Alle'))) {
        
        keyValueList[0] = 'gemeente##'+gem;
        getMapBrp(keyValueList,gem,selLg);
    } else {
            
    argumenten = '?gemeente='+gem+'&voornaam='+vnm+'&naam='+nm+'&artikelnr='+art+'&beroep='+brp;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            getMapBrp(keyValueList,gem,selLg);
            i_count = 0;
        }
    });
    }
       
}
    
    

function getMapBrp(keyValueList,gemeente,selLg)
{
    var scaleLineControl = new ol.control.ScaleLine();
    var imgwms;
    var layerArr = [];
    
    for (var i=0;i<selLg.length;i++)  {
        var laag = "aezel:"+selLg[i];
        imgwms = new ol.source.ImageWMS({
          url: mapviewerIP+'/geoserver/ows',
          params: {'LAYERS':laag,'VERSION':'1.1.1','serverType':'geoserver','BBOX':'178300.1875,312,667.875,203591.78125,362804.15625','SRS':'EPSG:28992'},
          serverType: 'geoserver'
        });
        layerArr.push(imgwms);
    }
    var wmsPerceel = new ol.source.ImageWMS({
      url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': 'aezel:vw_minperceel','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
      serverType: 'geoserver'
    });

    var vectorSource = new ol.source.Vector();
    var vector_layer = new ol.layer.Vector({
      source: vectorSource,
      style: new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: 'rgba(0, 255, 255, 2.0)',
          width: 4
        })
      })
    });

    var vectorSourceGem = new ol.source.Vector();
    var vector_layer_gem = new ol.layer.Vector({
      source: vectorSourceGem,
      style: new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: 'rgba(1, 0, 0, 1.0)',
          width: 1
        })
      })
    });
    var layers = [

      new ol.layer.Tile({source: new ol.source.OSM()}),
   ];
     
    for (var i=0;i<layerArr.length;i++)  {
         var ly = new ol.layer.Image({source: layerArr[i],maxResolution: 50})
         layers.push(ly);
    }
    layers.push(new ol.layer.Image({source: wmsPerceel, opacity: 0.5, maxResolution: 20}));

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

// get feature info

    map.on('singleclick', function(evt) {

        var feat = map.getFeaturesAtPixel(evt.pixel);
        
        for (var i=0;i< feat.length;i++) {
            var laag = feat[i].getId();
            if (laag.indexOf('minperceel') > 0) {
                var eigenschappen = feat[i].getProperties();
                var poutput = [];// voorbereiding
                var targetToPush = '<table>';
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'artikelnummer: '+eigenschappen.artnr;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'voornaam: '+eigenschappen.voornamen;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'naam: ' + eigenschappen.naam;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'woonplaats: '+eigenschappen.woonplaats;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'beroep: '+eigenschappen.beroep;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '</table>';                        
                poutput.push(targetToPush);
                $('#infobox').html('');
                $('#infobox').html(poutput.join(''));                
                $('#infobox').show();
                $('#metadata-form').collapse('show');
            }
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
        featureTypes: ['vw_minperceel'],
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
        featureTypes: ['vw_minperceel'],
        outputFormat: 'application/json',
        maxFeatures : 50,
        filter:                 ol.format.filter.or.apply(null, farray)

      });
  }
  
        // generate a GetFeature request voor hele gemeente 
        featureGemRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#aezel',
        featurePrefix: 'aezel',
        featureTypes: ['vw_minperceel'],
        outputFormat: 'application/json',
        //maxFeatures : 1,
        filter: ol.format.filter.equalTo('gemeente', gemeente)
    });

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
      
      // then post the request and add the received features to a layer
      fetch(mapviewerIP+'/geoserver/wfs', {
        method: 'POST',
        body: new XMLSerializer().serializeToString(featureGemRequest)
      }).then(function(response) {
        return response.json();
      }).then(function(json) {
        var features = new ol.format.GeoJSON().readFeatures(json);
        vectorSourceGem.addFeatures(features);
        map.addLayer(vector_layer_gem);
      });      
   };
