<script>
var varFiles = new Array();
var varCount = 0;
var varDownloaded = '';
var varSeconds = 15;
</script>
<?php
ini_set('max_execution_time', 30000);
if (!isset($_GET['xml']) || !isset($_GET['start'])) {
  exit('Sin datos');
}
echo '<script>varCount='.$_GET['start'].';</script>';
$varOnix = simplexml_load_file('onix/'.$_GET['xml'].'.xml');
if (isset($_GET['time'])) {
  echo '<script>varSeconds='.$_GET['time'].';</script>';
}
if (isset($_GET['type'])) {
  $varType = $_GET['type']=='cover'?'CoverImageLink':'MediaFileLink';
} else {
  $varType = 'MediaFileLink';
}

//$con= mysqli_connect("192.168.1.166","joseche","1234","editor_content_mgr_20151216_server");

//print_r($varOnix);


for ($varK=0; $varK<count($varOnix); $varK++) {
  if (isset($varOnix->Product[$varK]->{$varType})){ //&& $varOnix->Product[$varK]->NotificationType!='05' && $varOnix->Product[$varK]->EpubType=='029') {  //Verifica que exista el cover o content en el nodo
  //if (isset($varOnix->Product[$varK]->{$varType})) {  //Verifica que exista el cover o content en el nodo
    
      echo '<script>varFiles.push("'.$varOnix->Product[$varK]->{$varType}.'");</script>';
      //echo '<script>varFiles.push("https://clubedeautores.com.br/partners/editorialink/download/'.$varOnix->Product[$varK]->ProductIdentifier->IDValue.'/cover");</script>';
    
    /*if (!file_exists("files/imgs/".$varOnix->Product[$varK]->ProductIdentifier->IDValue.".jpg")) {
     echo '<script>varFiles.push("'.$varOnix->Product[$varK]->{$varType}.'");</script>';
    }*/
  }
}
?>
<html>
  <head>
  </head>
  <body>
    <span id='spn_output'>...</span>
    <input type="button" onClick="javascript:fncPause();" value="Pausa" />
    <input type="button" onClick="javascript:fncContinue();" value="Reanudar" />
    <a name="a_ancla" id="a_ancla" >&nbsp;</a>
  </body>
    <script>
    alert(varFiles.length);
    var varInterval = setInterval(fncInterval, varSeconds*1000);
    function fncInterval() {
      window.open(varFiles[varCount]);
      varDownloaded += 'Archivo descargado: '+varCount+': '+varFiles[varCount]+'<br />';
      document.getElementById('spn_output').innerHTML = varDownloaded;
      varCount++;
      if (varCount>=varFiles.length) {
        varDownloaded += 'Finalizado!<br />';
        document.getElementById('spn_output').innerHTML = varDownloaded;
        clearInterval(varInterval);
      }
    document.location = '#a_ancla';
    }
    function fncPause() {
      clearInterval(varInterval);
      varDownloaded += 'Pausa<br />';
      document.getElementById('spn_output').innerHTML = varDownloaded;
    }
    function fncContinue() {
      varDownloaded += 'Reanudado...<br />';
      document.getElementById('spn_output').innerHTML = varDownloaded;
      varInterval = setInterval(fncInterval, varSeconds*1000);
      fncInterval();
    }
    </script>    
</html>

