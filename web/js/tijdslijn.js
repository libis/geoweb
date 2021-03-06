tmpYear = 0;
initTijdslijst = false;
min=0;
max = 0;
minCurr=0;
maxCurr = 0;
minCurrDayDate=0;
maxCurrDayDate = 0;
interval = 0;
kleurLegend = [];
player = false;

function tijdsloop() {
    if (tijdlijn==false){
        tijdlijn = true;
        hideLagenbox();
        demToonTijdslijn();
    } else {
        tijdlijn = false
        hideLagenbox();
        demVerwijderTijdslijn();
    }
}

function histZoekGemeenten()
{
   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekAlleGemeentenHist.script.php";
   $.post(targetUrl,{selLg}, function(data) {
    data = data.trim();
    var poutput = [];// voorbereiding
    if(data.length>0)
    {
        keyValueList = data.split("%%");
        i_count = 0;

        var targetToPush = '';  

        while(i_count<keyValueList.length)
        {
            keyvaluearray=keyValueList[i_count].split("##");
            targetToPush += '<li><a href="#" class="small" data-value="';
            targetToPush += i_count;//id
            targetToPush += '" tabIndex="-1"><input type="checkbox" />&nbsp;';
            targetToPush += keyvaluearray[1]  ;//Item
            targetToPush += '</a></li>';      
            i_count++;
        }
        poutput.push(targetToPush);
    }
    $('#gemeentebox').html('');
    $('#gemeentebox').html(poutput.join(''));
    $('.gemeenteTextBox').attr("placeholder","Alle gemeenten");        
    });
}

function histZoekGemeentenZoekString()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekGemeentenHist.script.php";
    var filter = $(".gemeenteTextBox").val();
    argumenten = '?gemeente='+filter;
    $.post(targetUrl+argumenten,{selLg},function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding        // I want a list of names to use in my queries
        var targetToPush = '';  
        i_count = 0;
        i_count2 = 0;
        while(i_count2<selGem.length)
        {            
            targetToPush += '<li><a href="#" class="small" data-value="';
            targetToPush += i_count;//id

            targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
            targetToPush += selGem[i_count2] ;//Item
            targetToPush += '</a></li>';                  

            i_count++;                
            i_count2++;                
        }
       if(data.length>0)
        {
            keyValueList = data.split("%%");
        
            for(i_count2=0;i_count2<keyValueList.length;i_count2++)
            {
                keyvaluearray=keyValueList[i_count2].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1]  ;//Item
                targetToPush += '</a></li>';      
                i_count++;
            }
            poutput.push(targetToPush);
            
        }        
        $('#gemeentebox').html('');
        $('#gemeentebox').html(poutput.join(''));
    });
}


function demZoekTijdslijnLagen() {
    var formatter = new ol.format.WMSCapabilities();
    var endpoint = mapviewerIP+ '/wms';

    // async call to geoserver 
    $.get(endpoint + '?request=GetCapabilities',function(data) {

        // use the tool to parse the data
        var response = (formatter.read(data));

        // this object contains all the GetCapabilities data
        var capability = response.Capability;
        var layer = capability.Layer;

        // I want a list of names to use in my queries
        var poutput = [];// voorbereiding
        var targetToPush = '';  
        for(var i=0;i<layer.Layer.length;i++){
            var naam = layer.Layer[i].Name ;
            if (naam.substr(0,naam.indexOf(':')) === themalagenprefix) {
                naam = naam.substr(naam.indexOf(':')+1);
                if  (
                    (naam === 'sittard_amstenrade') || 
                    (naam === 'scheiding_limburg')
                    )
                {
                    targetToPush += '<li><a href="#" class="small" data-value="';
                    targetToPush += i;//id

                    targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                    targetToPush += naam ;//Item
                    targetToPush += '</a></li>';      
                }
            }
        }
        poutput.push(targetToPush);
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Zoek laag");        
    });
}



function demVerwijderTijdslijn() {
     $('#dem_tijdslijn').hide();
}


