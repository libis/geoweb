
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
    var voornaam = $(".voornaamTextBox").val();
    argumenten = '?voornaam='+voornaam;
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamen.script.php";
    
    var lg,lv,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
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



function demZoekVoornamenWoonplaats()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');
   selWpl = getCookie('selWpl');
   var voornaam = $(".voornaamTextBox").val();
   argumenten = '?voornaam='+voornaam;
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenWoonplaats.script.php";
    
    var lg,lv,ln,la,lw;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selWpl,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekVoornamenBeroep()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');
   selBrp = getCookie('selBrp');
   var voornaam = $(".voornaamTextBox").val();
   argumenten = '?voornaam='+voornaam;
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenBeroep.script.php";
    
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selBrp,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekVoornamenBeroepsgroep()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');
   selBgp = getCookie('selBgp');
   var voornaam = $(".voornaamTextBox").val();
   argumenten = '?voornaam='+voornaam;
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenBeroepsgroep.script.php";
    
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lb=selBgp.length == 0) selBgp=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selBgp,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lb==true) selBgp.splice(0,selBgp.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekVoornamenByGemeente(selGem)
{
    selGem = getCookie('selGem');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekVoornamenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        var poutput = [];
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var targetToPush = '';  
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

function demZoekFamilienamenByGemeente(/*selGem*/)
{
    selGem = getCookie('selGem');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        data = data.trim();
        var poutput = [];
        
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var targetToPush = '';  
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

    function demZoekFamilienamen()
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
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
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



function demZoekFamilienamenWoonplaats()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selWpl = getCookie('selWpl');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenWoonplaats.script.php";
    var naam = $(".familienaamTextBox").val();
    argumenten = '?naam='+naam;
    var lg,lv,ln,la,lw;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selWpl,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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


function demZoekFamilienamenBeroep()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenBeroep.script.php";
    var naam = $(".familienaamTextBox").val();
    argumenten = '?naam='+naam;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selBrp,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekFamilienamenBeroepsgroep()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selVnm = getCookie('selVnm');
    selArt = getCookie('selArt');
    selBgp = getCookie('selBgp');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenBeroepsgroep.script.php";
    var naam = $(".familienaamTextBox").val();
    argumenten = '?naam='+naam;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lb=selBgp.length == 0) selBgp=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selBgp,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lb==true) selBgp.splice(0,selBgp.length);
        if (lg==true) selGem.splice(0,selGem.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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


function demZoekArtikelnummers()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   var artnr = $(".artTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummers.script.php";
    argumenten='?artnr='+artnr;
    var lg,lv,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
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
 

function demZoekArtikelnummersWoonplaats()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   selWpl = getCookie('selWpl');    
   var artnr = $(".artTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersWoonplaats.script.php";
    argumenten='?artnr='+artnr;
    var lg,lv,ln,la,lw;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selWpl}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekArtikelnummersBeroep()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   selBrp = getCookie('selBrp');    
   var artnr = $(".artTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersBeroep.script.php";
    argumenten='?artnr='+artnr;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selBrp}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekArtikelnummersBeroepsgroep()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   selBgp = getCookie('selBgp');    
   var artnr = $(".artTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersBeroepsgroep.script.php";
    argumenten='?artnr='+artnr;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBgp.length == 0) selBgp=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selBgp}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selBgp.splice(0,selBgp.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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


function demZoekArtikelnummersByGemeente(selGem)
{

   selGem = getCookie('selGem');
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersByGemeente.script.php";
   if (lg=selGem.length == 0) selGem=['Alle '];
   $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush='';

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


function demZoekBeroepen()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   selBrp = getCookie('selBrp');    
   var beroep = $(".beroepTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepen.script.php";
    argumenten='?beroep='+beroep;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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
        });
}

function demZoekWoonplaatsen()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   selWpl = getCookie('selWpl');    
   var woonplaats = $(".woonplaatsTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekwoonplaatsen.script.php";
    argumenten='?woonplaats='+woonplaats;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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

function demZoekBeroepsgroepen()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selVnm = getCookie('selVnm');
   selArt = getCookie('selArt');    
   selBgp = getCookie('selBgp');    
   var beroepsgroep = $(".beroepsgroepTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepen.script.php";
    argumenten='?beroepsgroep='+beroepsgroep;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selVnm.length == 0) selVnm=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBgp.length == 0) selBgp=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selVnm.splice(0,selVnm.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selBgp.splice(0,selBgp.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            while(i_count2<selBgp.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selBgp[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selBgp )) == -1) {

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
        });
}

function demZoekBeroepenByGemeente()
{
   selGem = getCookie('selGem');    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);
        data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
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

function demZoekWoonplaatsenByGemeente()
{
       selGem = getCookie('selGem');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);        
       data = data.trim();
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
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

function demZoekBeroepsgroepenByGemeente()
{
    selGem = getCookie('selGem');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==true) selGem.splice(0,selGem.length);   
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count =0;
            var poutput = [];
            var targetToPush = '';  
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

function demZoekFamilienamenStat()
{
    selGem = getCookie('selGem');
    selWpl = getCookie('selWpl');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');
    selBgp = getCookie('selBgp');
    selNm = getCookie('selNm');
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenStat.script.php";
    var naam = $(".familienaamTextBox").val();
    argumenten = '?naam='+naam;
    var lg,lv,la,lb,lw;
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lv=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selBrp,selWpl,selArt,selBgp}, function(data) {    
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selBgp.splice(0,selBgp.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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


function demZoekArtikelnummersStat()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selBgp = getCookie('selBgp');
   selWpl = getCookie('selWpl');
   selBrp = getCookie('selBrp');    
   selArt = getCookie('selArt');    
   var artnr = $(".artTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersStat.script.php";
    argumenten='?artnr='+artnr;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selBgp.length == 0) selBgp=['Alle '];
    if (lv=selWpl.length == 0) selWpl=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selWpl,selBrp,selBgp}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selWpl.splice(0,selWpl.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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


function demZoekBeroepenStat()
{
    
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selBgp = getCookie('selBgp');
   selWpl = getCookie('selWpl');
   selBrp = getCookie('selBrp');    
   selArt = getCookie('selArt');       
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepenStat.script.php";
    var beroep = $(".beroepTextBox").val();   
    argumenten = '?beroep='+beroep;
    var lb,lw,lg,ln,la;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lb=selGem.length == 0) selGem=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selWpl,selBgp,selNm,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lb==true) selGem.splice(0,selGem.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selWpl.splice(0,selWpl.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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
        });
        
}

function demZoekBeroepsgroepenStat()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selBgp = getCookie('selBgp');
   selWpl = getCookie('selWpl');
   selBrp = getCookie('selBrp');    
   selArt = getCookie('selArt');    
   var beroepsgroep = $(".beroepsgroepTextBox").val();
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenStat.script.php";
    argumenten='?beroepsgroep='+beroepsgroep;
    var lg,lv,ln,la,lb;
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (lv=selWpl.length == 0) selWpl=['Alle '];
    if (lg=selGem.length == 0) selGem=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selWpl,selBrp,selArt}, function(data) {    
        if (ln==true) selNm.splice(0,selNm.length);
        if (la==true) selArt.splice(0,selArt.length);
        if (lv==true) selWpl.splice(0,selWpl.length);
        if (lg==true) selGem.splice(0,selGem.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            while(i_count2<selBgp.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selBgp[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selBgp )) == -1) {

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
        });
}


