<?php
if (!isset($_GET['file'])) {
	?>
    <script>
	var varPath = prompt('Ingresa el nombre de txt y carpeta fuente:');
	if (!varPath) {
		document.write('<p style="font-family:Arial; text-align:center;">Inserta un criterio de trabajo para continuar</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
	} else {
		document.location = 'index.php?file='+varPath;
	}
    </script>
	<?php
	exit('1');
}

if (!file_exists('txt/'.$_GET['file'].'.txt')) {
	exit('<p style="text-align:center;">No existe el archivo de texto <b>'.$_GET['file'].'</b> relacionado</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}
if (!file_exists('source/'.$_GET['file'].'')) {
	exit('<p style="text-align:center;">No existe la carpeta fuente <b>'.$_GET['file'].'</b> relacionada</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}

$varTRs = '<tr>';
$varTRs .= '<th>Archivo fuente</th>';
$varTRs .= '<th>Existe?</th>';
$varTRs .= '<th>Nuevo nombre</th>';
$varTRs .= '<th>Existe?</th>';
$varTRs .= '<th>Renombrado</th>';
$varTRs .= '</tr>';

$varFile = fopen('txt/'.$_GET['file'].'.txt', 'r');
while ($varLine = fgets($varFile)) {
	$varExplode = explode('->', $varLine);
	$varExistFile = file_exists('source/'.$_GET['file'].'/'.$varExplode[0]);
	$varExistFileRen = file_exists('source/'.$_GET['file'].'/'.$varExplode[1]);
	$varTRs .= '<tr style="background:#'.(($varExistFile || $varExistFileRen)?'000':'555').'">';
	$varTRs .= '<td>'.$varExplode[0].'</td>';
	$varTRs .= '<td>'.$varExistFile.'</td>';
	$varTRs .= '<td>'.$varExplode[1].'</td>';
	$varTRs .= '<td>'.$varExistFileRen.'</td>';
	if ($varExistFile) {
		rename('source/'.$_GET['file'].'/'.$varExplode[0], 'source/'.$_GET['file'].'/'.((string)str_replace(chr(10), '', $varExplode[1])) );
		$varTRs .= '<td>ok</td>';
	} else {
		$varTRs .= '<td>-</td>';
	}
	$varTRs .= '</tr>';
}

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plantilla de lectura</title>
    <style>
    	body {
    		background: #000;
    		color: #0F0;
    		font-size: 12px;
    		font-family: Arial;
    	}
    </style>
</head>

<body>
	<table border="1">
    	<?=$varTRs;?>
    </table>
<?php
?>
</body>
</html>