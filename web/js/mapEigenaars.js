vectorLayers = [];
 
function geoRemoveLayersMap() {
    for(var i=0;i<vectorLayers.length;i++){
        map.removeLayer(vectorLayers[i]);
    }
    vectorLayers = [];
} 
 
function demMinMax(omgeving,laag,selGem,selLg){

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekJaartallenVoorTijdslijn.script.php";
    
    var schema = 'themas';
    if (omgeving == 'aezel') schema = 'public';
    $.post(targetUrl,{schema,laag,selGem}, function(data) {    
        
        data = data.trim();
        if(data.length>0)
        {
            interval = 10;
            keyValueList = data.split("%%");
            i_count = 0;

            keyvaluearray=keyValueList[0].split("##");
            min = Number(keyvaluearray[1]);
            keyvaluearray=keyValueList[1].split("##");
            max = Number(keyvaluearray[1]);
            
            if (min != max){
                $('#dp_vanaf').show();
                $('#dp_tot').show();
                $('#hist_reset_vanaf').show();
                $('#hist_reset_totMet').show();
                $("#dem_toon_tijdlijn").show();
                $("#dem_tijdslijn").show();
                $('#dem_player').show();
                geoInitMap(selLg);
                demGeoBerekenTijdsinterval(hoofdlaag[2].trim(),min,max);   
            } else {
                geoInitMap(selLg);
                geoGetMap(null,false,false);
            }            
        }
    });
}



function demGetEigenaarsBeroepsgroep(){

    var enkelgemeente = false;
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selBgp = getCookie('selBgp');
    selLg = getCookie('selLg');
   
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBgp.length == 0) selBgp=['Alle '];
    if ((ln==true) &&
     (la==true) &&
     (lb==true) &&
     (ln==true) &&
     (lv==true)) {
        enkelgemeente = true;
    }      
    geoKeyValueList = new Array;
    
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanEigenaarsBeroepsgroep.script.php";
    $('#map').html('');
           
        $.post(targetUrl,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp}, function(data) {    
            if (ln==true) selNm.splice(0,selNm.length);
            if (la==true) selArt.splice(0,selArt.length);
            if (lv==true) selVnm.splice(0,selVnm.length);
            if (lg==true) selGem.splice(0,selGem.length);
            if (lb==true) selBgp.splice(0,selBgp.length);
        data = data.trim();
            if(data.length>0){
                geoKeyValueList = data.split("%%");
//                if(geoKeyValueList.length < 250) 
{
                    
                    if (openTijdslijn) {
                        minMax=demMinMax(hoofdlaag[2].trim(),hoofdlaag[1].trim(),selGem,selLg); 
                    } else {
                        geoInitMap(selLg);
                        geoGetMap(null,false,enkelgemeente);
                    }
                }
            }
        });
}
   
function demGetEigenaarsWoonplaats(){

    var enkelgemeente = false;
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selWpl = getCookie('selWpl');
    selLg = getCookie('selLg');
   
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selWpl.length == 0) selWpl=['Alle '];

    if ((ln==true) &&
     (la==true) &&
     (lb==true) &&
     (lv==true)) {
        enkelgemeente = true;
    }     
    geoKeyValueList = new Array;
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanEigenaarsWoonplaats.script.php";
    $('#map').html('');
            
        $.post(targetUrl,{hoofdlaag,selGem,selNm,selVnm,selArt,selWpl}, function(data) {    
            if (ln==true) selNm.splice(0,selNm.length);
            if (la==true) selArt.splice(0,selArt.length);
            if (lv==true) selVnm.splice(0,selVnm.length);
            if (lg==true) selGem.splice(0,selGem.length);
            if (lb==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
            if(data.length>0) {
                geoKeyValueList = data.split("%%");
//                if(geoKeyValueList.length < 250) 
                {
                    if (openTijdslijn) {
                        minMax=demMinMax(hoofdlaag[2].trim(),hoofdlaag[1].trim(),selGem,selLg); 
                    } else {
                        geoInitMap(selLg);
                        geoGetMap(null,false,enkelgemeente);
                    }
                }
            }
        });
       
}
   