function demToonTijdslijn()
{
    var targetToPush = '';     
    var poutput = [];// voorbereiding
    tijdlijn = true;

    if (initTijdslijst) {
        $('#dem_tijdslijn').show();
    } else {
    
        var min = parseInt($('#tijdslijn_vanaf').val());
        var max = parseInt($('#tijdslijn_TotMet').val());
        var i_count = min;
        while  (i_count < max+1)
        {
            if (i_count == minCurr) {
                targetToPush += '<div data-year="'+i_count+'" class="active"></div>';
            } else {
                targetToPush += '<div data-year="'+i_count+'"></div>';
            }
            i_count = i_count+parseInt(interval);
        }
            
        poutput.push(targetToPush);
        $('#dem_tijdslijn').empty();
        $('#dem_tijdslijn').html(poutput.join(''));
        $('#dem_tijdslijn').timeliny({
          // or 'desc'
          order: 'asc',
          // classname for the timeline
          className: 'timeliny',
          // timeline wrapper
          wrapper: '<div class="timeliny-wrapper"></div>',
          // boundaries
          boundaries: 2,
          // animation speed in ms
          animationSpeed: 1,
          // hides blank years
          hideBlankYears: true,
          // callbacks
          onInit: function() {
              initTijdslijst = true;
          },
          onDestroy: function() {
              //naDestroy();
              i=0;
          },
          afterLoad: function(currYear) {
                histGetLayerInTime(selGem,currYear,false);  
          },          
          onLeave: function(currYear, nextYear) {
              i=0;
          },
          afterChange: function(currYear) {
            if (!player) {
                minCurrDayDate = currYear+"-01-01";
                if (tmpYear == 0) {
                    tmpYear = currYear;
                    histGetLayerInTime(selGem,currYear,false);                 
                } else {
                    if (tmpYear != currYear) {
                        histGetLayerInTime(selGem,currYear,false);                 
                        tmpYear = currYear;
                    }
                }
           } else {
               player = false;
           }
          },
          afterResize: function() {
              i=0;
          }
        });
    }

}
function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function demBerekenKleurenVoorLegende() 
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekLegendItems.script.php";
    $.post(targetUrl,{selLg}, function(data) {
            keyValueList = data.split("%%");
            i_count =0;

            var seq = palette('mpn65', keyValueList.length);

            while(i_count<keyValueList.length)
            {
                
                keyvaluearray=keyValueList[i_count].split("##");
                r = hexToRgb(seq[i_count]).r;
                g = hexToRgb(seq[i_count]).g;
                b = hexToRgb(seq[i_count]).b;
                var rgb = [r,g,b]; 
                kleurLegend.push(keyvaluearray[1]);
                kleurLegend[keyvaluearray[1]] = [];
                kleurLegend[keyvaluearray[1]].push(rgb); 
                i_count++;
            }
            demToonTijdslijn();
            
   });
}


function demGeoBerekenTijdsinterval(omgeving,min,max)
{
    var schema = 'themas';
    if (omgeving == 'aezel') schema = 'public';
        var poutputStart = [];// voorbereiding
        var poutputEnd = [];// voorbereiding
                
        toontijdslijn = true;
        interval =  (max - min) / tijdsvakken;
        interval = parseInt(interval);
        if (interval==0) interval =1;

        modulus = min%interval;
        min = min - modulus;
        modulus = max%interval;
        max = max-modulus;
        maxCurr = max;
        minCurr = min;
        tmpYear = min;

        var startYearToPush = ''; 
        var endYearToPush = ''; 
        i_count = min;
        currYear = min + (10 * interval);

        startYearToPush = '<option selected="selected" value="'+min+'">'+min+'</option>'

        while  (i_count < max+1)
        {
            i_count = i_count+interval;
            if (i_count < max) {
                startYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'
                endYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'    
            }
        }
        endYearToPush += '<option selected="selected" value="'+max+'">'+max+'</option>'

        $('#tijdslijn_vanaf').html('');
        $('#tijdslijn_TotMet').html('');

        poutputStart.push(startYearToPush);
        poutputEnd.push(endYearToPush);

        $('#tijdslijn_vanaf').html(poutputStart.join(''));
        $('#tijdslijn_TotMet').html(poutputEnd.join(''));
        $('#tijdslijn_vanaf').hide();
        $('#tijdslijn_TotMet').hide();


        $('#dp_vanaf').datepicker("setDate",minCurr+"-01-01");
        $('#dp_vanaf').datepicker("option", "maxDate", maxCurr+"-12-30" );


        $('#dp_tot').datepicker("setDate",maxCurr+"-12-31");        
        $('#dp_tot').datepicker("option", "minDate", minCurr+"-01-02");
        maxCurrDayDate = maxCurr+"-12-31";
        minCurrDayDate = minCurr+"-01-01";
        if (thema.indexOf('geo_percelen') == -1) {
            demBerekenKleurenVoorLegende();
        }  else {
            demToonTijdslijn();
        }      
}



