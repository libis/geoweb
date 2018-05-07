
function demGetEigenaars(){

    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selLg = getCookie('selLg');
   
    var lg,lv,ln,la;
    if (ln=selNm[0] == "") selNm=['Alle '];
    if (la=selArt[0] == "") selArt=['Alle '];
    if (lv=selVnm[0] == "") selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
   
    var keyValueList = new Array;

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanEigenaars.script.php";
    $('#map').html('');
    if ((ln == true) && (la == true) && (lv == true)) {
        keyValueList[0] = 'gemeente##'+selGem[0];
        getMapEig(keyValueList,selGem[0],selLg);
    } else {
        $.post(targetUrl,{selGem,selNm,selVnm,selArt}, function(data) {    
            if (ln==true) selNm.splice(0,selNm.length);
            if (la==true) selArt.splice(0,selArt.length);
            if (lv==true) selVnm.splice(0,selVnm.length);
            if (lg==true) selGem.splice(0,selGem.length);
            data = data.trim();
            if(data.length>0)
                keyValueList = data.split("%%");
                getMapEig(keyValueList,selGem,selLg);
                i_count = 0;
        })
    }
}


function getMapEig(keyValueList,gemeente,selLg)
{
    var mywindow = null;
    var scaleLineControl= new ol.control.ScaleLine();
    var layerArr = [];
    var imgwms;
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
      params: {'LAYERS': 'aezel:vw_minperceel0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'178300.1875,312667.875,203591.78125,362804.15625','SRS':'EPSG:28992'},
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
                var targetToPush = '<table class="fixed">';
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'artikelnummer:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.artnr;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'voornaam:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.voornamen;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'naam:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.naam;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'woonplaats:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.woonplaats;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'beroep:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.beroep;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'perceelnummer:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.tekst;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'toponiem:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.toponiem;
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
    var featureGemRequest;

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

            var i_count2 = 0;
            var targetToPush="";
            var first = true;
            while(i_count2<selGem.length)
            {            
                if (first != true) {
                    targetToPush += ",'";
                    targetToPush += selGem[i_count2] ;//Item
                    targetToPush += "'";

                } else {
                    first = false;
                    targetToPush += "('";
                    targetToPush += selGem[i_count2] ;//Item
                    targetToPush += "'";
                }
                i_count2++;                
            }
            targetToPush +=")";
            

    wmsPerceel.updateParams({'cql_filter': "gemeente in "+targetToPush});

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
  
  
      // generate a GetFeature request voor hele gemeente 
        featureGemRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#aezel',
        featurePrefix: 'aezel',
        featureTypes: ['vw_minperceel0'],
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
