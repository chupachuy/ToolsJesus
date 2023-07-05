<?php
if (!isset($_GET['file'])) {
	?>
    <script>
	var varPath = prompt('Ingresa el nombre de txt y carpeta fuente:\n\nRecuerda poner los fuentes en:\n[/Applications/XAMPP/htdocs/file_extractor/source/]');
	if (!varPath) {
		document.write('<p style="font-family:Arial; text-align:center;">Inserta un criterio de trabajo para continuar</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
	} else {
		document.location = 'index.php?file='+varPath;
	}
    </script>
	<?php
	exit();
}

if (!file_exists('txt/'.$_GET['file'].'.txt')) {
	exit('<p style="text-align:center;">No existe el archivo de texto <b>'.$_GET['file'].'</b> relacionado</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}
if (!file_exists('source/'.$_GET['file'].'')) {
	exit('<p style="text-align:center;">No existe la carpeta fuente <b>'.$_GET['file'].'</b> relacionada</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}

$varTRs = '<tr>';
$varTRs = '<th>Nombre de archivo</th><th>Existe?</th><th>Copiado?</th>';
$varTRs .= '</tr>';
$varIndex = 0;
$varFile = fopen('txt/'.$_GET['file'].'.txt', 'r');
if (!file_exists('output/'.$_GET['file'])) {
	mkdir('output/'.$_GET['file']);
	chmod('output/'.$_GET['file'], 0777);
}
while ($varLine = fgets($varFile)) {
	$varTRs .= '<tr id="tr_'.$varIndex.'">';
	$varTRs .= '<td id="td_file_'.$varIndex.'">'.str_replace(chr(10), '', $varLine).'</td>';
	$varTRs .= '<td id="td_exists_'.$varIndex.'"></td>';
	$varTRs .= '<td id="td_copied_'.$varIndex.'"></td>';
	$varTRs .= '</tr>';
	$varIndex++;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plantilla de lectura</title>
    <style>
    html {
		background:#000;
		color:#0F0;
		font-family:Arial;
		font-size:12px;
	}
    </style>
</head>

<body>
	<!--<p>Faltantes: <b><?=$varMiss;?></b></p>-->
    <table border="1" style="text-align:center;">
    	<tr>
        	<th>Total registros</th><th>Por procesar</th><th>Correctos</th><th>Erroneos</th><th></th>
        </tr>
        <tr>
        	<td id="td_total" style="color:#FF0;"><?=$varIndex;?></td><td id="td_processed" style="color:#CCC;"><?=$varIndex;?></td><td id="td_oks">0</td><td id="td_errs" style="color:#F00;">0</td><td><input type="button" value="Detener" onClick="javascript:fncAbort();"></td>
        </tr>
    </table>
    <hr>
	<table border="1">
    	<?=$varTRs;?>
    </table>
    <script>
    var varFileName = '<?=$_GET['file'];?>';
    </script>
	<script src="js/jquery.min.js"></script>
	<script src="js/index.js?t=<?=time();?>"></script>
</body>
</html>