function demGetEigenaarsBeroep(){

    var enkelgemeente = false;
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');
    selLg = getCookie('selLg');
   
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
 
    if ((ln==true) &&
     (la==true) &&
     (lb==true) &&
     (lv==true)) {
        enkelgemeente = true;
    }    
    geoKeyValueList = new Array;
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanEigenaarsBeroep.script.php";
    $('#map').html('');
            
        $.post(targetUrl,{hoofdlaag,selGem,selNm,selVnm,selArt,selBrp}, function(data) {    
            if (ln==true) selNm.splice(0,selNm.length);
            if (la==true) selArt.splice(0,selArt.length);
            if (lv==true) selVnm.splice(0,selVnm.length);
            if (lg==true) selGem.splice(0,selGem.length);
            if (lb==true) selBrp.splice(0,selBrp.length);
        data = data.trim();
            if(data.length>0) {
                geoKeyValueList = data.split("%%");
//                if(geoKeyValueList.length < 250) 
                {
                    if (openTijdslijn) {
                        minMax=demMinMax(hoofdlaag[2].trim(),hoofdlaag[1].trim(),selGem,selLg); 
                    } else {
                        geoInitMap(selLg);
                        geoGetMap(null,false,enkelgemeente);
                    }                
                }
            }
        });
       
}
   
function demGetEigenaars(){
    var enkelgemeente = false;
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selLg = getCookie('selLg');
   
    var lg,lv,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
   
    geoKeyValueList = new Array;

    if ((ln==true) &&
     (la==true) &&
     (lv==true)) {
        enkelgemeente = true;
    }

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekPercelenVanEigenaars.script.php";
    $('#map').html('');

        $.post(targetUrl,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
            if (ln==true) selNm.splice(0,selNm.length);
            if (la==true) selArt.splice(0,selArt.length);
            if (lv==true) selVnm.splice(0,selVnm.length);
            if (lg==true) selGem.splice(0,selGem.length);
            data = data.trim();
            if(data.length>0) {
                geoKeyValueList = data.split("%%");
//                if  (geoKeyValueList.length < 250)
                {
                    if (openTijdslijn) {
                        minMax=demMinMax(hoofdlaag[2].trim(),hoofdlaag[1].trim(),selGem,selLg); 
                    } else {
                        geoInitMap(selLg);
                        geoGetMap(null,false,enkelgemeente);
                    }
                }
            }
        });
}