function demBerekenTijdsinterval(omgeving,laag)
{
    selGem = getCookie('selGem');    
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekJaartallenVoorTijdslijn.script.php";
    
    var lg;
    var schema = 'themas';
    if (omgeving == 'aezel') schema = 'public';
    $.post(targetUrl,{schema,laag,selGem}, function(data) {    
        
        data = data.trim();
        var poutputStart = [];// voorbereiding
        var poutputEnd = [];// voorbereiding
        if(data.length>0)
        {
            interval = 10;
            keyValueList = data.split("%%");
            i_count = 0;

                keyvaluearray=keyValueList[0].split("##");
                min = Number(keyvaluearray[1]);
                keyvaluearray=keyValueList[1].split("##");
                max = Number(keyvaluearray[1]);
                
                    toontijdslijn = true;
                    interval =  (max - min) / tijdsvakken;
                    interval = parseInt(interval);
                    if (interval==0) interval =1;

                    modulus = min%interval;
                    min = min - modulus;
                    modulus = max%interval;
                    max = max-modulus;
                    maxCurr = max;
                    minCurr = min;
                    tmpYear = min;

                    var startYearToPush = ''; 
                    var endYearToPush = ''; 
                    i_count = min;
                    currYear = min + (10 * interval);

                    startYearToPush = '<option selected="selected" value="'+min+'">'+min+'</option>'

                    while  (i_count < max+1)
                    {
                        i_count = i_count+interval;
                        if (i_count < max) {
                            startYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'
                            endYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'    
                        }
                    }
                    endYearToPush += '<option selected="selected" value="'+max+'">'+max+'</option>'
        
                    $('#tijdslijn_vanaf').html('');
                    $('#tijdslijn_TotMet').html('');

                    poutputStart.push(startYearToPush);
                    poutputEnd.push(endYearToPush);

                    $('#tijdslijn_vanaf').html(poutputStart.join(''));
                    $('#tijdslijn_TotMet').html(poutputEnd.join(''));
                    $('#tijdslijn_vanaf').hide();
                    $('#tijdslijn_TotMet').hide();


                    $('#dp_vanaf').datepicker("setDate",minCurr+"-01-01");
                    $('#dp_vanaf').datepicker("option", "maxDate", maxCurr+"-12-30" );


                    $('#dp_tot').datepicker("setDate",maxCurr+"-12-31");        
                    $('#dp_tot').datepicker("option", "minDate", minCurr+"-01-02");
                    maxCurrDayDate = maxCurr+"-12-31";
                    minCurrDayDate = minCurr+"-01-01";
            if (thema.indexOf('geo_percelen') == -1) {
                demBerekenKleurenVoorLegende();
            }  else {
                demToonTijdslijn();
            }      
            
        }
                
    });
}


function herberekenTot(tijd)
{
    //var selectVal = $('#tijdslijn_vanaf').val();
    
    minCurrDayDate = tijd;
    minCurr = parseInt(tijd.split("-")[0]);
    tmpYear = minCurr;

    var poutputEnd = [];// voorbereiding
    var endYearToPush = ''; 
    var i_count = minCurr;
    currYear = minCurr + (10 * interval);
    startYearToPush = '<option selected="selected" value="'+minCurr+'">'+minCurr+'</option>'

    while  (i_count < maxCurr+1)
    {
        i_count = i_count+interval;
        if (i_count < maxCurr) {
            endYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'    
        }
    }
    endYearToPush += '<option selected="selected" value="'+maxCurr+'">'+maxCurr+'</option>'

    $('#tijdslijn_TotMet').html('');
    poutputEnd.push(endYearToPush);

    $('#tijdslijn_TotMet').html(poutputEnd.join(''));
    $('#dp_tot').datepicker("setDate",maxCurr+"-12-31");
    $('#dp_vanaf').datepicker("option", "maxDate", maxCurr+"-12-30" );
    
}


