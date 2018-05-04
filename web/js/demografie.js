

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function demZoekVoornamen(selGem,selNm,selVnm,selArt)
{
    
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamen.script.php";
    var naam = $(".voornaamTextBox").val();   
    argumenten = '?voornaam='+naam;
    var lg,lv,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{selGem,selNm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selVnm.indexOf('Alle voornamen') == -1) && (selVnm.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle voornamen</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selVnm.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selVnm[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selVnm )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#voornaambox').html('');
        $('#voornaambox').html(poutput.join(''));
        });
        
}


/*
function demZoekVoornamenWoonplaats(gem,nm,vnm,art,wpl)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenWoonplaats.script.php";
    argumenten = '?gemeente='+gem+'&voornaam='+vnm+'&familienaam='+nm+'&artikelnummer='+art+'&woonplaats='+wpl;
    $('#dem_gemeente_voornaam').editableSelect('clear');  
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_voornaam').editableSelect( 'add','Alle voornamen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_voornaam').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_voornaam').attr("placeholder","Kies een voornaam...");

    });
}
function demZoekVoornamenBeroep(gem,nm,vnm,art,wpl)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenBeroep.script.php";
    argumenten = '?gemeente='+gem+'&voornaam='+vnm+'&familienaam='+nm+'&artikelnummer='+art+'&beroep='+brp;
    $('#dem_gemeente_voornaam').editableSelect('clear');  
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_voornaam').editableSelect( 'add','Alle voornamen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_voornaam').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_voornaam').attr("placeholder","Kies een voornaam...");

    });
}

function demZoekVoornamenBeroepsgroep(gem,nm,vnm,art,bgp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenBeroepsgroep.script.php";
    argumenten = '?gemeente='+gem+'&voornaam='+vnm+'&familienaam='+nm+'&artikelnummer='+art+'&beroepsgroep='+bgp;
    $('#dem_gemeente_voornaam').editableSelect('clear');  
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_voornaam').editableSelect( 'add','Alle voornamen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_voornaam').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_voornaam').attr("placeholder","Kies een voornaam...");

    });
}
*/
function demZoekVoornamenByGemeente(selGem)
{
    selGem = getCookie('selGem');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle voornamen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#voornaambox').html('');
        $('#voornaambox').html(poutput.join(''));
        $('.voornaamTextBox').attr("placeholder","Zoek voornaam");
    });
}

/*

function demZoekFamilienamenWoonplaats(gem,nm,vnm,art,wpl)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenWoonplaats.script.php";
    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&voornaam='+vnm+'&artikelnummer='+art+'&woonplaats='+wpl;
    $('#dem_gemeente_familienaam').editableSelect('clear');  
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_familienaam').editableSelect( 'add','Alle namen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_familienaam').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
       $('#dem_gemeente_familienaam').attr("placeholder","Kies een naam...");
    });
}
function demZoekFamilienamenBeroep(gem,nm,vnm,art,brp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenBeroep.script.php";
    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&voornaam='+vnm+'&artikelnummer='+art+'&beroep='+brp;
    $('#dem_gemeente_familienaam').editableSelect('clear');  
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_familienaam').editableSelect( 'add','Alle namen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_familienaam').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
       $('#dem_gemeente_familienaam').attr("placeholder","Kies een naam...");
    });
}

function demZoekFamilienamenBeroepsgroep(gem,nm,vnm,art,bgp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenBeroepsgroep.script.php";
    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&voornaam='+vnm+'&artikelnummer='+art+'&beroepsgroep='+bgp;
    $('#dem_gemeente_familienaam').editableSelect('clear');  
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_familienaam').editableSelect( 'add','Alle namen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_familienaam').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
       $('#dem_gemeente_familienaam').attr("placeholder","Kies een naam...");
    });
}


}
*/

