function demZoekMenu(thema,menu){
    
    argumenten = '?thema='+thema;
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekMenu.script.php";
    
    $.post(targetUrl+argumenten, function(data) {    
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            i_count = 0;
            var first = true;
            var targetToPush = '<ul class="nav navbar-nav">'; 
            keyValueList = data.split("%%");
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                targetToPush +='<li class="nav-item"  role="presentation">';
                if (keyvaluearray[1].indexOf('tatistie') > -1){
                    targetToPush +='<a class="nav-header" href="javascript:void(0)" onclick="eigenaars_statistieken();">Statistieken</a>';
                } else {
                    targetToPush +='<a class="nav-header" href="javascript:void(0)" onclick="openMenu(\''+thema+'\',\''+keyvaluearray[1]+'\');">'+keyvaluearray[1]+'</a>';
                }
                targetToPush +='</li>';
                i_count++;
                if (first==true) {
                    if ((menu != "") && (menu != "false")){
                        openMenu(thema,menu);
                    } else {
                        actiefmenu = keyvaluearray[1];
                        openMenu(thema,keyvaluearray[1]);
                    }
                    first = false;
                }
            }
            targetToPush += '</ul>';
            poutput.push(targetToPush);
        $('#navbarSupportedContent').html('');
        $('#navbarSupportedContent').html(poutput.join(''));            
        }        
    });
}

function openMenu(thema,menu){
    
    argumenten = '?thema='+thema+'&menu='+menu;
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekCrit.script.php";
    
    //reset lagen en tiles
    selLg.splice(0,selLg.length);
    selTg.splice(0,selTg.length);
    selCrit.splice(0,selCrit.length);
    
    
    $('#geo_menu_title').html('');
    $('#geo_menu_title').html('<h2>'+menu[0].toUpperCase()+menu.substring(1)+'</h2>');       
    
    $.post(targetUrl+argumenten, function(data) {    
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            i_count = 0;
            var first = true;
            var targetToPush = ''; 
            keyValueList = data.split("%%");
            while(i_count<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count].split("##");
                //if (keyvaluearray[1].toLowerCase().indexOf('emeent') > -1) { 
                if (i_count==0) {                     
                    //flGem =true;
                    if (keyvaluearray[2] != "") {
                        //in geval er een vaste gemeente gekozen wordt...
                        //flGem = false;
                        //selGem.push(keyvaluearray[2]);
                        selCrit.push([keyvaluearray[1].toLowerCase(),[keyvaluearray[2]],false,true]);
                        i_count++;
                        continue;
                    }
                }
                //INITIALISATIE criteriaLijst met criterium kolom naam, geselecteerde criterium items en aangeklikte criteriumboxvlag
                selCrit.push([keyvaluearray[1].toLowerCase(),[],true,false]);
                if (keyvaluearray[1].toLowerCase().indexOf('voorna') > -1) flVnm =true;
                if (keyvaluearray[1].toLowerCase().indexOf('naam') > -1) flNm = true;
                if (keyvaluearray[1].toLowerCase().indexOf('topo') > -1) flTpn = true;
                if (keyvaluearray[1].toLowerCase().indexOf('art') > -1) flArt = true;
                if (keyvaluearray[1].toLowerCase().indexOf('beroepsgroe') > -1) flBgp = true;
                if (keyvaluearray[1].toLowerCase().indexOf('beroep') > -1) flBrp = true;
                if (keyvaluearray[1].toLowerCase().indexOf('woonpl') > -1) flWpl = true;
                if (keyvaluearray[1].toLowerCase().indexOf('vak') > -1) flVak = true;
                if (keyvaluearray[1].toLowerCase().indexOf('graf') > -1) flGrf = true;
/*
                targetToPush += '<div class="button-group">'; 
                targetToPush += '<input class="geotextbox '+keyvaluearray[1]+'TextBox" name="'+keyvaluearray[1]+'box" placeholder="Kies '+keyvaluearray[1]+'" onkeyup="demZoek'+keyvaluearray[1]+'();" maxlength="20"/>';
                targetToPush += '<button id="'+keyvaluearray[1]+'_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">'+keyvaluearray[1].substr(0,1).toUpperCase()+keyvaluearray[1].substr(1)+'<span class="caret"></span></button>';
                targetToPush += '<ul id='+keyvaluearray[1]+'box class="dropdown-menu">';
                targetToPush += '</ul>';
                targetToPush += '</div>';
*/
                targetToPush += '<div class="button-group">'; 
                targetToPush += '<input class="geotextbox '+i_count+'TextBox" name="'+keyvaluearray[1]+'box" placeholder="Kies '+keyvaluearray[1]+'" onkeyup="demZoek('+i_count+');" maxlength="20"/>';
                targetToPush += '<button id="'+i_count+'_btn" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">'+keyvaluearray[1].substr(0,1).toUpperCase()+keyvaluearray[1].substr(1)+'<span class="caret"></span></button>';
                targetToPush += '<ul id='+i_count+'box name='+i_count+' class="dropdown-menu">';
                targetToPush += '</ul>';
                targetToPush += '</div>';
                i_count++;
            }
            poutput.push(targetToPush);
        $('#geo_zoekcriteria').html('');
        $('#geo_zoekcriteria').html(poutput.join('')); 
        resetGeo();
        demZoekLagen(thema,menu);
        demZoekTiles(thema);
         
        }        
    });    

    
}