function demZoekWoonplaatsenStat()
{
   selGem = getCookie('selGem');
   selNm = getCookie('selNm');
   selBgp = getCookie('selBgp');
   selArt = getCookie('selArt');
   selBrp = getCookie('selBrp');     
   selWpl = getCookie('selWpl');     
   
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenStat.script.php";
    var woonplaats = $(".woonplaatsTextBox").val();
    argumenten = '?woonplaats='+woonplaats;
    var lb,lw,lg,la,ln;
    if (la=selArt.length == 0) selArt=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl+argumenten,{hoofdlaag,selBrp,selBgp,selNm,selArt,selGem}, function(data) {    
        if (la==true) selArt.splice(0,selArt.length);
        if (ln==true) selNm.splice(0,selNm.length);
        if (lb==true) selBrp.splice(0,selBrp.length);
        if (lg==true) selBgp.splice(0,selBgp.length);
        if (lw==true) selGem.splice(0,selGem.length);
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
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



function demZoekStatGrondbezitters()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezitters.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per eigenaar'
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
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {
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
                output[i_count] = [(keyvaluearray[2]),Math.abs(parseInt(keyvaluearray[1]))];
                opp_count += Math.abs(parseInt(keyvaluearray[1]));
                i_count++;
            }
//            output[i_count] = [('Anderen'),(parseInt(keyvaluearray[3]) - opp_count)];       
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
        chart.draw(stat, options);
    });
}