function demZoekArtikelnummers(selGem,selNm,selVnm,selArt)
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummers.script.php";
    var naam = $(".artTextBox").val();   
    argumenten = '?artikelnummer='+naam;
    var lg,lv,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{selGem,selNm,selVnm}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selArt.indexOf('Alle artikelnummers') == -1) && (selArt.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle artikelnummers</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selArt.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selArt[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selArt )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
        }
        $('#artikelnummerbox').html('');
        $('#artikelnummerbox').html(poutput.join(''));
        });
        
}
/*  

function demZoekArtikelnummersWoonplaats(gem,nm,vnm,art,wpl)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersWoonplaats.script.php";
    $('#dem_gemeente_artikelnummer').editableSelect('clear');
    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&voornaam='+vnm+'&woonplaats='+wpl;
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_artikelnummer').editableSelect( 'add','Alle artikelnummers');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_artikelnummer').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_artikelnummer').attr("placeholder","Kies een artikelnummer...");
   });
}
function demZoekArtikelnummersBeroep(gem,nm,vnm,art,brp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersBeroep.script.php";
    $('#dem_gemeente_artikelnummer').editableSelect('clear');
    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&voornaam='+vnm+'&beroep='+brp;
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_artikelnummer').editableSelect( 'add','Alle artikelnummers');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_artikelnummer').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_artikelnummer').attr("placeholder","Kies een artikelnummer...");
   });
}

function demZoekArtikelnummersBeroepsgroep(gem,nm,vnm,art,bgp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersBeroepsgroep.script.php";
    $('#dem_gemeente_artikelnummer').editableSelect('clear');
    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&voornaam='+vnm+'&beroepsgroep='+bgp;
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_artikelnummer').editableSelect( 'add','Alle artikelnummers');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_artikelnummer').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_artikelnummer').attr("placeholder","Kies een artikelnummer...");
   });
}
*/
function demZoekArtikelnummersByGemeente(selGem)
{

   selGem = getCookie('selGem');
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersByGemeente.script.php";
   if (lg=selGem.length == 0) selGem=['Alle '];
   $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle artikelnummers";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle artikelnummers</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        
        $('#artikelnummerbox').html('');
        $('#artikelnummerbox').html(poutput.join(''));
        $('.artTextBox').attr("placeholder","Zoek artikelnummer");
        });
        
} 
/*

function demZoekBeroepen(gem,nm,vnm,art,brp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekberoepen.script.php";
    $('#dem_gemeente_beroep').editableSelect('clear');
    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&voornaam='+vnm+'&beroep='+brp;
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_beroep').editableSelect( 'add','Alle beroepen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_beroep').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_beroep').attr("placeholder","Kies een beroep...");
   });
}

function demZoekWoonplaatsen(gem,nm,vnm,art,wpl)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekwoonplaatsen.script.php";
    $('#dem_gemeente_woonplaats').editableSelect('clear');
    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&voornaam='+vnm+'&woonplaats='+wpl;
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_woonplaats').editableSelect( 'add','Alle woonplaatsen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_woonplaats').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_woonplaats').attr("placeholder","Kies een woonplaats...");
   });
}

function demZoekBeroepsgroepen(gem,nm,vnm,art,bgp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekberoepsgroepen.script.php";
    $('#dem_gemeente_beroepsgroep').editableSelect('clear');
    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&voornaam='+vnm+'&beroepsgroep='+bgp;
    $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
        
            $('#dem_gemeente_beroepsgroep').editableSelect( 'add','Alle beroepsgroepen');
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                $('#dem_gemeente_beroepsgroep').editableSelect( 'add',keyvaluearray[1]);  
                i_count++;
            }
        }
        $('#dem_gemeente_beroepsgroep').attr("placeholder","Kies een beroepsgroep...");
   });
}

function demZoekBeroepenByGemeente(selGem)
{
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle beroepen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#beroepbox').html('');
        $('#beroepbox').html(poutput.join(''));
        $('.beroepTextBox').attr("placeholder","Zoek beroep");
    });
}

function demZoekWoonplaatsenByGemeente(selGem)
{
    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);        
       data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle woonplaatsen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#woonplaatsbox').html('');
        $('#woonplaatsbox').html(poutput.join(''));
        $('.woonplaatsTextBox').attr("placeholder","Zoek woonplaats");
    });
}

function demZoekBeroepsgroepenByGemeente(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle beroepsgroepen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#beroepsgroepbox').html('');
        $('#beroepsgroepbox').html(poutput.join(''));
        $('.beroepsgroepTextBox').attr("placeholder","Zoek beroepsgroep");
    });
}

function demZoekBeroepenByGemeenteStat(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
       data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle beroepen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
        
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle beroepen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        
        $('#beroepbox').html('');
        $('#beroepbox').html(poutput.join(''));
        $('.beroepTextBox').attr("placeholder","Zoek beroep");
        });
        
}

function demZoekArtikelnummersByGemeenteStat(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersByGemeente.script.php";
     if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle artikelnummers";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
        
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle artikelnummers</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        
        $('#artikelnummerbox').html('');
        $('#artikelnummerbox').html(poutput.join(''));
        $('.artTextBox').attr("placeholder","Zoek artikelnummer");
        });
        
}
*/
function demZoekFamilienamenByGemeenteStat(selGem)
{
    selGem = getCookie('selGem');  
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle namen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
        
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle namen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        
        $('#familienaambox').html('');
        $('#familienaambox').html(poutput.join(''));
        $('.familienaamTextBox').attr("placeholder","Zoek naam");
        });
        
}
/*
function demZoekBeroepsgroepenByGemeenteStat(gem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenByGemeente.script.php";
    argumenten = '?gemeente='+gem;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle beroepsgroepen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
        
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle beroepsgroepen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        
        $('#beroepsgroepbox').html('');
        $('#beroepsgroepbox').html(poutput.join(''));
        $('.beroepsgroepTextBox').attr("placeholder","Zoek beroepsgroep");
        });
        
}


function demZoekFamilienamenStat(selWpl,selBgp,gem,selNm,selArt,selBrp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenStat.script.php";
//    var filter = $(".eigenaarTextBox").val();
    var naam = $(".familienaamTextBox").val();   
//    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&artikelnummer='+art+'&beroep='+beroep;
    argumenten = '?gemeente='+gem+'&naam='+naam;
    var lb,lw,lg,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selWpl,selBgp,selArt,selBrp}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle namen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selNm.indexOf('Alle namen') == -1) && (selNm.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle namen</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selNm.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selNm[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selNm )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#familienaambox').html('');
        $('#familienaambox').html(poutput.join(''));
        });
        
}


function demZoekArtikelnummersStat(selWpl,selBgp,gem,selNm,selArt,selBrp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersStat.script.php";
//    var filter = $(".eigenaarTextBox").val();
    var artikelnummer = $(".artTextBox").val();   
//    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&artikelnummer='+art+'&beroep='+beroep;
    argumenten = '?gemeente='+gem+'&artikelnummer='+artikelnummer;
    var lb,lw,lg,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selWpl,selBgp,selNm,selBrp}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle artikelnummers";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selArt.indexOf('Alle artikelnummers') == -1) && (selArt.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle artikelnummers</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selArt.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selArt[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selArt )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#artikelnummerbox').html('');
        $('#artikelnummerbox').html(poutput.join(''));
//        $(".beroepTextBox").val(selectedValue).html();
        });
        
}


function demZoekBeroepenStat(selBrp,selBgp,gem,selNm,selArt,selWpl)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepenStat.script.php";
//    var filter = $(".eigenaarTextBox").val();
    var beroep = $(".beroepTextBox").val();   
//    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&artikelnummer='+art+'&beroep='+beroep;
    argumenten = '?gemeente='+gem+'&beroep='+beroep;
    var lb,lw,lg,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selWpl,selBgp,selNm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle beroepen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selBrp.indexOf('Alle beroepen') == -1) && (selBrp.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle beroepen</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selBrp.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selBrp[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selBrp )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#beroepbox').html('');
        $('#beroepbox').html(poutput.join(''));
//        $(".beroepTextBox").val(selectedValue).html();
        });
        
}

function demZoekBeroepsgroepenStat(selBrp,selWpl,gem,selNm,selArt,selBgp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenStat.script.php";
//    var filter = $(".eigenaarTextBox").val();
    var beroepsgroep = $(".beroepsgroepTextBox").val();   
//    argumenten = '?gemeente='+gem+'&familienaam='+nm+'&artikelnummer='+art+'&beroepsgroep='+beroepsgroep;
    argumenten = '?gemeente='+gem+'&beroepsgroep='+beroepsgroep;
    var lb,lw,lg,la,ln;
    if (la=selArt.length == 0) selArt=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selWpl,selBrp,selNm,selArt}, function(data) {    
        if (la==true) selArt.splice(0,selArt.length);
        if (ln==true) selNm.splice(0,selNm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle beroepsgroepen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selBrp.indexOf('Alle beroepen') == -1) && (selBrp.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle beroepsgroepen</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selBrp.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selBrp[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selBrp )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#beroepsgroepbox').html('');
        $('#beroepsgroepbox').html(poutput.join(''));
//        $(".beroepTextBox").val(selectedValue).html();
        });
        
}


function demZoekWoonplaatsenStat(selWpl,selBgp,gem,selNm,selArt,selBrp)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenStat.script.php";
    var woonplaats = $(".woonplaatsTextBox").val();
    
//    argumenten = '?gemeente='+gem+'&artikelnummer='+art+'&familienaam='+nm+'&woonplaats='+woonplaats;
    argumenten = '?gemeente='+gem+'&woonplaats='+woonplaats;
    var lb,lw,lg,la,ln;
    if (la=selArt.length == 0) selArt=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selBrp,selBgp,selNm,selArt}, function(data) {    
        if (la==true) selArt.splice(0,selArt.length);
        if (ln==true) selNm.splice(0,selNm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle woonplaatsen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selWpl.indexOf('Alle woonplaatsen') == -1) && (selWpl.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle woonplaatsen</a></li>';
                i_count = 1;
            }
            
            while(i_count2<selWpl.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selWpl[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selWpl )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
        }
        $('#woonplaatsbox').html('');
        $('#woonplaatsbox').html(poutput.join(''));
        });
        
}


function demZoekWoonplaatsenByGemeenteStat(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        var poutput = [];// voorbereiding
        var selectedValue ="Alle woonplaatsen";
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
        
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle woonplaatsen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#woonplaatsbox').html('');
        $('#woonplaatsbox').html(poutput.join(''));
        $('.woonplaatsTextBox').attr("placeholder","Zoek woonplaats");
        });
        
}

function demZoekStatGrondbezitters(gem,selNm,selArt,selBrp,selWpl,selBgp)
{
    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezitters.script.php";
    argumenten = '?gemeente='+gem;//+'&naam='+nm+'&artikelnr='+art;
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Eigenaar');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp,selNm,selArt}, function(data) {
        if (la==true) selArt.splice(0,selArt.length);
        if (ln==true) selNm.splice(0,selNm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);    
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            output = []; 
            opp_count = 0;
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
                opp_count += parseInt(keyvaluearray[1]);
                i_count++;
            }
            output[i_count] = [('Anderen'),(parseInt(keyvaluearray[3]) - opp_count)];       
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
        chart.draw(stat, options);
    });
    }

function demZoekStatGrondbezittersGem(gem,selNm,selArt,selBrp,selWpl,selBgp,)
{
    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezitters.script.php";
    argumenten = '?gemeente='+gem;//+'&naam='+nm+'&artikelnr='+art;
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Eigenaar');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp,selNm,selArt}, function(data) {
        if (la==true) selArt.splice(0,selArt.length);
        if (ln==true) selNm.splice(0,selNm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);    
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1]/parseInt(keyvaluearray[3]))];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
        chart.draw(stat, options);
    });
    }



function demZoekStatGrondbezittersBeroep(gem,nm,art,selBrp,selWpl,selBgp)
{
    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroep.script.php";
    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroep');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp}, function(data) {
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);    
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
        chart.draw(stat, options);
    });
    }

function demZoekStatGrondbezittersBeroepsgroep(gem,nm,art,selBrp,selWpl,selBgp)
{
    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepsgroep.script.php";
    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroepsgroep');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp}, function(data) {
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);    
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
        chart.draw(stat, options);
    });
    }

function demZoekStatGrondbezittersWoonplaats(gem,nm,art,selBrp,selWpl,selBgp)
{
    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersWoonplaats.script.php";
    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Woonplaats');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp}, function(data) {
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);    
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
        chart.draw(stat, options);
    });
    }

function demZoekStatBarGrondbezitters(gem,selNm,selArt,selBrp,selWpl,selBgp)
{
    
    var output=[];
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezitters.script.php";

    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Eigenaar');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);  
        if (la==true) selArt.splice(0,selArt.length);  
        if (ln==true) selNm.splice(0,selNm.length);  
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            opp_count = 0;
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1]/parseInt(keyvaluearray[3]))];
                opp_count += parseInt(keyvaluearray[1]);
                i_count++;
            }
            output[i_count] = [('Anderen'),(parseInt(keyvaluearray[3]) - opp_count)];       
        }  
     
      var options = {
                       width:700,
                       legend: 'none',
        hAxis: {
          title: 'Eigenaar',
          minValue: 1
        },
        vAxis: {
          title: 'Grondbezit(m²)'
        }
      };        
        stat.addRows(output);
        var chart = new google.charts.Bar(document.getElementById('myBarChart'));

        chart.draw(stat, google.charts.Bar.convertOptions(options));
    });
}

function demZoekStatBarGrondbezittersBeroep(gem,nm,art,selBrp,selWpl,selBgp)
{
    
    var output=[];
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersBeroep.script.php";

    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var lb,lw,lg;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroep');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp}, function(data) {  
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);  
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
     
      var options = {
                       width:700,
                       legend: 'none',
        hAxis: {
          title: 'Beroep',
          minValue: 1
        },
        vAxis: {
          title: 'Grondbezit(m²)'
        }
      };        
        stat.addRows(output);
        var chart = new google.charts.Bar(document.getElementById('myBarChart'));

        chart.draw(stat, google.charts.Bar.convertOptions(options));
    });
}

function demZoekStatBarGrondbezittersBeroepsgroep(gem,nm,art,selBrp,selWpl,selBgp)
{
    
    var output=[];
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersBeroepsgroep.script.php";

    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var lb,lw,lg;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroepsgroep');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp}, function(data) {  
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);  
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
     
      var options = {
                       width:700,
                       legend: 'none',
        hAxis: {
          title: 'Beroepsgroep',
          minValue: 1
        },
        vAxis: {
          title: 'Grondbezit(m²)'
        }
      };        
        stat.addRows(output);
        var chart = new google.charts.Bar(document.getElementById('myBarChart'));

        chart.draw(stat, google.charts.Bar.convertOptions(options));
    });
}

function demZoekStatBarGrondbezittersWoonplaats(gem,nm,art,selBrp,selWpl,selBgp)
{
    
    var output=[];
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersWoonplaats.script.php";

    argumenten = '?gemeente='+gem+'&naam='+nm+'&artikelnr='+art;
    var lb,lw,lg;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Woonplaats');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl+argumenten,{selBrp,selWpl,selBgp}, function(data) {  
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);  
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            keyvaluearray=keyValueList[i_count].split("##");
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
     
      var options = {
                       width:700,
                       legend: 'none',
        hAxis: {
          title: 'Woonplaats',
          minValue: 1
        },
        vAxis: {
          title: 'Grondbezit(m²)'
        }
      };        
        stat.addRows(output);
        var chart = new google.charts.Bar(document.getElementById('myBarChart'));

        chart.draw(stat, google.charts.Bar.convertOptions(options));
    });
}

function demZoekGrondgebruikByGemeente(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekGrondgebruikByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle grondgebruik</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#grondgebruikbox').html('');
        $('#grondgebruikbox').html(poutput.join(''));
        $('.grondgebruikTextBox').attr("placeholder","Zoek woonplaats");
    });
}

function demZoekToponiemenByGemeente(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekToponiemenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle toponiemen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#toponiembox').html('');
        $('#toponiembox').html(poutput.join(''));
        $('.toponiemTextBox').attr("placeholder","Zoek toponiem");
    });
}
*/
function demZoekLagen() {
    var formatter = new ol.format.WMSCapabilities();
    var endpoint = mapviewerIP+ '/geoserver/wms';

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
            if (naam.substr(0,naam.indexOf(':')) === lagenprefix) {
                naam = naam.substr(naam.indexOf(':')+1);
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += naam ;//Item
                targetToPush += '</a></li>';      
            }
        }
        poutput.push(targetToPush);
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Zoek laag");        
    });
}