function geoInitMap(selLg)
{
    var mywindow = null;
    var scaleLineControl= new ol.control.ScaleLine();
    var layerArr = [];
    var omgeving;
    var stijl;
    var imgwms;
    for (var i=0;i<selLg.length;i++)  {
        
        var laag = lagenprefix+":"+selLg[i];
        for (var j=0;j<keyValueLayerList.length;j++){
            keyvaluearray=keyValueLayerList[j].split("##");
            if (keyvaluearray[1].indexOf(selLg[i]) > -1){
              omgeving = keyvaluearray[2];
              omgeving = omgeving.trim();
              stijl = keyvaluearray[3];
              laag = omgeving+":"+selLg[i];
              stijl = stijl.trim();
              laag = laag.trim();
              j= keyValueLayerList.length;
            }
        }
        imgwms = new ol.source.ImageWMS({
          url: mapviewerIP+'/geoserver/ows',
          params: {'LAYERS':laag,'STYLES':stijl, 'VERSION':'1.1.1','serverType':'geoserver','BBOX':'178300.1875,312,667.875,203591.78125,362804.15625','SRS':'EPSG:28992'},
          serverType: 'geoserver'
        });
        layerArr.push(imgwms);
    }

    var mainlayer = mainLayer.split("##");
    omgeving = mainlayer[2];
    omgeving = omgeving.trim();
    laag = mainlayer[1].trim();
    laag  = laag.trim();
    stijl = mainlayer[3];
    stijl = stijl.trim();
    geoWmsPerceel = new ol.source.ImageWMS({
      url: mapviewerIP+'/geoserver/ows',
      params: {'LAYERS':laag,'STYLES':stijl,'VERSION':'1.1.1','serverType':'geoserver','BBOX':'178300.1875,312667.875,203591.78125,362804.15625','SRS':'EPSG:28992'},
      serverType: 'geoserver'
    });

    var layers = [];
    for (var i=0;i<selTg.length;i++)  {
        if (selTg[0]= 'Open Street Map') {
        layers.push(new ol.layer.Tile({source: new ol.source.OSM()}));
        }
    }
        /*
    var layers = [
      new ol.layer.Tile({source: new ol.source.OSM()}),
    ];
     */
    for (var i=0;i<layerArr.length;i++)  {
         var ly = new ol.layer.Image({source: layerArr[i],maxResolution: 50})
         layers.push(ly);
    }
    layers.push(new ol.layer.Image({source: geoWmsPerceel, opacity: 0.5, maxResolution: 80}));

      var view = new ol.View({
          center: [665300, 6644430],
          zoom: 10
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
      

// get feature info
    map.on('singleclick', function(evt) {

    feat = map.getFeaturesAtPixel(evt.pixel);
    geoShowMetadata();
    });     
    
}
/*
function openLinkMenu(evt) {
    
    
    var pixel = [evt.offsetX,evt.offsetY];
    feat = map.getFeaturesAtPixel(pixel);
    var mainlayer = mainLayer.split("##");
    var laag = mainlayer[1].trim();    
    for (var i=0;i< feat.length;i++) {
        var featlaag = feat[i].getId();
        if (featlaag.indexOf(laag) >= 0) {
            var eigenschappen = feat[i].getProperties();
            var poutput = [];// voorbereiding
    
    
                    targetToPush = '<option value="';
                    targetToPush += eigenschappen.adacode;// key                    
                    targetToPush += '">';
                    targetToPush += 'adacode';// value
                    targetToPush += '</option>';
                    targetToPush += '<option value="';
                    targetToPush += eigenschappen.feit_id;// key                    
                    targetToPush += '">';
                    targetToPush += 'administratieve info';// value
                    targetToPush += '</option>';
                    poutput.push(targetToPush);
                    $('#eig_popup_list').html('');
                    $('#eig_popup_list').html(poutput.join(''));
                    $("#eig_popup").css({left: evt.offsetX});
                    $("#eig_popup").css({top: evt.offsetY});
                    $("#eig_wait_popup").css({left: evt.offsetX});
                    $("#eig_wait_popup").css({top: evt.offsetY});
                    $("#eig_popup").show();
            break;
        }
    }
   
}
*/
    
function openLinkMenu(evt) {
    
    var pixel = [evt.offsetX,evt.offsetY];
    feat = map.getFeaturesAtPixel(pixel);
    var mainlayer = mainLayer.split("##");
    var laag = mainlayer[1].trim();    
    for (var i=0;i< feat.length;i++) {
        var featlaag = feat[i].getId();
        if (featlaag.indexOf(laag) >= 0) {
            var eigenschappen = feat[i].getProperties();
            var poutput = [];// voorbereiding
    
            targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekExterneLinks.script.php";
        
            $.post(targetUrl, function(data) {
                data = data.trim();
                i_count = 0;
                keyValueList = data.split("%%");
                targetToPush = '';
                while (i_count <  keyValueList.length) {
                keyvaluearray=keyValueList[i_count].split("##");
                    targetToPush += '<option value="';
                    if (keyvaluearray[1].indexOf('feit_id') > -1) targetToPush += keyvaluearray[2]+eigenschappen.feit_id; 
                    else if (keyvaluearray[1].indexOf('adacode') > -1) targetToPush += eigenschappen.adacode; 
                    targetToPush += '">';
                    targetToPush += keyvaluearray[0];// value
                    targetToPush += '</option>';     
                    i_count++;
                }
                    poutput.push(targetToPush);
                    $('#eig_popup_list').html('');
                    $('#eig_popup_list').html(poutput.join(''));
                    $("#eig_popup").css({left: evt.offsetX});
                    $("#eig_popup").css({top: evt.offsetY});
                    $("#eig_wait_popup").css({left: evt.offsetX});
                    $("#eig_wait_popup").css({top: evt.offsetY});
                    $("#eig_popup").show();
             });
             break;
         }
    }
}

function geo_link(select) {

    $("#eig_wait_popup").show();
    $("#eig_popup").hide();

    var item = select.options[select.selectedIndex].text;
    if (item.indexOf('aart')> -1) {
        
        targetUrl="http://"+websiteIP+websitePath+"/gdrive/openFile.php";
        argumenten = '?adacode=NL-LI-RMD00-100-001-1842-a02';
//        argumenten = '?adacode='+select.options[select.selectedIndex].value;
        $.post(targetUrl+argumenten, function(data) {
            $("#eig_wait_popup").hide();
            
        data = data.trim();
        if(data.length==0){
            alert ('file niet gevonden.');
        } else {
            i_count = 0;
            keyValueList = data.split("%%");
            keyvaluearray=keyValueList[i_count].split("##");
            newwindow = window.open("http://"+websiteIP+websitePath+"/"+keyvaluearray[0], "_blank");
            newwindow.onload = function () {
            targetUrl="http://"+websiteIP+websitePath+"/gdrive/verwijderFile.php";
            $.post(targetUrl+argumenten,{keyvaluearray}, function(data) {
                 });
             }
         }
        }); 
    } else if (select.options[select.selectedIndex].value.indexOf('http')> -1) {
        //window.open('http://'+websiteIP+'/limburgers/feit/'+select.options[select.selectedIndex].value,"_blank");
        window.open(select.options[select.selectedIndex].value,"_blank");
        $("#eig_wait_popup").hide();
    }
}
function isLetter(str) {
  return str.length === 1 && str.match(/[a-z]/i);
}

function geoShowMetadata() { 
    var mainlayer = mainLayer.split("##");
    var laag = mainlayer[1].trim();    
    
    for (var i=0;i< feat.length;i++) {
        var featlaag = feat[i].getId();
        if (featlaag.indexOf(laag) >= 0) {
            var eigenschappen = feat[i].getProperties();

 var artikelnummer = eigenschappen.artikelnummer;
    artikelnummer = parseInt(eigenschappen.tekst);
            
            var poutput = [];// voorbereiding
            var targetToPush = '<table class="fixed">';
            
            targetToPush += '<tr>';
            targetToPush += '<td>';
            targetToPush += 'gemeente:';
            targetToPush += '</td>';                        
            targetToPush += '<td>';
            targetToPush += eigenschappen.gemeente;
            targetToPush += '</td>';                        
            targetToPush += '</tr>';                        
            targetToPush += '<tr>';
            targetToPush += '<td>';
            targetToPush += 'artikelnummer:';
            targetToPush += '</td>';                        
            targetToPush += '<td>';
            targetToPush += eigenschappen.artikelnummer;
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
            var last = eigenschappen.oobjnr.lastIndexOf('/')+1;
            var ind=last;
            while (isLetter(eigenschappen.oobjnr.substr(ind,1))) {
                ind=ind+1;
                if (ind == eigenschappen.oobjnr.length) break;
            }
            var sub  = eigenschappen.oobjnr.substr(last,ind-last)+'-'+eigenschappen.oobjnr.substr(ind);
            targetToPush += sub;
            
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
            metadataID = eigenschappen.artikelnummer;
        }
    }
};
    
    
function geoDBShowMetadata(metadataID) {


    var mainlayer = mainLayer.split("##");
    var omgeving = mainlayer[2].trim();
    var laag = mainlayer[1].trim();
    var schema = 'public';
    
    var datum = minCurrDayDate.replace(/-/g,'');
    datum = datum +'5';
    if (omgeving.indexOf('aezel') == -1) schema = 'themas';
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekMetadataGeo.script.php";
    argumenten = '?metadataId='+metadataID+'&begindatum='+datum;
    
    
    $.post(targetUrl+argumenten,{schema,laag}, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            for(i_count2=0;i_count2<keyValueList.length;i_count2++)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
 var perceelnummer = keyvaluearray[6];
    perceelnummer = parseInt(keyvaluearray[6]);

                var poutput = [];// voorbereiding    
                var targetToPush = '<table class="fixed">';
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'artikelnummer:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[1];
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'gemeente:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[2];
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'voornaam:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[3];
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'naam:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[4];
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'woonplaats:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[5];
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'beroep:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[6];
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'perceelnummer:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                
            var last = keyvaluearray[7].lastIndexOf('/')+1;
            var ind=last
            while (isLetter(keyvaluearray[7].substr(ind,1))) {
                ind=ind+1;
                if (ind == keyvaluearray[7].length) break;
            }
            var sub  = keyvaluearray[7].substr(last,ind-last)+'-'+keyvaluearray[7].substr(ind);
            
            targetToPush += parseInt(sub);                
                targetToPush += '</td>';                        
                targetToPush += '</tr>';                        
                targetToPush += '<tr>';
                targetToPush += '<td>';
                targetToPush += 'toponiem:';
                targetToPush += '</td>';                        
                targetToPush += '<td>';
                targetToPush += keyvaluearray[7];
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
    
function geoGetMap(vanaf,speler,enkelGemeente) {

    if ( $('#metadata-form').is(':visible') && openTijdslijn)
    {
        geoDBShowMetadata(metadataID);
    }
    
    //show feature

    var farray = [];
    var ftarray = [];
    var farrayGem = [];
    var i_count=0;
    var featureRequest;
    var featureGemRequest;
    var filters = null;

    selGem = getCookie('selGem');    
    
    var mainlayer = mainLayer.split("##");
    var omgeving = mainlayer[2].trim();
    var laag = mainlayer[1].trim();

    
    
    if (vanaf != null) {
        vanaf = vanaf.replace(/-/g,"")
        if (vanaf.length == 4) {
            vanaf = vanaf+"0101";
        }
        vanaf = vanaf+"5";

    //    $('#hist_curr_day_date').text(vanaf);

        ftarray[0]=ol.format.filter.lessThanOrEqualTo('begindatum',parseFloat(vanaf));
        ftarray[1]=ol.format.filter.greaterThan('einddatum',parseFloat(vanaf));
    }

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
        geoWmsPerceel.updateParams({'cql_filter': "kadastergemeente in "+targetToPush});        
        

    if ((geoKeyValueList.length == 1) ) {

        keyvaluearray=geoKeyValueList[i_count].split("##");
//        geoWmsPerceel.updateParams({'cql_filter': "kadastergemeente = '"+gemeente+"'"});

        if (keyvaluearray[0] == 'gemeente'){

        if (vanaf != null) {
            filters = ol.format.filter.and(ol.format.filter.equalTo('naam', keyvaluearray[1]),ol.format.filter.and.apply(null,ftarray));
        } else {
            filters = ol.format.filter.equalTo('naam', keyvaluearray[1]);
        }

      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#'+omgeving,
        featurePrefix: omgeving,
        featureTypes: ['a_2011_Gemeentegrenzen_NL_LI0'],
        outputFormat: 'application/json',
        maxFeatures : 1,
        filter: filters
      });
        } else {
        if (vanaf != null) {
            filters = ol.format.filter.and(ol.format.filter.equalTo('objkoppel', keyvaluearray[1]),ol.format.filter.and.apply(null,ftarray));
        } else {
            filters = ol.format.filter.equalTo('objkoppel', keyvaluearray[1]);
        }

      // generate a GetFeature request
        featureRequest = new ol.format.WFS().writeGetFeature({
        srsName: 'EPSG:900913',
        featureNS: 'http://opengeo.org/#'+omgeving,
        featurePrefix: omgeving,
        featureTypes: [laag],
        outputFormat: 'application/json',
        maxFeatures : 1,
        filter: filters
      });
    }
  } else {

        if (geoKeyValueList.length < 250){   

            i_count=0;
            while(i_count<geoKeyValueList.length)
            {
                keyvaluearray=geoKeyValueList[i_count].split("##");
                farray[i_count] = ol.format.filter.equalTo('objkoppel', keyvaluearray[1]);
                i_count++;
            }
            if (vanaf != null) {
                 filters = ol.format.filter.and(ol.format.filter.or.apply(null, farray),ol.format.filter.and.apply(null,ftarray));
             } else {
                 filters = ol.format.filter.or.apply(null, farray);
             }    


           // generate a GetFeature request
             featureRequest = new ol.format.WFS().writeGetFeature({
             srsName: 'EPSG:900913',
                 featureNS: 'http://opengeo.org/#aezel',
                 featurePrefix: 'aezel',
                 featureTypes: [laag],
             outputFormat: 'application/json',
             maxFeatures : 250,
             filter: filters

           });
      }
  }

        // generate a GetFeature request voor hele gemeente 
        if (selGem.length > 1) {
            i_count=0;
            while(i_count<selGem.length)
            {
                farrayGem[i_count] = ol.format.filter.equalTo('kadastergemeente', selGem[i_count]);
                i_count++;
            }              
            featureGemRequest = new ol.format.WFS().writeGetFeature({
            srsName: 'EPSG:900913',
            featureNS: 'http://opengeo.org/#aezel',
            featurePrefix: 'aezel',            
            featureTypes: [laag],
            outputFormat: 'application/json',
            filter: ol.format.filter.or.apply(null, farrayGem)
            });
        } else {
            featureGemRequest = new ol.format.WFS().writeGetFeature({
            srsName: 'EPSG:900913',
            featureNS: 'http://opengeo.org/#aezel',
            featurePrefix: 'aezel',            
            featureTypes: [laag],
            outputFormat: 'application/json',
            filter: ol.format.filter.equalTo('kadastergemeente', selGem[0])
            });
        }

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

//verwijder alle voorgaande requests (nodig voor tijdlijngebruik)
geoRemoveLayersMap();
if ((enkelGemeente == false) && (geoKeyValueList.length < 250)){
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
        vectorLayers.push(vector_layer);        
        curr_extent = vectorSource.getExtent();
        map.getView().fit(vectorSource.getExtent());

      });
      }
      
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
        vectorLayers.push(vector_layer);        
        if ((enkelGemeente == true) || (geoKeyValueList.length >= 250)) {
            curr_extent = vectorSourceGem.getExtent();
            map.getView().fit(vectorSourceGem.getExtent());
        }
      });
    if (speler) { 
        player = true;
        $('#dem_tijdslijn').timeliny('goToYear', currentSlide);
    }
};
