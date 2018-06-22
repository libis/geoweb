function demGetLayerInTime(selLg,vanaf)
{
    var mywindow = null;
    var scaleLineControl= new ol.control.ScaleLine();
    var layerArr = [];
    var themalaag =selLg[0];
/*    
    var imgwms;
    imgwms = new ol.source.ImageWMS({
        url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS': 'aezel:a_2011_Gemeentegrenzen_NL_LI0','VERSION':'1.1.1','serverType':'geoserver','BBOX':'626172.135625,6574807.4240625,665307.89410156,6613943.1825391'},
        serverType: 'geoserver'
      });
    layerArr.push(imgwms);
*/

    for (var i=0;i<selLg.length;i++)  {
        var laag = themalagenprefix+":"+selLg[i];
    }
    
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


//show feature

    var farray = [];
    var featureRequest;
    
//    farray[0]=ol.format.filter.lessThanOrEqualTo('Vanaf',vanaf);
//    farray[1]=ol.format.filter.greaterThanOrEqualTo('Tot_met',vanaf);
    farray[0]=ol.format.filter.lessThanOrEqualTo('begindatum',vanaf);
    farray[1]=ol.format.filter.greaterThanOrEqualTo('einddatum',vanaf);


      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://www.geonode.org/',
        featurePrefix: 'geonode',
        featureTypes: [themalaag],
        outputFormat: 'application/json',
        maxFeatures : 250,
        filter:  ol.format.filter.and.apply(null, farray)
      });

      // then post the request and add the received features to a layer
      fetch(mapviewerIP+'/geoserver/wfs', {
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
        var gebiedFeatureLegend = [];
        
        
        while (index < features.length){
            prop = features[index].getProperties();
            /*
            if (!gebiedsdeel.includes(prop.Heerschapp)) {
            gebiedsdeel.push(prop.Heerschapp)
            gebiedFeature.push(prop.Heerschapp);
            gebiedFeature[prop.Heerschapp] = [];
            }
            gebiedFeature[prop.Heerschapp].push( features[index]);
            */
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
        var r=255,g=0,b=0;
            var vectorSource;
            var vector_layer;
            var extent,curr_extent;
    var stat = new google.visualization.DataTable();
    var output=[];
    stat.addColumn('string', 'Heerser');
    stat.addColumn('number', 'Gemeenten(aantal)');
    
        output.push(["Element", "Density", { role: "style" }]);
        while (index < gebiedsdeel.length){
            var gebied = gebiedsdeel[index];
            gebFeatures = gebiedFeature[gebied]; 
            index++;
            r = r-(index*30);
            g = g+(index*30);
            b = b+(index*30);
            var rgb = 'rgb('+r+','+g+','+b+')';
            output.push([gebied,gebFeatures.length,rgb]);
            vectorSource = new ol.source.Vector();
            vector_layer = new ol.layer.Vector({
              source: vectorSource,
              style: new ol.style.Style({
                stroke: new ol.style.Stroke({
                  color: 'rgba(255,80,50,1)',
                  width: 4
                }),
                fill: new ol.style.Fill({
                  color: 'rgba('+r+','+g+','+b+',1)',
                })
/*                
                 ,
                text:  new ol.style.Text({
                   text: gebied,
                   font:'12px serif'
                })
*/                
              })
            });
            vectorSource.addFeatures(gebFeatures);
            map.addLayer(vector_layer);
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
        curr_extent[1]-= 8000;
//        var factor = (curr_extent[3] - curr_extent[1])/(curr_extent[3] - curr_extent[1]+8000);
//        curr_extent[0] *= factor;
        map.getView().fit(curr_extent);

      var data = google.visualization.arrayToDataTable(output);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 
                        1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
           chartArea: {width: '30%'},
        width: 400,
        height: 200,
        bar: {groupWidth: "95%"},
        legend: { position: "left" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("legend-form"));
      chart.draw(view, options);
    });
};