function demZoekLagenZoekString(selLg)
{
    selLg = getCookie('selLg');
    var formatter = new ol.format.WMSCapabilities();
    var endpoint = mapviewerIP+ '/geoserver/wms';    
    var laag = $(".lagenTextBox").val();
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
        i_count = 0;
        i_count2 = 0;

            
        while(i_count2<selLg.length)
        {            
            targetToPush += '<li><a href="#" class="small" data-value="';
            targetToPush += i_count;//id

            targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
            targetToPush += selLg[i_count2] ;//Item
            targetToPush += '</a></li>';                  

            i_count++;                
            i_count2++;                
        }
        for(i_count2=0;i_count2<layer.Layer.length;i_count2++){
            var naam = layer.Layer[i_count2].Name ;
            if (naam.substr(0,naam.indexOf(':')) === 'aezel') {
                naam = naam.substr(naam.indexOf(':')+1);
                if ((naam.indexOf(laag)) > 0) {
                    if ((jQuery.inArray( naam, selLg)) == -1) {
                        targetToPush += '<li><a href="#" class="small" data-value="';
                        targetToPush += i_count ;//id
                        targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                        targetToPush += naam ;//Item
                        targetToPush += '</a></li>';                  
                    }
                }
                i_count++;
            }
        }
        poutput.push(targetToPush);
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        });
}