function demZoek(criteriumNr)
{
    if (criteriumNr == 0) {
        demZoekHoofdCriterium();
        return;
    }
    var criterium = selCrit[criteriumNr][0];
    var crit = $("."+criteriumNr+"TextBox").val();
    
    argumenten = '?filter='+crit+'&criterium='+criterium;
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekCriterium.script.php";
    $.post(targetUrl+argumenten,{hoofdlaag,selCrit}, function(data) {    
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            while(i_count2<selCrit[criteriumNr][1].length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += [selCrit[criteriumNr][1]][i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selCrit[criteriumNr][1] )) == -1) {

                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count ;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox"/>&nbsp;';
                targetToPush += keyvaluearray[1] ;//Item
                targetToPush += '</a></li>';                  
                }
                i_count++;
                i_count2++;
            }
        }
        poutput.push(targetToPush);
        $('#'+criteriumNr+'box').html('');
        $('#'+criteriumNr+'box').html(poutput.join(''));
        $('.'+criteriumNr+'TextBox').attr("placeholder","Kies "+selCrit[criteriumNr][0]);
        });
        
}

function demZoekCriteriumBy0Box(boxNr){
    
    var criterium = selCrit[boxNr][0];
    var sel0Box = selCrit[0];
    var targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekCriteriumBy0Box.script.php";
    var argumenten = "?criterium="+criterium;
    
    $.post(targetUrl+argumenten,{hoofdlaag,sel0Box}, function(data) {
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
        $('#'+boxNr+'box').html('');
        $('#'+boxNr+'box').html(poutput.join(''));
        $('.'+boxNr+'TextBox').attr("placeholder","Kies "+selCrit[boxNr][0]);
    });    
}


function demZoekVak()
{
    
    var vak = $(".vakTextBox").val();
    argumenten = '?vak='+vak;
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekVak.script.php";
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            while(i_count2<selVak.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selVak[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selVak )) == -1) {

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
        $('#vakbox').html('');
        $('#vakbox').html(poutput.join(''));
        });
        
}


function demZoekVakByGemeente()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekVakByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);   
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
        $('#vakbox').html('');
        $('#vakbox').html(poutput.join(''));
        $('.vakTextBox').attr("placeholder","Kies vak");
    });
}

function demZoekGraf_van()
{
    
    var graf_van = $(".graf_vanTextBox").val();
    argumenten = '?graf_van='+graf_van;
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekGraf_van.script.php";
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueList = data.split("%%");
            i_count = 0;
            i_count2 = 0;
        
            var targetToPush = ''; 
            while(i_count2<selGrf.length)
            {            
                targetToPush += '<li><a href="#" class="small" data-value="';
                targetToPush += i_count;//id

                targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
                targetToPush += selGrf[i_count2] ;//Item
                targetToPush += '</a></li>';                  
               
                i_count++;                
                i_count2++;                
            }
            i_count2 = 0;
            while(i_count2<keyValueList.length)
            {
                keyvaluearray=keyValueList[i_count2].split("##");
                if ((jQuery.inArray( keyvaluearray[1], selGrf )) == -1) {

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
        $('#graf_vanbox').html('');
        $('#graf_vanbox').html(poutput.join(''));
        });
        
}


