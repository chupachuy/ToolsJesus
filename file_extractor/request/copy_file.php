<?php
$varJson = array();
$_POST['file_name'] = str_replace(chr(10), "", $_POST['file_name']);
$varFileName = '../source/'.$_POST['txt_name'].'/'.$_POST['file_name'];

//exit('-'.$varFileName.'-');
$varExists = file_exists($varFileName );

if ($varExists) {
	$varJson['copied'] = copy($varFileName, '../output/'.$_POST['txt_name'].'/'.$_POST['file_name']);
	chmod('../output/'.$_POST['txt_name'].'/'.$_POST['file_name'], 0777);
} else {
	$varJson['copied'] = '';
}

$varJson['exists'] = $varExists;

echo json_encode($varJson);
?>