function demZoekFamilienamenByGemeente(/*selGem*/)
{
    selGem = getCookie('selGem');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
            targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" checked="true"/>&nbsp;Alle namen</a></li>';
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count+1 ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#familienaambox').html('');
        $('#familienaambox').html(poutput.join(''));
        $('.familienaamTextBox').attr("placeholder","Zoek naam");
    });
}    

    function demZoekFamilienamen(selGem,selNm,selVnm,selArt)
{
       selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamen.script.php";
    var naam = $(".familienaamTextBox").val();
    argumenten = '?naam='+naam;
    var lg,lv,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{selGem,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            
            if ((selNm.indexOf('Alle namen') == -1) && (selNm.indexOf('Alle ') == -1)) {
                targetToPush +='<li><a href="#" class="small" data-value="0" tabIndex="-1"><input type="checkbox" />&nbsp;Alle namen</a></li>';
                i_count = 1;
            }
           
            while(i_count2<selNm.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selNm[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selNm )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#familienaambox').html('');
        $('#familienaambox').html(poutput.join(''));
        });
}


function demZoekGemeenten()
{
    
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekAlleGemeenten.script.php";
   $.post(targetUrl, function(data) {
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

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1]  ;//Item
                targetToPush += '</a></li>';      
                i_count++;
            }
            poutput.push(targetToPush);
            
            
        }
        
        $('#gemeentebox').html('');
        $('#gemeentebox').html(poutput.join(''));
        $('.gemeenteTextBox').attr("placeholder","Kies een gemeente...");        
        
        });
        
}


function demZoekGemeentenZoekString(/*selGem*/)
{

   selGem = getCookie('selGem');
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekGemeenten.script.php";
   var filter = $(".gemeenteTextBox").val();
   argumenten = '?gemeente='+filter;
   $.post(targetUrl+argumenten, function(data) {
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

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            var str = c.substring(name.length, c.length);
            return str.split(",");
        }
    }
    return "";
}
