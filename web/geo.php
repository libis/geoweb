<?php ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>LGGI - Geografisch kaartenbestand</title>
         <link rel="shortcut icon" href="favicon.ico" >
        <script type="text/javascript" src="js/demografie.js"></script>
    </head>
<script>
    
            
var thema = getQueryVariable("thema");

if (thema.indexOf('geo') == 0){
    window.open("./bevolking/geoheader.php?thema="+thema,"_self");
} else if (thema.indexOf('his') == 0){
    window.open("./bevolking/tijdslijn.php?thema="+thema,"_self");
}
</script>