function demZoekGraf_vanByGemeente()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekGraf_vanByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);   
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
        $('#graf_vanbox').html('');
        $('#graf_vanbox').html(poutput.join(''));
        $('.graf_vanTextBox').attr("placeholder","Kies graf van");
    });
}


function demZoekvoornamen()
{
    
    var voornaam = $(".voornamenTextBox").val();
    argumenten = '?voornaam='+voornaam;
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekVoornamen.script.php";
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
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
        $('#voornamenbox').html('');
        $('#voornamenbox').html(poutput.join(''));
        });
        
}


function demZoekVoornamenByGemeente()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekVoornamenByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);   
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
        $('#voornamenbox').html('');
        $('#voornamenbox').html(poutput.join(''));
        $('.voornamenTextBox').attr("placeholder","Kies voornaam");
    });
}

function demZoekFamilienamenByGemeente(/*selGem*/)
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);   
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
        $('#naambox').html('');
        $('#naambox').html(poutput.join(''));
        $('.naamTextBox').attr("placeholder","Kies naam");
    });
}    

    function demZoekFamilienamen()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekFamilienamen.script.php";
    var naam = $(".naamTextBox").val();
    argumenten = '?naam='+naam;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {  
       
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
        
        $('#naambox').html('');
        $('#naambox').html(poutput.join(''));
        });
}

   function demZoeknaam()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekFamilienamen.script.php";
    var naam = $(".naamTextBox").val();
    argumenten = '?naam='+naam;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
        
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
        
        $('#naambox').html('');
        $('#naambox').html(poutput.join(''));
        });
}



function demZoekartikelnummer()
{
   var artnr = $(".artikelnummerTextBox").val();
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummers.script.php";
    argumenten='?artnr='+artnr;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
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
 


function demZoekArtikelnummersByGemeente()
{

   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersByGemeente.script.php";
   if ((lg=selGem.length) == 0) selGem=['Alle '];
   $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);
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
        $('.artikelnummerTextBox').attr("placeholder","Kies artikelnummer");
        });
        
} 


function demZoekberoep()
{
   var beroep = $(".beroepTextBox").val();
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekBeroepen.script.php";
    argumenten='?beroep='+beroep;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
        
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

function demZoekwoonplaats()
{
   var woonplaats = $(".woonplaatsTextBox").val();
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekwoonplaatsen.script.php";
    argumenten='?woonplaats='+woonplaats;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
        
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

function demZoekberoepsgroep()
{
   var beroepsgroep = $(".beroepsgroepTextBox").val();
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepen.script.php";
    argumenten='?beroepsgroep='+beroepsgroep;

    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selVnm,selArt,selBgp,selBrp,selWpl,selVak,selGrf}, function(data) {    
        
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekBeroepenByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);
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
        $('.beroepTextBox').attr("placeholder","Kies beroep");
    });
}

function demZoekWoonplaatsenByGemeente()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);        
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
        $('.woonplaatsTextBox').attr("placeholder","Kies woonplaats");
    });
}

function demZoekBeroepsgroepenByGemeente()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenByGemeente.script.php";
    if ((lg=selGem.length) == 0) selGem=['Alle '];
    $.post(targetUrl,{hoofdlaag,selGem}, function(data) {
       if (lg==0) selGem.splice(0,selGem.length);   
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
        $('.beroepsgroepTextBox').attr("placeholder","Kies beroepsgroep");
    });
}

function demZoekFamilienamenStat()
{
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekFamilienamenStat.script.php";
    var naam = $(".naamTextBox").val();
    argumenten = '?naam='+naam;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selBrp,selWpl,selArt,selBgp}, function(data) {    
        
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
        
        $('#naambox').html('');
        $('#naambox').html(poutput.join(''));
        });

        
}