function herberekenVanaf(tijd)
{
    //var selectVal = $('#tijdslijn_TotMet').val();
    maxCurrDayDate = tijd;
    maxCurr = parseInt(tijd.split("-")[0]);
    var poutputStart = [];// voorbereiding
    var startYearToPush = ''; 
    var i_count = minCurr;
    startYearToPush = '<option selected="selected" value="'+minCurr+'">'+minCurr+'</option>'

    while  (i_count < maxCurr-interval)
    {
        i_count = i_count+interval;
        startYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'
    }

    $('#tijdslijn_vanaf').html('');
    poutputStart.push(startYearToPush);

    $('#tijdslijn_vanaf').html(poutputStart.join(''));
    $('#dp_vanaf').datepicker("setDate",minCurr+"-01-01");
    $('#dp_tot').datepicker("option", "minDate", minCurr+"-01-02");
    
}

function rebuildTijdslijnDiv()
{
    $('#dem_tijdslijn').timeliny('destroy');
    var div = document.createElement("div");
    div.id="dem_tijdslijn";
    document.getElementById("tijdslijn_control").appendChild(div);     
}
function resetVanaf()
{
    var poutputStart = [];// voorbereiding
    var startYearToPush = ''; 
    var i_count = minCurr;

    $('#dp_vanaf').datepicker("setDate",min+"-01-01");
    $('#dp_tot').datepicker("option", "minDate", min+"-01-02");
    rebuildTijdslijnDiv();
    
    startYearToPush = '<option selected="selected" value="'+min+'">'+min+'</option>'
    while  (i_count < maxCurr-interval)
    {
        i_count = i_count+interval;
        startYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'
    }

    $('#tijdslijn_vanaf').html('');
    poutputStart.push(startYearToPush);
    $('#tijdslijn_vanaf').html(poutputStart.join(''));
    minCurrDayDate = min+"-01-01";
    minCurr = min;
    naDestroy();

}

function resetTotMet()
{
    var poutputStart = [];// voorbereiding
    var endYearToPush = ''; 
    var i_count = minCurr;
    
    $('#dp_tot').datepicker("setDate",max+"-01-01");    
    $('#dp_vanaf').datepicker("option", "maxDate", max+"-12-30" );
    
    rebuildTijdslijnDiv();   
    
    while  (i_count < max)
    {
        i_count = i_count+interval;
        endYearToPush += '<option value="'+i_count+'">'+i_count+'</option>'
    }
    endYearToPush += '<option selected="selected" value="'+max+'">'+max+'</option>'

    $('#tijdslijn_TotMet').html('');
    poutputStart.push(endYearToPush);
    $('#tijdslijn_TotMet').html(poutputStart.join(''));
    maxCurrDayDate = max+"-01-01";
    maxCurr = max;
    naDestroy();
}


function tijdslijnVanaf(tijd)
{
    if (playing) stopSlideshow();
    rebuildTijdslijnDiv();
    herberekenTot(tijd);
    currentSlide =  parseInt(0);
    slideInterval = parseInt(0);
    naDestroy();
}

function tijdslijnTot(tijd)
{
    if (playing) stopSlideshow();
    rebuildTijdslijnDiv();
    herberekenVanaf(tijd);
    currentSlide =  parseInt(0);
    stop = parseInt(0);
    slideInterval = parseInt(0);    
    naDestroy();
}

function naDestroy(){
    var targetToPush="";
    var poutput=[];
/*    
    var min = parseInt($('#tijdslijn_vanaf').val());
    var max = parseInt($('#tijdslijn_TotMet').val());
*/    
    var i_count = minCurr;
        while  (i_count < maxCurr+1)
        {
            if (i_count == minCurr) {
                targetToPush += '<div data-year="'+i_count+'" class="active"></div>';
            } else {
                targetToPush += '<div data-year="'+i_count+'"></div>';
            }
            i_count = i_count+parseInt(interval);
        }
        poutput.push(targetToPush);

        $('#dem_tijdslijn').html(poutput.join(''));
        $('#dem_tijdslijn').timeliny({
          // or 'desc'
          order: 'asc',
          // classname for the timeline
          className: 'timeliny',
          // timeline wrapper
          wrapper: '<div class="timeliny-wrapper"></div>',
          // boundaries
          boundaries: 2,
          // animation speed in ms
          animationSpeed: 1,
          // hides blank years
          hideBlankYears: true,
          // callbacks
          onInit: function() {
              initTijdslijst = true;
          },
          onDestroy: function() {
          },
          afterLoad: function(currYear) {
                histGetLayerInTime(selGem,minCurrDayDate,false);         
          },
          onLeave: function(currYear, nextYear) {
          },
          afterChange: function(currYear) {
            if (!player)
            {
                minCurrDayDate = currYear+"-01-01";
                if (tmpYear == 0) {
                   tmpYear = currYear;
                   histGetLayerInTime(selGem,currYear,false);                 
               } else {
                   if (tmpYear != currYear) {
                       histGetLayerInTime(selGem,currYear,false);                 
                       tmpYear = currYear;
                   }
               }
           } else {
               player = false;
           }
          },
          afterResize: function() {
          }
        });
    
}

