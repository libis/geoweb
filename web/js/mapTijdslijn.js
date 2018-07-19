 vectorLayers = [];
 vectorLayersP = [];
 metadataID = "";

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function demo() {
  console.log('Taking a break...');
  await sleep(2000);
  console.log('Two second later');
}

function histShowMetadata(metadataID) {

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekMetadataHist.script.php";
    argumenten = '?metadataId='+metadataID+'&begindatum='+minCurrDayDate;
    ;
    $.post(targetUrl+argumenten,{selLg}, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            for(i_count2=0;i_count2<keyValueList.length;i_count2++)
            {
                keyvaluearray=keyValueList[i_count2].split("##");

                var poutput = [];// voorbereiding
                var targetToPush = '<table class="fixed">';
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'heerser:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += keyvaluearray[1];
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'naam:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += keyvaluearray[2];
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'begindatum:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += keyvaluearray[3];
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'einddatum:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += keyvaluearray[4];
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '</table>';                        
                poutput.push(targetToPush);
                $('#infobox').html('');
                $('#infobox').html(poutput.join(''));                
                $('#infobox').show();        
            }
        } 
    });
}

function histRemoveLayersMap() {
    for(var i=0;i<vectorLayers.length;i++){
        map.removeLayer(vectorLayers[i]);
    }
    vectorLayers = [];
}

function histInitMap(selLg){

    var scaleLineControl= new ol.control.ScaleLine();
    var layerArr = [];
    themalaag = selLg[0];
    for (var i=0;i<selLg.length;i++)  {
        var laag = themalagenprefix+":"+selLg[i];
    }
/*
    var imgwms;
    imgwms = new ol.source.ImageWMS({
        url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': laag,'VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
        serverType: 'geoserver'
      });
    layerArr.push(imgwms);
*/  
    
    var layers = [
//      new ol.layer.Tile({source: new ol.source.OSM()}),
   ];
    
    for (var i=0;i<layerArr.length;i++)  {
         var ly = new ol.layer.Image({source: layerArr[i]})
         layers.push(ly);
    }

//scale

      scaleLineControl.setUnits('metric');


      var view = new ol.View({
          center: [655309.93, 6621586.89],
          zoom: 9
        });

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
    
      map.on('singleclick', function(evt) {

      feat = map.getFeaturesAtPixel(evt.pixel);
      showMetadata();
    });
}

        
function showMetadata() {        
        for (var i=0;i< feat.length;i++) {
            var laag = feat[i].getId();
            if (laag.includes(selLg[0])) {
                var eigenschappen = feat[i].getProperties();
                var poutput = [];// voorbereiding
                var targetToPush = '<table class="fixed">';
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'heerser:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.Heerser;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'naam:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.NAAM;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'begindatum:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.begindatum;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '<tr>';
                    targetToPush += '<td>';
                    targetToPush += 'einddatum:';
                    targetToPush += '</td>';                        
                    targetToPush += '<td>';
                    targetToPush += eigenschappen.einddatum;
                    targetToPush += '</td>';                        
                    targetToPush += '</tr>';                        
                    targetToPush += '</table>';                        
                poutput.push(targetToPush);
                $('#infobox').html('');
                $('#infobox').html(poutput.join(''));                
                $('#infobox').show();
                $('#metadata-form').collapse('show');
                metadataID = eigenschappen.NAAM;
            }
        }
    }