function demZoekArtikelnummersStat()
{
   var artnr = $(".artikelnummerTextBox").val();
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekArtikelnummersStat.script.php";
    argumenten='?artnr='+artnr;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selWpl,selBrp,selBgp}, function(data) {    
        
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
    
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekBeroepenStat.script.php";
    var beroep = $(".beroepTextBox").val();   
    argumenten = '?beroep='+beroep;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selWpl,selBgp,selNm,selArt}, function(data) {    
        
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
   var beroepsgroep = $(".beroepsgroepTextBox").val();
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekBeroepsgroepenStat.script.php";
    argumenten='?beroepsgroep='+beroepsgroep;
    $.post(targetUrl+argumenten,{hoofdlaag,selGem,selNm,selWpl,selBrp,selArt}, function(data) {    
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
   
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekWoonplaatsenStat.script.php";
    var woonplaats = $(".woonplaatsTextBox").val();
    argumenten = '?woonplaats='+woonplaats;
    $.post(targetUrl+argumenten,{hoofdlaag,selBrp,selBgp,selNm,selArt,selGem}, function(data) {    
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezitters.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per eigenaar'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Eigenaar');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte eigenaar per gemeente',

        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Gemeente');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroep.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per beroep'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroep');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte beroep per gemeente'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'beroep per gemeente');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
    var output=[];

    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepsgroep.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per beroepsgroep'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroepsgroep');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
    var output=[];

    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersBeroepsgroepPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte beroepsgroep per gemeente'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'gemeente');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selNm,selArt,selBrp,selWpl,selBgp}, function(data) {
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
    var output=[];

    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersWoonplaats.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Oppervlakte per woonplaats van eigenaars'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Woonplaats');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selArt,selNm,selBrp,selWpl,selBgp}, function(data) {
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
    var output=[];

    targetUrl=websiteIP+websitePath+"/CRUDScripts/statGrondbezittersWoonplaatsPerGem.script.php";
    var options = {
            'legend':'left',
            'is3D':true,
            'width':700,
            'title':'Opp woonplaats eigenaars per gemeente'
        };
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Gemeente');
    stat.addColumn('number', 'Percentage');
    $.post(targetUrl,{hoofdlaag,selGem,selArt,selNm,selBrp,selWpl,selBgp}, function(data) {
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statBarGrondbezitters.script.php";
    var lb,lw,lg,la,ln;
    if ((lb=selBgp.length) == 0) selBrp=['Alle '];
    if ((lg=selBgp.length) == 0) selBgp=['Alle '];
    if ((lw=selWpl.length) == 0) selWpl=['Alle '];
    if ((la=selArt.length) == 0) selArt=['Alle '];
    if ((ln=selNm.length) == 0) selNm=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Eigenaar');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
        if (lb==0) selBrp.splice(0,selBrp.length);
        if (lg==0) selBgp.splice(0,selBgp.length);
        if (lw==0) selWpl.splice(0,selWpl.length);  
        if (la==0) selArt.splice(0,selArt.length);  
        if (ln==0) selNm.splice(0,selNm.length);  
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersBeroep.script.php";
    var lb,lw,lg,la,ln;
    if ((lb=selBgp.length) == 0) selBrp=['Alle '];
    if ((lg=selBgp.length) == 0) selBgp=['Alle '];
    if ((lw=selWpl.length) == 0) selWpl=['Alle '];
    if ((la=selArt.length) == 0) selArt=['Alle '];
    if ((ln=selNm.length) == 0) selNm=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroep');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
        if (lb==0) selBrp.splice(0,selBrp.length);
        if (lg==0) selBgp.splice(0,selBgp.length);
        if (lw==0) selWpl.splice(0,selWpl.length);  
        if (la==0) selArt.splice(0,selArt.length);  
        if (ln==0) selNm.splice(0,selNm.length);   
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersBeroepsgroep.script.php";
    var lb,lw,lg,la,ln;
    if ((lb=selBgp.length) == 0) selBrp=['Alle '];
    if ((lg=selBgp.length) == 0) selBgp=['Alle '];
    if ((lw=selWpl.length) == 0) selWpl=['Alle '];
    if ((ln=selNm.length) == 0) selNm=['Alle '];
    if ((la=selArt.length) == 0) selArt=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Beroepsgroep');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
        if (lb==0) selBrp.splice(0,selBrp.length);
        if (lg==0) selBgp.splice(0,selBgp.length);
        if (lw==0) selWpl.splice(0,selWpl.length);  
        if (la==0) selArt.splice(0,selArt.length);  
        if (ln==0) selNm.splice(0,selNm.length); 
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
    targetUrl=websiteIP+websitePath+"/CRUDScripts/statBarGrondbezittersWoonplaats.script.php";
    var lb,lw,lg,la,ln;
    if ((lb=selBgp.length) == 0) selBrp=['Alle '];
    if ((lg=selBgp.length) == 0) selBgp=['Alle '];
    if ((lw=selWpl.length) == 0) selWpl=['Alle '];
    if ((ln=selNm.length) == 0) selNm=['Alle '];
    if ((la=selArt.length) == 0) selArt=['Alle '];
    var stat = new google.visualization.DataTable();
    stat.addColumn('string', 'Woonplaats');
    stat.addColumn('number', 'Oppervlakte(m²)');
    $.post(targetUrl,{hoofdlaag,selGem,selBrp,selWpl,selBgp,selNm,selArt}, function(data) {  
        if (lb==0) selBrp.splice(0,selBrp.length);
        if (lg==0) selBgp.splice(0,selBgp.length);
        if (lw==0) selWpl.splice(0,selWpl.length);  
        if (la==0) selArt.splice(0,selArt.length);  
        if (ln==0) selNm.splice(0,selNm.length); 
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

function demZoekTiles(thema) {
    
   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekTiles.script.php";
   argumenten = '?thema='+thema;
   $.post(targetUrl+argumenten, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding
        if(data.length>0)
        {
            keyValueTilesList = data.split("%%");
            i_count = 0;
        
            var targetToPush = '';  
            
            while(i_count<keyValueTilesList.length)
            {
                keyvaluearray=keyValueTilesList[i_count].split("##");
                    targetToPush += '<li><a href="#" class="small" data-value="';
                    targetToPush += keyvaluearray[2];//id
                    targetToPush += '" tabIndex="-1"><input type="checkbox" ';
                    if (keyvaluearray[3] == 't') {
                        targetToPush += 'checked=true';
                        selTg.push(keyvaluearray[1].trim());
                    }
                    targetToPush += '>&nbsp;';
                    targetToPush += keyvaluearray[1].trim();//Item
                    targetToPush += '</a></li>';       
                i_count++;
            }
            poutput.push(targetToPush);
        }
        $('#tilesbox').html('');
        $('#tilesbox').html(poutput.join(''));
        $('.tilesTextBox').attr("placeholder","Kies achtergrond");   
         getMapStartup(thema); 
    });
}


function demZoekTilesZoekString()
{
    var laag = $(".tilesTextBox").val();
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekTilesZoekString.script.php";
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
        $('.tilesTextBox').attr("placeholder","Kies achtergrond");        
    });
    
}

function demZoekLagen(thema,menu) 
{
   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekLagen.script.php";
   argumenten = '?thema='+thema+'&menu='+menu;
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

                        var imag = '<img src="'+mapviewerIP+'/wms?Service=WMS&amp;REQUEST=GetLegendGraphic&amp;VERSION=1.0.0&amp;FORMAT=image/png&amp;WIDTH=50&amp;HEIGHT=10&amp;LAYER='+hoofdlaag[2].trim()+':'+hoofdlaag[1].trim()+'&amp;STYLE='+hoofdlaag[3]+'">';
                        $("#legend-form").html(imag);

                        targetUrl=websiteIP+websitePath+"/CRUDScripts/isTijdAanwezig.script.php";
                        argumenten = '?laag='+hoofdlaag[1]+'&omgeving='+hoofdlaag[2];
                        $.post(targetUrl+argumenten, function(data) {
                            if (data == true) {
                                openTijdslijn = true;
                                tijdlijn = false;
                            } 
                            if (menu != 'statistieken'){
                                if (selCrit[0][1].length == 0) {
                                    demZoekHoofCriteriumInit();
                                } else {
                                    //in geval er een vaste gemeente is geconfigureerd
                                    ZoekGerelateerdeLijsten0Box();
                                }             
                            } else {                            
                                if (selGem.length == 0) {
                                    demZoekGemeentenInit();
                                } else {
                                    //in geval er een vaste gemeente is geconfigureerd
                                    ZoekGerelateerdeLijstenGem();
                                }             
                            }
                            
                        });
                    } else {
                        selLg.push(keyvaluearray[1].trim());
                    }
                } else {
                    targetToPush += '<li><a href="#" class="small" data-value="';
                    targetToPush += keyvaluearray[2];//id
                    targetToPush += '" tabIndex="-1"><input type="checkbox" ';
                    if (keyvaluearray[4] == 't') {
                        targetToPush += 'checked=true';
                        selLg.push(keyvaluearray[1].trim());
                    }
                    targetToPush += '>&nbsp;';
                    targetToPush += keyvaluearray[1].trim();//Item
                    targetToPush += '</a></li>';    
                }
                i_count++;
            }
            if (thema.indexOf('hist') == 0){
                openLaag(hoofdlaag[2]);
            }
            poutput.push(targetToPush);
        }
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Kies voorgrond");        
    });
}


