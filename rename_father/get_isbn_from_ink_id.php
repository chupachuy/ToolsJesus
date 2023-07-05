<?php
if (!isset($_GET['file'])) {
	?>
    <script>
	var varPath = prompt('Ingresa el nombre de txt:');
	if (!varPath) {
		document.write('<p style="font-family:Arial; text-align:center;">Inserta un criterio de trabajo para continuar</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
	} else {
		document.location = 'get_isbn_from_ink_id.php?file='+varPath;
	}
    </script>
	<?php
	exit('');
}

if (!file_exists('txt/'.$_GET['file'].'.txt')) {
	exit('<p style="text-align:center;">No existe el archivo de texto <b>'.$_GET['file'].'</b> relacionado</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
}

//include('../dataINdb_srv.php');
include('../dataINdb_lcl_li.php');

$varTRs = '';
$varFile = fopen('txt/'.$_GET['file'].'.txt', 'r');
while ($varLine = fgets($varFile)) {
	$varLine = str_replace(' ', '', $varLine);
	$varLine = str_replace(chr(10), '', $varLine);
	$varQuery = 'SELECT isbn_13 FROM books WHERE id_ink="'.$varLine.'" LIMIT 1';
	$varExec = mysqli_query($con, $varQuery);
	$varRow = mysqli_fetch_assoc($varExec);
	
	$varTRs .= '<tr>';
	$varTRs .= '<td>'.$varLine.'</td>';
	$varTRs .= '<td>'.$varRow['isbn_13'].'</td>';
	$varTRs .= '<td>'.$varQuery.'</td>';
	$varTRs .= '</tr>';
}

?>
	<table border="1">
    	<?=$varTRs;?>
    </table>
</body>
</html>