currentSlide =  parseInt(0);
var stop = parseInt(0);
var slideInterval = parseInt(0);

function nextSlide(){
    currentSlide = (currentSlide+interval);
    if (currentSlide <= maxCurr) {
        minCurrDayDate = currentSlide.toString()+"-01-01";
        histGetLayerInTime(selGem,minCurrDayDate,true);   
    }else {
        stopSlideshow();
    }
}

var playing = false;

function pauseSlideshow(){
    $('#dem_film_pause').hide();
    $('#dem_film_play').show();
    playing = false;
    clearInterval(slideInterval);
}

function playSlideshow(){
    $('#dem_film_pause').show();
    $('#dem_film_play').hide();
    playing = true;
    currentSlide =(parseInt(tmpYear));
    stop = maxCurr;
    slideInterval = setInterval(nextSlide,intervaltijd);
}

function stopSlideshow() {
    $('#dem_film_pause').hide();
    $('#dem_film_play').show();
    playing = false;
    clearInterval(slideInterval);
    currentSlide =  minCurr;
}

function frSlideshow() {
    clearInterval(slideInterval);
    currentSlide =  minCurr;
    tmpYear = minCurr;
    minCurrDayDate = minCurr+"-01-01";
    histGetLayerInTime(selGem,minCurrDayDate,true);   
    if (playing) slideInterval = setInterval(nextSlide,intervaltijd);
}

function ffSlideshow() {
    playing = false;
    $('#dem_film_pause').hide();
    $('#dem_film_play').show();
    clearInterval(slideInterval);
    currentSlide =  maxCurr;
    maxCurrDayDate = maxCurr+"-12-31";
    minCurrDayDate = maxCurr+"-01-01";
    histGetLayerInTime(selGem,minCurrDayDate,true);  
}   
 

function spSlideshow() {

  clearInterval(slideInterval);
  targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekVorigeDatumHist.script.php";
  arguments = "?datum="+minCurrDayDate;
  var schema = 'themas';
  var laag;
  var datum;
  if (omgeving == 'aezel') {
      schema = 'public';
      laag = hoofdlaag[1];
      datum = minCurrDayDate.replace(/-/g,'');
      datum = datum + '5';
  } else {
      laag = selLg[0];
      datum = minCurrDayDate;
  }
  arguments = "?datum="+datum;
  $.post(targetUrl+arguments,{laag,schema}, function(data) {
    data = data.trim();
    if(data.length>0) {
        data = data.substr(0,10);
        minCurrDayDate = data;
        tmpYear = parseInt(minCurrDayDate.split("-")[0]);
        currentSlide = tmpYear;
        histGetLayerInTime(selGem,minCurrDayDate,true);                      
        if (playing) slideInterval = setInterval(nextSlide,intervaltijd);
    }
  });
}

function snSlideshow() {
    
  clearInterval(slideInterval);
  targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekVolgendeDatumHist.script.php";
  var schema = 'themas';
  var laag;
  var datum;
  if (omgeving == 'aezel') {
      datum = minCurrDayDate.replace(/-/g,'');
      datum = datum + '5';
      schema = 'public';
      laag = hoofdlaag[1];
  } else {
      laag = selLg[0];
      datum = minCurrDayDate;
  }
  arguments = "?datum="+datum;
  
  $.post(targetUrl+arguments,{laag,schema}, function(data) {
    data = data.trim();
    if(data.length>0) {
        data = data.substr(0,10);
        minCurrDayDate = data;
        tmpYear = parseInt(minCurrDayDate.split("-")[0]);
        currentSlide = tmpYear;
        histGetLayerInTime(selGem,minCurrDayDate,true);                      
        if (playing) slideInterval = setInterval(nextSlide,intervaltijd);
    } else {
        ffSlideshow();
    }
  });
}