function demZoekStatGrondbezittersPerGem()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte eigenaar per gemeente',

        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Gemeente');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {
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
                i_count++;
             
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieGemChart'));
        chart.draw(stat, options);
    });
}

function demZoekStatGrondbezittersBeroep()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');  
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroep.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per beroep'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroep');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
function demZoekStatGrondbezittersBeroepPerGem()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');  
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte beroep per gemeente'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'beroep per gemeente');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieGemChart'));
        chart.draw(stat, options);
    });
    }

function demZoekStatGrondbezittersBeroepsgroep()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');     
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepsgroep.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per beroepsgroep'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroepsgroep');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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

function demZoekStatGrondbezittersBeroepsgroepPerGem()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');     
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepsgroepPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlaket beroepsgroep per gemeente'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'gemeente');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieGemChart'));
        chart.draw(stat, options);
    });
    }

function demZoekStatGrondbezittersWoonplaats()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersWoonplaats.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per woonplaats van eigenaars'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Woonplaats');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selArt,selNm,selBrp,selWpl,selBgp}, function(data) {
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

function demZoekStatGrondbezittersWoonplaatsPerGem()
{
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');    
    var output=[];

    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statGrondbezittersWoonplaatsPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Opp woonplaats eigenaars per gemeente'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Gemeente');
    stat.addColumn('number', 'Percentage');
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem,selArt,selNm,selBrp,selWpl,selBgp}, function(data) {
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
            output = []; 
            while(i_count<keyValueList.length)
            {

                keyvaluearray=keyValueList[i_count].split("##");
                output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
               
                i_count++;
            }
        }  
        stat.addRows(output); // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('myPieGemChart'));
        chart.draw(stat, options);
    });
    }
    
function demZoekStatBarGrondbezitters()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezitters.script.php";
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Eigenaar');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
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
                        output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1])];
/*
                        keyvaluearray=keyValueList[i_count].split("##");
                        output[i_count] = [(keyvaluearray[2]),parseInt(keyvaluearray[1]/parseInt(keyvaluearray[3]))];
                        opp_count += parseInt(keyvaluearray[1]);
*/                
                        i_count++;
                
                    }
//                    output[i_count] = [('Anderen'),(parseInt(keyvaluearray[3]) - opp_count)];       
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

function demZoekStatBarGrondbezittersBeroep()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');    
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersBeroep.script.php";
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroep');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
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

