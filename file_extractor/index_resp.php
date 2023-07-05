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
	exit('1');
}

if (!file_exists('txt/'.$_GET['file'].'.txt')) {
	exit('<p style="text-align:center;">No existe el archivo de texto <b>'.$_GET['file'].'</b> relacionado</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}
if (!file_exists('source/'.$_GET['file'].'')) {
	exit('<p style="text-align:center;">No existe la carpeta fuente <b>'.$_GET['file'].'</b> relacionada</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}

$varTRs = '';
$varMiss = 0;
$varFile = fopen('txt/'.$_GET['file'].'.txt', 'r');
mkdir('output/'.$_GET['file']);
chmod('output/'.$_GET['file'], 0777);
while ($varLine = fgets($varFile)) {
	$varLine = str_replace(chr(10), '', $varLine);
	$varLine = str_replace(' ', '', $varLine);
	$varFileExists = file_exists('source/'.$_GET['file'].'/'.$varLine);
	$varBG = 'FFF';
	if (!$varFileExists) { //Sino existe el archivo
		$varMiss++;
		$varBG = 'F99';
	} else { //Si existe lo copia
		copy('source/'.$_GET['file'].'/'.$varLine, 'output/'.$_GET['file'].'/'.$varLine);
		chmod('output/'.$_GET['file'].'/'.$varLine, 0777);
	}
	$varTRs .= '<tr style="background:#'.$varBG.'">';
	$varTRs .= '<td>'.$varLine.'</td>';
	$varTRs .= '<td>'.$varFileExists.'</td>';
	$varTRs .= '</tr>';
	
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plantilla de lectura</title>
</head>

<body>
	<p>Faltantes: <b><?=$varMiss;?></b></p>
	<table border="1">
    	<?=$varTRs;?>
    </table>
<?php
?>
</body>
</html>