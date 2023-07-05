<?php
if (!isset($_GET['file'])) {
	?>
    <script>
	var varPath = prompt('Ingresa el nombre de txt:');
	if (!varPath) {
		document.write('<p style="font-family:Arial; text-align:center;">Inserta un criterio de trabajo para continuar</p><p style="text-align:center;"><input type="button" value="< Reintentar" onClick="javascript:document.location=\'index.php\'"></p>');
	} else {
		document.location = 'get_ink_id_from_isbn.php?file='+varPath;
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

$varType = 'kobo_id';
$varTRs = '';
$varMiss = array();
$varFile = fopen('txt/'.$_GET['file'].'.txt', 'r');
while ($varLine = fgets($varFile)) {
	$varLine = str_replace(' ', '', $varLine);
	$varLine = str_replace(chr(10), '', $varLine);
	$varQuery = 'SELECT id_ink FROM books WHERE '.$varType.'="'.$varLine.'" LIMIT 1';
	$varExec = mysqli_query($con, $varQuery);
	$varRow = mysqli_fetch_assoc($varExec);
	
	$varTRs .= '<tr>';
	$varTRs .= '<td>'.$varLine.'</td>';
	$varTRs .= '<td>'.$varRow['id_ink'].'</td>';
	$varTRs .= '<td>'.$varQuery.'</td>';
	$varTRs .= '</tr>';
	if (!$varRow['id_ink']) {
		array_push($varMiss, $varLine);
	}
}

$varTRsMiss = '';
foreach($varMiss as $varMissReg) {
	$varTRsMiss .= '<tr><td>'.$varMissReg.'</td></tr>';
}

?>
	<table border="1">
    	<?=$varTRsMiss;?>
    </table>
	<table border="1">
    	<?=$varTRs;?>
    </table>
</body>
</html>