function demZoekStatBarGrondbezittersBeroepsgroep()
{
    
    var output=[];
    selGem = getCookie('selGem');
    selNm = getCookie('selNm');
    selBgp = getCookie('selBgp');
    selArt = getCookie('selArt');
    selBrp = getCookie('selBrp');     
    selWpl = getCookie('selWpl');        
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersBeroepsgroep.script.php";
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroepsgroep');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
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

function demZoekStatBarGrondbezittersWoonplaats()
{
    
    var output=[];
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersWoonplaats.script.php";
    var lb,lw,lg,la,ln;
    if (lb=selBrp.length == 0) selBrp=['Alle '];
    if (lg=selBgp.length == 0) selBgp=['Alle '];
    if (lw=selWpl.length == 0) selWpl=['Alle '];
    if (ln=selNm.length == 0) selNm=['Alle '];
    if (la=selArt.length == 0) selArt=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Woonplaats');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
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
/*
function demZoekGrondgebruikByGemeente(selGem)
{
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekGrondgebruikByGemeente.script.php";
    if (lg=selGem.length == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
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
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
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


function demZoekTiles(thema) {
    
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekTiles.script.php";
   argumenten = '?thema='+thema;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueLayerList = data.split("%%");
            i_count = 0;
        
            var targetToPush = '';  
            
            while(i_count<keyValueLayerList.length)
            {
                keyvaluearray=keyValueLayerList[i_count].split("##");
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += keyvaluearray[2];//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1]  ;//Item
                targetToPush += '</a></li>';      
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#tilesbox').html('');
        $('#tilesbox').html(poutput.join(''));
        $('.tilesTextBox').attr("placeholder","Kies achtergrond");        
    });
}


function demZoekTilesZoekString(){


    var laag = $(".tilesTextBox").val();
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekTilesZoekString.script.php";
   argumenten = '?thema='+thema+'&laag='+laag;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        i_count = 0;
        i_count2 = 0;

        var targetToPush = '';  
        
       if(data.length>0)
        {
            keyValueList = data.split("%%");
        
            for(i_count2=0;i_count2<keyValueList.length;i_count2++)
            {
                keyvaluearray=keyValueList[i_count2].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count2;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1]  ;//Item
                targetToPush += '</a></li>';      
            }
            poutput.push(targetToPush);
            
        } 
        $('#tilesbox').html('');
        $('#tilesbox').html(poutput.join(''));
        $('.tilesTextBox').attr("placeholder","Zoek achtergrond");        
    });
    
}

function demZoekLagen(thema) {
    
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekLagen.script.php";
   argumenten = '?thema='+thema;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueLayerList = data.split("%%");
            i_count = 0;
        
            var targetToPush = '';  
            
            while(i_count<keyValueLayerList.length)
            {
                keyvaluearray=keyValueLayerList[i_count].split("##");
                if (i_count == 0) {
                    mainLayer = keyValueLayerList[0];
                    hoofdlaag = mainLayer.split("##");
                    hoofdlaag[1] = hoofdlaag[1].trim();
                    hoofdlaag[2] = hoofdlaag[2].trim();                    
                    if (thema.indexOf('geo') == 0){

                        var imag = '<img src="'+mapviewerIP+'/geoserver/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER='+hoofdlaag[2].trim()+':'+hoofdlaag[1].trim()+'&amp;STYLE='+hoofdlaag[3]+'">';
                        $("#legend-form").html(imag);

                        targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/isTijdAanwezig.script.php";
                        argumenten = '?laag='+hoofdlaag[1]+'&omgeving='+hoofdlaag[2];
                        $.post(targetUrl+argumenten, function(data) {
                            if (data == true) {
                                openTijdslijn = true;
                                tijdlijn = false;
                            }                            
                            demZoekGemeenten();              
                        });
                    } else {
                        openLaag(hoofdlaag[2],hoofdlaag[1]);
                    }
                } else {
                    targetToPush += '<li><a href="#" class="small" data-value="';
                    targetToPush += keyvaluearray[2];//id

                    targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                    targetToPush += keyvaluearray[1]  ;//Item
                    targetToPush += '</a></li>';      
                }
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Zoek voorgrond");        
    });
}

function demCheckStijlen(thema) {
    
    targetUrlStijlen="http://"+websiteIP+websitePath+"/CRUDScripts/checkStijlen.script.php";
    argumentenStijlen = '?thema='+thema;
   
    $.post(targetUrlStijlen+argumentenStijlen, function(data){
    });    
}


function demZoekLagenGeoserver() {
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
        $('.lagenTextBox').attr("placeholder","Zoek voorgrond");        
    });
}


function demZoekLagenZoekString(thema){

            selLg = getCookie('selLg');

    var laag = $(".lagenTextBox").val();
    targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekLagenZoekString.script.php";
   argumenten = '?thema='+thema+'&laag='+laag+'&hoofdlaag='+hoofdlaag[1];
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        i_count = 0;
        i_count2 = 0;

        var targetToPush = '';  
        
       if(data.length>0)
        {
            keyValueList = data.split("%%");
        
            for(i_count2=0;i_count2<keyValueList.length;i_count2++)
            {
                keyvaluearray=keyValueList[i_count2].split("##");

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count2;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1]  ;//Item
                targetToPush += '</a></li>';      
            }
            poutput.push(targetToPush);
            
        } 
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Zoek voorgrond");        
    });
    
}

function demZoekLagenZoekStringGeoServer(selLg)
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
                naam = naam.substr(naam.indexOf(':')+1).toLowerCase();
                
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

function demZoekGemeenten()
{
    
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekAlleGemeenten.script.php";
   $.post(targetUrl,{hoofdlaag}, function(data) {
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

function demZoekGemeentenZoekString()
{

   selGem = getCookie('selGem');
   targetUrl="http://"+websiteIP+websitePath+"/CRUDScripts/zoekGemeenten.script.php";
   var filter = $(".gemeenteTextBox").val();
   argumenten = '?gemeente='+filter;
   $.post(targetUrl+argumenten,{hoofdlaag}, function(data) {
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
            if (str=="") return [];
            return str.split(",");
        }
    }
    return "";
}

    function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var result = 'false';
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){
                result = pair[1];
            }
        }
        return(result);
    }