function demZoekLagenHist(thema) 
{
   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekLagenHist.script.php";
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
                    selLg.push(keyvaluearray[1].trim());
                } else {
                    targetToPush += '<li><a href="#" class="small" data-value="';
                    targetToPush += keyvaluearray[2];//id
                    targetToPush += '" tabIndex="-1"><input type="checkbox" ';
                    if (keyvaluearray[4] == 't') {
                        targetToPush += 'checked=true';
                        selLg.push(keyvaluearray[1].trim());
                    }
                    targetToPush += '>&nbsp;';
                    targetToPush += keyvaluearray[1].trim();//Item
                    targetToPush += '</a></li>';    
                }
                i_count++;
            }
            openLaag(hoofdlaag[2]);
            poutput.push(targetToPush);
        }
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Kies voorgrond");        
    });
}


function demCheckStijlen(thema) {
    
    targetUrlStijlen=websiteIP+websitePath+"/CRUDScripts/checkStijlen.script.php";
    argumentenStijlen = '?thema='+thema;
   
    $.post(targetUrlStijlen+argumentenStijlen, function(data){
    });    
}


function demZoekLagenGeoserver() {
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
        $('.lagenTextBox').attr("placeholder","Kies voorgrond");        
    });
}

function demZoekLagenZoekString(thema,menu){


    var laag = $(".lagenTextBox").val();
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekLagenZoekString.script.php";
   argumenten = '?thema='+thema+'&menu='+menu+'&laag='+laag+'&hoofdlaag='+hoofdlaag[1];
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
        $('.lagenTextBox').attr("placeholder","Kies voorgrond");        
    });
    
}