function histGetLayerInTime(selGem,vanaf,speler)
{
    
    if ( $('#metadata-form').is(':visible') )
    {
        histShowMetadata(metadataID);
    }

    
//show feature

    var farray = [];
    var farrayGem = [];
    var featureRequest;
    var f = ol.format.filter;
    var filters;
    
    if (vanaf.split("-").length == 1) {
        vanaf = vanaf+"-01-01";
    }
    $('#hist_curr_day_date').text(vanaf);

    farray[0]=ol.format.filter.lessThanOrEqualTo('begindatum',vanaf);
    farray[1]=ol.format.filter.greaterThan('einddatum',vanaf);

    filters = ol.format.filter.and.apply(null,farray);

    if (selGem.length > 0) {
        i_count=0;
        farrayGem[0] = ol.format.filter.equalTo('NAAM', "tweede gemeente");
        while(i_count<selGem.length)
        {
            farrayGem[i_count+1] = ol.format.filter.equalTo('NAAM', selGem[i_count]);
            i_count++;
        } 
        filters = 
                ol.format.filter.and(ol.format.filter.or.apply(null,farrayGem),ol.format.filter.and.apply(null,farray));

    }

      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://www.geonode.org/',
        featurePrefix: 'geonode',
        featureTypes: [themalaag],
        outputFormat: 'application/json',
//        maxFeatures : 1000,
        filter:  filters
      });


      // then post the request and add the received features to a layer
      fetch(mapviewerIPHist+'/geoserver/wfs', {
        method: 'POST',
        body: new XMLSerializer().serializeToString(featureRequest)
      }).then(function(response) {
         
       return response.json();
       
      }).then(function(json) {
          
        var features = new ol.format.GeoJSON().readFeatures(json);

       
        var index = 0;
        var prop;
        var gebiedsdeel = [];
        var gebiedFeature = [,];
        
        while (index < features.length){
            prop = features[index].getProperties();
            if (!gebiedsdeel.includes(prop.Heerser)) {
            gebiedsdeel.push(prop.Heerser);
            gebiedFeature.push(prop.Heerser);
            gebiedFeature[prop.Heerser] = [];
            }
            gebiedFeature[prop.Heerser].push( features[index]);           
            index++;
        }
        index = 0;
        var gebFeatures;
        var vectorSource;
        var vector_layer;
        var extent,curr_extent;
        var output=[];

        output.push(["Element", "Density", { role: "style" }]);
        histRemoveLayersMap();

        while (index < gebiedsdeel.length){
            var gebied = gebiedsdeel[index];
            gebFeatures = gebiedFeature[gebied]; 
            index++;
            var r = kleurLegend[gebied][0][0];
            var g = kleurLegend[gebied][0][1];
            var b = kleurLegend[gebied][0][2];
            var rgb = 'rgb('+r+','+g+','+b+')';
          
            output.push([gebied,100/*gebFeatures.length*/,rgb]);
            vectorSource = new ol.source.Vector();
            vector_layer = new ol.layer.Vector({
              source: vectorSource,
              style: new ol.style.Style({
                stroke: new ol.style.Stroke({
                  color: 'rgba(115,115,115,1)',
                  width: 2
                }),
                fill: new ol.style.Fill({
                  color: 'rgba('+r+','+g+','+b+',1)',
                })
//                 ,
//                text:  new ol.style.Text({
//                   text: gebied,
//                   font:'12px serif'
                })
              })
            vectorSource.addFeatures(gebFeatures);
            map.addLayer(vector_layer);
            vectorLayers.push(vector_layer);
            if (index == 1) {
                curr_extent = vectorSource.getExtent();
            }
            extent = vectorSource.getExtent();
            if (extent[0] < curr_extent[0]) curr_extent[0] = extent[0];
            if (extent[1] < curr_extent[1]) curr_extent[1] = extent[1];
            if (extent[2] > curr_extent[2]) curr_extent[2] = extent[2];
            if (extent[3] > curr_extent[3]) curr_extent[3] = extent[3];
            }            

            //opvangen tijdsbalk
            curr_extent[1]-= 30000;
            map.getView().fit(curr_extent);
 

                
      var data = google.visualization.arrayToDataTable(output);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 
                        1,
/*                        
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
*/                         
                       2]);

      var options = {
           chartArea:{left:'60%',top:0,width:'50%',height:'100%'},
        width: 400,
        height: 25*output.length,
        format:'none',
        bar: {groupWidth: "80%"},
        legend: { position: "left" },
         hAxis: { gridlines: { count: 0 } }
      };
      var chart = new google.visualization.BarChart(document.getElementById("legend-form"));
      chart.draw(view, options);
      
      if (speler) { 
          player = true;
          $('#dem_tijdslijn').timeliny('goToYear', currentSlide);
      }
    });
};
