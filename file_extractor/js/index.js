var varCurrentIndex;
var varAjax;
//------------------------------------------------------------------------------------------------------------------------ funciones generales

function fncCopyFile() {
	varAjax = $.ajax({
		url: 'request/copy_file.php',
		type: 'POST',
		data: {
			file_name: $('#td_file_'+varCurrentIndex).html(),
			txt_name: varFileName
		},
		success: onGotData,
		error: fncError
	});
	
	$('#td_exists_'+varCurrentIndex).html('..');
}

function onGotData(_resp) {
	//alert(_resp);
	//return;
	$('#td_processed').html(Number($('#td_processed').html())-1);
	
	try {
		var _json = JSON.parse(_resp);
	} catch(_err) {
		alert('Error en el servidor:\n'+_resp);
		return;
	}
	$('#td_exists_'+varCurrentIndex).html(_json.exists);
	$('#td_copied_'+varCurrentIndex).html(_json.copied);
	
	if (_json.exists==1 && _json.copied==1) { //Si todo está en orden oculta la línea
		$('#tr_'+varCurrentIndex).hide();
		$('#td_oks').html(Number($('#td_oks').html())+1);
	} else { //Si algo salió mal ahí la deja
		$('#td_errs').html(Number($('#td_errs').html())+1);
	}
	varCurrentIndex++;
	if ($('#tr_'+varCurrentIndex).html()) {
		fncCopyFile();
	} else {
		//alert('se acabó el desmadre');
	}
}

function fncError(xhr, ajaxOptions, thrownError) {
	alert('Error:\n'+xhr.status+'/'+thrownError);
}

function fncAbort() {
	varAjax.abort();
}
//------------------------------------------------------------------------------------------------------------------------ funciones iniciales
varCurrentIndex = 0;
fncCopyFile();