function demZoekLagenHistZoekString(thema){


    var laag = $(".lagenTextBox").val();
    targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekLagenHistZoekString.script.php";
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
        $('#lagenbox').html('');
        $('#lagenbox').html(poutput.join(''));
        $('.lagenTextBox').attr("placeholder","Kies voorgrond");        
    });
    
}

function demZoekLagenZoekStringGeoServer(selLg)
{
    var formatter = new ol.format.WMSCapabilities();
    var endpoint = mapviewerIP+ '/wms';    
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


function demZoekHoofCriteriumInit() {
    
    
   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekHoofdCriterium.script.php";
   
   argumenten = '?criterium='+selCrit[0][0]+'&filter=';
   $.post(targetUrl+argumenten,{hoofdlaag}, function(data) {
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
        $('#0box').html('');
        $('#0box').html(poutput.join(''));
        $('.0TextBox').attr("placeholder","Kies een "+selCrit[0][0]+"...");        
    });    
}

function demZoekHoofdCriterium()
{

   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekHoofdCriterium.script.php";
   var filter = $(".0TextBox").val();
   var criterium = selCrit[0][0];
   argumenten = '?criterium='+criterium+'&filter='+filter;
   $.post(targetUrl+argumenten,{hoofdlaag}, function(data) {
        data = data.trim();
        var poutput = [];// voorbereiding        // I want a list of names to use in my queries
        var targetToPush = '';  
        i_count = 0;
        i_count2 = 0;

            
        while(i_count2<selCrit[0][1].length)
        {            
            targetToPush += '<li><a href="#" class="small" data-value="';
            targetToPush += i_count;//id

            targetToPush += '" tabIndex="-1"><input type="checkbox" checked/>&nbsp;';
            targetToPush += selCrit[0][1][i_count2] ;//Item
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
            
        }        
        poutput.push(targetToPush);
        $('#0box').html('');
        $('#0box').html(poutput.join(''));
        });
}


function demZoekGemeentenInit()
{
    
   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekAlleGemeenten.script.php";
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

   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekGemeenten.script.php";
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

function demZoekgemeente()
{

   targetUrl=websiteIP+websitePath+"/CRUDScripts/zoekGemeenten.script.php";
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



